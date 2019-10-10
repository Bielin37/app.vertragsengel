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
<html lang="de">
<head>  
	<title>Vertragsübersicht</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="./vendor/linearicons/style.css">
	<link rel="stylesheet" href="./vendor/chartist/css/chartist-custom.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="./css/main.css">
	<link rel="stylesheet" href="./css/style.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="./img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="./img/favicon.png">
	<link rel="stylesheet" href="css/auswahl_ueber.css">  <!--  Hier kann auf den style der vertragsAuswahl und VertragsUebersicht zugegriffen werden -->

	<style>
		#wrapper .main {
  			padding-top: 50px; 
  		}
	</style>
</head>
	
<body>	
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">		<!-- navbar-fixed-top-->
			<span>
				<h1>Deine Verträge</h1>  <!-- Anzeige im Header -->
			</span>
		</nav>
		<div class="main">
			<div class="main-content">
				<div class="container-fluid">

					<!-- Diagramm -->

					<div class="col-md-4-2">
						<!-- REALTIME CHART -->
						<div class="panel panel-headline">
							<div class="panel-heading">
								<h2>Durch eine Haushaltsberatung kannst du bis zu 20% sparen</h2>
								<!-- hier funktion einbauen! -->
							</div>
							</br></br>
							<div class="panel-body">
								<div id="system-load" class="easy-pie-chart" data-percent="">
									<span class="percent"></span>
								</div>
								<ul class="list-unstyled list-justify">
									<li>Im Moment hast du <label id="anzahlvertraege"> Verträge
									<li>und zahlst dafür <label id="gesamtkosten">.
								</ul>	
							</div>
						</div>
					</div>	

					<!-- Diagramm Ende -->
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
			
		 			<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Vorsicht!</strong> Solange Dein Profil nicht vervollständigt ist, können wir kein Geld für dich sparen.<br> 
						<a href="forms/profil.php"><strong>Klicke hier</strong></a> um deine Angaben zu vervollständigen.
					</div> 
					
					<?php
						 } else {
						 	// Variable wird auf 1 gesetzt, d.h. alle noetigen persoenlichen Informationen sind angegeben
						 	$_SESSION['profil'] = 1;
						 }
					?>
					<!-- Ende - Profil vervollständigen: Meldung -->

					<div class="col-md-4-3">
						<div class="panel panel-body">
							<div class="panel-heading">
								<h2>Vertragsübersicht</h2>
							</div>
						<!-- TODO keine Verträge dann button hinzufügen für verträge!!!-->
						<?php
