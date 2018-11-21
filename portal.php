<?php
	include 'include/function.inc.php';
	session_start();
	// Clean cookies : redirect to member login
	if(!isset($_COOKIE['uid'])||!isset($_COOKIE['session'])){
		die('Portal access blocked, you are not signed on. Please go <a href="https://www.coffeebreak.ph/portal/login.php">here</a> first. DO NOT forget to enable cookies.');
	}

	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("SELECT MFirstName,MProfPic FROM member WHERE MEmailAddress=?")){
		$stmt->bind_param('s',$_COOKIE['uid']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($MFirstName,$MProfPic);
		$stmt->fetch();
		$stmt->close();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css"/>
    <script src="java/jquery-3.2.1.min.js" type="text/javascript"></script>
    <title>Coffeebreak Portal</title>
    <script type="text/javascript">
		$(document).ready(function(){
			$('.overlay').css('transition',' opacity 0ms');
			$('.overlay').delay(500).css('transition',' opacity 500ms');
			$('#popup1').load('doc/terms.html');
			$('#popup2').load('doc/privacy.html');
			$('#popup3').load('doc/cookie.html');
		});
	</script>
</head>

<body>
    <div id="popup1" class="overlay">
    </div>
    
	<div id="popup2" class="overlay">
   	</div>
   
	<div id="popup3" class="overlay">
	</div>

	<div id="popup4" class="overlay">
        <div class="popup">
        <h2>WELCOME TO COFFEEBREAK</h2>
                <a class="close" href="#">&times;</a>
                <div class="content">
        			Hi,<br /><br />
                    Thanks for registering to Coffeebreak!<br />
                    <ul>
                    	<li>
                        	<strong>Registration</strong><br />
                            Your have successfully registered.
                        </li>
                        <br />
                    	<li>
                        	<strong>Email Verification</strong><br />
							You will receive an email verification shortly, We highly advise you to check it and verify your registration.
                        </li>
                    </ul>
                </div>
        </div>
	</div>
    
	<div class="bg"></div>
	<div id="secsignin">
        <div id="divsignin">
        	<font size="+3"><strong>coffee</strong>break</font>
            <div style="float:right;padding:5px;bottom:0px;">
			<?php
				echo 'Hi, <a href="https://www.coffeebreak.ph/portal/profile.php">';
				echo ($MFirstName=='')? $_COOKIE['uid'] : $MFirstName .' ' ;
				echo ' <img src="'.$MProfPic.'" width="25px" style="border-radius:50%; margin-bottom:-6px;"/></a>';
			?>
            </div>
        </div>
	</div>
	<div class="formcontainerportal">
    <form name="apply" id="frm_register" action="http://1.1.1.1/login.cgi" method="post">
    	<img src="img/wifi.png" width="64" height="30" style="padding-right:10px;" /><h2>Coffeebreak Portal</h2>
        <input type="text" name="username" id="userValue" class="input" placeholder="wifi user" required="required" /><br />
        <input type="password" name="password" id="passwdValue" class="input" placeholder="wifi password" required="required" /><br />
        <br />
        <div style="width:300px;">
            <font size="-1">Review our <a href="#popup1">TERMS</a>, <a href="#popup2">PRIVACY POLICY</a> and <a href="#popup3">COOKIE USE</a></font>
        </div>
		<br />
		<input type="submit" name="apply" class="buttonportal" value="Enter">
		<br />
        <input type="reset" name="clear" class="buttonportal" value="Clear" >		        
        <br />
        <br />
        Not your account? <a href="https://www.coffeebreak.ph/portal/login.php">Sign Out</a><br />
    </form>
    </div>
</body>
</html>