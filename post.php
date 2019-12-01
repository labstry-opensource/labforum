<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<html>
<link rel="stylesheet" href="menu/dynamicmenu.css"/>
<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
<head>
<style type="text/css">
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
}
.card{
	box-shadow: 2px 2px 4px 4px #ACACAC;
	padding-bottom: 10px;
  border-radius: 20px;
  overflow-x: hidden;
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
	background-color: orange;
	color:white;

}
.orderwrapper{
	width:95%;
	min-height: 150px;
	margin:0 auto;
	padding-bottom: 40px;
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
	padding-left: 40px;
	padding-top: 40px;
}
#topic{
	border:none;
	border-bottom:2px solid white;
	background:orange;
	font-size:20px;
	outline: none;
	min-width: 400px;
}
.send{
	background-color: orange;
	padding: 10px;
	border-radius: 2px;
	font-size: 15px;
}
</style>
<style>
.settingsblank{
	background:transparent;
	border:none;
	border-bottom: 2px solid white;
	width: 100px;
	text-align:center;
	outline:none;
  display:inline-block;
}
.seoshow{
  /* Override the default width */
  width: 400px;
}
.row{
	min-height: 40px;
}
.toggle{
	background-color:orange;
	text-decoration:none;
	color:white;
	padding:5px;
	padding-left:50px;
	padding-right:50px;
	border-radius:4px;
	min-width: 50px;
}
/* Make these blanks hidden */
.seoblank, .draftset, .readpermission{
  display: none;
}

</style>	
<?php

header("Content-Type:text/html;charset=utf-8");
session_start();
require('connect.php');
require_once('ranking.php');
//Check for permission
if(@$_GET['mode'] == 'edit' && $tid=@$_GET['id']){
	if(!$myedit){
		header("Location: index.php");
	}
}

echo "\n<title>";
  		if(@$_GET['mode'] == 'edit') echo "編輯內容";
 		 else echo "發表新帖";
echo "</title>\n";

