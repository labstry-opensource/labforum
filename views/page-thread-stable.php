<?php
if(@$_GET['id'] && !isset($_SESSION)) session_start();


$threadid = @$_GET['id'];

//Process post when user posted a reply
if(@$_GET['action'] == 'addreply'){
    $replypost = new AddReply($pdoconnect, $pdotoolkit, $threadid);
    $replypost->submitReply(@$_POST['replytitle'], @$_POST['replycontent']);
}

//Check details of author
$authorprop = new AuthorProp($pdoconnect, $pdotoolkit, $threadid);
$authorid = $authorprop->userid;

$thread = new Thread($pdoconnect);
$thread->getThreadProp($threadid);
$authorid = $thread->author;

//Check details of thread
$threadprop = new ThreadProp($pdoconnect, $pdotoolkit, $threadid);
//$threadprop->triggerViewsCount();
$threadprop->getThreadProp();

$users = new Users($pdoconnect, $pdotoolkit);
$users->getUserPropById($authorid);



?>

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php

if($threadprop->descript != ""){
?>
<meta name="description" content="<?php echo $threadprop->descript; ?>"/>
<?php
}
?>

<title>Labstry 論壇- <?php echo $threadprop->threadname; ?></title>
<link rel="stylesheet" href="menu/dynamicmenu.css"/>
<link rel="stylesheet" href="thread.css"/>
</head>
<style>
.title{
	display:block;
	padding:40px; 
	width:100%; 
	height:10px; 
	background-color: green; 
	font-size: 40px;
}
.wrapper{
	width: 100%;
	margin: 0 auto;
	padding-bottom: 10px;
}
.card{
	box-shadow: 2px 2px 4px 4px #ACACAC;
	padding-bottom: 10px;
	border-radius: 18px;
	overflow: hidden;

}
.innerwrapper{
	width:94%; 
	/*margin:0 auto; */
	background: linear-gradient(to right, orange 50%, white 50%);
	background-size: 200% 100%;
	background-position: right bottom;
	transition: all .5s ease-out;
}
.innerwrapper:hover{
	background-position: left bottom;
}

.detailswrapper{
	background-color: #00c5ff;
	color:white;
}
.orderwrapper{
	width:95%;
	height: 180px;
	margin:0 auto;
}
.payment{
	display: inline-block; 
	float:right;
}
.nohoveroverride{
	width:95%;
	margin:0 auto;
}
.item22{
	width:100%;
}
.threadcontent{
	font-size:16px;
	font-weight:200;
	width: 95%;
	margin: 0 auto;
	padding-top: 40px;
	min-height: 100px;
}

.threadcontent img{
    max-width: 100%;
}
.operationprovider{
	width:100%;
	height:100%;
	background-color:grey;
	opacity: 0.8;
	position:fixed;
}
</style>

<body onload="Design();">
<?php include_once(dirname(__FILE__)."/../menu/header.php");?>
<!--- div class="operationprovider">


</div> --->
<?php
//Use parameter to get the appropiate header
$viewpage = "thread";
?>
<div class="wrapper">
	<div class="card">
		<!--- Describe the card that shows the thread --->
		<div class="detailswrapper">
			<div class="orderwrapper">
				<div class="details" style="display:inline-block;vertical-align:middle">
					<img class="avatarshow" style="vertical-align:middle;padding:10px;padding-left:0px" src="<?php echo $users->profilepic; ?>"/></div>
					<div style="display:inline-block;">
						<div id="tname" style="font-size:26px;display:inline-block;vertical-align:middle"><?php echo $threadprop->threadname; ?></div>
						<div id="tdate" style="font-size:15px"><?php echo $threadprop->date; ?></div>
					</div>
					<div class="details">
						<div class="author" style="font-size:15px;"><?php echo $threadprop->author; ?></div>
					</div>
					<div class="role" style="color:<?php echo $authorprop->color; ?>;font-size:15px"><?php echo $authorprop->rolename; ?></div>
				</div>
			</div>
			<!--- |-----------------------------------------------|  --->
			<div class="threadcontent"><?php echo $threadprop->getThreadContent(); ?></div>
			<div class="action">
				<div class="bottom">
					<?php echo $threadprop->getAvailableOperations(); ?>
			</div>
		</div>
	</div>
