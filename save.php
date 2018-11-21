<?php
include 'include/function.inc.php';

if (isset($_POST['updt_profile'])){
	$profpicpath='';
	$pathprofpic='img/pp/';
	$maxDim = '200';
	$birthday = $_POST['sel_year'].'-'.$_POST['sel_month'].'-'.$_POST['sel_date'];
	if(isset($_FILES['profpicinput'])){
			if(!$_FILES['profpicinput']['error']){
				$new_file_namesph = stripslashes($_FILES['profpicinput']['name']); 
				$extensionsph = strtolower(getextension($new_file_namesph));
				if (($extensionsph != "jpg") && ($extensionsph != "jpeg") && ($extensionsph != "jpg")){
					die('image file types only');
				}
				if($_FILES['profpicinput']['size'] > (10240000)){
					die("Oops!  Your file's size can't exceed 10MB.");
				}else{					
					$file_name = $_FILES['profpicinput']['tmp_name'];
					list($width, $height, $type, $attr) = getimagesize($file_name);
					if ( $width > $maxDim || $height > $maxDim ) {
						$new_width = $maxDim;
						$new_height = $maxDim;
					}else{
						$new_width = $width;
						$new_height = $height;
					}  //die($new_width.' x '.$new_height);
					$image_namesph=md5(date("ymdHisslide")).'.'.$extensionsph;
					$profpicpath=$pathprofpic.$image_namesph;
					$src = imagecreatefromstring( file_get_contents( $file_name ) );
					$dst = imagecreatetruecolor( $new_width, $new_height );
					imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
					imagedestroy( $src );
					imagejpeg( $dst, $profpicpath ); // adjust format as needed
					imagedestroy( $dst );
					//move_uploaded_file($_FILES['profpicinput']['tmp_name'],$profpicpath); 
				}
			}else{
				if($_POST['profpicpath']!=''){
					$imgpath = pathinfo($_POST['profpicpath']);
					$pathext = strtok($imgpath['extension'], '?'); 
					$image_namesph=md5(date("ymdHisslide")).'.'.$pathext;
					$profpicpath=$pathprofpic.$image_namesph; //die($profpicpath);
					copy($_POST['profpicpath'], $profpicpath);
				}else{
					die('Ooops!  Your upload triggered the following error:  '.$_FILES['profpicinput']['error']);
				}
			}
	}
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("UPDATE member SET MFirstName=?,MLastName=?,MMiddleName=?,MBirthday=?,MGender=?,MStreet=?,MCity=?,MProvince=?,MZipCode=?,MCountry=?,MProfPic=? Where MEmailAddress=?")){
		$stmt->bind_param('ssssssssssss',$_POST['mfirstname'],$_POST['mlastname'],$_POST['mmiddlename'],$birthday,$_POST['rad_gender'],$_POST['mstreet'],$_POST['mcity'],$_POST['mprovince'],$_POST['mzipcode'],$_POST['mcountry'],$profpicpath,$_POST['hdn_uid']);
		$stmt->execute();
		$stmt->close();
	}	
	header("Location: " . $_SERVER["HTTP_REFERER"]);
}

if (isset($_POST['updt_pw'])){
	header("Location: " . $_SERVER["HTTP_REFERER"]);
}
?>