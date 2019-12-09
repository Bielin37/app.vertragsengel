<?php 
    include('db/database.php'); 
?>
<html lang="en">
<head>  
	<title>Vertragsauswahl</title>
	<?php include('./forms/include/meta.php'); ?>
</head>
<body>
    <div class="container">
		<div id="vertragspanel" class="vertragspanel">
		
			<?php 
				include('forms/4TV.php');
			?>

		</div>
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
				     	<a class="link" href="vertragsAuswahl.php">Vertrag Auswahl<a>
                    </div>
                    <div class="nav-element">
						<a class="link" href="vertragsUebersicht.php">Vertrag Ubersicht</a>
                    </div>
                    <div id="show-profil" class="nav-element">
                        Profil<i id="caret" class="fa fa-fw fa-caret-down"></i>
                    </div>
                        <div id="nav-profil-element-2">
                            <div class="show-nav-profil-elements">
                                <div class="nav-element-p">
									<a class="link" href="forms/pDaten.php"><p>Mein Profil</p></a>
                                </div>
                                <div class="nav-element-p">
									<a class="link" href="forms/profil.php"><p>Alle Daten bearbaiten</p></a>
                                </div>
                                <div class="nav-element-p">
									<a class="link" href="forms/vertragspartner.php"><p>Partner hinzufügen</p></a>
                                </div>
                            </div>
                        </div>    
                    <div id="show-einstellungen" class="nav-element">
                        Einstellungen<i id="caret1" class="fa fa-fw fa-caret-down"></i>
                    </div>
                        <div id="nav-einstellungen-element-2">
                            <div class="show-nav-einstellungen-elements">
                                <div class="nav-element-p">
									<a class="link" href="datenschutz.php"><p>Datenschutz</p></a>
                                </div>
                                <div class="nav-element-p">
									<a class="link" href="agb.php"><p>AGB</p></a>
                                </div>
                                <div class="nav-element-p">
									<a class="link" href="faq.php"><p>FAQ</p></a>
                                </div>
                            </div>
                        </div>
                    <div class="nav-element">
						<a class="link" href="forms/logout.php">Auslogen<a>
                    </div>
                </div>
            </div>
                <div id="main" class="main">
					<div class="right-container-info">

					</div>
                    <div class="titel">
                        <span>
                            <h2>Vertrag Auswahl:</h2>  <!-- Anzeige im Header -->
                        </span>
                    </div>
                   
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
							<strong class="strong-red">Vorsicht!</strong> Solange Dein Profil nicht vervollständigt ist, können wir kein Geld für dich sparen.
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
		<div class="auswahl-panel">
            <div class="row">
				<div id="titel2" class="titel2">
                    <span>
                        <h2> Haushalt:<i id="caret2" class="fa fa-fw fa-caret-down"></i></h2>
                    </span>
                </div>
					<div id="auswahl-panel-1" class="auswahl-panel-1">
						<div id="auswahl-icon" class="auswahl-icon">
							<div class="background-icon">
								<i id="auswahl-icon-fernsehen" class="collapsed fas fa-tv"></i>
							</div>
							<p class="auswahl-text">Fernsehen</p>
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
								<a href="forms/1Strom.php" class="collapsed"><i class="fas fa-charging-station"></i></a>
							</div>
							<p class="auswahl-text">Strom</p>
						</div>
					</div>
			</div>
			<!-- Gesundheitsvorsorge -->
			<div class="row">
				<div id="titel3" class="titel3">
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
		<?php
			//Array $interesse mit Werten aus user_interessen fuellen
			$statememt = $pdo->prepare("SELECT * FROM user_interessen WHERE ID = ?");
			$statement->execute(array($_SESSION['userID']));
			$interesse = $statement->fetch();
			//wenn Spalte Vorsorge auf 1, dann nächsten <div class="row" .... > anzeigen
			if($interesse['Vorsorge'] == 1) {
		?>
			<!-- selbstbestimmtes Leben -->
			<div class="row">
				<div id="titel4" class="titel4">
                    <span>
                        <h2>Selbstbestimmtes Leben: <i id="caret4" class="fa fa-fw fa-caret-down"></i></h2>
                    </span>
                </div>
					<div id="auswahl-panel-3" class="auswahl-panel-3">
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="Gas.html" class="collapsed"><i class="fas fa-pen-fancy"></i></a>
							</div>
							<p class="auswahl-text">Vorsorgevollmacht</p>
						</div>
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="Gas.html" class="collapsed"><i class="fas fa-user-injured"></i></a>							
							</div>
							<p class="auswahl-text">Patientenverfügung</p>	
						</div>
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="Gas.html" class="collapsed"><i class="fas fa-hand-holding-heart"></i></a>
							</div>
							<p class="auswahl-text">Betreuungsvollmacht</p>
						</div>
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="Gas.html" class="collapsed"><i class="fas fa-scroll"></i></a>
							</div>
							<p class="auswahl-text">Testament</p>	
						</div>
						<div class="auswahl-icon">
							<div class="background-icon">
								<a href="Gas.html" class="collapsed"><i class="fas fa-hand-holding-usd"></i></i></a>
							</div>
							<p class="auswahl-text">Sterbegeld</p>
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
</div>
<!-- Javascript -->
    <script src="js/vertragsAuswahl.js"></script>
</body>
</html>