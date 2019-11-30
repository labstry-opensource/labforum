<script type="text/x-template" class="user-rights-template">
    <div class="details-card mt-3 mb-3">
        <div class="h4">Rights for {{username}}</div>
        <form>
            <div class="row">
                <div class="col-3 align-content-center d-flex flex-column justify-content-center">
                    <label for="user-group" class="mb-0">用戶組：</label>
                </div>
                <div class="col-9">
                    <select name="usergroup" class="form-control usergroup-selection" id="user-group" v-model="current_rights.role_id">
                        <option v-for="rights in rightsList" v-bind:value="rights.role_id">{{rights.role_name}}</option>
                    </select>
                </div>
            </div>

        </form>
        <div>閱讀權限：{{current_rights.rights}}</div>
    </div>

</script>

<script>
    Vue.component('user_rights', {
        template: $('.user-rights-template').html(),
        props:{
          username: String,
        },
        data:function(){
            return{
                username: "",
                rightsList: [],
                current_rights: [],
                isSpecialTeam: false,
            }
        },
        mounted: function(){
            this.getUserData();
            this.getRightList();
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
                        self.current_rights = data.rights;

                    }
                });

            },
            getRightList: function(){
                var self = this;
                $.ajax({
                    url: '/api/forum/admin/role-listing.php',
                    method: "GET",

                    success: function(data){
                        self.rightsList = data;
                    }
                });
            }
        }

    })
</script>