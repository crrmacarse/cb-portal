<?php
session_start();
include 'include/function.inc.php';
include_once 'securimage/securimage.php';

if (isset($_GET['action'])){
	// Verify Member
	$rowcount = 0;
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("UPDATE member SET MStatus=1,MVerified=1 Where MRequest=? And MVerification=?")){
		$stmt->bind_param('ss',$_GET['r'],$_GET['v']);
		$stmt->execute();
		$rowcount = $mysqli->affected_rows;
		$stmt->close();
	}	
	
	if ($rowcount!=0){
		// -----> goto wifi login
		header('location: https://www.coffeebreak.ph/portal/login.php');
		// insert session details then process to portal immediately
		die();
	}else{
		// -----> goto resend verification code
		// TODO:
	}
}

if (isset($_POST['btn_createaccount'])){
	$RemoteIP = substr($_SERVER['REMOTE_ADDR'],0,3);
	if ($RemoteIP!='119' && $RemoteIP!='222' && $RemoteIP!='192' && $RemoteIP!='122' && $RemoteIP!='180' && $RemoteIP!='203' && $RemoteIP!='103' && $RemoteIP!='175'){
		SendEmailReport($_SERVER['REMOTE_ADDR']);
		echo "Invalid Source.<br /><br />";
		echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
		exit;
	}
	
	// Validate HTTP Referer
	if(!$_SERVER['HTTP_REFERER']=='https://www.coffeebreak.ph/index.php'){
		echo "Invalid Referer.<br /><br />";
		echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
		exit;
	}
	
	/*if(isset($_POST['g-recaptcha-response'])){
	  $captcha=$_POST['g-recaptcha-response'];
	}
	
	if(!$captcha){
	  // -----> goto index
	  echo 'Recaptcha validation failed. <a href="https://www.coffeebreak.ph/portal/index.php">Try again</a>.';
	  die();
	}
	
	$secretKey = "6LdD7jIUAAAAAFjTZNQzetVJ3CWml7-zSY7wgjSL";
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
	$responseKeys = json_decode($response,true);
	
	if(intval($responseKeys["success"]) !== 1) {
	  // -----> goto index
	  echo 'Recaptcha validation failed. <a href="https://www.coffeebreak.ph/portal/index.php">Try again</a>.';
	  die();
	}*/
	
	// Validate Email not blank
	if (!isset($_POST['txt_email'])){
	  echo "Email address was not provided.<br /><br />";
	  echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	  exit;
	}
	
	// Validate Password not blank
	if (!isset($_POST['txt_password'])){
	  echo "Password was not provided.<br /><br />";
	  echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	  exit;
	}

	// Check the captcha
/*	$securimage = new Securimage();
	if ($securimage->check($_POST['captcha_code']) == false) {
	  echo "The security code entered was incorrect.<br /><br />";
	  echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	  exit;
	}*/
	
	// Check if entry exists
	$rowcount = 0;
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("Select count(idMember) as `rowcount` From member Where MEmailAddress=?")){
		$stmt->bind_param('s',$_POST['txt_email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($rowcount);
		$stmt->fetch();
		$stmt->close();
	}	

	if ($rowcount!=0){
		// -----> account exists goto forgot password
		header('location: https://www.coffeebreak.ph/portal/reset.php');
		die();
	}


	$attemptpassword = CreatePassword($_POST['txt_email'],$_POST['txt_password']);
	$birthday = $_POST['sel_year'].'-'.$_POST['sel_month'].'-'.$_POST['sel_date'];
	$date = date('Y-m-d H:i:s');
	$sessionstring = generateRandomString(20);
	$request=md5($sessionstring);
	$verification=md5($_POST['txt_email'].$date);
	
	// Create Member
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("Insert Into member(MEmailAddress,MPassword,MBirthday,MGender,MStatus,MTSUpdate,MVerified,MTSCreate,MRequest,MVerification,MRemoteIP) VALUES (?,?,?,?,1,?,0,?,?,?,?)")){
		$stmt->bind_param('sssssssss',$_POST['txt_email'],$attemptpassword,$birthday,$_POST['rad_gender'],$date,$date,$request,$verification,$_SERVER['REMOTE_ADDR']);
		$stmt->execute();
		$stmt->close();
	}	
	
	// Get Memeber ID
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("Select idMember From member Where MEmailAddress=? Order By idMember ASC Limit 1")){
		$stmt->bind_param('s',$_POST['txt_email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($idMember);
		$stmt->fetch();
		$stmt->close();
	}	
	
	// Create Session Detail
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("INSERT INTO membersession(idMember,MSValue,MSTSCreate,MSRemoteIP,MSBrowser) VALUES (?,?,?,?,?)")){
		$stmt->bind_param('issss',$idMember,$sessionstring,$date,$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT']);
		$stmt->execute();
		$stmt->close();
	}
			
	// Remember Logon for 1 Month
	setcookie("uid",$_POST['txt_email'],time()+2678400);
	setcookie("session",$sessionstring, time()+2678400);


	// Send Mail Activation Key
	SendEmailVerification($_POST['txt_email'],$request,$verification);
	
	// -----> goto wifi login	
	header('location: https://www.coffeebreak.ph/portal/portal.php#popup4');
	die();
}

?>