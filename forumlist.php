<?php

session_start();
require_once('connect.php');
require_once(@$_SERVER['DOCUMENT_ROOT']."/forum/classes/Forum.php");

$forum = new Forum($pdoconnect);

$gids = $forum->getForumListId();

?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<title>所有版塊 - Labstry 論壇</title>
    <link rel="stylesheet" href="menu/dynamicmenu.css"/>

</head>
<style>
.showtag{
	width: 98%;
	margin: 10px auto;
	box-shadow: 2px 2px 4px 4px #ACACAC;
	border-radius: 25px;
	height: 100px;
	overflow: hidden;
}
.cardtitle{
	padding-left: 15px;
	line-height: 100px;
	font-size: 28px;
	background-color: #BFFF00;
	color: black;
}
.threadwrapper{
	width: 98%;
	margin: 10px auto;
	border-radius: 25px;
	overflow: hidden;
}
.title{
	width: 100%;
	background-color: orange;
	color:white;
	text-align: center;
}
.table{
	display: table;
	background-color: #0092ff;
	width: 100%;
	padding: 20px 10px 20px 10px;
	color:white;

}
.row{
	display: table-row;
}
.cell{
	display: table-cell;
}
.empty{
	text-decoration: none;
	color:white;
}
</style>
<body>
<?php
include("menu/header.php");
require_once("ranking.php");
?>
<div class='showtag'>
	<div class="cardtitle">版塊列表</div>

</div>

<?php

foreach($gids as $gid){
	$gname = $forum->getForumName($gid);
	$subforumids = $forum->getSubforumIds($gid);
?>
<div class="threadwrapper">
	<div class="title"><?php echo $gname; ?></div>

	<?php
	foreach($subforumids as $fid){
		if($forum->hasRightsToViewForum($fid, $rights)){
			$fname = $forum->getSubforumName($fid);
	?>

	<a class="empty" href="viewforum.php?id=<?php echo $fid;?>">
		<div class="table">
			<div class="row">
				<div class="cell"><?php echo $fname; ?>&emsp;forum: <?php echo $fid;?></div>
			</div>
		</div>
	</a>
	<?php
		}
	}
	?>
</div>

<?php
}

?>
</body>
</html>