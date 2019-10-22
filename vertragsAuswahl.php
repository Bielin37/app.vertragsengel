<?php 
    include 'db/database.php'; 
?>
<!doctype html>
<html lang="en">

<head>
<!-- Titel & MetaDaten (seitenspezifisch) -->
	<title>Vertragsauswahl</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="vendor/linearicons/style.css">
	
	<!-- Eigene css -->
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <script src="js/script.js"></script>
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon.png">
	<link rel="stylesheet" href="css/auswahl_ueber.css">  <!--  Hier kann auf den style der index zugegriffen werden -->
	<style>
		#wrapper .main {
  			padding-top: 50px; 
  		}
	</style>
</head>
<body>	
	<div>
		<span>
			<h1 class="alert alert-success" style="width: 100vw;">Vertragsauswahl</h1>  <!-- Anzeige im Header -->
		</span>
	</div>
	<div id="wrapper" style="display: flex;" >
	<div class="navbar-collapse navbar-ex1-collapse" style="min-width: 20%; z-index: 1; padding-right: 20px;">
					<ul class="nav navbar-nav side-nav" style="display: flex; flex-direction: column; ">
						<li>
							<a href="vertragsAuswahl.php"><i class="glyphicon glyphicon-th"></i><span class="text">Vertrag Auswahl</span><i class="fa fa-fw fa-caret-down"></i></a>
						</li>                    
						<li>
							<a href="vertragsUebersicht.php"><i class="glyphicon glyphicon-list-alt"></i><span class="text">Vertrag Ubersicht</span><i class="fa fa-fw fa-caret-down"></i></a>
						</li>
						<li>
							<a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="glyphicon glyphicon-user"></i><span class="text">Profil</span><i class="fa fa-fw fa-caret-down"></i></a>
							<ul id="demo1" class="collapse">
								<li class="nav-item"><a href="forms/pDaten.php"><i class="glyphicon glyphicon-pushpin"></i><span>Mein Profil</span></a></li>
								<li class="nav-item"><a href="forms/profil.php"><i class="glyphicon glyphicon-pushpin"></i> <span>Alle Daten bearbaiten</span></a></li>
								<li class="nav-item"><a href="forms/vertragspartner.php"><i class="glyphicon glyphicon-pushpin"></i> <span>Partner hinzufügen</span></a></li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="glyphicon glyphicon-cog"></i><span class="text">Einstellungen</span><i class="fa fa-fw fa-caret-down"></i></a>
							<ul id="demo" class="collapse">
								<li class="nav-item"><a href="datenschutz.php"><i class="glyphicon glyphicon-info-sign"></i> <span>Datenschutz</span></a></li>
								<li class="nav-item"><a href="agb.php"><i class="glyphicon glyphicon-info-sign"></i> <span>AGB</span></a></li>
								<li class="nav-item"><a href="faq.php"><i class="glyphicon glyphicon-info-sign"></i> <span>FAQ</span></a></li>
								<li class="nav-item"><a href="forms/logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
					</ul>
			</div>
<!-- Start - Profil vervollständigen: Meldung -->
		<?php
			//userdaten abfragen
			$statement = $pdo->prepare("SELECT * FROM user WHERE ID = ?");
			$statement->execute(array($_SESSION['userID']));
			$user = $statement->fetch();
			$full = true;
			//schleifendurchläufe, array $user ist doppelt so lang wie die menge der spalten der tabelle
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
		?>
		<div class="main" style="display:flex; flex-direction: column; width: 60vw;">
			<div class="main-content" style="display:flex; flex-direction: column;">
				<div class="row">
					<div class="container-fluid" style="display: flex; justify-content: center;">
						<div class="alert alert-danger alert-dismissible" style="width: 40vw; margin-bottom: 60px; justify-content: center;">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Vorsicht!</strong> Solange Dein Profil nicht vervollständigt ist, können wir kein Geld für dich sparen.<br> 
							<a href="forms/profil.php"><strong>Klicke hier</strong></a> um deine Angaben zu vervollständigen.
						</div> 
					</div>
				</div>	

		<?php
			//alle nötigen persönlichen Daten sind vorhanden
			} else {
		?>

		<div class="main">
			<div class="main-content">
				<div class="container-fluid">
		<?php
			//fagen, die zum heranführen an andere versicherungs-, finanzdienstleistungen dienen, näheres in der entsprechenden datei 
			include("forms/include/fragen.php");
			} 
		?>