</div>

<div class="dynamicplaceholder">
<?php
for($i= 0 ; $i< $threadprop->numberOfReplies(); $i++){
	$currentcnt = $i +1; 
	$replyauthorprop = new ReplyAuthorProp($pdoconnect, $pdotoolkit, $threadid, $currentcnt);

	$replyprop = new ReplyProp($pdoconnect, $pdotoolkit, $threadid, $currentcnt);
	$replyprop->getThreadProp();

	?>
	<div class="wrapper">
		<div class="card">
		<!--- Describe the card that shows the reply --->
			<div class="detailswrapper">
				<div class="orderwrapper">
				<!-- Showing the reply order --->
					<div style='margin-right:10px;float:right'><?php 
						if($i == 0) echo "頭香";
						else echo "#".$currentcnt; ?>
					</div>
					<div class='details' style='display:inline-block;vertical-align:middle' >
						<img class='avatarshow' style='vertical-align:middle;padding:10px;padding-left:0px' src="<?php echo $replyauthorprop->profilepic; ?>"/>
					</div>
					<div style='display:inline-block;'>
						<div id='tname' style='font-size:26px;display:inline-block;vertical-align:middle'><?php echo $replyprop->threadname; ?></div>
						<div id='tdate' style='font-size:15px;'><?php echo $replyprop->date; ?></div>
					</div>
					<div class='details'><div class='author' style='font-size:15px;'><?php echo $replyauthorprop->username; ?></div></div>
					<div class='details'>
						<div class='author' style="color:<?php echo $replyauthorprop->color; ?>;font-size:15px">
							<?php echo $replyauthorprop->rolename; ?>		
						</div>
					</div>	
				</div>
			</div>
            <div class='threadcontent'>
                <iframe src="" frameborder="0">
                    <?php echo $replyprop->threadcontent; ?>
                </iframe>
            </div>
			<div class='action'>
				<div class="bottom">
					<?php echo $threadprop->getAvailableOperations(); ?>
				</div>
			</div>	
		</div>
	</div>
<?php
}
?>
</div> <!--- Dynamic place holder --->

<div class="wrapper" id="">
	<div class="card">
		<!--- Describe the card that shows the reply card--->
		<?php if(@$_SESSION['id']) { ?>
		<form method="POST" class="replyform" action="<?php echo basename($_SERVER['PHP_SELF'])."?id=".$threadid;?>&action=addreply">
			<div class="detailswrapper">
				<div class="orderwrapper">
					<div style="font-size:26px;padding-top: 20px;">回覆帖子內容</div>
					<input type="text" name="replytitle" class="replyclear" style="background:transparent; border:none;font-size: 18px;" placeholder="Input title here..." ></div>
				</div>
				<div class="replycontent" style="width: 99%;margin: 0 auto;">
					<div contenteditable="true" class="colorededit replyclear" style="min-height: 100px;"></div>
					<textarea class="replyedit" name="replycontent" style="display: none;"></textarea>
				</div>
				<input class="replysubmit" type="submit" value="Submit"/>
			</div>
		</form>
	<?php } else{ ?>
		<div class="detailswrapper">
				<div class="orderwrapper">
					<div style="font-size:26px;padding-top: 20px;">請<a href="/login.php?from=/forum/<?php echo basename($_SERVER['PHP_SELF'])."?id=".$threadid;?>">登入</a>以回覆</div>
				</div>
		</div>
	<?php } ?>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
$('.colorededit').on('DOMSubtreeModified', function() {
    $('.replyedit').html($('.colorededit').html()+ "<br>This reply is sumbitted by Project PostCard</br>");
});
$('.replyform').on("submit", function(e){
	e.preventDefault();
	$.ajax({
		url: $('.replyform').attr('action'),
		type: 'POST',
		data: $('.replyform').serialize(),
		success: function(data){
			$('.dynamicplaceholder').html($(data).filter('.dynamicplaceholder'));
			clearReplyBox();
		}

	});
});

function clearReplyBox(){
	$('.replyclear').html("");
}
</script>
</html>