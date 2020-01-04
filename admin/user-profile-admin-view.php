<?php

session_start();
include @$_SERVER["DOCUMENT_ROOT"]."/forum/classes/connect.php";
include @$_SERVER["DOCUMENT_ROOT"]."/forum/classes/UserRoles.php";
include @$_SERVER["DOCUMENT_ROOT"]."/forum/classes/Users.php";

$users = new Users($pdoconnect, "");
$roles = new UserRoles($pdoconnect);
$roles->getUserRole(@$_SESSION['id']);


if(!@$_SESSION["id"] || $roles->rights < 90 || !@$_GET["id"]){
    http_response_code(403);
    die('403 Forbidden');
    exit;
}

$users->getUserPropById(@$_GET["id"]);



?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manage <?php echo $users->username;?></title>
    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js" integrity="sha256-chlNFSVx3TdcQ2Xlw7SvnbLAavAQLO0Y/LBiWX04viY=" crossorigin="anonymous"></script>
    <script src="https://www.jsviews.com/download/jsrender.min.js"></script>

    <!-- style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/forum/css/stylesheets/main.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/fontawesome.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/solid.min.css" integrity="sha256-3FfMfpeajSEpxWZTFowWZPTv7k3GEu7w4rQv49EWsEY=" crossorigin="anonymous" />

</head>
<body>
<?php include_once "header.php"?>

