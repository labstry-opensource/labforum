<?php
defined('LAF_ROOT_PATH') || define('LAF_ROOT_PATH', dirname(__FILE__));
defined('API_PATH') || define('API_PATH', LAF_ROOT_PATH . '/api');
defined('DIR') || define('DIR', dirname(__DIR__));
defined('BASE_ROOT_URL') || define('BASE_ROOT_URL', str_replace(DIR, '', LAF_ROOT_PATH));
defined('BASE_ROOT_API_URL') || define('BASE_ROOT_API_URL', BASE_ROOT_URL . '/api');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@latest/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_ROOT_URL . '/css/stylesheets/installer.css'?>">

    <script src="https://unpkg.com/jquery@3.4.1/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/bootstrap@latest/dist/js/bootstrap.min.js"></script>
    <title>Install Labforum</title>
</head>
<style>

</style>
<body>
<div class="d-flex align-items-center w-100">
    <form class="reg-form p-3 w-100"
          action="<?php echo BASE_ROOT_API_URL . '/check-db-connection.php'?>"
          method="post" style="background-color: #fff;">
        <div class="container">
            <div class="py-5 px-3" style="background-color: #4BD2B0; color: white; border-radius: 25px">
                <h1 class="h2">Welcome to Labforum 3...</h1>
                <span>Note: The data below is only used to generate a config file for us to access your forum database. To prevent server attack, please only proceed if you are <b>installing locally or when you use HTTPS.</b></span>
            </div>
            <div class="p-3">
                <div class="form-group">
                    <label for="lang">Language:</label>
                    <select name="language" id="lang" class="form-control">
                        <option value="en" selected>English</option>
                        <option value="zh-hk">繁體中文</option>
                    </select>
                </div>
                <div class="form-group">
                    Type of your DB
                    <select name="db_type" id="" class="form-control">
                        <option value="mysql">MySQL / MariaDB</option>
                        <option value="mssql">SQL Server</option>
                        <option value="oracle">Oracle DB</option>
                    </select>
                    <div class="invalid-feedback db_type-invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="addr">What's your DB's address and port ?</label>
                    <div class="form-row">
                        <div class="col-8">
                            <input type="text" name="serveraddr" id="addr" class="form-control serveraddr" value="127.0.0.1">
                        </div>
                        <div class="col-4">
                            <input type="text" name="db_port" value="">
                            <small class="form-text text-muted">Leave it blank if you want to use default configuration.</small>
                        </div>

                    </div>

                    <div class="invalid-feedback serveraddr-invalid-feedback"></div>
                </div>
                <div class="form-group">
                    Pick a good database name...
                    <input type="text" name="dbname" class="form-control dbname">
                    <div class="invalid-feedback dbname-invalid-feedback"></div>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" id="delete_db_when_exists" name="delete_db_when_exists" class="form-check-input dbname">
                    <label for="delete_db_when_exists" class="form-check-label">Delete database if exists</label>
                </div>
                <div class="form-row form-group">
                    <div class="col-12 col-md-6">
                        Your database username
                        <input type="text" name="username" class="form-control username">
                        <div class="invalid-feedback username-invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        ,and your database password...
                        <input type="password" name="password" class="form-control password">
                        <div class="invalid-feedback password-invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-12 col-md-6">
                        Superuser for creating database
                        <input type="text" name="superuser" class="form-control superuser">
                        <div class="invalid-feedback superuser-invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        ,and superuser's password...
                        <input type="password" name="superuserpassword" class="form-control superuserpassword">
                        <div class="invalid-feedback superuserpassword-invalid-feedback"></div>
                    </div>
                    <small class="form-text text-muted">We will use the superuser to grant the database user with minimal privileges.</small>
                </div>
                <div class="form-group">
                    <button class="btn btn-light" style="border-radius: 24px">Install</button>
                </div>
            </div>

        </div>
    </form>
    <div class="modal fade" id="loading-modal" data-backdrop="static"  tabindex="-1"
         role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content overflow-hidden" style="border-radius: 24px;">
                <div class="modal-body msg-body py-5" style="background-color: #4BD2B0;">
                    <h3 class="text-light install-msg-title">Installing Labforum...</h3>
                    <div class="progress-div p-3">
                        <div class="core-install p-3">Installing core components... <span class="status"></span></div>
                        <div class="updating-database p-3">Updating database... <span class="status"></span></div>
                        <div class="post-installation p-3">Post installation settings <span class="status"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="error-modal" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content overflow-hidden" style="border-radius: 24px;">
                <div class="modal-body py-5 bg-danger">
                    <h3 class="text-light install-msg-title">Error installing...</h3>
                    <div class="text-light install-msg-content">
                        Message: <div class="message-error-installing"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var api_path = <?php echo json_encode(BASE_ROOT_API_URL); ?>;
    $('form').on('submit', function(e){
        e.preventDefault();
        $('.is-invalid').removeClass('is-invalid');
        $.ajax({
            url: api_path + '/check-db-connection.php',
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(data){
                if(data.error){
                    for(var key in data.error){
                        $('.' + key).addClass('is-invalid');
                        $('.' + key + '-invalid-feedback').html(data.error[key]);
                    }
                }else{
                    $('#loading-modal').modal('show');
                    installLabforum();
                }
            }
        });
    });

    function installLabforum(){
        $.post(api_path + '/installer/install-labforum.php',
            $( ".reg-form" ).serialize(),
            function(data){
               if(data.error){
                    $('#loading-modal').on('shown.bs.modal', function(){
                        setTimeout(function(){
                            $('#loading-modal').modal('hide');
                            if(data.msg){
                                $('#error-modal').modal('show');
                                $('.message-error-installing').html(data.error);
                            }
                        }, 1000);
                    });
                    if(!data.msg){
                        for(var key in data.error){
                            $('.' + key).addClass('is-invalid');
                            $('.' + key + '-invalid-feedback').html(data.error[key]);
                        }
                    }
               }else if(data.success){
                   $('.core-install').addClass('completed').children('.status').html('(Completed)');
                   setTimeout(function(){
                       initDatabaseStructure();
                   }, 2000);
               }
        });
    }

    function initDatabaseStructure(){
        $.get(api_path + '/installer/init-database.php', function(data){
            if(data.error){
                $('#loading-modal').modal('hide');
                $('#error-modal').modal('show');
                $('.message-error-installing').html(data.error);
            }else{
                $('.updating-database').addClass('completed').children('.status').html('(Completed)');
                //The forum is ready. However, to prevent other user seeing it, we set maintenance mode
                setTimeout(function(){
                    setMaintenance();
                }, 2000);
            }
        })
    }
    function postInstallation(){
        $.get(api_path + '/installer/post-installation-removal.php?keep_files=true', function(data) {
            $('.post-installation').addClass('completed').children('.status').html('(Completed)');
        });
    }

</script>
</body>
</html>