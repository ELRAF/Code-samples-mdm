<?php
error_reporting(E_ALL ^ E_NOTICE);

function checkUp(){
	if(!isset($_SESSION['userid'])){ //----------  KICK OUT OF SITE IF USER NOT LOGGED IN
		session_destroy();
		echo '<SCRIPT LANGUAGE="JavaScript">window.location="index.php"</script>';
		exit;
	}
}

function checkUpAdmin(){ //--------------- KICK OUT OF SITE IF ADMIN NOT LOGGED IN
	if(!isset($_SESSION['adminid'])){
		session_destroy();
		echo '<SCRIPT LANGUAGE="JavaScript">window.location="index.php"</script>';
		exit;
	}
}

function checkUpBoth(){ //--------------- KICK OUT OF SITE IF ADMIN OR USER NOT LOGGED IN
	if(!isset($_SESSION['adminid']) && !isset($_SESSION['userid'])){
		session_destroy();
		echo '<SCRIPT LANGUAGE="JavaScript">window.location="index.php"</script>';
		exit;
	}
}

//******************************************************************************************************************************
//**************************************************  ESTABLISH CONTENT BACKGROUND PIC ******************************************************************
//******************************************************************************************************************************

function bgPic($pic) 
{
	if(isset($_SESSION['device'])){
		echo'<div id="content" style="position:absolute; width:100%; overflow: scroll; -webkit-overflow-scrolling:touch; overflow-x:hidden;
		background: url(img/small/'.$pic.'.jpg) no-repeat 0 0; 
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;">';
	}else{
		echo'<div id="content" style="position:fixed; width:100%; overflow-y: auto; overflow-x:hidden; 
		background: url(img/'.$pic.'.jpg) no-repeat center top; 
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;">';
	}
}

