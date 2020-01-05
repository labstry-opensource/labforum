 <?php
 if(!isset($home_url)){
     $home_url = '/forum/';
 }

 if(!isset($footer_details)){
     $footer_details = array(
         'statistic' => array(
             'num_users' => 0,
             'new_comer' => 'No users yet. Become the first user! ',
             'new_comer_id' => null,
         ),
         'links'=> array(
             //One array stands for a column
             0 => array(
                 array(
                     'href' => '/login3.php',
                     'name' => 'Login',
                 )
             ),
             1 => array(
                 array(
                     'href' => '/register.php',
                     'name' => 'Register',
                 )
             )
         )
     );
 }
 ?>

        <footer data-title="Statistic" id="footer-stats" class="pushed-el-cards">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                  <path fill="#f3f4f5" fill-opacity="1" d="M0,224L30,234.7C60,245,120,267,180,234.7C240,203,300,117,360,122.7C420,128,480,224,540,240C600,256,660,192,720,181.3C780,171,840,213,900,234.7C960,256,1020,256,1080,250.7C1140,245,1200,235,1260,202.7C1320,171,1380,117,1410,90.7L1440,64L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path>
            </svg>
            <section class="footer" style="min-height: 400px; background-color: #f3f4f5; color: #909090; margin-top: -.25em">
                <div class="container">
                   <h3 class="h1 text-center py-3">
                        <img src="<?php echo $home_url; ?>/images/system/logof.svg" style="max-width: 100px" alt="">
                    </h3>
                    <div class="row">
                        <h5 class="col">
                            <span class="h1">
                                <large><?php echo $footer_details['statistic']['num_users']?></large>
                            </span> users.
                        </h5>
                        <h5 class="col">
                            <span class="h1">
                                <div><large>Labforumer: </large></div>
                            </span>
                            <a class="text-decoration-none" href="account/profile.php?id=<?php echo $footer_details['statistic']['new_comer_id']?>"><?php echo $footer_details['statistic']['new_comer']?></a>
                        </h5>
                    </div>
                    <div class="row py-5">
                        <div class="col-6">
                            <a href="/login3.php">Login</a>
                        </div>
                        <div class="col-6">
                            <a href="/register.php">Register</a>
                        </div>
                    </div>
                </div>
            </section>
        </footer>

    </body>
</html>