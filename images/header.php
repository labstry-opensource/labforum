<style type="text/css">
#clean{
	display:none;
	max-height: 0px;
	transition: max-height 0.5s ease-out;
}
.expanditem{
	display:inline-block;
}
#menudiv:hover #clean{
	max-height: 100px;
	height:100px;
	
}
.expandicon{
	display:none;
}
#menudiv{
  position:fixed;
  z-index: 1000;
  display: inline-block;
	height:50px; 
	width:100%;
	background-color:#00c5ff;
	float:left;

}
#itemwrapper{
  position: fixed;
}
.placeholder{
  height: 50px;
  position: relative;
}
.homeitemwrapper{
  display: inline-block;
}
@media screen and (max-width: 480px){
	#menudiv{
		display:block;
		height: auto;
		overflow-y: visible;
    background-color:transparent;
	}
	.expandicon{
		display:inline-block;
	}
	.expanditem{
		display:none;
    background-color: #00c5ff;
	}
  .homeitemwrapper{
    width:100%;
    background-color: #00c5ff;
  }
}
</style>
<div id="menudiv">
   <div id="itemwrapper" style="height:inherit;width: inherit;">
    <div class="homeitemwrapper">
      <img class='expandicon topmenutoggle' src='/menu/images/left.png' style='transform: rotate(-90deg);'/>
  	  <a class="menuitem home" href="/forum/index.php">Labstry 論壇</a>
    </div>
    <!-- Please look at documentation
      This link will be deprecated soon because it affects the implementation of mobile menu
    <a class="menuitem" href="../index.php">Labstry Shop 商城</a> -->  
	  <a class="menuitem expanditem" href="/forum/viewforum.php?id=1">Labstry General</a>
	  <?php 
    if(@$_SESSION['username']){
  	  $check = mysqli_query($connect, "SELECT * FROM users WHERE username ='".$_SESSION['username']."'");
  	  $rows = mysqli_num_rows($check);
  	  while($row = mysqli_fetch_assoc($check)){
  	  	echo "<a class='menuitem expanditem' href='/forum/account/profile.php?id=".$row['id']."'>".$_SESSION['username']."</a> ";
	echo "<a class='menuitem expanditem' href='/forum/index.php?action=logout'>登出</a>";
      }
    }else{
        echo "<a class='menuitem expanditem' href='/login.php?target=forum'>登入</a>";
    }
	  ?>

   </div>
   <div id="clean" style="background-color: #00c5ff">
   </div>
</div>
<div class="placeholder"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
  //Note: We have already defined jquery here...
  //We don't need new definitions
?>
<script type="text/javascript">

	/* Trigger when browser window resizes so that
	   it could resize the item to make it fit for particular window size
	 */
	$(window).on("resize", function(e){
    	checkSizeHeader();
  	});
	  //Check if scroll button is required in the window
  function checkSizeHeader(){
    var windowlen = window.innerWidth;
    if(windowlen >= 480){
      $('.expanditem').css({'display': 'inline-block'});
    }
    else $('.expanditem').css({'display': 'none'});
	}

/*
  We dont need this function anymore. As it will be loaded later in individual pages
    $(function(){
      $("#itemwrapper a").click(function(ae){
      ......
      )});
*/
    $('.topmenutoggle').click(function(e){
      if($('.expanditem').css('display') =='none'){
      		console.log('Running here');
      		//The item is expanded
           $('.expanditem').css({'display': 'block'});
           $('.expanditem').last().css({'border-radius': '0px 0px 18px 18px'});

      }else{
      		//When the button clicked, the function will judge whether it should appear or just hide it.
      		console.log('Running here');
      		var windowlen = window.innerWidth;
    		if(windowlen >= 480){
      			$('.expanditem').css({'display': 'inline-block'});
   			}
    			else $('.expanditem').css({'display': 'none'});
      }
    });
</script>