<!-- Ende - Profil vervollständigen: Meldung -->

<!-- Vertragssparten -->
<!-- Haushaltsverträge -->
			<div id="Fragen"></div>
				<div class="row" id="haushalt" style="flex: none;">
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-heading">
								<h2>Haushalt</h2>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								</div>
							</div>
							<div class="panel-body">
								<table>
									<tr>
										<td style="width:2%"><a href="forms/1Strom.php" class="collapsed"><img src="img/icon/1haushalt/strom/strom_gruen.png" alt="" height="50" width="50">
										<p>Strom </p></a></td>
										
										<td style="width:2%"><a href="forms/2Gas.php" class="collapsed"><img src="img/icon/1haushalt/gas/gas_gruen.png" alt="" height="50" width="50">
										<p>Gas </p></a></td>
									</tr>
									<tr>
									   <td style="width:2%"><a href="forms/3Mobilfunk.php" class="collapsed"><img src="img/icon/1haushalt/mobilfunk/mobilfunk_lila.png" alt=""  height="50" width="50">
									   <p>Mobilfunk </p></a></td>
											
									   <td style="width:2%"><a href="forms/5Internet.php" class="collapsed"><img src="img/icon/1haushalt/internet/internet_lila.png" alt=""  height="50" width="50">
										<p>Internet</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="forms/4TV.php" class="collapsed"><img src="img/icon/1haushalt/tv/tv_rot.png" alt=""  height="50" width="50">
										<p>Fernsehen</p></a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			
