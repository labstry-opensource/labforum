<!doctype html>
<html>
<?php 

	//Start session
	session_start();
	if(!($page = @$_GET['page'])){
		$page = 1;
	}
	$id = @$_GET['id'];

	//The process of getting files has been seperated into different parts.
	//The description part must be retrieved through php because they must be captured whenever page loads
	$json = file_get_contents("https://www.labstry.com/api/forum/thread-head.php?id=".urlencode($id));
	$data = json_decode($json, true);
?>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php if($data["seo"]){ ?>
		<meta name="description" content="<?=$data->seo ?>"/>
	<?php  } ?>
	<Title>Labstry 論壇</Title>

	<!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
</head>
<body>
<?php 

include_once("widgets/header.php");

?>
<div class="thread-total-wrapper">
	<div class="thread-content-wrapper">
	<div class="thread-display">
		<div class="thread-display-wrapper">
			<div class="thread-avatar">
				<div><img v-bind:src="thread.profile_pic" class="avatar-image" /></div>
				<div class="author-name">{{thread.username}}</div>	
			</div>
			<div class="topic-details-wrapper">
				<div class="topic-name">{{ thread.topic_name }}</div>
				<div class="topic-date">{{ thread.date }}</div>
			</div>
		</div>
	</div>
	<div class="topic-content-card" >
		<div class="topic-content-wrapper" v-html="thread.topic_content"></div>	
	</div>
	</div>

	<div class="reply-all-wrapper">
		<!-- Reply card -->
		<div class="reply-outer-wrapper" v-for="reply in replies">
			<div class="thread-display-wrapper">
				<div class="thread-avatar">
					<div><img v-bind:src="reply.profile_pic" class="avatar-image" /></div>
					<div class="author-name">{{reply.username}}</div>
				</div>
				<div class="topic-details-wrapper">
					<div class="topic-name">{{ reply.reply_topic }}</div>
					<div class="topic-date">{{ reply.date }}</div>
				</div>
			</div>
			<div class="reply-wrapper" >
				<div class="reply-content-wrapper">
						<div class="reply-content" v-html="showContent(reply.reply_content)"></div>
				</div>
			</div>
		</div>
	</div>

	

	<form method="POST" v-bind:action="'/api/forum/reply-composer.php?id=' + tid" class="reply-compose-box" v-if="isLoggedIn">
		<div class="reply-title-input-wrapper">
			<input name="reply-title" class="reply-title-compose-box"/>
		</div>
		<textarea name="reply-content"></textarea>
	</form>	

</div>

</body>

<script>
var thread_display = new Vue({
	el: '.thread-total-wrapper',
	data:{
		tid : <?php echo json_encode($id)?>, 
		thread: {},
		replies : {},
		page: <?php echo json_encode($page)?>,
		showReplyFrom : null,
		showReplyTo: null,
		replyBase: 5,

		//Reply box
		isLoggedIn : false,
		replyError: null,
	},
	mounted: function(e){
		var self = this;
		self.showReplyFrom = ((self.page - 1 ) * self.replyBase ) + 1;
		self.showReplyTo = self.showReplyFrom + self.replyBase - 1;
		self.loadThread();
		self.loadMenuStylesheet();
		self.loadMainStylesheet();
		self.checkIfLoggedIn();
	},
	methods: {
		loadThread: function(){		
			var self = this;
			$.ajax({
				url: "https://www.labstry.com/api/forum/threads-engine.php?id=" + <?php echo json_encode($id)?> + "&reply_from=" + self.showReplyFrom + "&reply_to=" + self.showReplyTo,
				method: 'GET', 
				success: function(data){
					self.thread = data;
					self.replies = data.replies;
					//Explicitly setting title by jquery
					$(document).attr("title", self.thread.topic_name);
				}
			});
		},
		loadMenuStylesheet: function(){
			var self = this;
            $.ajax({
                url: 'css/stylesheets/main.css',
                success: function(data){
                    $('head').append("<style>" + data + "</style>");
                }
            });
            $.ajax({
                url: 'css/stylesheets/header.css',
                success: function(data){
                    $('head').append("<style>" + data + "</style>");
                }
            });
		},
		loadMainStylesheet: function(){
			var self = this;
			$.ajax({
				url: 'menu/dynamicmenu.css',
				success: function(data){
					$('head').append("<style>" + data + "</style>");
				}
			});
		},
		showContent: function(value){
			if(!value) return "This thread has no content.";
			else return value;
		},
		checkIfLoggedIn: function(){
			var self = this;
			$.ajax({
				url: "https://www.labstry.com/api/forum/login-status-checker.php", 
				method: "GET",
				xhrFields:{
					withCredentials: true,
				},
				success: function(data){
					self.isLoggedIn = data.is_logged_in;
				}
			});
		},
		submitReply: function(){
			var self = this;
			$.ajax({
				url: $(".reply-compose-box").attr("action"),
				method: $(".reply-compose-box").attr("method"),
				data: $(".reply-compose-box").serialize(),
				xhrFields:{
					withCredentials: true,
				},
				success: function(data){
					if(data.error){
						this.replyError = data.error;
					}
				}
			});
		}
	}
	
});
</script>


</html>