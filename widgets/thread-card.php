<?php

?>
<script type="text/xtemplate" class="thread-card-template">
    <div id="postshow">

        <div class="card" v-for="thread in threads">
            <div class="intro" style="display:block;padding: 10px; height: 50px"
                 v-bind:style="{ 'background-color' : getThreadHighLight(thread) }">
                <a v-bind:href="'thread.php?id='+ thread.topic_id"  class="cardwrapper refreshable">
                    <div class="card-topic-show oneliner">[{{thread.fid}}]{{thread.topic_name}}</div>
                    <div class="description">
                        {{thread.topic_creator}} | Hotness: {{thread.views}} | {{thread.date}}
                    </div>
                </a>
            </div>
            <div class="contentpreview" style="width: 100%;">
                <div style="padding: 10px">
                    {{stripContents(thread.topic_content)}}
                </div>
            </div>
        </div>
    </div>
</script>


<script>
    Vue.component('thread_card', {
        template: $('.thread-card-template').html(),
        props:{
            threads : Array,
        },
        data: function(){
            return{

            }
        },
        methods:{
            getThreadHighLight: function(thread){
                return thread.highlightcolor ? thread.highlightcolor : '#add8e6'
            },
            stripContents: function(thread_content){
                var text = $('<div />').html(thread_content).text().substring(0, 150);
                return text + "...";
            }
        }
    });
</script>