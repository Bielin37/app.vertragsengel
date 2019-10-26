<?php

	$statement = $pdo->prepare("SELECT * FROM user_interessen WHERE ID = ?");
	$statement->execute(array($_SESSION['userID']));
	$interessen = $statement->fetch();
	// moegliche Spalten: ID, Vorsorge, Versicherung, Foerderung, Policen, Last
	
	$dateDifference = date_diff(new DateTime($interessen['Last']),new DateTime('today'));
	$diff = intval($dateDifference->format('%a'));

	$auswahl = array("Vorsorge", "Versicherung", "Foerderung", "Policen");
	
	//Datenbank abfragen und pruefen ob differenz zwischen letzter aenderung und today > 3
	//Frage kommt alle 7 Tage, wenn nicht 1, d.h. Interesse vorhanden, in Datenbank gesetzt
	if($diff > 3) {
		//$l wird zufaellig auf einen Wert zwischen 1 und 4 gesetzt
		//entsprechend $l wird eine Frage ausgewaehlt
		$l = rand(0,4);
		switch ($l) {
			//Vorsorge
			case ($l == 1 && $interessen['Vorsorge'] != 1) :
				?><div class="row">
					<div class="alert">
							<a href='#' onclick="document.getElementById('cross').submit();" class='close' data-dismiss='alert' aria-label='close'><i class="fa fa-times" aria-hidden="true"></i>
							</a><p>Besteht Interesse an selbstbestimmter Vorsorge?</p>
							<form method="post" action="../db/sendRequest.php">
								<p class="text-right demo-button"><button type="submit" name="submit_<?php echo $auswahl[0]; ?>" value="ok" class="positive-button"><?php echo "natürlich!"; ?></button></p>
							</form>
					</div>
				</div>
				<?php
				break;
			//Haushaltsversicherungen
			case ($l == 2 && $interessen['Versicherung'] != 1) :
				?>
				<div class="row">
					<div class="alert" >
							<a href='#' onclick="document.getElementById('cross').submit();" class='close' data-dismiss='alert' aria-label='close'><i class="fa fa-times" aria-hidden="true"></i>
							</a><p>Durch unsere Gemeinschaft erhalten unsere Kunden bei Haushaltsversicherungen (Hausrat, Haftpflicht, Unfall, Rechtsschutz, etc) bis zu 30% Rabatt.</p>
							<form method="post" action="../db/sendRequest.php">
								<p class="text-right demo-button"><button type="submit" name="submit_<?php echo $auswahl[1]; ?>" value="ok" class="positive-button"><?php echo "na klar!"; ?></button></p>
							</form>
					</div>
				</div>
				<?php
				break;
			//Foerdermittel
			case ($l == 3 && $interessen['Foerderung'] != 1) :
				?>
				<div class="row">
					<div class="alert">
							<a href='#' onclick="document.getElementById('cross').submit();" class='close' data-dismiss='alert' aria-label='close'><i class="fa fa-times" aria-hidden="true"></i>
							</a><p>Jedes Jahr werden 3,4 Mrd Euro an Fördermitteln für private Haushalte nicht abgerufen, da diese immer selbst beantragt werden müssen. Wann war Ihre letzte Überprüfung?</p>
							<form method="post" action="../db/sendRequest.php">
								<p class="text-right demo-button"><button type="submit" name="submit_<?php echo $auswahl[2]; ?>" value="ok" class="positive-button"><?php echo "schnellstmöglich!"; ?></button></p>
							</form>
					</div>
				</div>
				<?php
				break;
			//Policen
			case ($l == 4 && $interessen['Policen'] != 1) :
				?>
				<div class="row">
					<div class="alert">
							<a href='#' onclick="document.getElementById('cross').submit();" class='close' data-dismiss='alert' aria-label='close'><i class="fa fa-times" aria-hidden="true"></i>
							</a><p>Der Verbraucherschutz hat festgestellt, dass sich Kosten in deutschen Lebens- und Rentenversicherungen grundsätzlich um bis zu 50% reduzieren lassen. Durch den Policencheck erhöht sich der Wert Ihrer Auszahkung um durchschnittlich 15.000 €. Interesse an einem Policencheck?</p>
							<form method="post" action="../db/sendRequest.php">
								<p class="text-right demo-button"><button type="submit" name="submit_<?php echo $auswahl[3]; ?>" value="ok" class="positive-button"><?php echo "selbstverständlich!"; ?></button></p>
							</form>
					</div>		
				</div>
				<?php
				break;
		}
		//Formular, das bei "Wegklicken" der Frage submit ausloest und den Timer fuer letzte Aenderung (user_interessen -> LAST) aktualisiert
		?>
		<form id="cross" method="post" action="../db/sendRequest.php" style="display:none;">
			<input type="text" name="cross" value="1">
		</form>
		

		<?php

	} else {
		echo $diff;
	}
?>