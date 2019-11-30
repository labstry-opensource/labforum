<script type="text/x-template" class="personal-templates-template">
    <div class="details-card mt-3 mb-3">
        <div class="h4">Personal Information</div>
        <div class="user-details">
            <div>Email: {{userData.email}}</div>
            <div>Date of joining: {{userData.date}}</div>
            <div>Score: {{userData.score}}</div>
            <div>Number of replies: {{userData.replies}}</div>
        </div>
    </div>
    <div class="details-card mt-3 mb-3">
        <div class="h4">{{userData.username}}'s Awards</div>
        <div></div>
    </div>

</script>

<script>
    Vue.component('personal_details', {
        template: $('.personal-templates-template').html(),
        props: {
            userData: Array,
        },
        mounted: function(){
            console.log(this.userData);
        },
    });
</script>