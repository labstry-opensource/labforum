﻿<?php
if(!isset($_SESSION)) session_start();
include_once dirname(__FILE__)."/laf-config.php";
include_once dirname(__FILE__)."/classes/connect.php";
include_once dirname(__FILE__)."/api/classes/UserRoles.php";


$userrole = new UserRoles($pdoconnect);
$roles_arr = $userrole->getUserRole(@$_SESSION["id"]);

class Maintenance{
    public $pdoconnect;

    public function __construct($pdoconnect){
        $this->pdoconnect = $pdoconnect;
    }
    public function checkIfMaintaining(){
        $stmt = $this->pdoconnect->prepare("SELECT COUNT(*) 'cnt' FROM maintainance WHERE 
        s_date < NOW() AND e_date > NOW()");
        $stmt->execute();
        $resultset = $stmt->fetch(PDO::FETCH_ASSOC);
        if($resultset['cnt'] >=1 ) return true;
        else return false;
    }
    public function getMinUserRights(){
        $stmt = $this->pdoconnect->prepare("SELECT min_right FROM maintainance");
        $stmt->execute();
        $resultset = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultset["min_right"];
    }
    public function getMaintenance(){
        $stmt = $this->pdoconnect->prepare("SELECT * FROM maintainance");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
$maintenance = new Maintenance($pdoconnect);
if(($maintenance->checkIfMaintaining() === false) || $roles_arr['rights'] >= $maintenance->getMinUserRights()){
    return;
}

$maintain_arr = $maintenance->getMaintenance();
?>
    <html>
    <head>
        <style>
            body{
                margin: 0;
                background-color: #00c5ff;
                text-align: center;
                color:white;
            }
            a{
                text-decoration: none;
                color:white;
            }
        </style>
        <Title>論壇正在更新</Title>
    </head>
    <?php
    ?>
    <body>
    <h1 style='font-size: 40px; margin-top: 280px; '>升級中&emsp;UPDATING</h1></br>
    <h1 style='text-align: center; font-size: 20px; margin-top: 40px;color:white;'>
        對唔住，Forum 正在更新中...</br>
        由於<?php echo $maintain_arr['reason']?>，因此論壇暫時無法使用</br>
        等陣見
        </br>
        </br>
        更新時間: <?php echo $maintain_arr['s_date']."-".$maintain_arr['e_date']; ?>
        <br/>
        <br/>
        <br/>
    </h1>
    <a href="../login.php?target=forum">以特別身份登入...</a>
    </body>
    </html>

<?php
die;