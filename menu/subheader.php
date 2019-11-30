<link rel="stylesheet" href="css/uikit.css" />
<script src="js/uikit.js"></script>
<script src="js/uikit-icons.js"></script>
<style>
.submenu{
}
.button{
  position:absolute;
  background-color: rgba(75, 210, 176 , 0.8);
  z-index:900;
}
.left{
  left:0;
  border-radius:0px 0px 0px 15px;
}
.right{
  right:0;
  border-radius:0px 0px 15px 0px;
}
.bgwrapper{
  overflow: hidden;
}
.dummy-child{
  height:100%;
}
.dummy-child, .icon{
  display:inline-block;
  vertical-align: middle;
}
a{
  text-decoration: none;
}
</style>


<?php
require_once("ranking.php");
/* If the class is search, DO NOT PUT A REAL <a ON THEM, 
/* In other words, put '#' on href of search <a>
/*
/*
 */
//These are forum related

if($viewpage == "profile"){
  echo "<div class='submenu' style='overflow:hidden;background-color: #ACACAC; clear:both; width: 100%; height: 100px;'>";
  echo  "<h3 class='useraction'><a class='submenuitem' href='/account.php'>帳戶設定</a></h3>";
  echo  "<h3 class='useraction'><a class='submenuitem' href='/account/members.php'>找朋友</a></h3>";
  echo  "<h3 class='useraction'><a class='submenuitem' href='#'>我的帖子</a></h3>";
  echo   "</div>";
}

if($viewpage == "forumindex"){
  //echo "<div style='white-space:nowrap'>";
  /*
  echo "\n\t<div class='' style='display:inline-block;height:100px'>";
  echo "\n\t\t<";
  echo "\n\t</div>";
  */
 echo "<div class='bgwrapper' style='white-space:nowrap;background-color: #4BD2B0; width:100%;border-radius:0px 0px 15px 15px'>";
  //left button
  echo "\n\t<a href='#' class='button left' style='display:inline-block;height:100px;'>";
  echo "<div class='dummy-child'></div>";
  echo "\n\t\t\t<img src='data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAMAAAAM7l6QAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAaFQTFRFAAAA////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////ja4xQQAAAIt0Uk5TAAIdse7VInby/vgYkun61gRMrvTrgzMRScT2/+yCJAUUfcf3/dFuG23Z/OFwGQgumdy1aBcHP5DDThYBCrbl8KBRDliv86c+EANezO9/OQsfyfvfkR7C0nQx3siaGmMrTbmAEhNSuObTcTWf56EtR+SFCZQ2jbQsefVVZcViYUvx0CNCvfnGPKaz2mgI1GcAAAFASURBVHicY2DABIxMzCysWMShsmzsHJxcOKW5eXg5+fhxSAoICglzioiKYZcVl5CUkpaRlZPHKqugqKSsoqqmjl2WTUOTS0tbR5cRm6SevoEhn5SRsQlWWVMzc14VYQtLK2tssjaCtnZa9g6OTlhl9ZxdXDnt3Nw9sEl6cnt5+6ho+/r5Y9Ub4BWoEhQcEordQwyyYVyc4RGR2CUZGKK4pIPMuQVwSUdzcGrFxHriko4T8pE21InHJW2SkCjNp5qUjEOaMSU1LV05IzNLD6vHgCAr254zJzfPBoe0ab6RiFZBoR8u9xXlF6dr2eWWOOFyYHKpYZB0GY5IAYLyioxK4bCqFFweEK+u4eMLr7XBpd+qTlWYL6M+BVf4CjgLNUg3xjXhcp9Tc0tlaxs7LmkG+faOSi07nNIMpmKdXdEQJgCP3ThGEVzSaQAAAABJRU5ErkJggg==' class='icon' style='height:30px;width:30px;'/>";
  echo "\n\t</a>";

  echo "<div class='submenu' style='overflow:hidden; display:inline-block; white-space:nowrap; height: 100px;vertical-align:'>";
  if(@$_SESSION['username']){
    echo  "<div class='useraction'> 
       <a class='submenuitem' href='post.php'>
      \n\t<img src='../menu/images/discussion.png' class='icon' />
      \n\t<div style='text-align:center'>發表新帖&ensp;Thread</div>
      </a></div>";
  }
   echo  "<div class='useraction search'>
            <a class='submenuitem' href='#'>
            <img src='../menu/images/Search.png' class='icon' />
            <div style='text-align:center'>搜尋&ensp;Search</div>
           </a>
        </div>";
  
  
    echo  "<div class='useraction'> 
       <a class='submenuitem' href='forumlist.php'>
      \n\t<img src='../menu/images/discussion.png' class='icon' />
      \n\t<div style='text-align:center'>板塊&ensp;Thread</div>
      </a></div>";
  
 echo  "<div class='useraction'> 
       <a class='submenuitem' href='index.php'>
      \n\t<img src='../menu/images/msg.png' class='icon' />
      \n\t<div style='text-align:center'>訊息(即將推出)&ensp;Messages</div>
      </a></div>";
  echo   "</div>";
  //Right button
  echo "\n\t<a href='#' class='button right' style='display:inline-block;height:100px;vertical-align:top;float:right;'>";
  echo "<div class='dummy-child'></div>";
  echo "\n\t\t<img src='../menu/images/right.png' class='icon' style='height:30px;width:30px;'/>";
  echo "\n\t</div>";
  echo "</a>";
  //echo "</div>";
}

