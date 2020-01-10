<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type:text/html;charset=utf-8");

$header = new HeaderGenerator($pdoconnect);
$role = new UserRoles($pdoconnect);
$users = new Users($pdoconnect, "");
$sign = new Sign($pdoconnect);

if(@$_SESSION['id'])
    $role->getUserRole(@$_SESSION['id']);
    ?>
<html>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta name='description' content='Labstry 論壇是一個全方位的論壇。用戶可以在此討論多方面的話題。話題涵蓋用戶的生活方式到有關電腦程式開發等相關的話題'/>
  <meta name='keywords' content='Labstry, 論壇, AI, Android ROM, 生活方式, 分享, 討論, 電腦, 程式開發'>
  <style>
.show-when-loaded{
    display: none;
}
.name{
  color:white;
  padding: 20px;
  font-size: 16px;
}
.oneliner{
    vertical-align: top;
    display: inline-block;
}
.horizontal-btn{
    padding-left: 50px;
    padding-right: 50px;
    display: inline-block;
}
.divider{
	width: 100%;
	height: 2px;
	background-color: #ACACAC;
}
pre {
    white-space: pre-wrap;
}
 @media screen and (max-width: 480px){
    .roledisplay{
      text-align: left;
    }
    .detailsdiv, .avatarpic{
      vertical-align: middle;
      display: inline-block;
    }
  }
  </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js" integrity="sha256-chlNFSVx3TdcQ2Xlw7SvnbLAavAQLO0Y/LBiWX04viY=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <head>
  <title>Labstry 論壇- 首頁</title>
  </head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/fontawesome.min.css" integrity="sha256-0mlw4Ae1j9eDzZTzLuw5X9fBCL9nAehrtVyKfIstZQA=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/solid.min.css" integrity="sha256-xlh4aT8Ni/MnbIvFWbnIrJ+YKe+1S/y1xNQl7YWArXc=" crossorigin="anonymous" />
  <body style="margin: 0">
  <?php