echo "<body onLoad='iFrameOn();'>\n";
include("menu/header.php");
if(!@$_SESSION['username']) echo "<script>window.location='index.php'</script>";
if(@$_SESSION["username"]){
	$viewpage = "postedit";
	include("../menu/subheader.php");

?>
<!-- Edited by Chow Raynold:  This is the fake search header that will have the same size of submenu, being used to 

    replace the default menu when search is pressed--->

<div class="fakesubheader" style='min-height:150px;display:none;'>
	<div class="search" id="close" style="display:inline-block;vertical-align: middle;">

	<img src="../menu/images/cross.png" style="width:40px; height:40px" class="buttonimg"/>

	</div>
</div>
<div style="width:100%;position:absolute;top:150px;display: none;padding-left: 50px;" class="searchresultprovider">
  <?php
  //One time query if it's editable
  if(@$_GET['mode'] == 'edit'){
    @$editid = @$_GET['id'];
    $threadresultquery = mysqli_query($connect, "SELECT * FROM threads WHERE topic_id='".$editid."';");
    $titlerow = mysqli_fetch_assoc($threadresultquery);
    $title = $titlerow['topic_name'];
    $content = $titlerow['topic_content'];
    $readrights = $titlerow['rights'];
    $draftstate = $titlerow['draft'];
    $keywords = $titlerow['seo'];
  }else{
    //Set default settings if it's not in edit mode
    $readrights = 0;
    $draftstate = 0;
    $keywords = null;
  }

  /* Get current draft state so that it continues to keep it state after it submits again
     unless user cancel it
  */
  if($draftstate == 1) $draftword = "On";
  else $draftword = "Off";
  ?>
	<div class='row'>閱讀權限:<input  class='settingsblank permissionshow' name='permission' value='<?php echo $readrights; ?>'></input>
	<div id='readhint' style='display:none;background-color:red;color:white;margin-left:15px'>權限必須介乎0-255 之間</div>
	</div>
	<div class='row' style='display:inline-block'>草稿模式:<a href='#' class='toggle draft'><?php echo $draftword?></a></div>
	<div style='display:inline-block'>NEW</div>
  <div class='row'>帖子簡介: <input class='settingsblank seoshow' name='seoshow' value="<?php echo $keywords ?>"></input></div>
  <div style='display:inline-block'>This blank is to facilitate description of the search engine.</div>
</div>
<?php
    if((@$_GET['mode'] == 'edit' && @$_GET['id']) || !@$_GET['mode'] == 'edit'){
      
      //PARAMETERS
      $wordcount = '標題不得多於70字符';
      $nocontent = '無法發表空帖';
      //END PARAMETERS
      //decide the form submitting position according to get request
      echo "<form action='";
      if(@$_GET['mode'] == 'edit') echo "post.php?id=".$editid."&mode=edit&action=submit";
      else echo "post.php?action=submit";
      echo "' id='postedit' method='POST'>";

      //Use CardView
      echo "<div class='wrapper'>";
	  echo "\n\t<div class='card'>";
	  echo "\n\t\t<div class='detailswrapper'>";
	  echo "\n\t\t\t<div class='orderwrapper'>";
	  echo "\n\t\t\t\t<div class='details' style='display:inline-block;vertical-align:middle;padding-top: 40px;' >";
      //form started
	  if(@$_GET['mode']){
	  echo "\n\t\t\t\t\t<div>正在編輯</div>";
      	//Get all the related information
      	$titlecheck = mysqli_query($connect, "SELECT * FROM threads WHERE topic_id='".$editid."';");
      	$titlerow = mysqli_fetch_assoc($titlecheck);
      	//$title = $titlerow['topic_name'];
      	//$content = $titlerow['topic_content'];
      	//$readrights = $titlerow['rights'];

      }else{
	      //Let the user select a subforum
	echo "\n\t\t\t\t\t<div>正在發表新內容</div>";
      	echo "\n\t\t\t\t\t<select name='forumselect'>";
      	$forumquery = mysqli_query($connect, "SELECT * FROM subforum WHERE min_author_rights <= $rights");
      	while ($tname = mysqli_fetch_assoc($forumquery)) echo "\n\t\t\t\t\t\t<option value=".$tname['fid'].">".$tname['fname']."</option>";
      	echo "\n\t\t\t\t\t\t</option>
      		  \n\t\t\t\t\t</select>";
      	$title = ""; $content = "";

      }
      //Display the title bar in the cart top
       echo "<input type='text' name='topic_name' id='topic' value='".$title."'/>";
       echo "</div>";
   }
       //Display all the buttons
   		echo "\n\t\t\t\t<div class='details' style='display:block;vertical-align:middle'>";
  ?>

       <input type='button' class='ibtn' onClick='Bold()' value='B'/>
   	   <input type='button' onClick='Underline()' value='U'>
   	   <input type='button' onClick='Italic()' value='I'>
   	   <input type='button' onClick="Left()" value='Left'>
   	   <input type='button' onClick="Center()" value='Center'>
   	   <input type='button' onClick="Right()" value='Right'>
   	   <input type='button' onClick="UList()" value='Unordered List'>
   	   <input type='button' onClick="OList()" value='1.2.3'>
<?php
   	   echo "\n\t\t\t\t</div>";
   	   echo "\n\t\t\t\t<div class='details' style='display:block;vertical-align:middle'>";
   	   echo "\n\t\t\t\t\t<select id='fontselector' onchange='changeFont()'>
     		 \n\t\t\t\t\t\t<option value='Times New Roman'>Times New Roman</option>
       		 \n\t\t\t\t\t\t<option value='Tahoma'>Calibri</option>
    		 \n\t\t\t\t\t\t<option value='Georgia'>Georgia</option>
    	     \n\t\t\t\t\t\t<option value='Noto Sans TC'>Noto Sans TC</option>
   			 \n\t\t\t\t\t</select>";
   	   echo "\n\t\t\t\t\t<select id='sizeselector' onchange='changeSize()''>
     		 \n\t\t\t\t\t\t<option value='1'>Small</option>
     		 \n\t\t\t\t\t\t<option value='3'>Medium</option>
     		 \n\t\t\t\t\t\t<option value='5'>Large</option>
     		 \n\t\t\t\t\t\t<option value='6'>Very Large</option>
  		 	 \n\t\t\t\t\t</select>";
  	   echo "\n\t\t\t\t\t<input type='button' onclick='HyperLink()' value='HyperLink'/>";
   	   echo "\n\t\t\t\t\t<input type='button' onclick='Unlink()' value='Unlink'/>";
   	   echo "\n\t\t\t\t</div>";
       echo "\n\t\t\t\t<div class='details' style='display:block;vertical-align:middle'>";
       //echo "\n\t\t\t\t\t<input type='button' class='htmlbtn' onclick='switchHTMLView()' value='切換至HTML檢視模式'/>";
       //echo "\n\t\t\t\t\t<input type='button' class='visualbtn' onclick='switchWysiwygView()' value='切換至視覺檢視模式'/>";
       echo "\n\t\t\t\t</div>";
   	   //The contents starts here...
   	   echo "<textarea name='content' style='display:none' id='content'></textarea>";

       //!!! hidden readpemission and seo blank starts here....

	     echo "<input name=\"readpermission\" class=\"readpermission\" value=\"".$readrights."\"/>";  
       echo "<input name=\"seo\" class=\"seoblank\" value=\"".$keywords."\"/>";
       echo "<input name='draft' class='draftset' value='".$draftstate."'>";

       //!!! readpermission and seo ends here...


	     echo "</div></div>";
   	   echo "<div class='threadcontent'><iframe name='formatfaker' id='formatfaker' style='width: 95%; height:95%; margin: 0 auto; border:0px;'";
   	   if(@$_GET['mode']) echo "src='postretriever.php?id=$tid'/>";
   	   else echo "/>";
   	   echo "</div>";
   	   echo "</iframe>

   	   \n\t\t\t\t<div class='details' style='display:none;vertical-align:middle'>";
   	   if(@$_GET['mode'] == 'edit'){
			echo "\n\t<input class='send' name='send' type='button' value='保存修改' onClick='javascript:submit_form()'/>";
		}else{
			echo "\n\t<input class='send' name='send' type='button' value='發表帖子' onClick='javascript:submit_form()'/>";
		}
   	   echo "</div>";
}
?>

