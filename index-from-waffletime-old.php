<?php 
	require_once('inc/header.php'); 
	$mysqli = new mysqli($wti_server,$wti_username,$wti_password,$wti_database);
?>

<div id="content">
	<div id="main" class="pages" style="opacity:1; background-color: aliceblue; background-image:
    	<?php 
			$stmtBG = $mysqli -> stmt_init();
			if($stmtBG->prepare("SELECT SPhoto FROM slide WHERE SStatus=1")){
				$stmtBG->execute();
				$stmtBG->bind_result($SPhoto);
				$stmtBG->fetch();
				//echo $idA;
				$stmtBG->close();
			}
			echo 'url(img/gui/'.$SPhoto.')';
		?>; margin-top:0; background-repeat: no-repeat; background-size: 100%; background-position: top;">
        <!--<img id="mainFOTM" src="img/gui/FOTM.png" />-->
    </div>
    <div id="psavory" class="pages" style="background-image:url(img/products/Ourwaffle.png); margin-top:30px; background-repeat: no-repeat; background-size: contain;">
    	<span class="pagelabel">Our Waffles</span> 
    </div>
    <div id="psweet" class="pages">
    	<span class="pagelabel">Our Waffles</span>  
    </div>
    <div id="franchise" class="pages">
    	<div id="franchisebox">
            <div id="franchiseBG">
                <strong>Waffletime Franchise Package</strong>
                <br>
                <br><b>Package Cost :</b>
                <br>P 250,000.00 (net of taxes)
                <br><b>Franchise Fee :</b>
                <br>P 50,000.00 
                <br>
                <br><b>Security Deposit :</b>
                <br>P 50,000.00 - refundable upon expiration of the franchise agreement with no interest.
                <br>
                <br><b>Renewal Fee :</b>
                <br>P 50,000.00
                <br>
                <br><b>Franchise Duration :</b>
                <br>Three (3) years
                <br>
                <br><b>Package Inclusion:</b>
                <br>• Use of the Waffle Time Trade Name Marks
                <br>• Business Operations System
                <br>• Mobilization Set-up
                <br>• Cart and Signage
                <br>• Equipment and Small wares
                <br>• Marketing Support
                <br>• Operational and Technical Support
                <br>
                <br><b>Downloads:</b>
                <br>• <a class="dl" href="download/WAFFLETIME_FRANCHISE_PACKAGE.pdf" target="_blank"><b>Franchise package PDF Format</b></a>
                <br>• <a class="dl" href="download/Franchise_Application_Form_2017.doc" target="_blank"><b>Application Form</b></a>
                <br>
                <br>For contact information, please refer to <a id="franchisere" href="#contact">Contact Page</a>
            </div>
        </div>
        <img id="franimg" src="img/fran/cart.jpg" />
        <img id="franimg2" src="img/gui/WT pambansang waffle.png" />
    	<span class="pagelabel">Franchise</span> 
    </div>
    <div id="about" class="pages">
    	<div id="aboutbox">
            <div class="abouttabs" id="ahistory">
                <div class="abouttabshead"><img class="aboutarrow" src="img/about/Blue_Arrow_Up_Darker.png" style="transform:rotate(90deg)"/>OUR HISTORY</div>
                <div class="aboutcontent" style="display:block">
                	<?php 
						$stmtAU = $mysqli -> stmt_init();
						if($stmtAU->prepare("SELECT idAboutus,AUContent FROM aboutus WHERE idAboutus = 1")){
							$stmtAU->execute();
							$stmtAU->bind_result($idAU,$AUContent1);
							$stmtAU->fetch();
							echo $AUContent1;
							$stmtAU->close();
						}
					?>
                </div>
            </div>
            <div class="abouttabs" id="amission">
                <div class="abouttabshead"><img class="aboutarrow" src="img/about/Blue_Arrow_Up_Darker.png" />MISSION AND VISION</div>
                <div class="aboutcontent">
               		 <?php 
						$stmtAU = $mysqli -> stmt_init();
							if($stmtAU->prepare("SELECT idAboutus,AUContent FROM aboutus WHERE idAboutus = 2")){
								$stmtAU->execute();
								$stmtAU->bind_result($idAU,$AUContent2);
								$stmtAU->fetch();
								echo $AUContent2;
								$stmtAU->close();
							}
					?>
                </div>
            </div>
            <div class="abouttabs" id="acareers">
                <div class="abouttabshead"><img class="aboutarrow" src="img/about/Blue_Arrow_Up_Darker.png" />BE ONE OF US!</div>
                <div class="aboutcontent">
                	<br />OFFICE PERSONNEL<br>
                    <li>Male or Female (not more than 28 years old)
                    </li><li>Graduate of any four-year course
                    </li><li>With pleasing personality and can work under pressure</li>
                    <br>ACCOUNTING OFFICER<br>
                    <li>Male and Female
                    </li><li>21-25 years old
                    </li><li>Accountancy or Management Accounting graduate
                    </li><li>Computer Literate
                    </li><li>Good written and oral communication skills</li>
                    <br>MARKETING OFFICER<br>
                    <li>Male o Female (21-25 years old)
                    </li><li>Marketing or Advertising Graduate
                    </li><li>Must have extensive background in marketing and promotions
                    </li><li>Computer literate
                    </li><li>Good written and oral communication skills
                    </li><li>Enthusiastic and with pleasing personality</li>
                    <br>MANAGEMENT TRAINEES<br>
                    <li>Male or Female (20-28 years old)
                    </li><li>Graduate of any four-year course
                    </li><li>Has good communication, interpersonal, and leadership skills
                    </li><li>Willing to work long hours and on holidays</li>
                    <br>QUALITY ASSURANCE OFFICER<br>
                    <li>Male or Female
                    </li><li>Graduate of BS Food Technology from a reputable school
                    </li><li>Knowledgeable of CGMP &amp; HACCP
                    </li><li>Has good written and oral communication skills
                    </li><li>Willing to be trained and assigned in Manila</li>
                    <br>ENGINEERING AND MAINTENANCE OFFICER<br>
                    <li>Male (not more than 35 years old
                    </li><li>Graduate of Engineering or any related course, preferably board passer
                    </li><li>Able to design electrical lay-out for buildings
                    </li><li>Willing to work long hours and on holidays</li>
                    <br>HUMAN RESOURCE OFFICER<br>
                    <li>Male or Female (21-25)
                    </li><li>Graduate of Psychology or Management
                    </li><li>Efficient and with pleasing personality
                    </li><li>Has good written and oral communication skills</li>
                </div>
            </div>
        </div>
        <img id="aboutimg" src="img/about/different fillin.png" />
    	<span class="pagelabel">About Us</span> 
    </div>
    <div id="stores" class="pages" style="background:#FFF">
    	<img id="spbg" src="img/gui/StoreNW.jpg" />
        <div id="spbgframe"></div>
    	<div class="subpage storesubpage" id="sluz">
       		<input type="text" placeholder="Search Store" id="searchluz" class="searchstore" onchange="searchStore(this.value,'luzon')" value=""/>
        	<div id="sluzlist" class="storelist">
            	<div class="storescroll">
                    <table border="0">
                        <tbody>
                           <?php 
								$stmtSL = $mysqli -> stmt_init();
								if($stmtSL->prepare("SELECT SName,SAddress,SCount FROM store WHERE SName LIKE '%Metro Manila%'")){
									$stmtSL->execute();
									$stmtSL->bind_result($SName,$SAddress,$SCount);
									$i=0;
									while($stmtSL->fetch()){
										echo '<tr id="sluzlist-'.$i.'"><td>'.$SCount.'</td><td>'.$SAddress.'</td><td>'.$SName.'</td></tr>';
										$i++;
									};
									$stmtSL->close();
								}
							?>
                            <!--<tr><td>1</td><td>Alabang Town Food 1</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>Ali Mall, Cubao, QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>Ayala 2 MRT Station</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>EDSA Central, Manadaluyong City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>EGI 2, Taft Ave. Pasay City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>Ever Ortigas, Ever Gotesco Mall, Ortigas Center, Sta Lucia, Pasig</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>Farmers 1, Cubao, QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>Farmers 2, Cubao, QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>FESTIVAL MALL 1- 2nd Flr Festival Supermall, Alabang, Muntinlupa	</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>FESTIVAL MALL 2- Foodcourt</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>GLORIETA 1- Cinema</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>GRAND TERMINAL</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>GT TOWER - Makati</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>ISETANN 1- 1st level,CM Recto Ave. Quiapo</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>Isetann 2- Ground Level</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LKG AYALA - 11th flr, Ayala Ave. Makati</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT BACLARAN 1 South</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT BACLARAN 2 North</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT BLUMENTRITT 2 North</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT CARRIEDO 1- Quiapo</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT CARRIEDO 2- Quiapo</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT CENTRAL - Ermita</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT DE JOSE 1 - Sta Cruz</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT DE JOSE 2 - Sta Cruz</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT EDSA - Edsa Rotonda, Pasay</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT GIL PUYAT 1 - Buendia, Pasay</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT GIL PUYAT 2 - Buendia, Pasay</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT MONUMENTO 1 - Caloocan City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT NORTHMALL 1 - Rizal Ave,Caloocan City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT NORTHMALL 2 - Rizal Ave,Caloocan City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT PEDRO GIL 2 - South, Ermita</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT TAYUMAN 1 - North, Sta Cruz</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT UN 1 - South, Malate</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>LRT V. Mapa</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MAKATI CINEMA SQUARE - Chino Roces Ave. Makati</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MALABON CITY SQUARE</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MARKET2x 1 - 3rd Flr Global City, Taguig</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MARKET2x 2 - 2nd Flr Global City, Taguig</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MCU - Caloocan</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>METRO MARKET - Basement,Supermarket Area, Global City Taguig</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>METROPOINT 1 - 3rd flr, Taft. Ave, Pasay City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>METROPOINT 2 - 2nd flr, Taft Ave. Pasay City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>METROPOLIS ALABANG - 2nd Flr</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>METROPOLIS ALABANG- Basement Level, Metropolis Star</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MRT BONI STATION - Mandaluyong City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MRT GMA KAMUNING 1 -North</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MRT GMA KAMUNING 2 - South</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MRT ORTIGAS 1 -North, Mandaluyong</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MRT ORTIGAS 2 - South, Mandaluyong</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MRT QUEZON AVE 1 - North,Edsa QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MRT QUEZON AVE 2 - South, QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>MRT SHAW BOULEVARD</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>PARK N RIDE - Ermita</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>PARK SQUARE MART</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>PUREGOLD Libertad - Supermarket</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>ROB MANILA - Level 3 Foodcourt</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>ROB PIONEER - Level 1,Mandaluyong City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>ROYAL FAMILY MALL - L/G, Valenzuela City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SHANGRILA 1 - C1l1,Shaw Blvd, Mandaluyong City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SHANGRILA 2 - Stall Ax 103</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SHANGRILA 3 -Level 18, Edsa, Mandaluyong</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SHOPWISE MAKATI - Chino Roces Ave. Makati</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM BICUTAN - C203B, Paranaque City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM CUBAO - C2 SM Foodcourt</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM FAIRVIEW 1 - UPGF,Brgy Fairview,Greater Lagro,QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM FAIRVIEW 2 - C111,QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM FAIRVIEW BOWLING - SMCF Bowling Center, QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM FAIRVIEW MARKET - Supermarket Area, QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM FAIRVIEW TERMINAL-Jeepney Terminal Booth #4, QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM MALL OF ASIA 1</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM MALL OF ASIA 2</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM MANILA - C304A Arroceros St., Ermita</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM MEGAMALL - C010 LGF, Bldg A</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM North EDSA</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM SAN LAZARO - C306 Sta Cruz</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM SOUTHMALL 1 - C210</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM SOUTHMALL 2 - C124 UGF Las Pinas</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM SOUTHMALL 3 - CT003 Ice Skating Rink,LGF</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM SOUTHMALL SUPERMARKET - Supermarket Area</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM STA MESA 1 - G/F Araneta Ave. Sta Mesa QC</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM STA MESA 2 - C301</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM SUCAT - Supercenter, Sucat, Paranaque</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>SM VALENZUELA - Valenzuela City</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>STA LUCIA - 2nd Level Phase 1 Sta Lucia East Grand Mall, Pasig</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>STARMALL 1 - G/F, Edsa Cor Shaw Blvrd.Mandaluyong</td><td>Metro Manila</td></tr>
                            <tr><td>1</td><td>STARMALL 2 - Edsa Parking Cor Shaw Blvd. Mandaluyong</td><td>Metro Manila</td></tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
            <img id="storeimg1" class="storeimg" src="img/store/store1.png" />
            <img id="storeimg2" class="storeimg" src="img/store/store1.png" />
            <img id="storeimg3" class="storeimg" src="img/store/store1.png" />
        </div>
        <div class="subpage storesubpage" id="sviz">
        	<input type="text" placeholder="Search Store" id="searchvis" class="searchstore" onchange="searchStore(this.value,'visayas')" value=""/>
        	<div id="svizlist" class="storelist">
            	<div class="storescroll">
                    <table border="0">
                        <tbody>
                           <?php 
								$stmtSL = $mysqli -> stmt_init();
								if($stmtSL->prepare("SELECT SName,SAddress,SCount FROM store WHERE SName REGEXP 'Iloilo|Cebu'")){
									$stmtSL->execute();
									$stmtSL->bind_result($SName,$SAddress,$SCount);
									$i=0;
									while($stmtSL->fetch()){
										echo '<tr id="svizlist-'.$i.'"><td>'.$SCount.'</td><td>'.$SAddress.'</td><td>'.$SName.'</td></tr>';
										$i++;
									};
									$stmtSL->close();
								}
							?>
                            <!--<tr><td>1</td><td>Ateneo de Iloilo</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Atrium Mall</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Central Philippine Univ.</td><td>Iloilo City</td></tr>
                            <tr><td>3</td><td>Gaisano City Iloilo</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Gaisano Guanco</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Iloilo Supermart - Jaro</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Iloilo Supermart - Valeria</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Iloilo Supermart- Mandurriao</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Iloilo Supermart- Molo</td><td>Iloilo City</td></tr>
                            <tr><td>2</td><td>Marymart Mall</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Plaza Jaro</td><td>Iloilo City</td></tr>
                            <tr><td>2</td><td>Robinsons Iloilo</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>SM City - Delgado</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Society Commercial</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>University of San Agustin</td><td>Iloilo City</td></tr>
                            <tr><td>1</td><td>Washington Commercial</td><td>Iloilo City</td></tr>
                            <tr><td>2</td><td>Ayala Center</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Cebu Institute of Technological (CIT)</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Colonade Supermarket, Cebu City</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Elizabeth Mall (E-Mall)</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Fooda Guadalupe</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Fooda Saversmart</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>G. METRO COLON2</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Gaisano Bogo, Brgy. Carbon, Bogo, Cebu</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Gaisano Country Mall</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Gaisano Danao</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Gaisano Fiesta Mall</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Gaisano Mactan</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Gaisano Main</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Gaisano Metro Ayala</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Gaisano South</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Gaisano Supermetro</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Metro Colon</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Pier 1</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Pier 4</td><td>Cebu City</td></tr>
                            <tr><td>2</td><td>SM City Cebu</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Southwestern Univ.</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>Tiange Tiange, MC City Square</td><td>Cebu City</td></tr>
                            <tr><td>1</td><td>White Gold</td><td>Cebu City</td></tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
        	<img id="storeimg4" class="storeimg" src="img/store/store1.png" />
            <img id="storeimg5" class="storeimg" src="img/store/store1.png" />
            <img id="storeimg6" class="storeimg" src="img/store/store1.png" />
            <img id="storeimg7" class="storeimg" src="img/store/store1.png" />
            <img id="storeimg8" class="storeimg" src="img/store/store1.png" />          
        </div>
        <div class="subpage storesubpage" id="smin">
       		<input type="text" placeholder="Search Store" id="searchmin" class="searchstore" onchange="searchStore(this.value,'mindanao')" value=""/>
        	<div id="sminlist" class="storelist">
            	<div class="storescroll">
                    <table border="0">
                        <tbody>
                           <?php 
								$stmtSL = $mysqli -> stmt_init();
								if($stmtSL->prepare("SELECT SName,SAddress,SCount FROM store WHERE SName REGEXP 'Cagayan|Davao'")){
									$stmtSL->execute();
									$stmtSL->bind_result($SName,$SAddress,$SCount);
									$i=0;
									while($stmtSL->fetch()){
										echo '<tr id="sminlist-'.$i.'"><td>'.$SCount.'</td><td>'.$SAddress.'</td><td>'.$SName.'</td></tr>';
										$i++;
									};
									$stmtSL->close();
								}
							?>
                            <!--<tr><td>1</td><td>Berd's Theater Mall</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>Capitol University</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>Gaisano City</td><td>Cagayan de Oro</td></tr>
                            <tr><td>2</td><td>Gaisano Mall</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>Greeh, Bird's Mall Iligan</td><td>Cagayan de Oro</td></tr>
                            <tr><td>2</td><td>Limketkai Mall</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>Liseo De Cagayan Univ.</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>Ororama Supercenter</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>Robinsons</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>SM City</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>Xavier Highschool,Xavier Heights</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>Xavier University Campu, Brgy. 40</td><td>Cagayan de Oro</td></tr>
                            <tr><td>1</td><td>Ateneo College</td><td>Davao City</td></tr>
                            <tr><td>1</td><td>Ateneo High School</td><td>Davao City</td></tr>
                            <tr><td>1</td><td>Central Warehouse-Agdao</td><td>Davao City</td></tr>
                            <tr><td>1</td><td>Gaisano Mall</td><td>Davao City</td></tr>
                            <tr><td>2</td><td>Gaisano Southmall</td><td>Davao City</td></tr>
                            <tr><td>1</td><td>Lachmi Shopping Mall</td><td>Davao City</td></tr>
                            <tr><td>1</td><td>NCCC Centerpoint</td><td>Davao City</td></tr>
                            <tr><td>1</td><td>NCCC Mall</td><td>Davao City</td></tr>
                            <tr><td>1</td><td>Phil. Women\'s College</td><td>Davao City</td></tr>
                            <tr><td>3</td><td>SM City</td><td>Davao City</td></tr>-->
                        </tbody>
                    </table>
            	</div>
            </div>
        	<img id="storeimg9" class="storeimg" src="img/store/store1.png" />
            <img id="storeimg10" class="storeimg" src="img/store/store1.png" />
            <img id="storeimg11" class="storeimg" src="img/store/store1.png" />
        </div>
    	<span class="pagelabel">Our Stores</span> 
    </div>
    <div id="contact" class="pages">
    	<div id="contactbox">
        	<div class="contactlist">
            	<?php 
					$stmtCU = $mysqli -> stmt_init();
					if($stmtCU->prepare("SELECT `CUName`,`CUAddress`,`CUPerson`,`CUTelephone`,`CUFax`,`CUMobile` FROM `contact` WHERE Status=1")){
						$stmtCU->execute();
						$stmtCU->bind_result($CUName,$CUAddress,$CUPerson,$CUTelephone,$CUFax,$CUMobile);
						while($stmtCU->fetch()){
							?>
                            <div class="contacttab">
                                <div class="contacttabshead">
                                    <img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b><?php echo $CUName ?></b>
                                </div>
                                <div class="contactcontent">
                                    <?php echo $CUAddress ?>
                                    <br><?php echo $CUPerson ?>
                                    <br>Tel.:<?php echo $CUTelephone ?>
                                    <br>Fax:<?php echo $CUFax ?>
                                    <br>Mobile:<?php echo $CUMobile ?>
                                    
                                </div>
                            </div>
                            <?php
						};
						$stmtCU->close();
					}
				?>                       
				<!--<div class="contacttab">
                	<div class="contacttabshead">
                    	<img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b>Waffle Time, Inc. Manila Office</b>
                    </div>
                	<div class="contactcontent">
                    	# 69 C. Raymundo Avenue Brgy. Caniogan, Pasig City<br>Contact Person:Mr. Bryan Jaspe<br>Telephone:(63)(2) 5841601 (63)(2) 5843704 (63)(2) 6411151<br>Fax:(63)(2) 6841870<br>Mobile(+639228923441)<br>
                    </div>
                </div>
                <div class="contacttab">
                	<div class="contacttabshead">
                    	<img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b>Waffle Time, Inc. Iloilo Office</b>
                    </div>
                	<div class="contactcontent">
                    	Door 4, Q.H.P. Building, Arsenal St. Iloilo City, 5000, Philippines<br>Contact Person:Ms. Catherine Palencia<br>Telephone:(63)(33) 335-0935<br>Fax:(63)(33) 335-0026<br>Mobile(+639328923353)<br>
                    </div>
                </div>
                <div class="contacttab">
                	<div class="contacttabshead">
                    	<img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b>Waffle Time, Inc. Cebu Office</b>
                    </div>
                	<div class="contactcontent">
                    	Lot 2, Corner Bataan St., Andres-Abellan Extension, Brgy. Guadalupe, Cebu City<br>Contact Person:Ms. Joylyn  Sugo-on<br>Telephone: 2539679<br>Fax:032-253-9679<br>Mobile09228163502<br>
                    </div>
                </div>
                <div class="contacttab">
                	<div class="contacttabshead">
                    	<img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b>Waffle Time, Inc. Cagayan Office</b>
                    </div>
                	<div class="contactcontent">
                    	Dona Cecilia Avenue, Corner J.R. Borja Street Ext. Sta Cecilia Subd., Gusa, Cagayan De Oro City<br>Contact Person:Mr. Emmanuel Esrael Morbo<br>Telephone:8555011<br>Fax:317-317-3137<br>Mobile(+639228923472) Sun and (+639209505072) Smart<br>
                    </div>
                </div>
                <div class="contacttab">
                	<div class="contacttabshead">
                    	<img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b>Waffle Time, Inc. Davao Office</b>
                    </div>
                	<div class="contactcontent">
                    	#20 Sierra Madre Street, Rolling Hills Subd., Bacaca, Davao City<br>Contact Person:Ms. Vi Marie Sanchez<br>Telephone:082-3215395<br>Fax:082-3215395<br>Mobile(+639228923464) Sun and (+639209505073) Smart<br>
                    </div>
                </div>
                <div class="contacttab">
                	<div class="contacttabshead">
                    	<img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b>Waffle Time, Inc. Dagupan Office</b>
                    </div>
                	<div class="contactcontent">
                    	#497 Bolosan District, Dagupan City, Pangasinan<br>Contact Person:Ms. Honeyzel Tala-oc<br>Telephone:075-2020180<br>Fax:317-317-3137<br>Mobile1<br>
                    </div>
                </div>
                <!--<div class="contacttab">
                	<div class="contacttabshead">
                    	<img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b>Waffle Time, Inc. Bacolod Office</b>
                    </div>
                	<div class="contactcontent">
                    	#47 L.V Javellosa Apartment Roxas Avenue Brgy. 39, Bacolod City<br>Contact Person:Ms. Cristy Ellen Miranda<br>Telephone:4345943<br>Fax:317-317-3137<br>Mobile1<br>
                    </div>
                </div>-->
				
               	<div class="contacttab" style="width:100%">
                	<br />
                	<div class="contacttabshead">
                    	<img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b>LEAVE US A MESSAGE!</b>
                    </div>
                    <div class="contactcontent" style="display:block">
                        Give us your suggestions, comments<br> or feedbacks. We'd like to hear<br>from you! Leave us your message.<br><br>
                        <form method="post" action="/contact.php">
                            <table>
                            <tr><td width="10">Name:</td><td><input name="name" type="text"></td></tr>
                            <tr><td width="10">Email:</td><td><input name="email" type="text"><br></td></tr>
                            <tr><td width="10">Subject:</td><td><input name="subject" type="text"><br></td></tr>
                            <tr><td width="10">Message:</td></tr>
                            <tr><td width="10"></td><td><textarea name="message" style="height:200px" rows="8" cols="40"></textarea></td></tr>
                            <tr><td width="10"></td><td><input type="submit"></td></tr>
                            </table>
                        </form>
                    </div>
            	</div>
        	</div>
		</div>    
        <p class="triangle-right top">Follow Us!</p>
        <img id="waffy" src="img/contact/waffy.png" />
        <a class="sml" id="fb" target="_blank" href="https://facebook.com/waffletime" title="Follow us on Facebook!"><img src="img/contact/snfb.png" /></a>
        <a class="sml" id="t" target="_blank" href="https://twitter.c
        .om/waffletime_ph" title="Follow us on Twitter!"><img src="img/contact/snt.png" /></a>
        <a class="sml" id="ig" target="_blank" href="https://instagr.am/waffletime_ph" title="Follow us on Instagram!"><img src="img/contact/snig.png" /></a>
    	<span class="pagelabel">Contact Us</span> 
    </div>
    <div id="events" class="pages">
    	<!--<div id="eventscroll" style="width: 900px; height: 500px; max-height: 500px; overflow-y: scroll; margin-top: 150px; margin-left: 20px;">-->
    		<div id="eventlist" style="width: 750px; padding: 10px; height: auto; margin-top: 150px; margin-left: 20px; color:#222;" >
    			<?php 
					$stmtCU = $mysqli -> stmt_init();
					if($stmtCU->prepare("SELECT `ATitle`,`AContent`,`APhoto` FROM `article` WHERE Status=1")){
						$stmtCU->execute();
						$stmtCU->bind_result($ATitle,$AContent,$APhoto);
						while($stmtCU->fetch()){
							?>
                            <!--<div class="eventframe">
                                <div class="eventtitle" style="color: cadetblue">
                                    <h1><?php echo $ATitle; ?></h1>
                                </div>
                                <div class="eventcontent" style="color:darkcyan"> 
                                	<img src="<?php echo $APhoto;?>" style="max-height:600px"><?php echo $AContent; ?>       
                                </div>
                            </div>-->
                            <div class="contacttab" style="width:100%;">
                                <div class="contacttabshead">
                                    <img class="contactarrow" src="img/about/Blue_Arrow_Up_Darker.png" /><b><?php echo $ATitle ?></b>
                                </div>
                                <div class="contactcontent" style="font-size: 11px;">
                                	<?php echo $AContent; ?>
                                </div>
                            </div>
                            <?php
						};
						$stmtCU->close();
					}
				?>
    		</div>
    	<!--</div>-->
    	<span class="pagelabel">Events</span> 
	</div>
	<div id="toolbar">
    	<!--<a href="include/../">--><a href="#" onClick="window.location.reload()" id="mainlink"><img id="logo" src="img/gui/Waffle%20Time%202013.png"></a>
        <!--<img id="tagline" src="img/gui/WT pambansang waffle.png" />-->
        <div id="nav">
       	 	<a class="navlink" href="#events"><div class="navdiv">EVENTS</div></a>
        	<a class="navlink" href="#contact"><div class="navdiv">CONTACT US</div></a>
            <div class="navdiv navdivstores" id="navdivstores"><span style="display:block;position:absolute; width:100%; height:25px; text-align:center;z-index:1">OUR STORES</span>
            	<div class="navsubdiv">
                	<a class="navsublink" href="#stores" onclick="scrollStore(1);"><div class="navsubnavdiv">LUZON</div></a>
                	<a class="navsublink" href="#stores" onclick="scrollStore(2);"><div class="navsubnavdiv">VISAYAS</div></a>
                	<a class="navsublink" href="#stores" onclick="scrollStore(3);"><div class="navsubnavdiv">MINDANAO</div></a>
                </div>
            </div>
            <a class="navlink" href="#about"><div class="navdiv">ABOUT US</div></a>
            <a class="navlink" href="#franchise"><div class="navdiv">FRANCHISE</div></a>
            <a class="navlink" href="#psavory"><div class="navdiv">OUR WAFFLES</div></a>
            <!--<div class="navdiv" id="navdivprod"><span style="display:block;position:absolute; width:100%; height:25px; text-align:center;z-index:1">OUR WAFFLES</span>
            	<div class="navsubdiv">
                	<a class="navsublink" href="#psweet"><div class="navsubnavdiv">SWEET</div></a>
                    <a class="navsublink" href="#psavory"><div class="navsubnavdiv">SAVORY</div></a>
                </div>
            </div>-->
		</div>
	</div>
    <div id="footcolors">
		<img src="img/gui/blue.png" id="blue" class="footcolors" style="transform:rotate(60deg)"/>
		<img src="img/gui/yellow.png" id="yellow"  class="footcolors" style="transform:rotate(-30deg)"/>
		<img src="img/gui/red.png" id="red"  class="footcolors" style="transform:rotate(-30deg)"/>
  		<img src="img/gui/redr1.png" id="redr1"  class="footcolors" style="transform:rotate(0deg)"/>
		<img src="img/gui/redr2.png" id="redr2"  class="footcolors" style="transform:rotate(0deg)"/>
	</div>
</div>


<?php 
	require_once('inc/footer.php'); 
?>