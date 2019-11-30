<?php


class HeaderGenerator{
    public $pdoconnect;
    public $homelnk;
    public $hometext;
    
    public $link;
    public $linktext;
    
    public function __construct($pdoconnect){
        $this->link = array();
        $this->linktext = array();
        $this->pdoconnect = $pdoconnect;
    }
    
    public function getSessionStatus(){
        return (@$_SESSION['id']) ? true: false;
    }
    
    public function verifyUsername($userid){
        $stmt = $this->pdoconnect->prepare("SELECT * FROM `userspace`.users WHERE id = ?");
        $stmt->bindValue(1, $userid, PDO::PARAM_INT);
        $stmt->execute();
        
        return ($stmt->fetch(PDO::FETCH_ASSOC)) ? true: false;
    }
    
    public function addHome($homelnk, $hometext){
        $this->homelnk = $homelnk;
        $this->hometext = $hometext;
    }
    
    public function addLink($link, $linktext){
        array_push($this->link, $link);
        array_push($this->linktext, $linktext);
    }
    
    public function generateHeader(){
        $headerhtml = 
        '<div id="menudiv">
            <div id="itemwrapper" style="height:inherit;width: inherit;">
                <div class="homeitemwrapper">
                    <img class="expandicon topmenutoggle" src="/menu/images/left.png" style="transform: rotate(-90deg);"/>
                    <a class="menuitem home" href="'.$this->homelnk.'">'.$this->hometext.'</a>
                </div>';
                
        for($i=0; $i< sizeof($this->link);$i++){
            $headerhtml .= "<a class=\"menuitem expanditem\" href=\"".$this->link[$i]."\">".$this->linktext[$i]."</a>\n";
        }
        
        if($this->getSessionStatus() && $this->verifyUsername(@$_SESSION['id'])){
            $headerhtml .= '<a class="menuitem expanditem" href="/forum/account/profile.php?id='.@$_SESSION['id'].'">'.$_SESSION['username'].'</a>';
            $headerhtml .= '<a class="menuitem expanditem" href="/forum/index.php?action=logout">登出</a>';
        }else
            $headerhtml .= '<a class="menuitem expanditem" href="/login.php?target=forum">登入</a>';
     
        $headerhtml.= "</div>\n<div id=\"clean\" style=\"background-color:#00c5ff\"</div>\n</div></div>";
        $headerhtml .= "<div class=\"placeholder\"></div>";
        
        return $headerhtml;
    }
    
    public function generateStylesheet(){
        return 
        "
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
                height:auto; 
                width:100%;
                background-color: #4BD2B0;
                float:left;
                overflow:hidden;
                white-space: nowrap;
            }
            #itemwrapper{
                position: fixed;
                border-radius: 22px;
                background-color:#00c5ff;
                white-space: nowrap;
                position: relative;
                animation: dynmenu 2s ease;
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
            }";
        
    }
}

class HeaderOverrideStyle extends HeaderGenerator{
    public $bgcolor;
    public $textcolor;
    
    public function setBackground($color){
        $this->bgcolor = $color;
    }
    public function setTextColor($color){
        $this->textcolor = $color;
    }
    public function generateStylesheet(){
        return 
        "
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
                height:auto; 
                width:100%;
                background-color: ".$this->bgcolor.";
                float:left;
                overflow-x:hidden;
            }
            #itemwrapper{
                position: fixed;
                border-radius: 22px;
                background-color:#00c5ff;
                overflow-x: hidden;
                position: relative;
                animation: dynmenu 2s ease;
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
            }";
        
    }
}

?>
