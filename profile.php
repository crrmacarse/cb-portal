<?php
	include 'include/function.inc.php';
	if(!isset($_COOKIE['uid'])||!isset($_COOKIE['session'])){
		header('location: https://www.coffeebreak.ph/portal/login.php');
		die();
	}
	require_once 'php-graph-sdk-5.x/src/Facebook/autoload.php';

	$fb = new Facebook\Facebook([
	  'app_id' => '504347846607455',
	  'app_secret' => 'a8b4da189a3b4cb09c00f73df70b533e',
	  'default_graph_version' => 'v2.10',
	]);

	$verified = 0;
	$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("SELECT MEmailAddress,MVerified,MFirstName,MLastName,MMiddleName,MBirthday,MGender,MStreet,MCity,MProvince,MZipCode,MCountry,MProfPic,TIMEDIFF(CURRENT_TIMESTAMP,MTSCreate) AS `lapse` FROM member WHERE MEmailAddress=?")){
		$stmt->bind_param('s',$_COOKIE['uid']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($MEmailAddress,$verified,$MFirstName,$MLastName,$MMiddleName,$MBirthday,$MGender,$MStreet,$MCity,$MProvince,$MZipCode,$MCountry,$MProfPic,$lapse);
		$stmt->fetch();
		$stmt->close();
	}
	$lapsehour = (int) substr($lapse,0,strpos($lapse,":"));
	$dateset = explode('-', $MBirthday);
	$bdyear = $dateset[0];
	$bdmonth = $dateset[1];
	$bddate = $dateset[2];
	$RowCount = 100;
	$verVSnew = 'null';
	if(isset($_POST['updt_pw'])){
		$enteredPWD = $_POST['cur_pw'];
		$AttemptPassword = CreatePassword($MEmailAddress,$_POST['cur_pw']); 
		$DateNow = date('Y-m-d H:i:s'); //die($AttemptPassword.'---'.$DateNow);

		// Get Memeber ID and Check verification status
		$MVerified = 0;
		$MStatus = false;
		$RowCount = 0;
		$mysqli=new mysqli($GLOBALS['server'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
		$stmt = $mysqli->stmt_init();
		if($stmt->prepare("Select idMember,MStatus,MVerified,TIMEDIFF('".$DateNow."',MTSCreate) AS `MLapse` From member Where MEmailAddress=? And MPassword=? Limit 1")){
			$stmt->bind_param('ss',$MEmailAddress,$AttemptPassword);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($idMember,$MStatus,$MVerified,$MLapse);
			$RowCount = $mysqli->affected_rows;
			$stmt->fetch();
			$stmt->close();
		}
		
		if($RowCount!=0 && $MStatus!=0){ 
			$verVSnew='no';
			if($_POST['new_pw']==$_POST['ver_pw']){ //die($_POST['ver_pw']);
				$verVSnew='yes';
				$newpwd = CreatePassword($MEmailAddress,$_POST['new_pw']);
				$stmt = $mysqli->stmt_init();
				if($stmt->prepare("UPDATE member SET MPassword = ? Where MEmailAddress=? Limit 1")){
					$stmt->bind_param('ss',$newpwd,$MEmailAddress);
					$stmt->execute();
				}
			}
			
		}
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css"/>
    <script src="java/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			$.get("https://ipinfo.io", function(response) {
				//alert(response.country);
				//countryCode = response.country;
				getCountry(response.country);
			}, "jsonp");
			$('#profpic').click(function(){
				$('#profpicinput').trigger('click'); 
			});
			$("#profpicinput").change(function(){
				var file = this.files[0];
				var fileType = file["type"];
				var ValidImageTypes = ["image/jpg", "image/jpeg"];
				if ($.inArray(fileType, ValidImageTypes) < 0) {
					 alert('Please use .JPEG Files only.');
				}else{ readURL(this); }
			});
		})
		function getCountry(response) {
			$("#ACountry > option").each(function() {
				//alert(this.text + ' ' + this.value);
				if(this.value==response){
					//alert('-'+this.value+'---'+response+'-')
					$(this).attr('selected','selected')
				}
			});
		}
		function readURL(input) {
        	if (input.files && input.files[0]) {
				var reader = new FileReader();
				var img = new Image();
				reader.onload = function (e) {
					img.src = e.target.result;
					img.onload = function() {
						var width = img.naturalWidth,
							height = img.naturalHeight,
							ratio = parseFloat(width)/parseFloat(height);

						window.URL.revokeObjectURL( img.src );

						if( parseFloat(ratio) == 1 ) {
							$('#profpic').attr('src', e.target.result);
						}
						else {
							alert('Please upload square (1:1) photos.');
						}
					};
					
				}
			reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
	<title>Coffeebreak Portal</title>
</head>

<body>
<script>
	var accessTokenStr = '', userIDStr = '', ppLink = '', uname = '';
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '504347846607455',
      xfbml      : true,
      version    : 'v2.10'
    });
    FB.AppEvents.logPageView();
	FB.getLoginStatus(function(response) {
	  if (response.status === 'connected') {
		console.log(response.authResponse.accessToken);
		accessTokenStr = response.authResponse.accessToken;
		userIDStr = response.authResponse.userID;
	  } //alert(accessTokenStr+'----'+userIDStr)
		FB.api('/me?access_token='+accessTokenStr, function(response) {
			console.log(JSON.stringify(response));
		});
		FB.api('/me?fields=name,first_name,last_name', function(response) {
			console.log(JSON.stringify(response));
			fname = response.first_name;
			lname = response.last_name;
			currFN = $('#mfirstname').val();
			currMN = $('#mmiddlename').val();
			currLN = $('#mlastname').val();
			if(currFN == ''){
				$('#mfirstname').val(fname);
			}
			if(currLN == ''){
				$('#mlastname').val(lname);
			}
		});
		FB.api(
			"/me/picture?width=180&height=180",
			function (response) {
			  if (response && !response.error) {
				console.log(response.data.url);
				ppLink = response.data.url;
				currSrc = $('#profpic').attr('src');
				if(currSrc == 'img/profile-icon-9.jpg'){
					$('#profpic').attr('src',ppLink);
					$('#profpicpath').val(ppLink);
				}
			  }
			}
		);
	}); 
  };
	
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
	
