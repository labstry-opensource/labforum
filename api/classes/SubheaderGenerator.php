<?php

//Deprecation Notice.
// Calling classes file within api folder is deprecated and no longer actively supported
include_once dirname(__FILE__) . '/deprecated.php';

class SubheaderGenerator{

	public $href;
	public $icon;
	public $text;
	public $id;

	public $barwidth;

	public function __construct(){
		$this->href = array();
		$this->icon = array();
		$this->text = array();
		$this->id = array();
	}
	public function addLink($href, $icon, $text, $id){
		array_push($this->href, $href);
		array_push($this->icon, $icon);
		array_push($this->text, $text);
		array_push($this->id, $id);
	}

	public function generateSubheader(){
		$submenu = "<div class=\"bgwrapper\">\n
						<a href=\"#\" class=\"button left\" style=\"display: none; height: 100px; background-color: rgba(255, 255, 255, 0.3);\"><div class=\"dummy-child\"></div>
							<img src=\"../menu/images/left.png\" class=\"icon\" style=\"height:30px;width:30px;\">
						</a>
						<div class=\"submenu\">
					";
		for($i=0; $i < sizeof($this->href); $i++){
			$submenu .= "<div class=\"useraction\"><a class=\"submenuitem\" id=\"".$this->id[$i]."\" href=\"".$this->href[$i]."\">
            		<img src=\"".$this->icon[$i]."\" class=\"icon\">
            <div style=\"text-align:center\">".$this->text[$i]."</div>
           </a></div>";
		}
		$submenu .= "</div>";

		$submenu .= "<a href=\"#\" class=\"button right\" style=\"display: none; height: 100px; vertical-align: top; float: right; background-color: rgba(75, 210, 176, 0.8);\"><div class=\"dummy-child\"></div>
						<img src=\"../menu/images/right.png\" class=\"icon\" style=\"height:30px;width:30px;\">
					</a></div>";


		return $submenu;

	}

	public function setBarWidth($width){
		$this->barwidth = $width;
	}

	public function getStylesheetExp(){
		return "
			/* The content below is for the stylings of submenu */
			.icon{
				width:75px;
				height:75px;
			}
			@keyframes dropsubmenu{
				0%{top: -5000px; opacity: 0}
				90%{top:-4px; opacity: 0.3}
				100%{top:0px; opacity: 1}
			}

			.submenu{
				margin-left: 75px;
				margin-right: 75px;
				overflow-x: scroll;
				overflow-y:hidden;
				display:inline-block;
				white-space: nowrap;
				animation: dropsubmenu 1s ease;
			}
			.submenuitem{
				color:white;
			}

			#searchkey{
				border:none;
				/*Override the border */
				border-bottom: 2px solid white;
				font-size:18px;
			}
			.searchbox, #close{
				position:relative;
				animation: dropsubmenu 1s ease;
			}

			@keyframes dropdownsearchmenu{
				0%{height: 0px;}
				90%{height: 395px};
				100%{height: 400px}
			}

			.searchresultprovider{
				width:100%;
				position:absolute;
				top:150px;
				height:400px;
				display: none; 
				animation: : dropdownsearchmenu 1s ease;
				padding-left: 50px;
				
			}
			.leftcontrolaction{
				position: absolute;
				text-decoration: none;
				padding-left: 0px;
				left:0;
				background-color: #4BD2B0;
			}
			.rightcontrolaction{
				position:absolute;
				text-decoration: none;
				padding-right: 0px;
				right: 0;
				background-color: #4BD2B0;
			}
			.leftbtn{
				text-decoration: none;
				color:white;
				background-color: #4BD2B0;
				z-index:2;
				overflow-y:hidden;
				height: 100px;
				/*position:relative; */

			}
			.rightbtn{
				text-decoration: none;
				color:white;
				background-color: #4BD2B0;
				z-index:2
				overflow-y:hidden;
			}
			.submenu{
  				overflow:hidden;
  				display:inline-block;
  				white-space:nowrap;
  				height: 100px;
			}
			.useraction{
				font-size: 12px;
				display:inline-block;
				text-decoration: none;
				width: 200px;
				text-align:  center;
				/*padding-right:85px; */
				border-radius : 4px;
				clear:both;
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
				  margin-bottom:20px;
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


			/* For the style of navi button and background */
			.bgwrapper{
  				white-space:nowrap;
  				background-color: #4BD2B0; 
  				width: $this->barwidth;
  				margin: 0 auto;
  				border-radius:0px 0px 15px 15px
			}
			";
	}
}

?>