</body>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<!--- Script for dynamic search -->

<?php
    require_once('../SearchBarOpenHelper.html');
?>
<script>

//dynamically changing permission and seo blank in the form
$('.permissionshow').on("keyup", function(e){
	var value = $('.permissionshow').val();
	if($.isNumeric(value)){
		if(value >= 0 && value <=255){
			$('.readpermission').val(value);
			$('#readhint').css({'display':'none'});
			$('.permissionshow').css({'border-bottom':'2px solid white'});
		}
		else{
			$('#readhint').css({'display':'inline-block'});
			$('.readpermission').val("0");
			$('.permissionshow').css({'border-bottom':'2px solid red'});
		}
	}
	else if(value==''){
		$('.readpermission').val("0");
		$('#readhint').css({'display':'inline-block'});
		$('.permissionshow').css({'border-bottom':'2px solid red'});
	}
});

$('.seoshow').on("keyup", function(e){
  var value = $('.seoshow').val();
  $('.seoblank').val(value);
});


//Processing script for toggle
$('.draft').click(function(e){
	if($('.draft').text() == "Off"){
		//Turn draft on
		$('.draft').text("On");
    $('.draftset').val("1");
		$('.postbtn').css({'display':'none'});
		$('.draftbtn').css({'display':'inline-block'});
	}else{
		//Turn draft off
		$('.draft').text("Off");
    $('.draftset').val("0");
		$('.draftbtn').css({'display':'none'});
		$('.postbtn').css({'display':'inline-block'});
	}
});

