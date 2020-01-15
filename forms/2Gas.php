<?php
	include('../db/database.php');
	include('include/logged.php');
?>

<head>
</head>
<body>
	<div id="panel-ausfullen-details-main">
		<div class="panel-ausfullen-head">
			<?php echo $_GET['item']; ?> bearbeiten
			<i id="fa-times-circle" class="far fa-times-circle"></i>
		</div>

	<?php
		// Abfrage der Variable $_SESSION['profil'] und festzustellen, ob alle notwendigen persoenlichen Daten vorhanden sind
		// 1/0 = ja/nein
		if($_SESSION['profil'] == 0) {

		?>

		<!-- <div class="col-md-2">
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
		</div> -->

		<?php } ?>

	<form class="panel-ausfullen-form" id="gas-formular" method="post" action="" enctype="multipart/form-data" >
		<div class="text">Details</div>
			<div class="panel-ausfullen-form-row">
				<!-- <div class="felder">
					<label id="cameraLabel" for="fileInput0"><img src="../img/photo-camera.png" /></label>
				</div>
					<input  type="file" id="fileInput0" onchange="savePart()" name="fileInput[]" multiple size="50" accept=".png, .jpg, jpeg, .pdf" style="display:none;" />
					<p id="anzahlFiles">Keine Dateien ausgewählt!</p> -->
				<div class="felder">
					<p class="felder-text">Vertragspartner:</p>
					<?php $type = '2Gas';
					include('include/vpinclude.php'); ?>
				</div>
				<div class="felder" style="display: none">
					<p class="felder-text">Anbieter</p>
					<input class="felder-input" type="text" id="anbieter" name="anbieter" value="<?php echo $_GET['item'] ?>">
				</div>

				<!-- <?php
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
				?> -->

				<div class="felder">
					<p class="felder-text">Gas-Verbrauch</p>
					<input class="felder-input" type="text" id="verbrauch" name="verbrauch" placeholder="kwH" required>
				</div>
				<div class="felder">
					<p class="felder-text">Kundennummer</p>
					<input class="felder-input" type="text" id="kundennummer" name="kundennummer" required>
				</div>
				<div class="felder">
					<p class="felder-text">Zaehlernummer</p>
					<input class="inputFelder" type="text" id="zaehlernummer" name="zaehlernummer" required>
				</div>
			</div>
			<div class="text">Laufzeit und Fristen</div>
			<div class="panel-ausfullen-form-row">
				<div class="felder-checkbox">
					<p class="felder-text">Schon gekündigt?</p>
					<input type="checkbox" name="gekuendigt" require>
				</div>
			</div>
			<div class="panel-ausfullen-form-row">
				<div class="felder-date felder">
					<p class="felder-text">Vertragsende</p>
					<input class="felder-input" type="date" id="vertrag" name="vertrag" value="<?php echo date('Y-m-d'); ?>" required>
				</div>
				<div class="felder" style="display: none">
					<p class="felder-text">Vertragsanfang</p>
					<input style="display: none" class="felder-input" type="date" id="vertragsanfang" name="vertragsanfang" value="<?php echo date('Y-m-d'); ?>" required>
				</div>
			</div>
			<div class="panel-ausfullen-form-row">
				<div class="felder felder-kosten">
					<p class="felder-text">Kosten</p>
					<input class="inputFelder" type="text" id="kosten" name="kosten" placeholder="0,00 €" required>
				</div>
				<div class="felder-textarea felder">
					<p class="felder-text">Notizen</p>
					<textarea  class="inputFelder" id="notiz" name="notiz" cols="0" rows="4"></textarea>
				</div>
			</div>
			<div class="panel-ausfullen-form-row">
				<div class="felder">
					<input class="felder-button button-speichern" type="submit" name="submit_gas" value="Speichern">
				</div>
				<div class="felder">
					<div class="felder-button button-loschen">Vertrag löschen</div>
				</div>
			</div>
				<!-- END BASIC TABLE -->
		</form>
	</div>

<!-- END MAIN -->
<div class="clearfix"></div>

<!-- 	</div> -->
<!-- END WRAPPER -->
<!-- Javascript -->
</body>

</html>