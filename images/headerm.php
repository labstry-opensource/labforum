<style type="text/css">
#clean{
	display:none;
	max-height: 0px;
	transition: max-height 0.5s ease-out;
}
#menudiv:hover #clean{
	max-height: 100px;
	height:100px;
	
}
#menudiv{
	height:50px; 
	width:100%;
	background-color:#00c5ff;
	float:left;

}
@media screen and (max-width: 480px){
	#menudiv{
		display:block;
		height: auto;
		overflow-y: visible;
	}
}
</style>
<div id="menudiv">
   <div id="itemwrapper" style="height:inherit;width: inherit;">
    <div class='topmenutoggle'>
      <img class='expandicon' src='/menu/images/left.png' style='transform: rotate(-90deg);'/>
    </div>
	  <a class="menuitem home" href="/forum/index.php">Labstry 論壇</a>
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
        echo "<a class='menuitem' href='/login.php?target=forum'>登入</a>";
    }
	  ?>

   </div>
   <div id="clean" style="background-color: #00c5ff">
   </div>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="/forum/nanobar.js"></script>
<script type="text/javascript">
    $(function(){
      $("#itemwrapper a").click(function(ae){
        var nanobar =new Nanobar();
        nanobar.go(30);
        ae.preventDefault();
        link = this.href;
        $.get(link, function(data){
          document.open();
          document.write(data);
          document.close();
          nanobar.go(70);
          $.cache = {};
        }, "text");
        nanobar.go(100);
        history.pushState("","",link);
      }
      )});

    $('.topmenutoggle').click(function(e){
      if(('.expanditem').css('display') == none){
           $('.expanditem').css({'display': 'block'});
      }else{
            $('.expanditem').css({'display': 'block'});
      }
    });
</script>
