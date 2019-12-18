<?php 
	include('include/logged.php');
?>  

<head>
</head>
	<body>
		<div id="main-panel" class="main-panel">
            <div class="panel-titel">
                <span>
                  	<h2>Fernsehen</h2>  <!-- Anzeige im Header -->
				</span>
				<i id="fa-times-circle" class="far fa-times-circle"></i>
            </div>
		<!-- END NAVBAR -->
	<?php
			// Abfrage der Variable $_SESSION['profil'] und festzustellen, ob alle notwendigen persoenlichen Daten vorhanden sind
			// 1/0 = ja/nein
			if($_SESSION['profil'] == 0) {

	?>	
					<div class="row">
					    <div class="alert-danger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong class="strong-red">Vorsicht!</strong><br>Zum Ausfüllen der Formulare musst du dein Profil vervollständigen.<br> 
							<a href="forms/profil.php"><strong class="strong-red">Klicke hier</strong></a> um deine Angaben zu vervollständigen.
                        </div>
                    </div>	
			
		<?php } ?>
		<!-- MAIN -->

			<!-- MAIN CONTENT -->
				<form name="formular" id="strom-formular" method="post" action="db/sendRequest.php" enctype="multipart/form-data">
					<div class="panel-body">		
						<input class="file" type="file" id="file" onchange="savePart()" name="fileInput[]" multiple size="50" accept=".png, .jpg, jpeg, .pdf" />
						<!--	<label class="label" for="file">
								<i class="fas fa-file-upload"></i>
							</label> -->
							<div class="felder">
								<p class="felder-text">Vertragspartner:</p>
							</div>
								<?php $type = '4TV'; include('forms/include/vpinclude.php') ?>
							<div class="felder">
								<p class="felder-text">TV-Anbieter</p>
							</div>
							
										<?php	
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
										?>								
							<div class="felder">
								<p class="felder-text">Kundennummer</p>
							</div>
								<input class="felder-input" type="text" id="kundennummer" name="kundennummer" placeholder="Zb 000123" required>
							<div class="felder">		 
								<p class="felder-text">Kosten</p>
							</div>
							    <input class="felder-input" type="text" id="kosten" name="kosten" placeholder="Zb. 20,00 Euro" required>		
							<div class="felder">
							<p class="felder-text">Tarifbezeichnung</p>
							</div>
								<input class="felder-input" type="text" id="tarif" name="tarif" placeholder="Zb TV Size M" required>
							<div class="felder">
								<p class="felder-text">Vertragslaufzeit</p>
								<input class="felder-input" type="date" id="vertrag" name="vertrag" value="<?php echo date('Y-m-d'); ?>" required>		
								</div>
							<div class="felder" style="display: none">
								<p class="felder-text">Vertragsanfang</p>
							</div>
								<input style="display: none" class="felder-input" type="date" id="vertragsanfang" name="vertragsanfang" value="<?php echo date('Y-m-d'); ?>" required>
							
							<div class="felder">		
								<p class="felder-text">Schon gekündigt?</p>
							</div>
								<label class="switch">
									<input type="checkbox" name="gekuendigt">
									<span class="slider round"></span>
								</label>
							<div class="felder">
								<p class="felder-text">Notizen</p>
								<textarea class="felder-input" id="notiz" name="notiz" cols="30" rows="2" placeholder="Hier kannst Du deine Wünsche und Bemerkungen eintragen"></textarea>
							</div>	 	
							<div>
								<button class="btn-submit" id="submit" type="submit" name="submit_TV" value="Speichern">submit</button>
							</div>
							<!-- END BASIC TABLE -->
					</form>	
				</div>
			</div>
		</div>


	<!-- END WRAPPER -->
	<!-- Javascript -->
</body>

</html>