<?php 
    include 'db/database.php'; 
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vertragsauswahl</title>

    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
    <link rel="stylesheet" href="index1.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">
	<link rel="stylesheet" type="text/css" href="fonts/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/fontawesome.css">
	<link rel="stylesheet" type="text/css" href="fonts/all.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/all.css">
</head>
<body>
    <div class="container">
        <div class="top-nav">
            <div id="button" class="button">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <div class="icon">
                <img id="vertragsengel-logo" src="img/vertragsengelkreis logo.png" alt="Vertragsengel logo">
            </div>
        </div>
            <div id="nav1">
                <div id="nav" class="nav">
                    <div class="logo">
                        <img id="vertragsengel-logo" src="img/vertragsengelkreis logo.png" alt="Vertragsengel logo">
                    </div>
                    <div class="nav-element">
				     	<a class="link" href="vertragsAuswahl.php"><h4>Vertrag Auswahl</h4><a>
                    </div>
                    <div class="nav-element">
						<a class="link" href="vertragsUebersicht.php"><h4>Vertrag Ubersicht</h4></a>
                    </div>
                    <div id="show-profil" class="nav-element">
                        <h4>Profil<i id="caret" class="fa fa-fw fa-caret-down"></i></h4>
                    </div>
                        <div id="nav-profil-element-2">
                            <div class="show-nav-profil-elements">
                                <div class="nav-element">
									<a class="link" href="forms/pDaten.php"><p>Mein Profil</p></a>
                                </div>
                                <div class="nav-element">
									<a class="link" href="forms/profil.php"><p>Alle Daten bearbaiten</p></a>
                                </div>
                                <div class="nav-element">
									<a class="link" href="forms/vertragspartner.php"><p>Partner hinzufügen</p></a>
                                </div>
                            </div>
                        </div>    
                    <div id="show-einstellungen" class="nav-element">
                        <h4>Einstellungen<i id="caret1" class="fa fa-fw fa-caret-down"></i></h4>
                    </div>
                        <div id="nav-einstellungen-element-2">
                            <div class="show-nav-einstellungen-elements">
                                <div class="nav-element">
									<a class="link" href="datenschutz.php"><p>Datenschutz</p></a>
                                </div>
                                <div class="nav-element">
									<a class="link" href="agb.php"><p>AGB</p></a>
                                </div>
                                <div class="nav-element">
									<a class="link" href="faq.php"><p>FAQ</p></a>
                                </div>
                            </div>
                        </div>
                    <div class="nav-element">
						<a class="link" href="forms/logout.php"><h4>Logout</h4><a>
                    </div>
                </div>
            </div>
                <div class="main">
                        <div class="titel">
                            <span>
                                <h2>Vertrag Auswahl:</h2>  <!-- Anzeige im Header -->
                            </span>
                        </div>
            <div class="main1">        
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
					<div class="row">
					    <div class="alert-danger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong class="strong-red">Vorsicht!</strong> Solange Dein Profil nicht vervollständigt ist, können wir kein Geld für dich sparen.<br> 
							<a href="forms/profil.php"><strong class="strong-red">Klicke hier</strong></a> um deine Angaben zu vervollständigen.
                        </div>
                    </div> 
    <?php
			//alle nötigen persönlichen Daten sind vorhanden
			} else {
    ?>
    <?php
			//fagen, die zum heranführen an andere versicherungs-, finanzdienstleistungen dienen, näheres in der entsprechenden datei 
			include("forms/include/fragen.php");
			} 
	?>
	            <!-- Ende - Profil vervollständigen: Meldung -->
						<!-- Vertragssparten -->
						<!-- Haushaltsverträge -->
            <div class="row">
				<div id="titel1" class="titel1">
                    <span>
                        <h2> Haushalt: <i id="caret2" class="fa fa-fw fa-caret-down"></i></h2>
                    </span>
                </div>
					<div id="auswahl-panel-1" class="auswahl-panel-1">
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="forms/4TV.php" class="collapsed"><i class="fas fa-charging-station"></i></a>
							</div>
							<p class="auswahl-text">Strom</p>
						</div>
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="forms/2Gas.php" class="collapsed"><i class="fas fa-burn"></i></a>
							</div>
							<p class="auswahl-text">Gas</p>	
						</div>
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="forms/3Mobilfunk.php" class="collapsed"><i class="fas fa-mobile-alt"></i></a>
							</div>
							<p class="auswahl-text">Mobilfunk</p>
						</div>
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="forms/5Internet.php" class="collapsed"><i class="fas fa-wifi"></i></a>
							</div>
							<p class="auswahl-text">Internet</p>	
						</div>
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="forms/4TV.php" class="collapsed"><i class="fas fa-tv"></i></a>
							</div>
							<p class="auswahl-text">Fernsehen</p>
						</div>
					</div>
			</div>
			<div class="row">
				<div id="titel2" class="titel2">
                    <span>
                        <h2>Gesundheitsvorsorge:<i id="caret3" class="fa fa-fw fa-caret-down"></i></h2>
                    </span>
                </div>
					<div id="auswahl-panel-2" class="auswahl-panel-2">
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="forms/6Krankenkasse.php" class="collapsed"><i class="fas fa-hospital"></i></a>
							</div>
							<p class="auswahl-text">Krankenkasse</p>
						</div>
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="Gas.html" class="collapsed"><i class="fas fa-file-medical-alt"></i></a>
							</div>
							<p class="auswahl-text">Pflegeversicherung</p>	
						</div>
					</div>
            </div>
            
			
<!-- Gesundheitsvorsorge -->
			<!--	<div class="row" id="gesundheit" >
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
		<!--		<div class="row" id="selbstLeben">
					<div class="col-md-4">
							<!-- PANEL WITH FOOTER -->
				<!--		<div class="panel">
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
</div>
<!-- Javascript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="js/klorofil-common.js"></script>
    <script src="index1.js"></script>
</body>
</html>