if($viewpage == "thread"){
  echo "<div class='submenu' style='background-color: #ACACAC; clear:both; width: 100%; height: 100px;'>";
  if(@$_SESSION['username']){
    echo  "<div class='useraction'> 
       <a class='submenuitem' href='post.php'>
      \n\t<img src='../menu/images/discussion.png' class='icon' />
      \n\t<div style='text-align:center'>發表新帖&ensp;Thread</div>
      </a></div>";
    echo  "<h3 class='useraction'><a class='submenuitem' href='#replybox'>回覆</a></h3>";
    echo   "</div>";
  }
  else{
    echo  "<h3 class='useraction'><a class='submenuitem' href='login.php?from=thread.php?id=$threadid'>登入以回覆</a></h3>";
    echo   "</div>";
  }
}

if($viewpage == "viewforum"){
  require_once('ranking.php');
  echo "<div class='bgwrapper' style='white-space:nowrap;background-color: #4BD2B0; width:100%;border-radius:0px 0px 15px 15px'>";
  //left button
  echo "\n\t<a href='#' class='button left' style='display:inline-block;height:100px;'>";
  echo "<div class='dummy-child'></div>";
  echo "\n\t\t\t<img src='../menu/images/left.png' class='icon' style='height:30px;width:30px;'/>";
  echo "\n\t</a>";

  echo "<div class='submenu' style='overflow:hidden; display:inline-block; white-space:nowrap; height: 100px;vertical-align:'>";
  if(@$_SESSION['username']){
    echo  "<div class='useraction'> 
       <a class='submenuitem' href='post.php'>
      \n\t<img src='../menu/images/discussion.png' class='icon' />
      \n\t<div style='text-align:center'>在此板塊發帖&ensp;Posting Thread Here</div>
      </a></div>";
  }

  //Check if he/she is Moderator/Super Moderator/Admin
  if($role == "3"){
    $checkright = mysqli_query($connect, "SELECT * FROM Moderators WHERE fid='".$fid."' AND id='".$uid."';");
    if(mysqli_num_rows($checkright)){
      $hasright = 1;
    }
    else $hasright = 0;
  }
  if($role == "1" || $role == "2" || ($role == "3" && $hasright)){
      echo  "<div class='useraction'> 
       <a class='submenuitem' href='index.php'>
      \n\t<img src='../menu/images/msg.png' class='icon' />
      \n\t<div style='text-align:center'>管理板塊頁面&ensp;Manage Forum Page</div>
      </a></div>";
  }


  echo   "</div>";
  //Right button
  echo "\n\t<a href='#' class='button right' style='display:inline-block;height:100px;vertical-align:top;float:right;'>";
  echo "<div class='dummy-child'></div>";
  echo "\n\t\t<img src='../menu/images/right.png' class='icon' style='height:30px;width:30px;'/>";
  echo "\n\t</div>";
  echo "</a>";
  //echo "</div>";
}