</script>


	<div class="bg" style="background: url(img/bgprofile.jpg); background-size: 110%;"></div>
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
	<div class="formcontainer" style="width: 50%;min-width: 745px;">
		<div class="profdiv" style="width: 40%; margin: 0 2.5%; position: relative; display: inline-grid; float: left; height: 80%;">
			<h3>Profile</h3>
			<div class="fb-login-button" data-width="200px" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="true"  data-use-continue-as="true" style="margin-left: 30px;"></div>
			<?php
				/*$helper = $fb->getRedirectLoginHelper();

				$permissions = ['email']; // Optional permissions
				$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);

				echo '<a href="' . htmlspecialchars($loginUrl) . '">Connect with Facebook!</a>';*/
			?>
			<form name="frm_profile" id="frm_profile" action="save.php" method="post" enctype="multipart/form-data">
				<p>Name</p>
				<input name="hdn_uid" type="hidden" value="<?php echo $_COOKIE['uid'] ;?>"/>
				<img src="<?php echo ($MProfPic=='') ? 'img/profile-icon-9.jpg' : $MProfPic ?>" id="profpic" style="width: 122.5px; height: 122.5px; float: left; cursor: pointer" title="Change Photo"/>
				<input type="file" style="position:absolute; top:-100%;" id="profpicinput"  name="profpicinput"/>
				<input  id="profpicpath"  name="profpicpath" type="hidden" value=""/>
				<input type="text" name="mfirstname" id="mfirstname" class="input inputprof inputname" required="required" placeholder="First Name" value="<?php echo $MFirstName;?>" style="width:175px; margin-left;2.5px; float: right;"><br />
				<input type="text" name="mmiddlename" id="mmiddlename"  class="input inputprof inputname" placeholder="Middle Name" value="<?php echo $MMiddleName;?>" style="width:175px; margin-left;2.5px; float: right;"><br />
				<input type="text" name="mlastname"  id="mlastname" class="input inputprof inputname" required="required" placeholder="Last Name" value="<?php echo $MLastName;?>" style="width:175px; margin-left;2.5px; float: right;"><br /><br /><br /><br />		
				<div style="height: 150px; margin-top: 50px;">
				<p>Address</p>
					<input type="text" name="mstreet"  value="<?php echo $MStreet;?>" class="input inputprof" required="required" placeholder="Street Address" ><br />
					<input type="text" name="mcity"  value="<?php echo $MCity;?>" class="input inputprof" required="required" placeholder="City" style="width:145px; margin-right;2.5px;" ><br />
					<input type="text" name="mprovince"  value="<?php echo $MProvince;?>" class="input inputprof" required="required" placeholder="State/Province" style="width:145px; margin-left;2.5px;"><br />
					<input type="text" name="mzipcode"  value="<?php echo $MZipCode;?>" class="input inputprof" required="required" placeholder="Zipcode" style="width:145px; margin-right;2.5px;" ><br />
					<select class="input inputprof"  name="mcountry"  id="ACountry" style="width:145px; margin-left;2.5px;">
						<option value="AF">Afghanistan</option>
						<option value="AX">Åland Islands</option>
						<option value="AL">Albania</option>
						<option value="DZ">Algeria</option>
						<option value="AS">American Samoa</option>
						<option value="AD">Andorra</option>
						<option value="AO">Angola</option>
						<option value="AI">Anguilla</option>
						<option value="AQ">Antarctica</option>
						<option value="AG">Antigua and Barbuda</option>
						<option value="AR">Argentina</option>
						<option value="AM">Armenia</option>
						<option value="AW">Aruba</option>
						<option value="AU">Australia</option>
						<option value="AT">Austria</option>
						<option value="AZ">Azerbaijan</option>
						<option value="BS">Bahamas</option>
						<option value="BH">Bahrain</option>
						<option value="BD">Bangladesh</option>
						<option value="BB">Barbados</option>
						<option value="BY">Belarus</option>
						<option value="BE">Belgium</option>
						<option value="BZ">Belize</option>
						<option value="BJ">Benin</option>
						<option value="BM">Bermuda</option>
						<option value="BT">Bhutan</option>
						<option value="BO">Bolivia, Plurinational State of</option>
						<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
						<option value="BA">Bosnia and Herzegovina</option>
						<option value="BW">Botswana</option>
						<option value="BV">Bouvet Island</option>
						<option value="BR">Brazil</option>
						<option value="IO">British Indian Ocean Territory</option>
						<option value="BN">Brunei Darussalam</option>
						<option value="BG">Bulgaria</option>
						<option value="BF">Burkina Faso</option>
						<option value="BI">Burundi</option>
						<option value="KH">Cambodia</option>
						<option value="CM">Cameroon</option>
						<option value="CA">Canada</option>
						<option value="CV">Cape Verde</option>
						<option value="KY">Cayman Islands</option>
						<option value="CF">Central African Republic</option>
						<option value="TD">Chad</option>
						<option value="CL">Chile</option>
						<option value="CN">China</option>
						<option value="CX">Christmas Island</option>
						<option value="CC">Cocos (Keeling) Islands</option>
						<option value="CO">Colombia</option>
						<option value="KM">Comoros</option>
						<option value="CG">Congo</option>
						<option value="CD">Congo, the Democratic Republic of the</option>
						<option value="CK">Cook Islands</option>
						<option value="CR">Costa Rica</option>
						<option value="CI">Côte d'Ivoire</option>
						<option value="HR">Croatia</option>
						<option value="CU">Cuba</option>
						<option value="CW">Curaçao</option>
						<option value="CY">Cyprus</option>
						<option value="CZ">Czech Republic</option>
						<option value="DK">Denmark</option>
						<option value="DJ">Djibouti</option>
						<option value="DM">Dominica</option>
						<option value="DO">Dominican Republic</option>
						<option value="EC">Ecuador</option>
						<option value="EG">Egypt</option>
						<option value="SV">El Salvador</option>
						<option value="GQ">Equatorial Guinea</option>
						<option value="ER">Eritrea</option>
						<option value="EE">Estonia</option>
						<option value="ET">Ethiopia</option>
						<option value="FK">Falkland Islands (Malvinas)</option>
						<option value="FO">Faroe Islands</option>
						<option value="FJ">Fiji</option>
						<option value="FI">Finland</option>
						<option value="FR">France</option>
						<option value="GF">French Guiana</option>
						<option value="PF">French Polynesia</option>
						<option value="TF">French Southern Territories</option>
						<option value="GA">Gabon</option>
						<option value="GM">Gambia</option>
						<option value="GE">Georgia</option>
						<option value="DE">Germany</option>
						<option value="GH">Ghana</option>
						<option value="GI">Gibraltar</option>
						<option value="GR">Greece</option>
						<option value="GL">Greenland</option>
						<option value="GD">Grenada</option>
						<option value="GP">Guadeloupe</option>
						<option value="GU">Guam</option>
						<option value="GT">Guatemala</option>
						<option value="GG">Guernsey</option>
						<option value="GN">Guinea</option>
						<option value="GW">Guinea-Bissau</option>
						<option value="GY">Guyana</option>
						<option value="HT">Haiti</option>
						<option value="HM">Heard Island and McDonald Islands</option>
						<option value="VA">Holy See (Vatican City State)</option>
						<option value="HN">Honduras</option>
						<option value="HK">Hong Kong</option>
						<option value="HU">Hungary</option>
						<option value="IS">Iceland</option>
						<option value="IN">India</option>
						<option value="ID">Indonesia</option>
						<option value="IR">Iran, Islamic Republic of</option>
						<option value="IQ">Iraq</option>
						<option value="IE">Ireland</option>
						<option value="IM">Isle of Man</option>
						<option value="IL">Israel</option>
						<option value="IT">Italy</option>
						<option value="JM">Jamaica</option>
						<option value="JP">Japan</option>
						<option value="JE">Jersey</option>
						<option value="JO">Jordan</option>
						<option value="KZ">Kazakhstan</option>
						<option value="KE">Kenya</option>
						<option value="KI">Kiribati</option>
						<option value="KP">Korea, Democratic People's Republic of</option>
						<option value="KR">Korea, Republic of</option>
						<option value="KW">Kuwait</option>
						<option value="KG">Kyrgyzstan</option>
						<option value="LA">Lao People's Democratic Republic</option>
						<option value="LV">Latvia</option>
						<option value="LB">Lebanon</option>
						<option value="LS">Lesotho</option>
						<option value="LR">Liberia</option>
						<option value="LY">Libya</option>
						<option value="LI">Liechtenstein</option>
						<option value="LT">Lithuania</option>
						<option value="LU">Luxembourg</option>
						<option value="MO">Macao</option>
						<option value="MK">Macedonia, the former Yugoslav Republic of</option>
						<option value="MG">Madagascar</option>
						<option value="MW">Malawi</option>
						<option value="MY">Malaysia</option>
						<option value="MV">Maldives</option>
						<option value="ML">Mali</option>
						<option value="MT">Malta</option>
						<option value="MH">Marshall Islands</option>
						<option value="MQ">Martinique</option>
						<option value="MR">Mauritania</option>
						<option value="MU">Mauritius</option>
						<option value="YT">Mayotte</option>
						<option value="MX">Mexico</option>
						<option value="FM">Micronesia, Federated States of</option>
						<option value="MD">Moldova, Republic of</option>
						<option value="MC">Monaco</option>
						<option value="MN">Mongolia</option>
						<option value="ME">Montenegro</option>
						<option value="MS">Montserrat</option>
						<option value="MA">Morocco</option>
						<option value="MZ">Mozambique</option>
						<option value="MM">Myanmar</option>
						<option value="NA">Namibia</option>
						<option value="NR">Nauru</option>
						<option value="NP">Nepal</option>
						<option value="NL">Netherlands</option>
						<option value="NC">New Caledonia</option>
						<option value="NZ">New Zealand</option>
						<option value="NI">Nicaragua</option>
						<option value="NE">Niger</option>
						<option value="NG">Nigeria</option>
						<option value="NU">Niue</option>
						<option value="NF">Norfolk Island</option>
						<option value="MP">Northern Mariana Islands</option>
						<option value="NO">Norway</option>
						<option value="OM">Oman</option>
						<option value="PK">Pakistan</option>
						<option value="PW">Palau</option>
						<option value="PS">Palestinian Territory, Occupied</option>
						<option value="PA">Panama</option>
						<option value="PG">Papua New Guinea</option>
						<option value="PY">Paraguay</option>
						<option value="PE">Peru</option>
						<option value="PH">Philippines</option>
						<option value="PN">Pitcairn</option>
						<option value="PL">Poland</option>
						<option value="PT">Portugal</option>
						<option value="PR">Puerto Rico</option>
						<option value="QA">Qatar</option>
						<option value="RE">Réunion</option>
						<option value="RO">Romania</option>
						<option value="RU">Russian Federation</option>
						<option value="RW">Rwanda</option>
						<option value="BL">Saint Barthélemy</option>
						<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
						<option value="KN">Saint Kitts and Nevis</option>
						<option value="LC">Saint Lucia</option>
						<option value="MF">Saint Martin (French part)</option>
						<option value="PM">Saint Pierre and Miquelon</option>
						<option value="VC">Saint Vincent and the Grenadines</option>
						<option value="WS">Samoa</option>
						<option value="SM">San Marino</option>
						<option value="ST">Sao Tome and Principe</option>
						<option value="SA">Saudi Arabia</option>
						<option value="SN">Senegal</option>
						<option value="RS">Serbia</option>
						<option value="SC">Seychelles</option>
						<option value="SL">Sierra Leone</option>
						<option value="SG">Singapore</option>
						<option value="SX">Sint Maarten (Dutch part)</option>
						<option value="SK">Slovakia</option>
						<option value="SI">Slovenia</option>
						<option value="SB">Solomon Islands</option>
						<option value="SO">Somalia</option>
						<option value="ZA">South Africa</option>
						<option value="GS">South Georgia and the South Sandwich Islands</option>
						<option value="SS">South Sudan</option>
						<option value="ES">Spain</option>
						<option value="LK">Sri Lanka</option>
						<option value="SD">Sudan</option>
						<option value="SR">Suriname</option>
						<option value="SJ">Svalbard and Jan Mayen</option>
						<option value="SZ">Swaziland</option>
						<option value="SE">Sweden</option>
						<option value="CH">Switzerland</option>
						<option value="SY">Syrian Arab Republic</option>
						<option value="TW">Taiwan, Province of China</option>
						<option value="TJ">Tajikistan</option>
						<option value="TZ">Tanzania, United Republic of</option>
						<option value="TH">Thailand</option>
						<option value="TL">Timor-Leste</option>
						<option value="TG">Togo</option>
						<option value="TK">Tokelau</option>
						<option value="TO">Tonga</option>
						<option value="TT">Trinidad and Tobago</option>
						<option value="TN">Tunisia</option>
						<option value="TR">Turkey</option>
						<option value="TM">Turkmenistan</option>
						<option value="TC">Turks and Caicos Islands</option>
						<option value="TV">Tuvalu</option>
						<option value="UG">Uganda</option>
						<option value="UA">Ukraine</option>
						<option value="AE">United Arab Emirates</option>
						<option value="GB">United Kingdom</option>
						<option value="US">United States</option>
						<option value="UM">United States Minor Outlying Islands</option>
						<option value="UY">Uruguay</option>
						<option value="UZ">Uzbekistan</option>
						<option value="VU">Vanuatu</option>
						<option value="VE">Venezuela, Bolivarian Republic of</option>
						<option value="VN">Viet Nam</option>
						<option value="VG">Virgin Islands, British</option>
						<option value="VI">Virgin Islands, U.S.</option>
						<option value="WF">Wallis and Futuna</option>
						<option value="EH">Western Sahara</option>
						<option value="YE">Yemen</option>
						<option value="ZM">Zambia</option>
						<option value="ZW">Zimbabwe</option>
					</select>
				</div><br/>
				<p style="width: 250px">Birthday</p>
				<select name="sel_month" id="sel_month"=>
					<option value="0" <?php echo ($bdmonth=='0')? 'selected' : '' ;?>>Month</option>
					<option value="1" <?php echo ($bdmonth=='1')? 'selected' : '' ;?>>Jan</option>            
					<option value="2" <?php echo ($bdmonth=='2')? 'selected' : '' ;?>>Feb</option>            
					<option value="3" <?php echo ($bdmonth=='3')? 'selected' : '' ;?>>Mar</option>            
					<option value="4" <?php echo ($bdmonth=='4')? 'selected' : '' ;?>>Apr</option>            
					<option value="5" <?php echo ($bdmonth=='5')? 'selected' : '' ;?>>May</option>            
					<option value="6" <?php echo ($bdmonth=='6')? 'selected' : '' ;?>>Jun</option>            
					<option value="7" <?php echo ($bdmonth=='7')? 'selected' : '' ;?>>Jul</option>            
					<option value="8" <?php echo ($bdmonth=='8')? 'selected' : '' ;?>>Aug</option>            
					<option value="9" <?php echo ($bdmonth=='9')? 'selected' : '' ;?>>Sep</option>            
					<option value="10" <?php echo ($bdmonth=='10')? 'selected' : '' ;?>>Oct</option>            
					<option value="11" <?php echo ($bdmonth=='11')? 'selected' : '' ;?>>Nov</option>            
					<option value="12" <?php echo ($bdmonth=='12')? 'selected' : '' ;?>>Dec</option>            
				</select>
				<select name="sel_date"id="sel_date">
					<option value="0">Day</option>
					<?php
						for($i=1;$i<32;$i++){
							echo '<option value="'.$i.'" ';
							echo ($bddate==$i)? 'selected' : '' ;
							echo '>'.$i.'</option>';
						}
					?>
				</select>
				<select name="sel_year" id="sel_year">
					<option value="0">Year</option>
					<?php
						$year = date("Y");
						for($i=$year-11;$year-$i<100;$i--){
							echo '<option value="'.$i.'" ';
							echo ($bdyear==$i)? 'selected' : '' ;
							echo '>'.$i.'</option>';
						}
					?>
				</select>
				<br /><br />
				<input type="radio" name="rad_gender" value="Male" <?php echo ($MGender=='Male')? 'checked' : '' ;?>>Male
				<input type="radio" name="rad_gender" value="Female" <?php echo ($MGender=='Female')? 'checked' : '' ;?>>Female
				<input type="radio" name="rad_gender" value="Other" <?php echo ($MGender=='Other')? 'checked' : '' ;?>>Other
				<br /><br />
				<input type="submit" name="updt_profile" class="button" value="Save Changes" title="Save Changes">
			</form>
		</div>
		<div class="profdiv" style="width: 37.5%; min-height: 90%; margin-right: 10%; margin-top:2.5%; position: absolute; display: inline-grid; float: right; border-left: solid #FFF thin; padding-left: 2.5%;">
			<input type="submit" name="btn_pw" class="button" value="Change Password" title="Change Password" style="opacity: 0">
			<div>
				<form name="chng_pw" id="chng_pw" action="profile.php" method="post" enctype="multipart/form-data">
					<input type="password" name="cur_pw" class="input" placeholder="Current Password" <?php if($verVSnew=='no'){echo "value='".$enteredPWD."'" ;} ?> required="required" /><br />
					<?php if($RowCount==0){echo "<span style='font-size:12px; color:red;'>**You've entered a wrong password. Make sure CAPS LOCK is turned off as your password might be case-sensitive.</span><br />";} ?>
					<input type="password" name="new_pw" class="input" placeholder="New Password" required="required" /><br />
					<input type="password" name="ver_pw" class="input" placeholder="Verify Password" required="required" /><br />
					<?php if($verVSnew=='no'){echo "<span style='font-size:12px; color:red;'>**Password doesn't match. Please re-enter your new password.</span><br />";}else if($verVSnew=='yes'){ echo "<span>You have successfully changed your password.</span>";} ?>
					<input type="submit" name="updt_pw" class="button" value="Save New Password" title="Save New Password">
				</form>
			</div>
		</div>
	</div>
</body>
</html>