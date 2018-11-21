<?php
	include 'include/function.inc.php';
	
	setcookie("uid",$_POST['txt_email'],time() - 3600);
	setcookie("session",$sessionstring, time() - 3600);

if(isset($_POST['btn_login'])){
	$AttemptPassword = CreatePassword($_POST['txt_email'],$_POST['txt_password']); 
	$DateNow = date('Y-m-d H:i:s'); //die($AttemptPassword.'---'.$DateNow);

	// Get Memeber ID and Check verification status
	$MVerified = 0;
	$MStatus = false;
	$RowCount = 0;
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("Select idMember,MStatus,MVerified,TIMEDIFF('".$DateNow."',MTSCreate) AS `MLapse` From member Where MEmailAddress=? And MPassword=? Limit 1")){
		$stmt->bind_param('ss',$_POST['txt_email'],$AttemptPassword);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($idMember,$MStatus,$MVerified,$MLapse);
		$RowCount = $mysqli->affected_rows;
		$stmt->fetch();
		$stmt->close();
	}	

	if($RowCount!=0 && $MStatus!=0){
		
		// if still Unverified >=24H, Resend new code to Email but deactivate Status
		$LapseHour = (int) substr($MLapse,0,strpos($MLapse,":"));
		if($MVerified==0 && $LapseHour>=24){
			$RequestCode=md5(generateRandomString(20));
			$VerificationCode=md5($_POST['txt_email'].$DateNow);
	
			$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
			$stmt = $mysqli->stmt_init();
			if($stmt->prepare("Update member set MStatus=0,MRequest=?,MVerification=? Where MEmailAddress=?")){
				$stmt->bind_param('sss',$RequestCode,$VerificationCode,$_POST['txt_email']);
				$stmt->execute();
				$stmt->close();
			}
			SendEmailVerification($_POST['txt_email'],$RequestCode,$VerificationCode);	
		}

		// Create Session Detail
		$SessionString = generateRandomString(20);	  //die($RowCount.'---'.$SessionString);
		$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
		$stmt = $mysqli->stmt_init();
		if($stmt->prepare("INSERT INTO membersession(idMember,MSValue,MSTSCreate) VALUES (?,?,?)")){
			$stmt->bind_param('iss',$idMember,$SessionString,$DateNow);
			$stmt->execute();
			$stmt->close();
		}
				
		// Remember Logon for 1 Month
		setcookie("uid",$_POST['txt_email'],time() + 2678400);
		setcookie("session",$SessionString, time() + 2678400);
		
		// -----> goto wifi login
		header('location: https://www.coffeebreak.ph/portal/portal.php');
		die();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Coffeebreak Portal</title>
    <link rel="stylesheet" type="text/css" href="css/index.css"/>
    <script type="text/javascript" src="java/jquery-3.2.1.min.js"></script>
    <script>
		$(document).ready(function(e) {
			$('#popup1').load('doc/cookie.html');
        });
    </script>
</head>

<body>
    <div id="popup1" class="overlay">
    </div>

	<div class="bg"></div>
	<div id="secsignin">
        <div id="divsignin">
        	<font size="+3"><strong>coffee</strong>break</font>
        </div>
	</div>
    
    <div class="formcontainer">
    <form id="frm_login" action="login.php" method="post">
    	<h3>Member Login</h3>
        <div style="width:300px;">
			<p>To access our wifi service, You must be a Coffeebreak Member.</p>
            <p>Note: Avoid repeated login on this device by allowing to save cookies. Review our <a href="#popup1">Cookie Use</a></p>
        </div>
        <input type="email"  name="txt_email" class="input" placeholder="Your Email Address" required="required" value="<?php echo $_POST['txt_email']; ?>" /><br />
        <input type="password" name="txt_password" class="input" placeholder="Your Password" required="required" /><br />
        <?php
			if(isset($_POST['btn_login'])){
				if($RowCount<=0){
					echo '<br /><div style="width:300px;"><p><img src="img/warning.png" width="24" height="24" /> Invalid Username or Password</p></div>';
				}/*else{
					if($MVerified==0 && $LapseHour>=24){
						echo '<br /><div style="width:300px;"><p><img src="img/warning.png" width="24" height="24" /> Your account has been suspended because you fail to validate your email twice. To request reactivation, email us at customerservice@coffeebreak.ph</p></div>';
					}
				}*/
			}
		?>
        <br />
		<input type="submit" name="btn_login" class="button" value="Login">
        <br /><br />
        Forgot Password? <a href="https://www.coffeebreak.ph/portal/reset.php">Reset</a><br />
        Not a Member? <a href="https://www.coffeebreak.ph/portal/index.php">Sign Up</a>
    </form>
    </div>
</body>

</html>