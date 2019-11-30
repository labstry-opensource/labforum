<?php

if(!isset($_SESSION))session_start();


//Now we got the $dboconnection and ranking. Then it's time to check permission

if(!@$_SESSION["id"] && $rights < 90) {
    header("Location:/index.php");
    exit;
}
	$username = @$_SESSION['username'];
?>

<script class="reserve-username-module" type="text/x-template">
    <div class="reserved-username-wrapper">


        <form method="POST" class="username-reserve-form row no-gutters" action="/api/forum/admin/reserve-username.php" v-on:submit.prevent="reserveName">
            <input type="text" class="form-control col-12 col-md-10" name="reserve_username" />
            <input type="hidden" name="action" value="useradd"/>
            <input type="submit" class="form-control col-12 col-md-2" name="submit" value="Reserve"/>
        </form>

        <div class="row no-gutters pt-5 pb-5" v-for="(username, index) in reserved_username">
            <div class="col-12 col-md-8">
                {{username.reserved_username}}
            </div>
            <div class="col-12 col-md-4">
                <form method="POST" v-bind:class="deleteFormObject(index)" action="/api/forum/admin/reserve-username.php" v-on:submit.prevent="deleteReservedName(index)">
                    <input type="hidden" name="action" value="userdelete"/>
                    <input type="hidden" name="reserve_username" v-bind:value="username.reserved_username"/>
                    <button type="submit"><i class="fas fa-trash-alt"></i></button>
                </form>

            </div>

        </div>
    </div>


</script>


</body>

</html>

<script>
    Vue.component('reserveusername', {
        data: function(){
            return{
                is_error_generated: false,
                reserve_error: '',
                reserve_success: '',
                reserved_username: [],
            }
        },
        computed:{

        },
        mounted: function(){
            this.getReservedUsername();

        },
        methods:{
            deleteFormObject: function(index){
                var classname = "delete-form-" + index;
                var classobject = {};
                classobject[classname] = true;
                return classobject;
            },
            clearUsernameList: function(){
                this.reserved_username = [];
            },
            getReservedUsername: function(){
                this.$emit('loading');
                this.getReservedUsernameList();
                this.$emit('load_complete');
            },
            getReservedUsernameList: function(){
                var self = this;
                $.ajax({
                    url: '/api/forum/admin/my-reserved-username.php',
                    method: "POST",
                    success: function(data){
                        self.reserved_username = data.username;
                    }
                });
            },
            reserveName: function(){
                var self = this;
                self.is_error_generated = false;
                this.clearUsernameList();
                self.$emit('loading');
                $.ajax({
                    url: $('.username-reserve-form').attr("action"),
                    method: $('.username-reserve-form').attr("method"),
                    data: $('.username-reserve-form').serialize(),
                    success: function (data) {
                        if(!data.error){
                            self.reserve_success = data.success;
                        }else{
                            self.is_error_generated = true;
                            self.reserve_error = data.error;
                        }
                        self.getReservedUsernameList();
                        self.$emit('load_complete');
                    }
                })
            },
            deleteReservedName: function(index){
                var self = this;
                this.clearUsernameList();
                self.$emit('loading');
                $.ajax({
                    url: $('.delete-form-' + index).attr('action'),
                    method: $('.delete-form-'+ index).attr('method'),
                    data: $('.delete-form-' + index).serialize(),
                    success: function(data){
                        self.getReservedUsernameList();
                        self.$emit('load_complete');
                    }
                })
            }
        },
        template: $('.reserve-username-module').html(),
    })
</script>