<div class="user-manage-wrapper">
    <div class="user-card">
        <a href="#collapseOptions" data-toggle="collapse" role="button" aria-expanded="false" class="d-flex profile-descriptor">
            <img class="profile-pic" v-bind:src="'/forum/'+ userData.profile_pic" alt="User image">
            <div class="username-listing flex-column d-flex justify-content-center ml-2">
                <div>{{userData.username}} (uid: {{userData.id}})</div>
                <div v-bind:style="'color:' + userData.rights.tagcolor">{{userData.rights.role_name}}</div>
            </div>
        </a>
        <div class="operation-list row text-center collapse" id="collapseOptions">
            <a href="password-reset.php?id=<?php echo urlencode(@$_GET["id"])?>" v-on:click.prevent="togglePasswordReset" class="col-12 col-sm-6 col-md-4 ">重設密碼</a>
            <a href="add-to-black-hole.php?id=<?php echo urlencode(@$_GET["id"])?>" v-on:click.prevent="toggleBlackHouse" v-if="userData.id != current_user" class="col-12 col-sm-6 col-md-4">加入小黑屋</a>
            <a href="user-profile-admin-view.php?id=<?php echo urlencode(@$_GET["id"])?>" v-on:click.prevent="togglePersonalDetails" class="col-12 col-sm-6 col-md-4">個人資料</a>
            <a href="user-right-management.php?id=<?php echo urlencode(@$_GET["id"])?>" v-on:click.prevent="toggleRightManagement" class="col-12 col-sm-6 col-md-4 ">權限管理</a>
        </div>
    </div>
    <personal_details v-bind:user-data="userData" v-if="is_toggled_personal_details"></personal_details>
    <user_rights v-if="is_toggled_right_management" v-bind:username="userData.username"></user_rights>

    <!-- modal -->
    <div class="modal fade" id="operationDialog" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{dialog.title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-html="dialog.content">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary negative-button" data-dismiss="modal">{{dialog.negativeButtonDescription}}</button>
                    <button type="button" class="btn btn-primary positive-button">{{dialog.positiveButtonDescription}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "user-personal-details.php"?>
<?php include "user-right-management.php"?>

</body>


<script>
    var user_manage_app = new Vue({
        el: '.user-manage-wrapper',
        data:{
            current_user : <?php echo json_encode(@$_SESSION["id"])?>,
            userData: [],
            dialog: {
                title : null,
                content: null,
                positiveButtonDescription: null,
                negativeButtonDescription: 'Cancel',
            },
            //toggles
            is_toggled_personal_details : true,
            is_toggled_right_management: false,
        },
        mounted: function(){
            this.getUserData();
        },
        methods:{
            getUserData: function(){
                var self = this;
                $.ajax({
                   url: '/api/forum/admin/detailed-user-search.php',
                   data: {
                       id: <?php echo json_encode(@$_GET["id"])?>,
                   },
                   method: "POST",
                   xhrFields:{
                       withCredentials: true,
                   },
                   success: function(data){
                       self.userData = data;
                   }
                });
            },
            registerDialogContents: function($event, title, content, pve_button, nve_button, pve_func_name, nve_func_name){
                var self = this;

                this.dialog.title = title;
                this.dialog.content = content;
                this.dialog.positiveButtonDescription = pve_button;
                if(nve_button != null)
                    this.dialog.negativeButtonDescription = nve_button;

                if(nve_func_name === null){
                    nve_func_name = "disposeDialog" ;
                }

                $('.positive-button').on('click.DialogButtonAction', function(){
                    self[pve_func_name]();
                });

                $('.negative-button').on('click.DialogButtonAction', function(){
                    self[nve_func_name]();
                });
            },
            disposeDialog: function(){
                this.dialog.title = null;
                this.dialog.content = null;
                this.dialog.positiveButtonDescription = null;
                this.dialog.negativeButtonDescription = 'Cancel';

                $('.positive-button').off('click.DialogButtonAction');
            },
            //toggles
            toggleDialog: function(){
                $('#operationDialog').modal('toggle');
            },
            togglePasswordReset: function(e){
                var title = "Are you sure ?";
                var content = "You are resetting the password of user " + this.userData.username + ", " +
                        "a message will be sent to the user to reset his/her password";

                var pve_button = "Confirm";
                var func_name = "resetPassword";
                this.registerDialogContents(e, title, content, pve_button, null, func_name, null);

                this.toggleDialog();
            },
            toggleBlackHouse: function (e) {
                var title = "Are you sure you want to block this user ?";
                var content = "This user will NOT be removed from the forum, but he/she will be: " +
                        "<ul><li>Unable to access to forum rights such as posting or replying</li>" +
                        "<li>Unable to modify his profile unless further rights is granted.</li>" +
                        "<li>No longer count as active until he is being removed from the list.</li></ul>" +
                        "<form>" +
                        "<label for=\"reason\">Explanation: </label><input name=\"reason\" class=\"form-controls block-reason\" id=\"reason\"/>" +
                        "<div>Note: This reason is used to notify users and keeping record in the forums.</div>"
                        "</form>";

                var pve_button = "Enter";
                var func_name = "blockUser";

                this.registerDialogContents(e, title, content, pve_button, null, func_name, null);
                this.toggleDialog();
            },
            togglePersonalDetails: function(){
                if(!this.is_toggled_personal_details){
                    this.is_toggled_personal_details = true;
                }else{
                    this.is_toggled_personal_details = false;
                }
            },
            toggleRightManagement: function(){
                if(!this.is_toggled_right_management){
                    this.is_toggled_right_management = true;
                }else{
                    this.is_toggled_right_management = false;
                }
            },
            //actions
            resetPassword: function () {
                var self = this;
                $.ajax({
                   url: 'mail.php',
                   method: "POST",
                   data:{
                       id: <?php echo json_encode(@$_GET["id"])?>,
                   },
                   success: function(data){
                       if(data.success){
                           console.log("Success in sending password reset email");
                           self.disposeDialog();
                           self.toggleDialog();
                       }
                   }
                });
            },
            setUsernamePassword: function(userid, password){
                $.ajax({
                   url: '/forum/api/admin/change-password.php',
                   method: 'POST',
                   data:{
                       id: userid,
                       password: password,
                   }
                });
            },
            blockUser: function(){
                var self = this;
                $.ajax({
                    url: "/api/forum/admin/add-banned-user.php",
                    method: "POST",
                    xhrFields: {
                        withCredentials: true,
                    },
                    data:{
                        id: <?php echo json_encode(@$_GET["id"])?>,
                        reason: $('.block-reason').val(),
                    },
                    success: function(data){
                        if(data.success){
                            console.log("Success in adding to blocked list");
                            self.disposeDialog();
                            self.toggleDialog();
                        }
                    }
                });
            },

        }
    })
</script>
</html>
