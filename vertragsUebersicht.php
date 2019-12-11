<?php
	include('db/database.php');
	include('forms/include/logged.php');

	//Prüfung ob SESSION_ID gesetzt
	if(!isset($_SESSION['userID'])) {
		die('Bitte zuerst <a href="login.php">einloggen</a>');
	}	 
	//Abfrage der SESSION_ID aus dem Login + Begruessung
	$userid = $_SESSION['userID'];

	$vertraege = $pdo->prepare("
		SELECT user_vertrag_gas.VertragsID, user_vertrag_gas.Sparte, user_vertrag_gas.Status 
		FROM user_vertrag_gas
		WHERE user_vertrag_gas.ID = ".$_SESSION['userID']." 
			UNION SELECT user_vertrag_strom.VertragsID, user_vertrag_strom.Sparte, user_vertrag_strom.Status 
			FROM user_vertrag_strom
			WHERE user_vertrag_strom.ID = ".$_SESSION['userID']." 
				UNION SELECT user_vertrag_tv.VertragsID, user_vertrag_tv.Sparte, user_vertrag_tv.Status
				FROM user_vertrag_tv
				WHERE user_vertrag_tv.ID = ".$_SESSION['userID']."
					UNION SELECT user_vertrag_mobilfunk.VertragsID, user_vertrag_mobilfunk.Sparte, user_vertrag_mobilfunk.Status
					FROM user_vertrag_mobilfunk
					WHERE user_vertrag_mobilfunk.ID = ".$_SESSION['userID']."
						UNION SELECT user_vertrag_internet.VertragsID, user_vertrag_internet.Sparte, user_vertrag_internet.Status
						FROM user_vertrag_internet
						WHERE user_vertrag_internet.ID = ".$_SESSION['userID']."
		ORDER BY Sparte");
	$vertraege->execute(array());

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge"> 
	<title>Vertragsübersicht</title>
	<?php include('./forms/include/meta.php'); ?>
</head>	
<body>
					<!-- Start - Profil vervollständigen: Meldung -->
<?php
	//userdaten abfragen
	$statement = $pdo->prepare("SELECT * FROM user WHERE ID = ?");
	$statement->execute(array($_SESSION['userID']));
	$user = $statement->fetch();
	$full = true;
	//schleifendurchläufe
	$runs = count($user)/2;				
	//geburtsdatum prüfen (grunsätzlich kein leeres feld)
	if($user['Geburtsdatum'] = 0000-00-00) {
		$full = false;
	} else {
		//schleife durchlaufen bis ein für die vertragsbearbeitung wichtiger datensatz fehlt
		for($a=0; $a<$runs; $a++) {
			//1,7,8(beraterid,kinder,mobiltelefon) sind keine obligatorischen Daten (DSGVO)
			if($a == 7 or $a == 8 or $a == 1) {
				continue;
			}
			if(empty($user[$a])) {
				$full = false;
				break;
			}
		}	
	}
	//wenn datensatz fehlt ($full = false), Meldung für den Nutzer ausgeben und ihn auf das Problem hinweisen
	if(!$full) {
		// Variable kann global von allen Formularen verwendet werden, spart staendige Abfragen an Datenbank
		$_SESSION['profil'] = 0;
?>
					
<?php
		} else {
		// Variable wird auf 1 gesetzt, d.h. alle noetigen persoenlichen Informationen sind angegeben
		$_SESSION['profil'] = 1;
		}
?>
<!-- Ende - Profil vervollständigen: Meldung -->
	<!-- TODO keine Verträge dann button hinzufügen für verträge!!!-->
	<?php
				// Anzeige Vertraege		
		$i=0;
		$money = 0.00;
		while ($vertrag = $vertraege->fetch()) {
			$i++;
			$statement = $pdo->prepare(
				"SELECT Vertragsende, Vertragsanfang, Anbieter, Kosten
				FROM vertrag_".$sparten[$vertrag['Sparte']]."
				WHERE ID = ".$vertrag['VertragsID']);
			$statement->execute(array());
			$v = $statement->fetch();
			$v[] = $vertrag['Sparte'];
			$v[] = $vertrag['Status'];
			$v[] = $vertrag['VertragsID'];
			//Array (Vertragsende, Vertragsanfang, Anbieter, Kosten, Sparte, Status, vertragsID)
			$vArray[] = $v;
								
			//Kosten werden mit jedem Schleifendurchlauf summiert
			$money = $money + $v['Kosten'];
			}
			?>

	<div id="button-close-info-vertrag-uebersicht">
		
	</div>
	<div id="info-vertrag-uebersicht">
			
	</div>
<?php
			echo "<div class='top-nav'>
			<div id='button' class='button'>
				<i class='fa fa-bars' aria-hidden='true'></i>
			</div>
			<div class='icon'>
				<a href='./vertragsUebersicht.php'><img id='vertragsengel-logo' src='img/vertragsengelkreis logo.png' alt='Vertragsengel logo'></a>
			</div>
			</div>
				<div id='nav' class='nav'>
					<div class='logo'>
						<a href='./vertragsUebersicht.php'><img id='vertragsengel-logo' src='img/vertragsengelkreis logo.png' alt='Vertragsengel logo'></a>
					</div>
					<div class='nav-element'>
							<a class='link' href='vertragsAuswahl.php'>Vertrag Auswahl<a>
					</div>
					<div class='nav-element'>
						<a class='link' href='vertragsUebersicht.php'>Vertrag Ubersicht</a>
					</div>
					<div id='show-profil' class='nav-element'>
						Profil<i id='caret' class='fa fa-fw fa-caret-down'></i>
					</div>
						<div id='nav-profil-element-2'>
							<div class='show-nav-profil-elements'>
								<div class='nav-element-p'>
														<a class='link' href='forms/pDaten.php'><p>Mein Profil</p></a>
								</div>
								<div class='nav-element-p'>
									<a class='link' href='forms/profil.php'><p>Alle Daten bearbaiten</p></a>
								</div>
								<div class='nav-element-p'>
									<a class='link' href='forms/vertragspartner.php'><p>Partner hinzufügen</p></a>
								</div>
							</div>
						</div>    
					<div id='show-einstellungen' class='nav-element'>
						Einstellungen<i id='caret1' class='fa fa-fw fa-caret-down'></i></Einstellungen<i>
					</div>
						<div id='nav-einstellungen-element-2'>
							<div class='show-nav-einstellungen-elements'>
								<div class='nav-element-p'>
									<a class='link' href='datenschutz.php'><p>Datenschutz</p></a>
								</div>
								<div class='nav-element-p'>
									<a class='link' href='agb.php'><p>AGB</p></a>
								</div>
								<div class='nav-element-p'>
									<a class='link' href='faq.php'><p>FAQ</p></a>
								</div>
							</div>
						</div>
					<div class='nav-element'>
						<a class='link' href='forms/logout.php'>Auslogen<a>
					</div>
				</div>
				<div id='main' class='main'>
					<div id='right-container-info'>
						<div class='right-container-info-top'>
							<div class='right-container-info-header'>
								<i id='info-header-close' class='far fa-window-close info-header-close'></i>
							</div>
							<div class='right-container-info-header-avatar'>
							</div>
							<div class='right-container-info-header-avatar-text'>
								Rene,<br> <i>Kundenbetreuung</i>
							</div>
						</div>
					</div>
						<div class='titel'>
							<span>
								Deine Verträge:  <!-- Anzeige im Header -->
							</span>
							<a href='./vertragsAuswahl.php'><div class='vertrage-hinzufugen-button'>
								Verträge hinzufügen
							</div></a>
						</div>
					
								<!-- Diagramm -->
					
						<!--<div class='row'>
							<div class='alert-danger'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<strong class='strong-red'>Vorsicht!</strong> Solange Dein Profil nicht vervollständigt ist, können wir kein Geld für dich sparen.<br> 
								<a href='forms/profil.php'><strong class='strong-red'>Klicke hier</strong></a> um deine Angaben zu vervollständigen.
							</div>
						</div> -->
						<!-- REALTIME CHART -->
						<div class='row-info-window'>
						<!--	<h2 class='alert-info'>Durch eine Haushaltsberatung kannst du bis zu 20% sparen</h2> -->
									<!-- hier funktion einbauen! -->
												
								<div class='row-center'>	
										<div class='row-center-1'>
											<div class='row-center-content-1'>
												<div class='avatar-container'>
												</div>
												<div class='avatar-info-container'>
													<p style='color: black'>Hallo,<br>was kann ich heute für dich tun?<p><br>- Rene, <i>Kundenbetreuung</i>
													<div id='kontakt-aufnehmen-button'>
														<p>Kontakt aufnehmen</p>
													</div>
												</div>
											</div>
										</div>
										<div class='two-row-center'>
											<div class='row-center-2'>
												<div class='row-center-content-2'>
													<div class='gesamtkosten'>
														 $money
													</div>
													<div class='gesamtkosten-text'>
														Gesamtkosten pro Monat
													</div>
												</div>
											</div>
											<div class='row-center-3'>
												<div class='row-center-content-3'>
													<div class='laufende-vertrage'>
														$i
													</div>
													<div class='laufende-vertrage-text'>
														Laufende Verträge
													</div>		
												</div>
											</div>
										</div>
									</div>	
								</div>
										<!-- Diagramm Ende -->";
			echo "<div class='vertrag-container'>
			<div class='alert-box-info'>
				<div class='alert-info'>
					Vertragsübersicht:
				</div>
				<a href='./vertragsAuswahl.php'><div class='alert-info-button'>
					<i class='far fa-plus-square'></i>
				</div></a>
			</div>";
		if(count($vArray) < 1) {
							?>
							<div>
								<p style="margin-bottom: 150px;" class="alert-danger">Keine Verträge angelegt!</p>
							</div>
							<?php
							} else {
								//array_multisort sortiert nach dem ersten Element im Array, in diesem Fall Vertragsende
								array_multisort($vArray);
								$laufzeit = 365; //fiktive Laufzeit zum Testen der Bar
								for($j=0; $j < count($vArray); $j++ ) {
									$dateDifference1 = date_diff(new DateTime($vArray[$j][1]),new DateTime($vArray[$j][0]));
									$b = intval($dateDifference1->format('%a'));
									$dateDifference2 = date_diff(new DateTime($vArray[$j][1]),new DateTime('today'));
									$c = intval($dateDifference2->format('%a'));
									$dateDifference = date_diff(new DateTime($vArray[$j][0]),new DateTime('today'));
									$a = intval($dateDifference->format('%a'));
									$time = $a/$laufzeit;
									
							?>
<!-- Einzelne Verträge werden solange angelegt bis die Schleife durchlaufen wurde -->
<!-- onclick="location.href='...'" verlinkt den gesamten div-container, der 2 GET-Variablen für details.php übergibt -->
<!-- v0 = Sparten (Int), v1 = VertragsID (INT) -->
					<div class="vertrag-main">
						<div class="container-for-rowlist">
							<div class="row-list" id="<?php echo $vArray[$j][6];?>">
								<div id="image-container">
									<img id="vertragImage" src='img/icon/uebersicht/<?php echo $sparten[$vArray[$j][4]]; ?>_weis.png' alt="VertragsIcon">
								</div>				
							<div class="rest-info-container">
							<script type="text/javascript">
									var buttonCloseInfoVertragUebersicht = document.getElementById("button-close-info-vertrag-uebersicht");
									var rowList = document.getElementById("<?php echo $vArray[$j][6];?>");
									var main = document.getElementById("main");
									rowList.addEventListener("click", function refreshData(e){
									var display = document.getElementById("info-vertrag-uebersicht");
										if (display.style.display == "none") {
											display.style.display = "block";
											main.style.right = "37%";
											buttonCloseInfoVertragUebersicht.style.display = "block";
										} else {
											display.style.display = "block";
											main.style.right = "37%";
											buttonCloseInfoVertragUebersicht.style.display = "block";
										}
									var xmlhttp = new XMLHttpRequest();
									xmlhttp.open("GET", "forms/details.php?v0=<?php echo $vArray[$j][4];?>&v1=<?php echo $vArray[$j][6];?>");
									xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
									xmlhttp.send();
									xmlhttp.onreadystatechange = function() {
										if (this.readyState === 4 && this.status === 200) {
										display.innerHTML = this.responseText;
										} else {
										display.innerHTML = "Loading...";
										};
									}
									});
							</script>
									<?php									
										// Abfrage ob der Vertrag bereits gekuendigt wurde (0/1 - ja/nein) 
										// wenn gekuendigt wird Progressbar mit Schriftzug gekuendigt ersetzt
										if($vArray[$j][4] !== 0) { 
										// Auswahl der Farbe der Progressbar via Switch-Case	
										$laufzeitMonate = $a / 30;
											switch ($laufzeitMonate) {
												//Vertrag läuft noch länger als 4,5 Monate -> grüne Farbe
												case $laufzeitMonate > 4.5 : ?>
														<progress id="progress" min="0" max="<?php echo $b ?>" value="<?php echo $b-$c; ?>"></progress>
														<p><?php echo round(100 - ((($b-$c)/$b)*100)) ?>% Complete<p>			
													<?php
													break;
												//Vertrag läuft noch länger als 3 Monate -> gelbe Farbe
												case $laufzeitMonate > 3 : ?>
														<progress id="progress" min="0" max="<?php echo $b ?>" value="<?php echo $b-$c; ?>"></progress>
														<p><?php echo round(100 - ((($b-$c)/$b)*100)) ?>% Complete</p>				
													<?php
													break;
												//Vertrag läuft nur 3 oder weniger Monate -> rote Farbe
												case $laufzeitMonate > 0 : ?>
														<progress id="progress" min="0" max="<?php echo $b ?>" value="<?php echo $b-$c; ?>"></progress>
														<p><?php echo round(100 - ((($b-$c)/$b)*100)) ?>% Complete</p>					
													<?php
													break;
											}
									?>
								
							<!-- 
							Über der Vertragsgesellschaft soll der Beitrag (Monatlich angegeben) stehen
							-->	
								
									<?php } else { 
										echo "<p style='color: red'>gekündigt</p>"; 
									} 
									?>
								<div class="row">
									<?php
										//Verträge automatisch verlängern, wenn Zeit überschritten
										// 	-> Infos dazu müssen aus der AnbieterDatenbank (d.h. Herr Schirner) kommen 
										if ($dateDifference->format('%a') === "1") {
											echo "Vertragsverlängerung in: ";
										} else {
											echo "Vertragsverlängerung in: ";
										}
										echo $dateDifference->format('%a')." Tagen";
									?>
								</div>
							</div>	
						</div>
					</div>
							<?php
								}}
								

// Anzeige Krankenkassenvertraege 

								// SQL Select - Vertragsids von Krankenkassenvertregen des Nutzers auslesen
								$statement = $pdo->prepare("SELECT VertragsID FROM user_vertrag_krankenkasse WHERE ID =".$_SESSION['userID']);
								$statement->execute(array()); 
								$arrayVId = [];
								while ($vID = $statement->fetch()) {
									// array anlegen, dass alle Vertragsids enthaelt
									$arrayVId[] = $vID[0];
								}
								// SQL Select - Krankenkassenvertragsdetails
								$statement = $pdo->prepare("SELECT * FROM vertrag_krankenkasse WHERE ID = ?");
								// fuer jedes Element aus $arrayVId wird ein Vertrag in der Uebersicht angelegt
								for($i=0; $i<count($arrayVId); $i++) {
									$statement->execute(array($arrayVId[$i]));
									while ($details = $statement->fetch()) {
								?>
								<!-- v0 entspricht Sparte, v1 entspricht VertragsID -->
								<div class="metric" onclick="location.href='forms/details.php?v0=6&v1=<?php echo $arrayVId[$i];?>';" style="cursor:pointer;">
									<img src='/img/icon/uebersicht/<?php echo $sparten[6]; ?>_weis.png' alt="VertragsIcon" class="img-responsive logo" height="50" width="50">
									<span class="name"><p><?php echo $details['Anbieter'];?></p></span>
								</div>
								<?php
								}}								
							?>
						<!--End panel-body  -->
						</div>
						<!-- END OVERVIEW -->
					</div>
				<!-- END container-fluid -->
				</div>
			<!-- END MAIN CONTENT -->
			</div>
		</div>
	<!-- END WRAPPER -->
	</div>
	</div>
	<!-- END MAIN -->
	<!-- Javascript -->
	<script src="./js/vertragsUebersicht.js"></script>
	<!--<script src="./vendor/jquery/jquery.min.js"></script>
	<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="./vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="./vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="./vendor/chartist/js/chartist.min.js"></script>-->	
	<!-- footer -->
</body>
</html>
