<?php
include 'include/function.inc.php';

if(isset($_POST['btn_send'])){
	$message = '';
	
	// Validate Captcha
	/*if(isset($_POST['g-recaptcha-response'])){
	  $captcha=$_POST['g-recaptcha-response'];
	}
	
	if(!$captcha){
	  $message = 'Recaptcha validation failed. Try Again';
	  header('location: https://www.coffeebreak.ph/portal/reset.php?&msg='.$message.'#popup1');
	  die();
	}
	
	$secretKey = "6LdD7jIUAAAAAFjTZNQzetVJ3CWml7-zSY7wgjSL";
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
	$responseKeys = json_decode($response,true);
	
	if(intval($responseKeys["success"]) !== 1) {
	  $message = 'Recaptcha validation failed. Try Again';
	  header('location: https://www.coffeebreak.ph/portal/reset.php?&msg='.$message.'#popup1');
	  die();
	}*/
	
	// Get Memeber ID
	$rowcount = 0;
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("SELECT COUNT(idMember) as `rowcount` FROM member WHERE MEmailAddress=?")){
		$stmt->bind_param('s',$_POST['txt_email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($rowcount);
		$rowcount = $mysqli->affected_rows;
		$stmt->fetch();
		$stmt->close();
	}
		
	if($rowcount!=0){
		$RandomString = generateRandomString(5);
		$TemporaryPassword = CreatePassword($_POST['txt_email'],$RandomString);

		$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
		$stmt = $mysqli->stmt_init();
		if($stmt->prepare("Update member set MPassword=? Where MEmailAddress=?")){
			$stmt->bind_param('ss',$TemporaryPassword,$_POST['txt_email']);
			$stmt->execute();
			$stmt->close();
		}
		SendEmailResetPassword($_POST['txt_email'],$RandomString);
		
		$message = 'Temporary password has been sent to your Email.';
		header('location: https://www.coffeebreak.ph/portal/reset.php?&msg='.$message.'#popup1');
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
	<!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
</head>

<body>
    <div id="popup1" class="overlay">
        <div class="messagebox">
            <h2>Information</h2>
            <a class="close" href="#">&times;</a>
            <div class="content" id="cookiecontent">
            <?php  echo (isset($_GET['msg'])) ? $_GET['msg'] : ''; ?>
            </div>
        </div>
    </div>
	<div id="popup2" class="overlay">
        <div class="popup">
        <h2>REGISTRATION CHANGE</h2>
                <a class="close" href="#">&times;</a>
                <div class="content">
        			Hi,<br /><br />
                    We noticed that your account has already been registered in our portal. Our system assumes that you have forgotten your password thus, sending you here.<br /><br />
                    If your have completely forgotten your password, Send a request for Password reset by providing your mail account.<br />
                    If you know your password, click on the login link below.
                </div>
        </div>
	</div>

	<div class="bg"></div>
	<div id="secsignin">
        <div id="divsignin">
        	<font size="+3"><strong>coffee</strong>break</font>
        </div>
	</div>
    
    <div class="formcontainer">
    <form id="frm_login" action="reset.php" method="post">
    	<h3>Reset Password</h3>
        <div style="width:300px;">
			<p>A temporary password will be sent to your mail. Use this password to login and set your new password.</p>
        </div>
        <input type="email"  name="txt_email" class="input" placeholder="Your Email Address" required="required" value="<?php echo $_POST['txt_email']; ?>" /><br />
		<!--<br />
		<div class="g-recaptcha" data-sitekey="6LdD7jIUAAAAAJZfkeMDtCkTPtKIUgxq16-5PpE-"></div>
        <br />-->
		<br />
		<!-- <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" /><br />-->
		<!-- <input type="text" name="captcha_code" class="input" maxlength="6" placeholder="Captcha Code" /><br />-->
        <br />
		<input type="submit" name="btn_send" class="button" value="Send Password to Email">
        <br /><br />
        Already a Member? <a href="https://www.coffeebreak.ph/portal/login.php">Log in</a>
    </form>
    </div>
</body>

</html>