if($viewpage == "postedit"){
        echo "<div class='submenu' style='background-color: #ACACAC; clear:both; width: 100%; height: 100px;'>";
	echo  "<div class='useraction'>";
	if(@$_GET['mode'] == 'edit')
		echo "<a class='submenuitem' href='#' id='post'>儲存該內容</a></h3>";
	else{
	       	echo "<a class='submenuitem' style='display:block' href='#' id='post'>發表該內容</a></h3>";
		echo "<a class='submenuitem' style='display:none' href='#' id='draft'>儲存到草稿</a></h3>";
	}
	
	echo "</div>";
	echo "<div class='useraction'>";
	echo "<a class='submenuitem search' href='#' id='setting'>帖子設定</a></h3>";
	echo "</div>";
        echo "</div>";
}

//These are shop related
if($viewpage == "Personal"){
  echo "<div class='submenu' style='overflow:hidden; background-color: #4BD2B0; clear:both; width: 100%; height: 100px;'>";
  echo  "<div class='useraction'> 
       <a style='text-decoration:none;' class='submenuitem' href='cart.php'>
      \n\t<img src='menu/images/Cart.png' class='icon' />
      \n\t<div style='text-align:center;text-decoration:none'>購物車&ensp;Cart</div>
      </a></div>";
  echo  "<div class='useraction'>
      <a style='text-decoration:none;' class='submenuitem' href='list.php'>
      \n\t<img src='menu/images/time.png' class='icon' />
      \n\t<div style='text-align:center;text-decoration:none'>購買記錄&ensp;Purchases</div>
      </a></div>";
  echo  "<div class='useraction'>
      <a style='text-decoration:none;' class='submenuitem' href='status.php'>
      \n\t<img src='menu/images/truck.png' class='icon' />
      \n\t<div style='text-align:center;text-decoration:none'>商品狀態&ensp;Shipping status</div>
      </a></div>";
  echo   "</div>";
}

if($viewpage == "ShopIndex"){
  echo "<div class='submenu' style='overflow:hidden;background-color: #4BD2B0; clear:both; width: 100%; height: 100px;'>";
  echo  "<div class='useraction'>
            <a style='text-decoration:none;color:white;' class='submenuitem' href='index.php'>
            <img src='menu/images/hot.png' class='icon' />
            <div style='text-align:center;text-decoration:none'>熱門商品&ensp;Hot items</div>
            </a>
        </div>";
  echo  "<div class='useraction'>
	<a style='text-decoration:none;color:white;' class='submenuitem' href='catagory.php'>
	<img src='menu/images/catagory.png' class='icon' />
	<div style='text-align:center;text-decoration:none'>類別&ensp;Catagories</div>
	</a>
	</div>";
  echo  "<div class='useraction search'>
            <a style='text-decoration:none;color:white;' class='submenuitem' href='#'>
            <img src='menu/images/Search.png' class='icon' />
            <div style='text-align:center;text-decoration:none'>搜尋&ensp;Search</div>
            </a>
        </div>";
  echo  "<div class='useraction'>
            <a style='text-decoration:none;color:white;' class='submenuitem' href='cart.php'>
            <img src='menu/images/Cart.png' class='icon' />
            <div style='text-align:center;'>購物車&ensp;Cart</div>
            </a>
        </div>";

  echo   "</div>";
}



  if($viewpage == "catagories"){
	require_once("connect_shopping.php");
	echo "<div style='background-color: #4BD2B0;margin:0'>";
	  

   /*echo  "\n\t<div class='useraction'>                                   
          \n\t\t<a class='submenuitem' href='catagory.php'>
          \n\t\t<img src='menu/images/All.png' class='icon'  style='max-height:64px;max-width:64px;'/>
          \n\t\t<div style='text-align:center'>全部&ensp;All</div>
          \n\t\t</a>
          \n\t</div>";*/
		  
		  
          $query = mysqli_query($shoppingconnect,"select cname,cid,image from catagory");
          echo "<div uk-slider>
              <div class='uk-margin uk-text-center' style='margin:0px;'>
                  <div class='uk-inline-block uk-width-xxlarge'>
                      <div class='uk-slider-container uk-light'>
                          <ul class='uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-6@m '>
               ";
               echo "
                      <li>
                      <a href='catagory.php' style='text-decoration:none;'>
                      <img src='menu/images/All.png' style='max-height:64px;max-width:64px;'/>
                      <div style='font-size:12px;text-align:center;text-decoration:none;'>全部ALL</div>
                      </a>
                      </li>
               ";
               while($result = mysqli_fetch_assoc($query)){
                  $cname = $result['cname'];
                  $cid = $result['cid'];
                  $image= $result['image'];
                   echo "<li>
                      <a href='viewcatagory.php?viewitem=".$result['cid']."' style='text-decoration:none;'>
                      <img src='".$result['image']."' style='max-height:64px;max-width:64px;'/>
                      <div style='font-size:12px;text-align:center;text-decoration:none;'>".$cname."</div>
                      </a>
                      </li>";
              }
                            
          echo "       </ul>
                      </div>
                      <a class='uk-position-center-left-out uk-position-small' href='#'' uk-slidenav-previous uk-slider-item='previous'></a>
                      <a class='uk-position-center-right-out uk-position-small' href='#'' uk-slidenav-next uk-slider-item='next'></a>
                  </div>
              </div>
          </div>
          ";


  echo "</div>";
}
  


  
  
  
?>