include_once("menu/header.php");
    //The submenu is no longer used, so as the fake search bar. These items are either integrated into widget->header or widget->landing-greetings-card
  ?>
  <div class="standard-wrapper home-content-wrapper">
      <?php if(@$_SESSION['username']) {
          $users->getUserPropById(@$_SESSION['id']);
          $user_details = array(
              'profile' => $users->profilepic,
              'username' => @$_SESSION['username'],
              'rank_name' => $role->role_name,
              'signed_in_today' => $sign->checkIfSigned(@$_SESSION['id']),
              'rights' => 0,
              'continuous_checkin' => $sign->checkContinousSign(@$_SESSION['id']),
          );
      }
      include dirname(__FILE__)."/../widgets/landing-greetings-card.php";
      ?>

      <div style="font-size: 24px; width:98%; margin: 0 auto; padding-top: 15px; padding-bottom: 15px;">
          Featured
      </div>

      <div class="postshow" v-if="home_threads === undefined">
          <div class="card" style="display:block; height: auto">
              <?php include dirname(__FILE__)."/../widgets/loading-circle.php" ?>
          </div>
      </div>
      <thread_card v-bind:threads="home_threads"></thread_card>
      <?php
      //One time query
      $users->getNewestUser();
      $newuser = $users->username;
      $newuserid = $users->userid;
      $numusers = $users->getUserCount();
      $numthreads = $pdotoolkit->rowCounterWithLimit($pdoconnect, "threads");
      ?>
      <div class="divider"></div>

      <div class="card">
          <div class="intro" style="display:block;background-color:#add8e6; padding: 20px; height: 50px">Statistic</div>
          <div class="contentpreview" style="width: 100%; padding: 20px;">
              <div>The site has <?php echo $numusers; ?> users.</div>
              <div>Newcomer: <a href="account/profile.php?id=<?php echo $newuserid; ?>"><?php echo $newuser; ?></a></div>
              <div>A total of <?php echo $numthreads; ?> threads.</div>
          </div>
      </div>
  </div>
  <?php include dirname(__FILE__)."/../widgets/legacy/thread-card.php" ?>

  <script type="text/javascript">
      // Let the document know when the mouse is being used
      document.body.addEventListener('mousedown', function() {
          document.body.classList.add('using-mouse');
      });
      document.body.addEventListener('keydown', function() {
          document.body.classList.remove('using-mouse');
      });
      var indexApp = new Vue({
          el: '.home-content-wrapper',
          data:{
              home_threads: undefined,
          },
          mounted: function(){
              this.loadHamburgerScript();
              this.loadStylesheet();
              this.getHomeThread();
          },
          methods:{
              getHomeThread: function(){
                  var self = this;
                  $.ajax({
                      url: 'api/threads-engine.php?page=home',
                      method: 'GET',
                      success: function(data){
                          self.home_threads = data;
                      }
                  });
              },
              loadStylesheet: function(){
                  var self = this;
                  $.ajax({
                      url: 'css/stylesheets/header.css?v=<?php echo filemtime('css/stylesheets/header.css') ?>',
                      success: function(data){
                          $('head').append("<style>" + data + "</style>");
                      }
                  });
                  $.ajax({
                      url: 'menu/dynamicmenu.css',
                      success: function(data){
                          $('head').append("<style>" + data + "</style>");
                      }
                  });
                  $.ajax({
                      url: 'css/index.css',
                      success: function(data){
                          $('head').append("<style>" + data + "</style>");
                      }
                  });
                  $.ajax({
                      url: 'css/stylesheets/main.css',
                      success: function(data){
                          $('head').append("<style>" + data + "</style>");
                      }
                  })
              },
              loadHamburgerScript: function(){
                  var self = this;
                  $.getScript("js/toggle.js", function(data){
                      //$('body').append("<script>" + data + "<\/script>");
                  })
              }
          }
      });
  </script>
  <script>
      $(document).on('submit', '.searchform', function(e) {
          if (e.delegateTarget.activeElement.type!=="submit") {
              e.preventDefault();
          }
      });
      //Show checkin counter
      $('.counter').each(function() {
          var $this = $(this),
              countTo = $this.attr('data-count');

          $({ countNum: $this.text()}).animate({countNum: countTo},
              {

                  duration: 800,
                  easing:'linear',
                  step: function() {
                      $this.text(Math.floor(this.countNum));
                  },
                  complete: function() {
                      $this.text(this.countNum);
                  }

              });

      });
  </script>
  </body>
</html>
<?php
  if(@$_GET['action'] == 'checkin'){
    //deprecated for finding id through database !!!!

    //We should protect our code by checking whether user have signed
    //We MUST USE PREPARED STATEMENT HERE TO PREVENT INJECTION
    $id = @$_SESSION['id'];
    $signstatsql = "SELECT COUNT(*) FROM checkin WHERE id = ? AND TO_DAYS(checkindate) = TO_DAYS(NOW())";
    $times = $pdotoolkit->rowCounterWithPara($pdoconnect, $signstatsql, $id);
    if(!$times){
      $signstmt = $pdoconnect->prepare("INSERT INTO checkin(id, checkindate) VALUES(?, NOW())");
      $signstmt->bindParam(1, $id);
      $signstmt->execute();
      $checkincount = $pdotoolkit->rowCounterWithLimit($pdoconnect, "continuouscheckin", "id=".$id);

      //When we found a continuous record for checkin, then our action is to update it. Otherwise, we will insert a new record
      if(!$checkincount) $contstmt = "INSERT INTO continuouscheckin(id, times) VALUES(?, '1')";
      else $contstmt = "UPDATE continuouscheckin SET times = times + 1 WHERE id = ?";

      $contchkin = $pdoconnect->prepare($contstmt);
      $contchkin->bindParam(1, $id);
      $contchkin->execute();
    }
    echo "<script>window.location='index.php';</script>";
    header("Location: index.php");
  }
  if(@$_GET['action']== "logout"){
    session_destroy();
    echo "<script>window.location='index.php';</script> ";
  }
?>
