<?php
//require_once dirname(__FILE__)."/../classes/LoginPolicy.php";

//$policy = new LoginPolicy($pdoconnect, "" , "");

if(!isset($_SESSION)) session_start();
  //This value is to check whether it's in maintainance state
  $testmode = false;
  //require_once(@$_SERVER['DOCUMENT_ROOT']."/forum/testmodule.php");


?>
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
  box-sizing: border-box;
	background-color: #4BD2B0;
	float:left;

}
#itemwrapper{
  position: fixed;
  border-radius: 22px;
  background-color:#00c5ff;
  border: 1px solid transparent;
}
.placeholder{
  height: 50px;
  position: relative;
  background-color:#4BD2B0;
}
.homeitemwrapper{
  display: inline-block;
}
@media screen and (max-width: 480px){
	#menudiv{
		display:block;
		height: auto;
		overflow-y: visible;
    background-color:#4BD2B0;
    border-radius: 0px;
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
      <img class='expandicon topmenutoggle' src='data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAMAAAAM7l6QAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAaFQTFRFAAAA////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////ja4xQQAAAIt0Uk5TAAIdse7VInby/vgYkun61gRMrvTrgzMRScT2/+yCJAUUfcf3/dFuG23Z/OFwGQgumdy1aBcHP5DDThYBCrbl8KBRDliv86c+EANezO9/OQsfyfvfkR7C0nQx3siaGmMrTbmAEhNSuObTcTWf56EtR+SFCZQ2jbQsefVVZcViYUvx0CNCvfnGPKaz2mgI1GcAAAFASURBVHicY2DABIxMzCysWMShsmzsHJxcOKW5eXg5+fhxSAoICglzioiKYZcVl5CUkpaRlZPHKqugqKSsoqqmjl2WTUOTS0tbR5cRm6SevoEhn5SRsQlWWVMzc14VYQtLK2tssjaCtnZa9g6OTlhl9ZxdXDnt3Nw9sEl6cnt5+6ho+/r5Y9Ub4BWoEhQcEordQwyyYVyc4RGR2CUZGKK4pIPMuQVwSUdzcGrFxHriko4T8pE21InHJW2SkCjNp5qUjEOaMSU1LV05IzNLD6vHgCAr254zJzfPBoe0ab6RiFZBoR8u9xXlF6dr2eWWOOFyYHKpYZB0GY5IAYLyioxK4bCqFFweEK+u4eMLr7XBpd+qTlWYL6M+BVf4CjgLNUg3xjXhcp9Tc0tlaxs7LmkG+faOSi07nNIMpmKdXdEQJgCP3ThGEVzSaQAAAABJRU5ErkJggg==' style='transform: rotate(-90deg);'/>
  	  <a class="menuitem home" href="/forum/index.php">Labstry 論壇</a>
    </div>
    <!-- Please look at documentation
      This link will be deprecated soon because it affects the implementation of mobile menu
    <a class="menuitem" href="../index.php">Labstry Shop 商城</a> -->  
    <a class="menuitem expanditem" href="/focussight/index.php">FocusSight</a>
	  <a class="menuitem expanditem" href="/forum/viewforum.php?id=1">Labstry General</a>
<?php 
    if(@$_SESSION['username'] && $policy->validateUser(@$_SESSION['username'])){
?>
  	<a class="menuitem expanditem" href="/forum/account/profile.php?id=<?php echo @$_SESSION['id']; ?>"><?php echo @$_SESSION['username']?></a>
	  <a class="menuitem expanditem" href="/forum/index.php?action=logout">Logout</a>

<?php
}else{
?>
    <a class="menuitem expanditem" href="/login.php?target=/forum/index.php">Login</a>
<?php
}
?>

   </div>
   <div id="clean" style="background-color: #00c5ff">
   </div>
</div>
<div class="placeholder"></div>
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

    $(window).scroll(function(e){
      var scroll = $(window).scrollTop();
      if(scroll > 50){
        $('#menudiv').css({
          'background-color': 'transparent'
        });
      }else if(scroll <= 50){
        $('#menudiv').css({
          'background-color': '#4BD2B0'
        });
      }
      if(scroll > 150){
        $('#itemwrapper').css({
          'border': '1px solid white'
        });
      }else{
        $('#itemwrapper').css({
          'border': '1px solid transparent'
        });
      }
    });
</script>
