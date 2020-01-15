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
					<!-- <div class="row">
					    <div class="alert-danger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong class="strong-red">Vorsicht!</strong><br>Zum Ausfüllen der Formulare musst du dein Profil vervollständigen.<br>
							<a href="forms/profil.php"><strong class="strong-red">Klicke hier</strong></a> um deine Angaben zu vervollständigen.
                        </div>
                    </div> -->

		<?php } ?>
<form class="panel-ausfullen-form" id="strom-formular" method="post" action="" enctype="multipart/form-data">
	<div class="text">Details</div>
			<!-- <label class="label" for="file">
				<i class="fas fa-file-upload"></i>
			</label> -->
		<div class="panel-ausfullen-form-row">
			<div class="felder">
				<p class="felder-text">Vertragspartner:</p>
				<?php $type = '4TV';
				include('./include/vpinclude.php') ?>
			</div>
			<div class="felder" style="display: none">
				<p class="felder-text">Anbieter</p>
				<input class="felder-input" type="text" id="anbieter" name="anbieter" value="<?php echo $_GET['item'] ?>">
			</div>

			<!-- <?php
				// SQL INSERT
				$sql = "SELECT DISTINCT Name FROM anbieter WHERE Sparten LIKE '%4%'";
				$anbieterListe = array();
				foreach ($pdo->query($sql) as $anbieter) {
					$anbieterListe[] = $anbieter[0];
				};

				echo "<input type=\"text\" placeholder=\"TV-Anbieter\"list=\"anbieterListe\" id=\"anbieter\" class=\"felder-input\" name=\"anbieter\">";
				echo "<datalist id=\"anbieterListe\">";
				foreach($anbieterListe as $anbieter) {
					echo	"<option value=\"".$anbieter."\">";
				};
				echo "</datalist>";
			?> -->
			<div class="felder">
				<p class="felder-text">Tarifbezeichnung</p>
				<input class="felder-input" type="text" id="tarif" name="tarif" require>
			</div>
			<div class="felder">
				<p class="felder-text">Kundennummer</p>
				<input class="felder-input" type="text" id="kundennummer" name="kundennummer" require>
			</div>
		</div>
		<div class="text">Laufzeit und Fristen</div>
		<div class="panel-ausfullen-form-row">
			<div class="felder-checkbox">
				<p class="felder-text">Schon gekündigt?</p>
				<input type="checkbox" name="gekuendigt" id="gekuendigt" require>
			</div>
		</div>
		<div class="panel-ausfullen-form-row">
			<div class="felder-date felder">
				<p class="felder-text">Vertragsende</p>
				<input class="felder-input" type="date" id="vertrag" name="vertrag" require>
			</div>
			<div class="felder" style="display: none">
				<p class="felder-text">Vertragsanfang</p>
				<input class="felder-input" type="date" id="vertragsanfang" name="vertragsanfang" value="<?php echo date('Y-m-d'); ?>">
			</div>
		</div>
		<div class="panel-ausfullen-form-row">
			<div class="felder felder-kosten">
				<p class="felder-text">Kosten</p>
				<input class="felder-input" type="text" id="kosten" name="kosten" placeholder="0,00 €" require>
			</div>
			<div class="felder-textarea felder">
				<p class="felder-text">Notizen</p>
				<textarea class="felder-input" id="notiz" name="notiz" cols="30" rows="4"></textarea>
			</div>
			<!-- <div class="felder">
			<p class="felder-text">Datei upload</p>
				<input class="file" type="file" id="file" onchange="savePart()" name="fileInput[]" multiple size="50" accept=".png, .jpg, jpeg, .pdf" />
			</div> -->
		</div>
		<div class="panel-ausfullen-form-row">
			<div class="felder">
				<input class="felder-button button-speichern" type="submit" name="submit_TV" value="Speichern">
			</div>
			<div class="felder">
				<div class="felder-button button-loschen">Vertrag löschen</div>
			</div>
		</div>
			<!-- END BASIC TABLE -->
	</form>
</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
</body>

</html>