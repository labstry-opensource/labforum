<?php
require_once("forum/connect.php");

//decide which step user is in
if(!@$_GET['step']) $step = 0 ;
else $step = @$_GET['step'];

//Get all the values if avail
if(@$_POST['uname']) $username = @$_POST['uname'];
if(@$_POST['realuname']) $username = @$_POST['realuname'];

if(@$_POST['email']) $email = @$_POST['email'];
if(@$_POST['realemail']) $email = @$_POST['realemail'];
?>

<html>

<style>
.card{
	border:2px solid grey;
	border-radius: 18px;
	width: 400px;
	height:400px;
	margin:auto;
	overflow: hidden;
}
.slogan{
	text-align: center;
	padding-top: 50px;
	font-size: 40px;
}
.subheader{
	text-align: center;
	font-size: 30px;
	position: absolute;
	bottom: 10px;
	left: 10px;
}
.wrapper{
	background-color: #00c5ff;
	height: 200px;
	position: relative;
}

/*Stying input blanks */
.blank{
	border:none;
	border-bottom: 2px solid grey;
	display: inline-block;
	height:25px;
	width: 100%;
	font-size: 16px;
	outline: none;
	margin-bottom: 0;
	transition: border-bottom 0.1s ease;
	text-align:right;
	margin: 0 auto;
}
/* A bit hacking here...
	The -2px means that we have to move the animated bar to coverup the input border. Urgh. */
.blankborder{
	display: block;
	content: '';
	transform: scaleX(0);
	transition: transform 0.5s ease-in-out;
	border-bottom: 2px solid green;
	margin-top: -2px;
}
.blank:focus ~.blankborder{
	transform: scaleX(1);
	}
.blank:focus{
	font-size:16px;
	text-align: left;
	border-bottom:none;
}

.card{
	display: none;
}
.name{
	display: inline-block;
}

</style>
<head>
	<Title>Register Your Account - Labstry</Title>
</head>

<body>
	<?php
	$nxtstp = $step + 1;
	echo "\t<form autocomplete=\"off\" method=\"POST\" action=\"guideregister.php?step=".$nxtstp."\">";

	?>
		<div class="cardwrapper" cardcount="2">
			<div class='slogan'>Hello. Nice to meet you.</div>
			<!-- Showing the card UI -->
				<div class="card0">
					<div class="wrapper">
						<div class="subheader">How do we call you? </div>
				  	</div>
				  	<div style="display:table; width: 95%;margin:0 auto">
				  		<input type="text" class="blank" id="uname" name="uname" placeholder="Username..." /><br>
			 	  		<span class='blankborder'></span>
				    </div>
				  	<input type="button" name="submit" class='nextbtn' value="Next" />
				  	<?php
				  	if($sugname =  @$_GET['suggestname']){
				  		$nameexists = mysqli_query($connect, "SELECT username FROM users WHERE username='".$sugname."';");
				  		if(mysqli_num_rows($nameexists)){
				  			echo "<div>Someone else has claimed that name, try another one</div>";
				  		}
				  	}

				  	?>
				</div>

				<div class="card1">
					<div class="wrapper">
						<div class="subheader"><div class="name"></div>, let's keep in touch</div>
				  	</div>
				  	<div style="display:table; width: 95%;margin:0 auto">
				  		<input type="email" class="blank" id="email" name="email" placeholder="Your email..." /><br>
			 	  		<span class='blankborder'></span>
				    </div>
				    <input type="button" name="submit" class='previousbtn' value="Previous Page" />
				  	<input type="button" name="submit" class='nextbtn' value="Next" />
				</div>
		</div>
		<?php
		echo "\n\t\t\t<input name='realuname' class='hiddenblanks realuname' value=' $username' />";
		echo "\n\t\t\t<input name='realemail' class='hiddenblanks realemail' value='$email' />"
		?>
	</form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
var cardcount = $('.cardwrapper').attr("cardcount");

//Function to load specified card
function loadCard(cardNum){
	$('.card'+ cardNum).css({
		'display': 'block'
	});
	for(var i=0; i<=cardcount; i++){
		if(i == cardNum) continue;
		$('.card' + i).css({
			'display': 'none'
		});
	}
	//Reset all checkings
	$('.nextbtn').attr("disabled", true);
}

//Function to set all cards
function setAllCardProp(){
	for(var i=0; i<=cardcount; i++){
		$('.card'+ i).css({
			'border' : '2px solid grey',
			'border-radius' : '18px',
			'width'  : '400px' ,
			'height' : '400px' , 
			'margin' : 'auto',
			'overflow': 'hidden'
		})
	}
}
</script>
<script type="text/javascript">
var counter = 0;

//Initialise the first card
setAllCardProp();
loadCard(counter);

$('.nextbtn').on("click", function(e){
	counter++;
	loadCard(counter);

});
$('.previousbtn').on("click", function(e){
	counter--;
	loadCard(counter);

});

//United Handlers for each blank
$('input').on('keyup', function(e){
	var id = e.currentTarget.id;
	var value = $('#'+id).val();

	//Implementing individual checking
	if(id == 'uname'){
		//Setting greetings character
		var shortname = value.split(' ')[0];
		$('.name').text(shortname);
		if(value != "") $('.nextbtn').removeAttr("disabled");
		var name = $('.realuname').val();
		$.ajax({
			url: "UserCheckUtility.php", 
			type: "GET",
			data: {
				suggestname : name
			}, 
			success: function(e){
				console.log(e)
			}


		})

	}
	if(id == 'email'){

	}

	$('.real'+id).val(value);
});

$('.uname').on('keyup', function(e){
	var name = $('.uname').val();
	var shortname = name.split(' ')[0];
	$('.realuname').val(name);
	$('.name').text(shortname);
});


</script>
</html>