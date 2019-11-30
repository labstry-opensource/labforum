<?php
if(!@$_SESSION) session_start();

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

<script type="text/x-template" class="user-role-template">
    <div>
        <div class="user-role-container" v-for="(rights, index) in rightsList">
            <div class="general-card-wrapper" v-bind:class="'role-card-' + index">
                <div class="user-role-title-wrapper">
                    {{rights.role_id}}.<input type="text" class="role-name-input" v-bind:style="'color:' + rights.tagcolor" v-bind:value="rights.role_name"/>
                </div>
                <div class="general-card-padding role-card-internal-wrapper">
                    <div v-bind:class="'tag-color-' + index">標籤顏色：
                        <div v-bind:id="'picker-instance-' + index"></div>
                        <!--<input type="text" class="form-control" v-bind:class="['picker-instance-' + index]" v-model="rights.tagcolor"/>--></div>
                    <div>閱讀權限：<input type="text" class="form-control " v-model="rights.rights"></div>
                    <div class="role-button-group">編輯權限:
                        <button type="button" class="btn" v-bind:class="{'active': rights.r_edit === '1' }" v-on:click="rights.r_edit = (rights.r_edit === '0') ? '1': '0' ">
                            {{rights.r_edit | onOffToggle }}
                        </button>
                        <input type="hidden" class="" v-model="rights.r_edit">
                    </div>
                    <div class="role-button-group">刪除權限:
                        <button type="button" class="btn" v-bind:class="{'active': rights.r_del  === '1'}" v-on:click="rights.r_del = (rights.r_del === '0') ? '1': '0' ">
                            {{rights.r_del | onOffToggle }}
                        </button>
                        <input type="hidden" class="" v-model="rights.r_del">
                    </div>
                    <div class="role-button-group">提升權限:
                        <button type="button" class="btn" v-bind:class="{'active': rights.r_promo  === '1'}" v-on:click="rights.r_promo = (rights.r_promo === '0') ? '1': '0' ">
                            {{rights.r_promo | onOffToggle }}
                        </button>
                        <input type="hidden" class="" v-model="rights.r_promo">
                    </div>
                </div>
		
            </div>
        </div>
    </div>

</script>

<script>
    Vue.filter('onOffToggle', function(toggle){
        return (toggle === "1" || toggle === "true") ? "On" : "Off";
    });
    Vue.component('user_role', {
        template: $('.user-role-template').html(),
        data: function(){
            return{
                rightsList: [],
                pickrs: [],
            }
        },
        props:{
            active: Boolean,
        },
        mounted: function(){
            this.getRightsList();
        },
        methods:{
            getColorPickerClass: function(index){
                return "pickr-" + index;
            },
            getRightsList: function(){
                var self = this;
                $.ajax({
                    url: '/api/forum/admin/role-listing.php',
                    method: "GET",

                    success: function(data){
                        self.rightsList = data;
                    }
                });
            },
            initColorPicker: function(){
                var self = this;
                pickers = [];
                for(var i = 0; i< this.rightsList.length; i++){
                    window["picker-"+ i] = colorjoe.rgb("picker-instance-"+ i , self.rightsList[i].tagcolor);
                    window["picker-"+i].on("change", function(color){
                        console.log(color.css(), i);
                    })
                }

            }
        },
        watch:{
            active: function(val){
                if(val){
                    this.initColorPicker();
                }
            }
        }
    });
</script>