<!-- Gesundheitsvorsorge -->
				<div class="row" id="gesundheit" >
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-heading">
								<h2>Gesundheitsvorsorge</h2>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								</div>
							</div>
							<div class="panel-body">
								<table>
									<tr>
										<td style="width:2%"><a href="forms/6Krankenkasse.php" class="collapsed"><img src="img/icon/2gesundheitsvorsorge/krankenkasse/krankenkasse_gelb.png" alt="" height="50" width="50">
											<p>Krankenkasse</p></a></td>
										<td style="width:2%"><a href="Gas.html" class="collapsed"><img src="img/icon/2gesundheitsvorsorge/pflegeV/pflege_gelb.png" alt="" height="50" width="50">
											<p>Pflegeversicherung</p></a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>


		<?php
			//Array $interesse mit Werten aus user_interessen fuellen
			$statememt = $pdo->prepare('SELECT * FROM user_interessen WHERE ID = ?');
			$statement->execute(array($_SESSION['userID']));
			$interesse = $statement->fetch();
			//wenn Spalte Vorsorge auf 1, dann nächsten <div class="row" .... > anzeigen
			if($interesse['Vorsorge'] == 1) {
		?>
<!-- selbstbestimmtes Leben -->
				<div class="row" id="selbstLeben">
					<div class="col-md-4">
							<!-- PANEL WITH FOOTER -->
						<div class="panel">
							<div class="panel-heading">
									<h2>Selbstbestimmtes Leben</h2>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									</div>
							</div>
							<div class="panel-body">
								<table>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="img/icon/3selbstbestimmtesLeben/vorsorgeVM/vorsorgeVM_gelb.png" alt="Vertragsengel Logo" height="50" width="50">
												<p>VorsorgevollmachtV</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="img/icon/3selbstbestimmtesLeben/patientenVerfuegung/patientenV_gelb.png" alt="Vertragsengel Logo" height="50" width="50">
												<p>Patientenverfügung</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="img/icon/3selbstbestimmtesLeben/betreungsVM/006-heart.png" alt="Vertragsengel Logo" height="50" width="50">
												<p>Betreuungsvollmacht</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="img/icon/3selbstbestimmtesLeben/testament/testament_gelb.png" alt="Vertragsengel Logo" height="50" width="50">
												<p>Testament</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="img/icon/3selbstbestimmtesLeben/sterbegeld/sterbegeld_gelb.png" alt="Vertragsengel Logo" height="50" width="50">
												<p>Sterbegeld</p></a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

<!-- Altersvorsorge -->			<!-- momentan:  style="display:none"-->
<!-- icon src="" muss noch angepasst werden -->
				<div class="row" id="alter" style="display:none">
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-heading">
								<h2>Altersvorsorge</h2>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								</div>
							</div>
							<div class="panel-body">
								<table>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Lebensversicherung</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Rentenversicherung</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Riester-Rente</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Rürup-Rente</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Betriebliche Altersvorsorge</p></a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>


<!-- Kraftfahrzeug -->		<!-- momentan:  style="display:none"-->
<!-- icon src="" muss noch angepasst werden -->
				<div class="row" id="kfz" style="display:none" >
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-heading">
								<h2>Kraftfahrzeug</h2>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								</div>
							</div>
							<div class="panel-body">
								<table>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Kfz-Haftpflicht</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Vollkasko/Teilkasko</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Automobilclub/Mobilität</p></a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
		
<!-- Absicherung der Arbeitskraft -->			<!-- momentan:  style="display:none"-->
<!-- icon src="" muss noch angepasst werden -->
				<div class="row" id="arbeit" style="display:none" >
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-heading">
								<h2>Absicherung der Arbeitskraft</h2>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								</div>
							</div>
							<div class="panel-body">
								<table>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Berufsunfähigkeit</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Grundfähigkeit</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Unfallversicherung</p></a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>


<!-- Haus und Wohnung -->		<!-- momentan:  style="display:none"-->
<!-- icon src="" muss noch angepasst werden -->
				<div class="row" id="hausUndWohnung" style="display:none" >
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-heading">
								<h2>Haus und Wohnung</h2>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								</div>
							</div>
							<div class="panel-body">
								<table>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Haftpflicht</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Hausrat</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Glasversicherung</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Gebäudeversicherung</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Umweltschutz</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Rechtsschutz</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Bauherrenhaftpflicht</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Grundbesitzhaftpflicht</p></a></td>
									</tr><tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Berufs-/Diensthaftpflicht</p></a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>


<!-- Hobby/Tiere/Reisen -->				<!-- momentan:  style="display:none"-->	
<!-- icon src="" muss noch angepasst werden -->
				<div class="row" id="hobby" style="display:none" >
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-heading">
								<h2>Hobby/Tiere/Reisen</h2>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								</div>
							</div>
							<div class="panel-body">
								<table>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Kleingarten</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Fluggeräte</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Tierhaftpflicht</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Tierkrankenversicherung</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Reiserücktrittversicherung</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Reisegepäckversicherung</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Bootsversicherung</p></a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>										

<!-- Geld -->			<!-- momentan:  style="display:none"-->					
<!-- icon src="" muss noch angepasst werden -->
				<div class="row" id="geld" style="display:none" >
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-heading">
								<h2>Geld</h2>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								</div>
							</div>
							<div class="panel-body">
								<table>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Girokonto</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Bausparen</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Tagesgeldkonto</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Sparkonto</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Depot</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Festgeldkonto</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Fondsparen</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Edelmetalle/Kryptowährungen</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Strom.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Baufinanzierung</p></a></td>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="50" width="50">
											<p>Privat-Kredit</p></a></td>
									</tr>
									<tr>
										<td style="width:2%"><a href="Gas.html" data-toggle="collapse" class="collapsed"><img src="" alt="Vertragsengel Logo" height="40" width="40">
											<p>Kfz-Kredit</p></a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- Javascript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="js/klorofil-common.js"></script>
</body>
</html>