<script>
checkSize();
checkScrollPosition(0);

  $(window).on("resize", function(e){
    checkSize();
  });
  // These device could not be simply controlled by button, thus a fallback is applied
  // But in a thorough test, it passes all of our test through Android Samsung browser and Chrome on Android,
  // we just let magic happens again :D
  /* 
  if(navigator.userAgent.match(/(iPod|iPhone|iPad|Android)/)){
     $('.submenu').css({
      'overflow': 'scroll'
     })
     $('.button').css({
      'display': 'none'
     })
  } */
  //Check if scroll button is required in the window
  function checkSize(){
    var barlen = $('.submenu').width() + 75;
    var windowlen = window.innerWidth;
    if(barlen <= windowlen){
      $('.button').css({'display': 'none'});
    }
    else $('.button').css({'display': 'inline-block'});
  }

//Its a bit ugly. But do the right job
function checkScrollPosition(scrollDisp){
	  //reset scroll button to default
	  $('.button').css({'background-color': 'rgba(75,210,176, 0.8)'});
    var windowsize = window.innerWidth;

    //Judge the scroll direction
    //If the Displacement is postive, then it's to the right;
    if(scrollDisp > 0){
	    var ScrollPos = $('.bgwrapper').scrollLeft() + scrollDisp + windowsize;
    }
    else{
      var ScrollPos = $('.bgwrapper').scrollLeft() + scrollDisp;
    }
	  var barlen = $('.submenu').width()+75;
    //alert(ScrollPos + ";" + barlen);
	  //Make button disable when it is at the either end
	  if(ScrollPos <= 0){
	  	$('.left').css({'background-color': 'rgba(255,255,255, 0.3)'});
	  }
	  if(ScrollPos >= barlen){
	  	$('.right').css({'background-color': 'rgba(255,255,255, 0.3)'});
	  }
  }
</script>
<script>
  //Dealing with left and right click of the button
  $('.left').click(function(e){
        var leftPos = $('.bgwrapper').scrollLeft();
    $('.bgwrapper').animate({
      scrollLeft: leftPos - 200
	}, "slow");
	checkScrollPosition(-200);
  });
  $('.right').click(function(e){
    var rightPos = $('.bgwrapper').scrollLeft();
    $('.bgwrapper').animate({
      scrollLeft: rightPos + 200
    }, "slow");
    checkScrollPosition(200);
  });
</script>
