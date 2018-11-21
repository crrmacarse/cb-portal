<?php

$timezone = 'Asia/Manila';
if(function_exists('date_default_timezone_set')) {date_default_timezone_set($timezone);}

$server = 'localhost';
$port = '3306';	
$username = 'jqgfc_member';
$password = '@i3cFg#7mP!2t?';
$database = 'jqgfc_coffeebreakmember';

function CreatePassword($CPUser,$CPPass){
	$aucount = strlen($CPUser);
	$salt = substr(md5($CPUser),$aucount);
	$pwhash = md5($CPPass);
	$pwhashsount=strlen($pwhash);
	return substr($pwhash,$aucount).$salt.substr($pwhash,$aucount+1,$pwhashsount-$aucount);
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function ExecuteReader($query){
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$res=$mysqli->query($query);
	$row = $res->fetch_assoc();
	$mysqli->close();
	return $row['result'];
}

function ExecuteNonQuery($query){
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$mysqli->query($query);
	$mysqli->close();
}

function SendEmailVerification($recipient,$request,$verification){
	$from = "customercare@coffeebreak.ph";
	$to = $recipient;
	$subject = "Coffeebreak Membership";
	
	$message = '
	<html>
	<head>
	<title>Verify Account</title>
	</head>
	<body style="font-family:Verdana, Geneva, sans-serif" bgcolor="#000000" text="#FFFFFF">
	<p>Hi there,</p>
	<p>Welcome to Coffeebreak Caf&eacute;! We hope you are enjoying your stay. Complete the verification process and you are ready. Verify your account by clicking this <a href="https://www.coffeebreak.ph/portal/registration.php?&action=verify&r='.$request.'&v='.$verification.'">link</a>.
	<br /><br />For questions, Feel free to contact us at <b>customercare@coffeebreak.ph</b></p>
	Sincerely,<br />
	<i>The Coffeebreak Team</i><br /><br />
	<img src="https://www.coffeebreak.ph/img/CBlogin.jpg">
	</body>
	</html>
	';
	
	$headers ="From:<$from>\n";
	$headers.="MIME-Version: 1.0\n";
	$headers.="Content-type: text/html; charset=iso 8859-1";

	mail($to,$subject,$message,$headers,"-f$from");
}

function SendEmailResetPassword($recipient,$Password){
	$from = "customercare@coffeebreak.ph";
	$to = $recipient;
	$subject = "Coffeebreak Membership";
	
	$message = '
	<html>
	<head>
	<title>Verify Account</title>
	</head>
	<body>
	<p>Hi '.$recipient.',</p>	
	<p>Your temporary password is <strong>'.$Password.'</strong>. <a href="https://www.coffeebreak.ph/portal/login.php">Login</a> to Coffeebreak and set a new one.</p>
	</body>
	</html>
	';
	
	$headers ="From:<$from>\n";
	$headers.="MIME-Version: 1.0\n";
	$headers.="Content-type: text/html; charset=iso 8859-1";

	mail($to,$subject,$message,$headers,"-f$from");
}

function SendEmailReport($Message){
	$from = "customercare@coffeebreak.ph";
	$to = "carlson@coffeebreak.ph";
	$subject = "Coffeebreak Membership";
	
	$message = '
	<html>
	<head>
	<title>Email Report</title>
	</head>
	<body>
	<p>Content : '.$Message.'
	</body>
	</html>
	';
	
	$headers ="From:<$from>\n";
	$headers.="MIME-Version: 1.0\n";
	$headers.="Content-type: text/html; charset=iso 8859-1";

	mail($to,$subject,$message,$headers,"-f$from");
}

function getextension($str) {
	 $i = strrpos($str,".");
	 if (!$i) { return ""; }
	 $l = strlen($str) - $i;
	 $ext = substr($str,$i+1,$l);
	 return $ext;
}


?>