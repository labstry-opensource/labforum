<?php
session_start();

include_once "../classes/connect.php";
include_once "../classes/Users.php";
include_once "../classes/UserRoles.php";

$user = new Users($pdoconnect, "");
$roles = new UserRoles($pdoconnect);
$roles->getUserRole(@$_SESSION["id"]);

if(!@$_SESSION["id"] || $roles->rights < 90) {
    header("HTTP/2.0 403 Forbidden");
    die('403 Forbidden');
}

?>



<!DOCTYPE html>
<html>
<head>
	<title>論壇管理</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- style -->
    <link rel="stylesheet" href="/forum/css/stylesheets/main.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/fontawesome.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/solid.min.css" integrity="sha256-3FfMfpeajSEpxWZTFowWZPTv7k3GEu7w4rQv49EWsEY=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/colorjoe@4.1.0/css/colorjoe.css">

    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js" integrity="sha256-chlNFSVx3TdcQ2Xlw7SvnbLAavAQLO0Y/LBiWX04viY=" crossorigin="anonymous"></script>
    <script src="https://www.jsviews.com/download/jsrender.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/colorjoe@4.1.0/dist/colorjoe.min.js"></script>



</head>
<body>
<?php include_once "header.php"?>

<div class="standard-width-wrapper">
    <div class="admin-manage-cardwrapper">
        <div class="manage-title">
            <div>Labstry 論壇後台管理</div>
        </div>
        <div class="admin-manage-link-wrapper w-100 row no-gutters">
            <a class='link col-12 col-md-3' v-bind:class="{active : reserve_username_active}" href="reserveuname.php" v-on:click.prevent="toggleReserveUsername">預留用戶名</a>
            <a class='link col-12 col-md-3' href="newforum.php">新增板塊</a>
            <a class='link col-12 col-md-3' v-bind:class="{active : forum_manage_active}" >自定義板塊設計</a>
            <a class="link col-12 col-md-3" v-bind:class="{active : user_manage_active}" href="usermanage.php" v-on:click.prevent="toggleUserManage">用戶管理</a>
            <a class="link col-12 col-md-3">小黑屋</a>
            <a class="link col-12 col-md-3" href="/phpmyadmin/">phpMyAdmin</a>
            <a class="link col-12 col-md-3" v-bind:class="{active: role_manage_active}" v-on:click.prevent="toggleRoleManage" href="user-role-manage.php">角色管理</a>
        </div>
    </div>


    <div class="management-one-stage-container" v-bind:class="{active: user_manage_active}">
        <usermanage v-on:loading="showLoadScreen" v-on:load_complete="hideLoadScreen"></usermanage>
    </div>
    <div class="management-one-stage-container" v-bind:class="{active: reserve_username_active}">
        <reserveusername v-on:loading="showLoadScreen" v-on:load_complete="hideLoadScreen"></reserveusername>
    </div>
    <div class="management-one-stage-container" v-bind:class="{active: role_manage_active}">
        <user_role v-on:loading="showLoadScreen" v-bind:active="role_manage_active" v-on:load_complete="hideLoadScreen"></user_role>
    </div>
    <div v-if="is_loading">
        <?php include_once @$_SERVER["DOCUMENT_ROOT"]."/forum/widgets/loading-circle.php"?>
    </div>
</div>

<?php include "usermanage.php"?>
<?php include "reserveuname.php"?>
<?php include "user-role-manage.php"?>

</body>

<script>
    var forum_manage = new Vue({
       el: '.standard-width-wrapper',
       data: {
           reserve_username_active: false,
           forum_manage_active: false,
           user_manage_active : false,
           role_manage_active: false,
           is_loading: false,
       },
       mounted:function(){

       },
       methods:{
           removeActive: function(){
               this.reserve_username_active = false;
               this.user_manage_active = false;
           },
           toggleUserManage: function(){
               this.removeActive();
               this.user_manage_active = !this.user_manage_active;
           },
           toggleReserveUsername: function(){
               this.removeActive();
               this.reserve_username_active = !this.reserve_username_active;
           },
           toggleRoleManage: function(){
               this.removeActive();
               this.role_manage_active = !this.role_manage_active;
           },
           showLoadScreen: function() {
               this.is_loading = true;
           },
           hideLoadScreen: function(){
               this.is_loading = false;
           },
       }
    });
</script>

</html>
