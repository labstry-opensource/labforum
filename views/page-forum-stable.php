<?php
if(!isset($_SESSION)) session_start();
$fid = @$_GET['id'];
$roles = new UserRoles($pdoconnect);
$roles->getUserRole(@$_SESSION['id']);
$forum = new Forum($pdoconnect);

$forum_arr = $forum->getSubformByFid($fid);
$forumname = $forum_arr['fname'];
$rules = $forum_arr['rules'];
?>

<html>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta name='description' content='Labstry 論壇是一個全方位的論壇。用戶可以在此討論多方面的話題。話題涵蓋用戶的生活方式到有關電腦程式開發等相關的話題'/>
<meta name='keywords' content='Labstry, 論壇, AI, Android ROM, 生活方式, 分享, 討論, 電腦, 程式開發'>
<style type="text/css">
    .header{
        float:left;
    }
    .titleshow{
        margin-left: 40px;
    }
    a{
        text-decoration: none;
    }
    .moderator{
        clear:both;
        margin-left:40px;
    }
</style>
<link rel="stylesheet" href="menu/dynamicmenu.css"/>
<link rel="stylesheet" href="css/threadliststyle.css"/>
<head>
    <?php
    echo "<Title>$forumname</Title>\n";
    ?>
</head>
<body>
<?php
include("menu/header.php");
$viewpage = "viewforum";
//The only subheader in use is in the root one

?>
<div class="fakesubheader">
    <div class="searchbarwrapper">
        <div class="search" id="close" style="display:inline-block;vertical-align: middle" >
            <img src="../menu/images/cross.png" style="width:40px; height:40px" class="buttonimg"/>
        </div>
    </div>
</div>
<div class="searchresultprovider">
    <?php
    if(!is_null($rules)){
        echo $rules;
    }else{
        echo "暫未設定板塊";
    }
    ?>
</div>

<?php
echo "\n<div class='titleshow'>";
echo "\n<h1 class='header'>$forumname</h1><h4 class='header'>&emsp;(fid: $fid)</h4>";
echo "\n</div>";
//We show all the moderators in this forum

if($mods = $forum->getModerators($fid)){
    echo "\n<div class='moderator'>本版版主: ";
    $counter = 0;
    $mod_arr = array();
    foreach($mods as $key => $mod){
        $mod_arr[] = $mod['username'];
    }
    echo implode(', ', $mod_arr);
    echo "</div>\n";

}
else{
    echo "<div class='moderator'>版主位置空置</div>";
}

?>
<div id='wrapper' style='clear: both'>
    <br/>
    <br/>
    <div style="" id="postshow">
        <?php
        $rights = $roles->rights;
        $connect = mysqli_connect('localhost', 'playground', 'plyg2043', 'php_forum');
        //We should first display the sticky threads
        $stickyquery = mysqli_query($connect, "SELECT * FROM threads t, subforum s WHERE draft=0 AND stickyness<>0 AND s.fid = t.fid AND s.fid='$fid' AND t.rights <= '$rights' ORDER BY stickyness DESC,  topic_name ASC");
        while($stickythread = mysqli_fetch_assoc($stickyquery)){
            /* You will also get the highlight colors of thread, as well as sticky valid date */
            $forumid = $stickythread['fid'];
            $date = $stickythread['date'];
            $topicid = $stickythread['topic_id'];
            $topic_name = $stickythread['topic_name'];
            $views = $stickythread['views'];
            $topicauthor = $stickythread['author'];
            $highlightcolor = $stickythread['highlightcolor'];
            $url = $stickythread['url'];
            $fname = $stickythread['fname'];

            echo "<div class='amazeui' style='background-color:".$highlightcolor."'>";

            echo "\n\t\t<a class='refreshable' href='thread.php?id=$topicid'style='width:400px;display:block;background-color:"
                .$highlightcolor."' >
                            <div class='topic'>".$topic_name."</h1><br/>
             <div class='description'>".$fname."| ".$topicauthor."| 閱讀次數:".$views.
                " |&nbsp;";
            echo          $date;
            echo "</div></div>";
            echo "</a>";
            echo "</div>";

        }


        $threadcheck = mysqli_query($connect, "SELECT * FROM threads t, subforum s WHERE draft = 0 AND stickyness =0 AND s.fid=".$fid." 
        								 		AND s.fid = t.fid ORDER BY topic_id DESC ");
        if(mysqli_num_rows($threadcheck) != 0){
            while($threadrow = mysqli_fetch_assoc($threadcheck)) {
                /* This is where you got all the thread items,
                 * from that it will help us to display amaze ui contents
                 *
                 */

                /* Unnecessary. We have already got the forum name
                $forumid = $row['fid'];
                $fname = (mysqli_fetch_assoc($checkforumname))['fname'];
                */
                $id = $threadrow['topic_id'];
                //The code below is the dynamic content filler

                echo "<div class='amazeui'>";

                echo "\n\t\t<a class='refreshable' href='thread.php?id=$id'style='width:400px;display:block;' >
                            <div class='topic'>" . $threadrow['topic_name'] . "</h1><br/>
			    <div class='description'>" . $forumname . "| " . $threadrow['author'] . "| 閱讀次數:" . $threadrow['views'] .
                    " |&nbsp;";
                echo $threadrow['date'];
                echo "</div></div>";
                echo "</a>";
                echo "</div>";
            }
        }
        echo "\n\t</div>";
        //End of thread links
        echo "\n</div>\n";
        ?>
</body>


</html>