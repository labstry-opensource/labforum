<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION)) session_start();
include_once "../classes/connect.php";
include_once "../classes/Users.php";
include_once "../classes/UserRoles.php";


  $roles = new UserRoles($connection);
  $roles->getUserRole(@$_SESSION['id']);

  if(!@$_SESSION["id"] || $roles->rights < 255) header("Location:/index.php");

 ?>
<!-- The action above is a fallback action for users that doesn't enable javascript in
their browsers -->
<script type="text/x-template" class="friend-finder-template">
    <div class="frined-finder-wrapper">
        <form class='friend-finder' action='/api/forum/user-search.php' v-on:submit.prevent="searchUsers" method="POST" autocomplete="off" style=''>
            <div class="row no-gutters">
                <input type="text" name="username" class="form-control col-12 col-md-10" >
                <input type="submit" name="submit" value="搜尋" class="form-control col-12 col-md-2">
            </div>

        </form>
        <template v-if="!is_result_ready && !is_error_generated">
            <?php include_once @$_SERVER["DOCUMENT_ROOT"]."/forum/widgets/loading-circle.php"?>
        </template>

        <template v-if="is_error_generated">
            <div class="p-5">
                <b>Error: </b>{{errorMsg}}
            </div>
        </template>

        <div class="row no-gutters friend-listing" v-if="is_result_ready && !is_error_generated">
            <div class="col-12 user-listing" v-for="user in userData">
                <div class="row no-gutters">
                    <div class="col-12 col-md-4">{{user.username}} (uid: {{user.id}})</div>
                    <div class="col-12 col-md-4">{{user.email}}</div>
                    <div class="col-12 col-md-4">
                        <a v-bind:href="'user-profile-admin-view.php?id=' + user.id">Manage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script>
    Vue.component('usermanage', {
       props: [],
       data: function(){
           return{
               is_error_generated: false,
               errorMsg: '',

               is_result_ready: true,
               userData: [],

           }
       },
       methods:{
           searchUsers(){
               var self = this;
               self.$emit('loading');
               self.userData = [];

               $.ajax({
                   url: $('.friend-finder').attr("action"),
                   method: $('.friend-finder').attr("method"),
                   data: $('.friend-finder').serialize(),
                   success: function(data){
                       if(!data.error){
                           self.userData = data;
                       }else{
                           self.is_error_generated = true;
                           self.errorMsg = data.error;
                       }
                       self.$emit('load_complete');
                   }
               });

           }
       },
       template: $('.friend-finder-template').html(),

    });
</script>