// ******************************************** INHEAD *********************
function inHead($t){
	$titlePart = getProperTitle($t);
	$title = $titlePart;
	echo'<title>'.$title.'</title>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.printelement.min.js"></script>
	<script src="js/perfect-scrollbar.jquery.js"></script>
	<script src="wysiwyg/nicEdit.js"></script>
	<script src="js/datepick/jquery.plugin.js"></script>
	<script src="js/datepick/jquery.datepick.js"></script>
	
	<script src="nav/assets/js/easyaspie.js"></script>
	<script src="nav/assets/js/easyaspie.min.js"></script>
	<script src="nav/assets/js/modernizr.js"></script>
	<script src="nav/assets/js/superfish.js"></script>
	<script src="js/modernizr.custom.86080.js"></script>
	<script type="text/javascript" src="js/highlight.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="nav/assets/css/main.css" /> 
	<link rel="stylesheet" type="text/css" href="css/perfect-scrollbar.css" />
	<link rel="stylesheet" type="text/css" href="css/print.css" />
	<link rel="stylesheet" type="text/css" href="js/datepick/smoothness.datepick.css" >
	<link rel="stylesheet" type="text/css" href="css/style4.css" />

	<style type="text/css">.highlight { background: #FFFF40; }</style>';
	
	?>
	<script>			
			$(document).ready(function(){
				tx = $(".loginField")
				tx.width(tx.prop("scrollWidth"));
				var lbh = $("#loginBox").height() + 8;
				$("#resetPswd").click(function(event){
				$("#field").fadeIn(700);
				$("#edit").fadeIn(1000);
				$("#showEdit").fadeIn(1000);
				$(window).scrollTop($('body').offset().top);
				var dbc= $(this).attr("id");	
					$.ajax({
					  type: "POST",
					  url: "ax.php",
					  data: {getResetPswdForm: dbc},
					  success: comeback
					});   
					return false;	
				});
			});
		</script>

	<script>	
		function comeback(data, status){
			  $('#showEdit').html(data);
			}
	</script>

	<script>			
		$(function() {
				$(".off").click(function(){
				$("#field").fadeOut(700);
				$("#edit").fadeOut(1000);
				$("#showEdit").fadeOut(1000);
			});
		});
	</script>
	
	<script >
		oldTextAry = new Array();

		function changeText (fieldObj, newTexStr) {
		if (newTexStr == fieldObj.innerHTML) {
		fieldObj.innerHTML = oldTextAry[fieldObj.id];
		} else {
		oldTextAry[fieldObj.id] = fieldObj.innerHTML;
		fieldObj.innerHTML = newTexStr;
		}
		}
	</script>
	
	<?php
	if(isset($_SESSION['device']))
	{
		// HIDES LOGO ON SCROLL UP - MOBILE
		echo' 
		<script>
			$(function() {
				$(window).scroll(function() {
					var x = $(window).scrollTop();
					if (x >= 42) {
					  $("#logo").hide();
					  $("#menu").css({"margin-top":"3.1em"});
					} else {
					  $("#logo").show();
					  $("#menu").css({"margin-top":"0"});
					}

				});
			});
		</script>
		';
	
		//MOBILE : ADJUST BACKGROUND PICTURE UPON RESIZING 
		echo'
		<SCRIPT>
			$(window).bind("resize", function(e)
			{
			  if (window.RT) clearTimeout(window.RT);
			  window.RT = setTimeout(function()
			  {
				var subtract = $("#header").height();
				var diff = $(window).height() - subtract;
				$("#content").css("margin-top", subtract +"px");
				$("#content").css({"min-height": diff + "px"});
			  }, 100);
			});
		</script>';

		//MOBILE : SET BACKGROUND PICTURE ON LOAD -->
		echo'
		<SCRIPT>
			$(function() {
				var subtract = $("#header").height();
				if(subtract == 0){ var subtract = $("#pushRight").height(); }
				var win = $(window).height();
				var diff = win - subtract;
				$("#content").css("margin-top", subtract + "px");
				$("#content").css({"min-height": diff + "px"});
			});
		</script>';
		//PREVENT THE DOUBLE CLICK NEED ON MOBILE -->
		echo'
		<script>
			$(function() {
			   $("a").on("click touchend", function(e) {
				  var el = $(this);
				  var link = el.attr("href");
				  window.location = link;
			   });

			});
		</script>';
	}else{
	?>
	<!-- ADJUST BACKGROUND PICTURE UPON RESIZING -->
	<SCRIPT>
		$(window).bind('resize', function(e)
		{
		  if (window.RT) clearTimeout(window.RT);
		  window.RT = setTimeout(function()
		  {
			var subtract = $('#header').height();
			var diff = $(window).height() - subtract;
			$('#content').css('margin-top', subtract +'px');
			$('#content').css({'height': diff + 'px'});
		  }, 100);
		});
	</script>

	<!-- SET BACKGROUND PICTURE ON LOAD -->
	<SCRIPT>
	$(function() {
		var subtract = $('#header').height();
		var diff = $(window).height() - subtract;
		$('#content').css('margin-top', subtract +'px');
		$('#content').css({'height': diff + 'px'});
		var indexPageHt = $("#indexPage").height() + 32;
		var indexPageTop = (diff - indexPageHt)/2;
		$('#indexPage').css({'top': indexPageTop + 'px'});
	});
	</script>
	<?php
	} 
	?>
	<!-- GOOGLE SEARCH WIDGET -->
	<script>
	$(function(){
		$('.search').click(function(){
			$('.searchField').toggle('slideIn(1000)');
			return false;
		});
	});
	</script>

<?php
}

function masthead(){ //-------------- page tops
	if(!isset($_SESSION['userid']) && !isset($_SESSION['adminid'])){ //----------- kick off site if sessions are dead or non-existent
		session_destroy();
		echo'<SCRIPT LANGUAGE="JavaScript">window.location="index.php"</script>'; 
	}
	$logo = 'img/logo.png';  
	echo'<div id="logo">
				<a href="home.php" target="_self"><img src="'.$logo.'" alt="'.LOGO_ALT.'" border="0" /></a>
		</div>';
}

function getProperTitle($t) // ESTABLISH A TITLE TAG
{
	 switch($t){
	 	case "":
			$title = "Welcome to ".WEBNAME;
		break;
		case "index":
			$title = "Welcome to ".WEBNAME;
		break;
		case "home":
			$title = "Home Page";
		break;
		case "adminDirectory":
			$title = "Directory";
		break;
		case "directory":
			$title = "Directory";
		break;
		case "communications":
			$title = "Communications";
		break;
		case "eAlert":
			$title = "Schedule reminder";
		break;
		case "duties":
			$title = "Duties setup";
		break;
		case "adminEvents":
			$title = "Event type schedules";
		break;
		case "events":
			$title = "Event type schedules";
		break;
		case "calendario2":
			$title = "Create a calendar";
		break;
		case "adminCal":
			$title = "Create availability";
		break;
		case "adminPubCal":
			$title = "Schedules";
		break;
		case "userCal":
			$title = "Schedules";
		break;
		case "userLCal":
			$title = "Schedules";
		break;
		case "archive":
			$title = "Schedules archive";
		break;
		case "adminHours":
			$title = "Hours management";
		break;
		case "myHours":
			$title = "Hours management";
		break;
		case "eventCalendarAdmin":
			$title = "Calendar Events";
		break;
		case "eventCalendar":
			$title = "Calendar Events";
		break;
		case "adminContEd":
			$title = "Continuing Education";
		break;
		case "contEd":
			$title = "Continuing Education";
		break;
		case "adminTrips":
			$title = "Excursions";
		break;
		case "trips":
			$title = "Excursions";
		break;
		case "vvUpload":
			$title = "Newsletter";
		break;
		case "newsletter":
			$title = "Newsletter";
		break;
		case "editor":
			$title = "Useful Info";
		break;
		case "pages":
			$title = "Useful Information ";
		break;
		
		default:
		break;
	}
	return $title;
}