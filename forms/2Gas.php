<?php
	include('../db/database.php');	
	include('include/logged.php');	
?>
<!doctype html>
<html lang="en">

<head>
	<title>Gas</title>
	<?php include('include/meta.php'); ?>

<style>
		/****************************************************
		* Seitenspezifische CSS Für die Farben
		****************************************************/	
		
			h4{
				color: : #C9301A;
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
</style>

	
</head>

<body onload="engelPicture('gas')">
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div><h1>Gas</h1></div>
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
									  <label id="cameraLabel" for="fileInput0"><img src="../img/photo-camera.png" /></label>
									</div>
									  <input  type="file" id="fileInput0" onchange="savePart()" name="fileInput[]" multiple size="50" accept=".png, .jpg, jpeg, .pdf" style="display:none;" />
									  <p id="anzahlFiles">Keine Dateien ausgewählt!</p>
									
									  
									 <div class="felder">
									 <p>Vertragspartner</p>
									 </div>
										<?php $type = '2Gas'; include('include/vpinclude.php'); ?>
									 </br> </br>
									<div class="felder">
									  </br><p>Gas-Anbieter</p>
									 </div>
									  <?php	
											// SQL INSERT 
											$sql = "SELECT DISTINCT Name FROM anbieter WHERE Sparten LIKE '%2%'";
											$anbieterListe = array();
											foreach ($pdo->query($sql) as $anbieter) {
												$anbieterListe[] = $anbieter[0];
											};
											
											echo "<input type=\"text\" placeholder=\"Gas-Anbieter\"list=\"anbieterListe\" id=\"anbieter\" name=\"anbieter\">";
											echo "<datalist id=\"anbieterListe\">";
											foreach($anbieterListe as $anbieter) {
												echo	"<option value=\"".$anbieter."\">";
											};
											echo "</datalist>";	
										?>
									  </br> 
									 <div class="felder">
									  <p>Gas-Verbrauch</p>
									 </div>
										<input class="inputFelder" type="text" id="verbrauch" name="verbrauch" placeholder="in kwH" required>
						
									  
									<div class="felder">
									  <p>Kundennummer</p>
									 </div>
									  <input class="inputFelder" type="text" id="kundennummer" name="kundennummer" placeholder="zb 12555555" required>
								
									
									<div class="felder">
									  <p>Zaehlernummer</p>
									</div>
									  <input class="inputFelder" type="text" id="zaehlernummer" name="zaehlernummer" placeholder="zb 00 555555" required>
								
									
									<div class="felder">
									  <p>Kosten-Gas</p>
									</div>
									  <input class="inputFelder" type="text" id="kosten" name="kosten" placeholder="zB 45,00 Euro" required>
									
									
									<div class="felder">
									  <p>Vertragslaufzeit</p>
									</div>
									  <input class="inputFelder" class="inputFelder" type="date" id="vertrag" name="vertrag" value="<?php echo date('Y-m-d'); ?>" required>
								  
									
									<div class="felder">
									   </br><p>Schon gekündigt?</p>
									</div>
										<label class="switch">
										  <input type="checkbox" name="gekuendigt">
										  <span class="slider round"></span>
										</label>
									
									
									<div class="felder">
									  <p>Ihre Notizen</p><textarea  class="inputFelder" id="notiz" name="notiz" cols="0" rows="4" placeholder="Hier kannst Du deine Wünsche und Bemerkungen eintragen"></textarea>
									</div>
							</div>
						
				
		
						<div id="secondSpace">	
									<!-- ENGEL -->
						<h4>ENGEL: Wie wichtig ist dir...?</h4>
									<?php
										$kategorie = array('Der Bezug von Oekostrom','Eine lange Preisgarantie','Eine kurze Kündigungsfrist','monatliche Zahlweise','Ein Neukundenbonus');
										include('include/engel.php');
									?>
										
						</div>
							<input class="btn" id="submit" type="submit" name="submit_gas" value="Speichern">
						</div>
							<!-- END BASIC TABLE -->
				</form>	
			</div>
		</div>
	</div>

		<!-- END MAIN -->
		<div class="clearfix"></div>
		<?php include('include/footer.php'); ?>
	
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script>
</body>

</html>