</script>
<!--- End of dynamic menu -->
<script>
  
  $('#post').click(function(e){
  	e.preventDefault();
	submit_form();
  });

  function iFrameOn(){
	 formatfaker.document.designMode = 'On';
  };
  function Bold(){
    formatfaker.document.execCommand('bold',false,null);
  };
  function Underline(){
    formatfaker.document.execCommand('underline', false, null);
  };
  function Italic(){
    formatfaker.document.execCommand('italic', false, null);
  };
  function Center(){
    formatfaker.document.execCommand('justifyCenter', false, null);
  };
  function Left(){
    formatfaker.document.execCommand('justifyLeft',false,null);
  };
  function Right(){
    formatfaker.document.execCommand('justifyRight', false, null);
  };
  function UList(){
    formatfaker.document.execCommand('InsertUnorderedList', false, 'unorderedlist')
  };
  function OList(){
    formatfaker.document.execCommand('InsertOrderedList', false, 'orderedList');
  }
  //This is the DOM PARSER
  function htmlDecode(input)
  {
  console.log(input);
  var doc22 = input.replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/<div>/g, '\n<br>\n').replace(/<\/div>/g, '\n<br>\n');
  console.log(doc22);
  return doc22;
  }

  function submit_form(){
	  var myformcontent = $('#formatfaker').contents().find("body").html();
    var contenttxt = htmlDecode(myformcontent);
    $('#content').val(contenttxt);
	  //alert($('#content').val());
	  $('#postedit').submit();
  };
  function changeFont(){
    var type = document.getElementById('fontselector');
    var ftype = type.options[type.selectedIndex].value;
    formatfaker.document.execCommand('fontName', false, ftype);
  };
  function changeSize(){
    var e = document.getElementById('sizeselector');
    var size = e.options[e.selectedIndex].value;
    formatfaker.document.execCommand('fontSize', false, size);
  };
  function HyperLink(){
    var url = prompt('Enter URL', 'http://');
    formatfaker.document.execCommand('CreateLink', false, url);
  }
  function Unlink(){
    formatfaker.document.execCommand('Unlink', false, null)
  }

  //Code for switching to HTML Mode
  function switchHTMLView(){
    //First we will disable HTML button, then force enabling the visual button no matter what state it's in
    $('.htmlbtn').css({'display': 'none'});
    $('.visualbtn').css({'display': 'block'});
    var purehtml = $('#formatfaker').contents().find("body").html();
    alert(purehtml);

  }
  </script>
  <?php
  //Parameters for topic name and content
  $t_name = @$_POST['topic_name'];
	$content = @$_POST['content'];
	$readpermission = @$_POST['readpermission'];
  $seo = @$_POST['seo'];
  //Get draft value
  $draft = @$_POST['draft'];

  if(@$_GET['action']=='submit' && !@$_GET['mode']){
    $t_name = @$_POST['topic_name'];
    $content = @$_POST['content'];
    $readpermission = @$_POST['readpermission'];
    $seo = @$_POST['seo'];

    if($t_name && $content){
      if(strlen($t_name) <= 70){
        $fid = @$_POST['forumselect'];

        $stmt = $pdoconnect->prepare("INSERT INTO threads(fid, topic_name, topic_content, author, draft, 
          date, rights, seo) VALUES(? ,?,?,?,?, NOW() ,?,?)");

        $stmt->bindValue(1, $fid);
        $stmt->bindValue(2, $t_name);
        $stmt->bindValue(3, $content);
        $stmt->bindValue(4, @$_SESSION["id"]);
        $stmt->bindValue(5, $draft);
        $stmt->bindValue(6, $readpermission);
        $stmt->bindValue(7, $seo);

        $stmt->execute();

        $tid = $pdoconnect->lastInsertId();

        echo $tid;
        echo "<script>window.location = 'thread.php?id=$tid'</script>";
        
      }else echo $wordcount;
    }else echo $nocontent;
  }

  //This is the case where the posting is an edit action
  if(@$_GET['action'] == 'submit' && @$_GET['mode']=='edit'){
    if($t_name && $content){
      if(strlen($t_name) <=70){
        $query = mysqli_query($connect, "UPDATE threads SET topic_name = '".$t_name."', topic_content = '".$content."', rights = '".$readpermission."', seo='".$seo."' 
          , draft = '".$draft."' WHERE topic_id = ".$editid.";");
        echo "<script>window.location = 'thread.php?id=$tid'</script>";
      } else echo $wordcount;

    }else echo $nocontent;
  }
?>
