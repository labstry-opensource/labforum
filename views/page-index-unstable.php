<?php
if (! isset($meta)) {
    $meta = array(
        'keywords' => 'Labstry, 論壇, AI, Android ROM, 生活方式, 分享, 討論, 電腦, 程式開發',
        'description' => 'Labstry is a forum for all range of topics ranging from programming to lifestyle.',
        'viewport' => 'width=device-width, initial-scale=1.0'
    );
}
if (! isset($opt_in_script)) {
    $opt_in_script = array(
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.7/jquery.timeago.min.js'
    );
}

header("Content-Type:text/html;charset=utf-8");


$essentials = new Essentials($meta, null, $opt_in_script);

$role = new UserRoles($pdoconnect);
$users = new Users($pdoconnect, "");
$sign = new Sign($pdoconnect);

if (@$_SESSION['id'])
    $role->getUserRole(@$_SESSION['id']);
    
    $essentials->getHeader();
    ?>

<style>
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

  <div class="container">
      <?php

    ?>
  </div>
  <div class="standard-wrapper home-content-wrapper">
      <?php
      if (@$_SESSION['username']) {
          $users->getUserPropById(@$_SESSION['id']);
          $user_details = array(
              'profile' => $users->profilepic,
              'username' => @$_SESSION['username'],
              'rank_name' => $role->role_name,
              'signed_in_today' => $sign->checkIfSigned(@$_SESSION['id']),
              'rights' => 0,
              'continuous_checkin' => $sign->checkContinousSign(@$_SESSION['id'])
          );
      }
      $thread_details = array(
          'thread-url' => 'api/get-home-threads.php',
          'title' => 'Featured',
      );

      include "widgets/landing-greetings-card3.php";
      include "modules/thread-display.php";

      // One time query
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
              <div>The site has <?php

                  echo $numusers;
                  ?> users.</div>
              <div>Newcomer: <a href="account/profile.php?id=<?php

                  echo $newuserid;
                  ?>"><?php

                      echo $newuser;
                      ?></a></div>
              <div>A total of <?php

                  echo $numthreads;
                  ?> threads.</div>
          </div>
      </div>
  </div>

</body>
</html>
<?php
if (@$_GET['action'] == 'checkin') {
    // deprecated for finding id through database !!!!

    // We should protect our code by checking whether user have signed
    // We MUST USE PREPARED STATEMENT HERE TO PREVENT INJECTION
    $id = @$_SESSION['id'];
    $signstatsql = "SELECT COUNT(*) FROM checkin WHERE id = ? AND TO_DAYS(checkindate) = TO_DAYS(NOW())";
    $times = $pdotoolkit->rowCounterWithPara($pdoconnect, $signstatsql, $id);
    if (! $times) {
        $signstmt = $pdoconnect->prepare("INSERT INTO checkin(id, checkindate) VALUES(?, NOW())");
        $signstmt->bindParam(1, $id);
        $signstmt->execute();
        $checkincount = $pdotoolkit->rowCounterWithLimit($pdoconnect, "continuouscheckin", "id=" . $id);

        // When we found a continuous record for checkin, then our action is to update it. Otherwise, we will insert a new record
        if (! $checkincount)
            $contstmt = "INSERT INTO continuouscheckin(id, times) VALUES(?, '1')";
        else
            $contstmt = "UPDATE continuouscheckin SET times = times + 1 WHERE id = ?";

        $contchkin = $pdoconnect->prepare($contstmt);
        $contchkin->bindParam(1, $id);
        $contchkin->execute();
    }
    echo "<script>window.location='index.php';</script>";
    header("Location: index.php");
}
if (@$_GET['action'] == "logout") {
    session_destroy();
    echo "<script>window.location='index.php';</script> ";
}
?>
