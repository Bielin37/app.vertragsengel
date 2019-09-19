<?php
	include('../db/database.php');
	include('include/logged.php');
?>

<!doctype html>
<html lang="de">
<head>
	<title>Krankenkasse</title>
	<?php include('include/meta.php'); ?>
</head>

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

<body onload="engelPicture('Krankenkasse')">
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div>
			<h1>Krankenkasse</h1></div>
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
									<label id="cameraLabel" for="fileInput0"><img src="http://localhost/HHA/img/photo-camera.png" />
								</label></div>
									  <input type="file" id="fileInput0" onchange="savePart()" name="fileInput[]" multiple size="50" accept=".png, .jpg, jpeg, .pdf" style="display:none;" />
										<p id="anzahlFiles">Keine Dateien ausgewählt!</p>
								
									 
								<div class="felder">
								<p>Vertragspartner</p>
								</div>
									<?php $type = '6Krankenkasse'; include('include/vpinclude.php') ?>
									</br></br></br>
								
								
								<div class="felder">
								<p>Anbieter</p>
								</div>
										<?php	
											// SQL INSERT 
											$sql = "SELECT DISTINCT Name FROM anbieter WHERE Sparten LIKE '%6%'";
											$anbieterListe = array();
											foreach ($pdo->query($sql) as $anbieter) {
												$anbieterListe[] = $anbieter[0];
											};
											
											echo "<input type=\"text\" placeholder=\"Ihre Krankenkasse\"list=\"anbieterListe\" id=\"anbieter\" name=\"anbieter\">";
											echo "<datalist id=\"anbieterListe\">";
											foreach($anbieterListe as $anbieter) {
												echo	"<option value=\"".$anbieter."\">";
											};
											echo "</datalist>";	
										?>
								
								<div class="felder">
									<p>Art der Versicherung</p>
								</div>
									  	<select id="art" name="art" required>
											<option value="privat">privat</option>
											<option value="gesetzlich">gesetzlich</option>
											<option value="familienversichert">familienversichert</option>
										</select>
							
								<div class="felder">
									<p>Beteiligung an Zusatzversicherungen?</p>
								</div></br></br>
									<label class="switch">
										  <input type="checkbox" name="zusatz">
										  <span class="slider round"></span>
									</label>
								
								<div class="felder">
									<p>Bonus am Jahresende?</p>
								</div></br></br>
									<label class="switch">
										  <input type="checkbox" name="bonus">
										  <span class="slider round"></span>
									</label>
								
								<div class="felder">
									</br><p>Notiz</p>  <textarea id="notiz" name="notiz" cols="30" rows="2" placeholder="Hier kannst Du deine Wünsche und Bemerkungen eintragen"></textarea>
								</div>
									
									
							</div>
							
							<div id="secondSpace">
							<!-- ENGEL -->
							<h4>ENGEL: Wie wichtig ist dir...?</h4>
						
							<?php
								$kategorie = array('Ein Zuschuss bei Zahnersatz','Ein Zuschuss zur Brille','Ihr Status als Privatpatient','Alternativ-Medizin','gute Vorsorge + Impfungen');
								include('include/engel.php');
							?>						
						</div>
						<input class="btn" id="submit" type="submit" name="submit_krankenkasse" value="Speichern">
					</div>
						
				<!-- END BASIC TABLE -->
				</form>	
			</div>
		</div>
	</div>

		<!-- END MAIN -->
	<div class="clearfix"></div>
		<?php include('include/footer.php'); ?>	

	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script>
</body>

</html>