<?php
	include('../db/database.php');
	include('include/logged.php');
?>
<!doctype html>
<html lang="en">

<head>
	<title>Strom</title>   <!-- Title wird nicht ausgelagert -->  
	
	<?php include('include/meta.php'); ?>
	
<style>
		/****************************************************
		* Seitenspezifische CSS Für die Farben
		****************************************************/	
		@font-face { font-family: 'meine-schrift';
				 src: url('../fonts/Raleway-Medium.ttf') format('truetype'); }
				
		h1{
			font-size: 		16px;
			font-family:	meine-schrift;
		}
		
		h2{
			font-size: 		12px;
			font-family: 	meine-schrift;
			color: 			#8fbc26;
		}
		
		body{
			font-family: 	  meine-schrift;
			background-color: white;
			font-size: 		  12px;
			color: 			  #383838;
		}
		
		#notiz{
			font-size: 		12px;
		}
		

			h4{
				font-size: 14px;
				color: : #8fbc26;
				float: left;
				margin-left: 2%;
				margin-bottom: 1%;
			}
			h5{
				font-size: 14px;
				color: : #8fbc26;
				float: left;
				margin-left: 7%;
				margin-bottom: 2%;
			}
			
			.btn{  
				  background: white;
				  border: 1px solid #8fbc26;
				  color: #8fbc26;
				}

			.btn:hover {
				  background: #383838;
				  border: 1px solid white;
				  color: #c0c0c0;
				}
			.switch{
				margin-left: 8%;
			}
			
			#vertrag{
				margin-left: 8%;
			}
</style>

</head>


<!-- javascript sorgt dafuer, dass die Engel beim Laden von body angezeigt werden -->
<!-- notwendig, da die via engel.php geladenen Engel noch keine Angabe zum Ort der Bilddatei enthalten -->
<body onload="engelPicture('strom')">
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div><h1>Strom</h1></div>
		</nav>
		<!-- END NAVBAR -->
		
		<?php
			// Abfrage der Variable $_SESSION['profil'] und festzustellen, ob alle notwendigen persoenlichen Daten vorhanden sind
			// 1/0 = ja/nein
			if($_SESSION['profil'] == 0) {

			?>	
			
		<div class="col-md-2">
			<div class="panel">
				<div class="panel-heading">
					<div class="right">
						<button type="button" id="removeTop" class="btn-remove"><i class="lnr lnr-cross"></i></button>
					</div>
				</div>
				<div class="panel-body">
					<p>Zum Ausfüllen der Formulare musst du dein Profil vervollständigen.</p>
				</div>
			</div>
		</div>
			
		<?php
			} 
		?>
<!-- MAIN CONTENT -->
		<div class="main-content">
			<form name="formular" id="formular" method="post" action="../db/sendRequest.php"enctype="multipart/form-data" >
				
		<div class="col-md-3">
			<div class="panel panel-headline">
				<div class="panel-body">
					<div class="felder">
						<label id="cameraLabel" for="fileInput0"><img src="http://app.vertragsengel.de/img/photo-camera.png" /></label>
					</div>  
						<!-- inputfeld fuer Bildupload, javascript savePart() speichert die einzelnen aufeinanderfolgenden Eingaben -->
						<input type="file" id="fileInput0" onchange="savePart()" name="fileInput[]" multiple size="50" accept=".png, .jpg, jpeg, .pdf" style="display:none;" />
							<p id="anzahlFiles">Keine ausgewählt</p>
								
							<div class="felder"> 
								<h4>Vertragspartner</h4>
							</div>
								<!-- $type wird festgelegt und dann durchgereicht um die Rueckkehr zum Formular zu ermoeglichen, wenn ein neue Partner angelegt wird  ->vertragspartner.php->1Strom.php -->
								<?php $type = '1Strom'; include('./include/vpinclude.php'); ?>
								</br></br></br>
							<div class="felder">
								<h4>Ihr derzeitger Anbieter</h4>
							</div>		  
								<?php	
									// SQL Select anbieter
									$sql = "SELECT DISTINCT Name FROM anbieter WHERE Sparten LIKE '%1%'";
									$anbieterListe = array();
									foreach ($pdo->query($sql) as $anbieter) {
										$anbieterListe[] = $anbieter[0];
									};
									
									//stellt sicher, dass die Anbieter aus der Datenbank im DropDown-Menue angezeigt werden
									echo "<input type=\"text\" placeholder=\"Ihr Strom-Anbieter\"list=\"anbieterListe\" id=\"anbieter\" name=\"anbieter\">";
									echo "<datalist id=\"anbieterListe\">";
									foreach($anbieterListe as $anbieter) {
										echo	"<option value=\"".$anbieter."\">";
									};
										echo "</datalist>";	
								?>			
								
<!-- verbrauch -->
								 <div class="felder">
									  <h4>Verbrauch</h4>
								 </div>	
									<input type="text" id="verbrauch" name="verbrauch" placeholder="z.B 100 kwH" required>
									
<!-- Kunden- / Vertragskontonummer -->
								<div class="felder">	
									  <h4>Kunden- / Vertragskontonummer</h4>
								</div>		 
									<input type="text" id="kundennummer" name="kundennummer" placeholder="Zb. 000123" required>

<!-- Zählernummer -->
								<div class="felder">
									  <h4>Ihre Z&auml;hlernummmer</h4>
								</div>	
									<input type="text" id="zaehlernummer" name="zaehlernummer" placeholder="zB. 50 12345" required>

<!-- Monatlicher Abschlag -->
								<div class="felder">	
									  <h4>Wie hoch ist der monatliche Abschlag?</h4>
								</div>		  
									  <input type="text" id="kosten" name="kosten" placeholder="zB. 50,00 Euro " required>
									 

<!-- Vertragslaufzeit -->
								<div class="felder">		  
									  <h4>Vertrag läuft bis?</h4>
								</div>
									  <input type="date" id="vertrag" name="vertrag" value="<?php echo date('Y-m-d'); ?>" required>

<!-- Kündigungsstatus-->
								<div class="felder">	
									  <h4>Schon gekündigt?</h4>
								</div>
									<label class="switch">
										<input type="checkbox" name="gekuendigt">
										<span class="slider round"></span>
									</label>
										
<!-- notizen -->		
								<div class="felder">
									  <h4>Ihre Notizen</h4>
										<textarea id="notiz" name="notiz" cols="0" rows="4" placeholder="Hier kannst Du deine Wünsche und Bemerkungen eintragen"></textarea>
								</div>	
							</div>

<!-- Engel Bewertungs- und Auswahlbereich -->						
				<div id="secondSpace">	
					<h5>Wie wichtig ist dir...?</h5>  
					</br></br>
					
					<?php
						//Array fuer Engelueberschriften	
						$kategorie = array('Der Bezug von Oekostrom','Eine lange Preisgarantie','Eine kurze Kündigungsfrist','monatliche Zahlweise','Ein Neukundenbonus');
						include('include/engel.php');
					?>	
				</div>
					<input class="btn" id="submit" type="submit" name="submit_strom" value="Speichern">
						
		</div>
	</form>	
			
			</div>
		</div>
	</div>

<!-- Footerbereich  include/footer.php -->
	<div class="clearfix"></div>
		<?php include('include/footer.php'); ?>
	</div>


<!-- Javascript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script>
</body>

</html>