// Anzeige Vertraege
							$i=0;
							$money = 0.00;
							while ($vertrag = $vertraege->fetch()) {
								$i++;
								$statement = $pdo->prepare(
									"SELECT Vertragsende, Anbieter, Kosten
									FROM vertrag_".$sparten[$vertrag['Sparte']]."
									WHERE ID = ".$vertrag['VertragsID']);
								$statement->execute(array());
								$v = $statement->fetch();
								$v[] = $vertrag['Sparte'];
								$v[] = $vertrag['Status'];
								$v[] = $vertrag['VertragsID'];
								//Array (Vertragsende, Anbieter, Kosten, Sparte, Status, vertragsID)
								$vArray[] = $v;
								
								//Kosten werden mit jedem Schleifendurchlauf summiert
								$money = $money + $v['Kosten'];
							}	

							if(count($vArray)<1) {
							?>
								<p>Keine Verträge angelegt!</p>
							</div>
							<?php
							} else {
								//array_multisort sortiert nach dem ersten Element im Array, in diesem Fall Vertragsende
								array_multisort($vArray);
								$laufzeit = 2*365; //fiktive Laufzeit zum Testen der Bar
								for($j=0; $j < count($vArray); $j++ ) {
									$dateDifference = date_diff(new DateTime($vArray[$j][0]),new DateTime('today'));
									$a = intval($dateDifference->format('%a'));
									$time = $a/$laufzeit;
									
							?>
<!-- Einzelne Verträge werden solange angelegt bis die Schleife durchlaufen wurde -->
<!-- onclick="location.href='...'" verlinkt den gesamten div-container, der 2 GET-Variablen für details.php übergibt -->
<!-- v0 = Sparten (Int), v1 = VertragsID (INT) -->
							<div class="metric" onclick="location.href='forms/details.php?v0=<?php echo $vArray[$j][3];?>&v1=<?php echo $vArray[$j][5];?>';" style="cursor:pointer;">
								<img src='/img/icon/uebersicht/<?php echo $sparten[$vArray[$j][3]]; ?>_weis.png' alt="VertragsIcon" class="img-responsive logo" height="50" width="50">
								
								<span class="name"><p><?php echo $vArray[$j][1];?></p></span>
									
									<?php									
										// Abfrage ob der Vertrag bereits gekuendigt wurde (0/1 - ja/nein) 
										// wenn gekuendigt wird Progressbar mit Schriftzug gekuendigt ersetzt
										if($vArray[$j][4] !== 0) { 
										// Auswahl der Farbe der Progressbar via Switch-Case	
										$laufzeitMonate = $a / 30;
											switch ($laufzeitMonate) {
												//Vertrag läuft noch länger als 4,5 Monate -> grüne Farbe
												case $laufzeitMonate > 4.5 : ?>
													<div class="progress progress-xs">
														<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $time;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $time*100;?>%">
															<span class="sr-only"><?php echo $time*100;?>% Complete</span>
														</div>
													</div>					
													<?php
													break;
												//Vertrag läuft noch länger als 3 Monate -> gelbe Farbe
												case $laufzeitMonate > 3 : ?>
													<div class="progress progress-xs">
														<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $time;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $time*100;?>%">
															<span class="sr-only"><?php echo $time*100;?>% Complete</span>
														</div>
													</div>					
													<?php
													break;
												//Vertrag läuft nur 3 oder weniger Monate -> rote Farbe
												case $laufzeitMonate > 0 : ?>
													<div class="progress progress-xs">
														<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $time;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $time*100;?>%">
															<span class="sr-only"><?php echo $time*100;?>% Complete</span>
														</div>
													</div>					
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
								<span>
									<?php
										//Verträge automatisch verlängern, wenn Zeit überschritten
										// 	-> Infos dazu müssen aus der AnbieterDatenbank (d.h. Herr Schirner) kommen 
										if ($dateDifference->format('%a') === "1") {
											echo "<p>Vertragsverlängerung in: ";
										} else {
											echo "<p>Vertragsverlängerung in: ";
										}
										echo $dateDifference->format('%a')." Tagen</p>";
									?>
								</span>
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
	<!-- END MAIN -->
	<!-- Javascript -->
	<script src="./vendor/jquery/jquery.min.js"></script>
	<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="./vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="./vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="./vendor/chartist/js/chartist.min.js"></script>
	<script src="./js/klorofil-common.js"></script>

	<script>
		//JQuery 
		$(function() {
			var data, options;
			// chart
			var sysLoad = $('#system-load').easyPieChart({
				size: 130,
				barColor: function(percent) {
					return "rgb(" + Math.round(200 * (1.1 - percent / 100)) + ", " + Math.round(200 * percent / 100) + ", 0)";
				},
				trackColor: 'rgba(245, 245, 245, 0.8)',
				scaleColor: false,
				lineWidth: 5,
				lineCap: "square",
				animate: 800
			});
			sysLoad.data('easyPieChart').update(<?php echo $i*5;?>);
			sysLoad.find('.percent').text(<?php echo $i*5;?>);

			$("label[id='anzahlvertraege']").text(<?php echo $i;?>+" Verträge");
			$("label[id='gesamtkosten']").text(<?php echo $money;?>+" €/Monat");
		});

	</script>

	<!-- footer -->
	<?php include('forms/include/footer2.php'); ?>

</body>
</html>
