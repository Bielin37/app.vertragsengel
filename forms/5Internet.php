<?php
	include('../db/database.php');
	include('include/logged.php');
?>

<!doctype html>
<html lang="en">

<head>
	<title>Internet</title>
	<?php include('include/meta.php'); ?>

<style>
		/****************************************************
		* Seitenspezifische CSS Für die Farben
		****************************************************/


			@font-face {
				font-family: 'meine-schrift';
				src: url('../fonts/Raleway-Medium.ttf') format('truetype'); }

			body{
				font-family: meine-schrift;
				color: black;
				background-color: white;
				box-shadow: none;

				}


			h4{
				color: #C9301A;
				text-align: center;

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
			#wrapper{
				font-size: 14px;
			}
</style>

</head>

<body onload="engelPicture('internet')">
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div>
			<h1>Internet</h1></div>
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
									  <label id="cameraLabel" for="fileInput0"><img src="../img/photo-camera.png" height="50px" width="50px" /></label>
								</div>
									<input type="file" id="fileInput0" onchange="savePart()" name="fileInput[]" multiple size="50" accept=".png, .jpg, jpeg, .pdf" style="display:none;" />
									<p id="anzahlFiles">Mache Bilder von deinen Unterlagen.</p>
								<div class="felder">
									<p>Wähle bitte aus</p>
								</div>
										<?php $type = '5Internet'; include('include/vpinclude.php') ?>
								</br></br></br>
								<div class="felder">
								</div>
										<?php
											// SQL INSERT
											$sql = "SELECT DISTINCT Name FROM anbieter WHERE Sparten LIKE '%Internet%'";
											$anbieterListe = array();
											foreach ($pdo->query($sql) as $anbieter) {
												$anbieterListe[] = $anbieter[0];
											};

											echo "<input type=\"text\" placeholder=\"Anbieter\"list=\"anbieterListe\" id=\"anbieter\" name=\"anbieter\">";
											echo "<datalist id=\"anbieterListe\">";
											foreach($anbieterListe as $anbieter) {
												echo	"<option value=\"".$anbieter."\">";
											};
											echo "</datalist>";
										?>

								<div class="felder">
									  <td><p>Kundennummer</p>
								</div>
									<input type="text" id="kundennummer" name="kundennummer" placeholder="Zb. 000123" required>

								<div class="felder">
									<p>Kosten</p>
								</div>
									<input type="text" id="kosten" name="kosten" placeholder="Zb. 40,00 Euro" required>

								<div class="felder">
									<p>Tarifbezeichnung</p>
								</div>
									<input type="text" id="tarif" name="tarif" placeholder="Zb. Internet S" required>

								<div class="felder">
									<p>Vertragslaufzeit</p>
								</div>
									<input type="date" id="vertrag" name="vertrag" value="<?php echo date('Y-m-d'); ?>" required>
									<div class="felder" style="display: none">
								<p class="felder-text">Vertragsanfang</p>
							</div>
								<input style="display: none" class="felder-input" type="date" id="vertragsanfang" name="vertragsanfang" value="<?php echo date('Y-m-d'); ?>" required>

								<div class="felder">
									</br><p>Schon gekündigt?</p>
								</div>
									<label class="switch">
										  <input type="checkbox" name="gekuendigt">
										  <span class="slider round"></span>
									</label>

								<div class="felder">
									  <p>Notizen</p><textarea id="notiz" name="notiz" cols="30" rows="2" placeholder="Hier kannst Du deine Wünsche und Bemerkungen eintragen"></textarea>
								</div>
							</div>

						<div id="secondSpace">
											<!-- ENGEL -->
								<h4>Wie wichtig ist dir...?</h4>

							<?php
								$kategorie = array('Die Nutzung des Internet','Die W-lan Nutzung','Telefonieren ins Festnetz', 'Telefonieren ins Mobilfunknetz', 'Streaming von Videos');
								include('include/engel.php');
							?>
						</div>
							<input class="btn" id="submit" type="submit" name="submit_internet" value="Speichern">
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