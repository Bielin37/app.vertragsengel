

<?php
	if (!isset($_SESSION['userID'])) {
		echo "<input type=\"text\" name=\"vertragspartner\" id=\"vertragspartner\" placeholder=\"Vertragspartner\">";

	}
	else {

		// SQL Select
		// Array wird mit vorhandenen Vertragspartner passend zu entsprechender UserID gefuellt
		$statement = $pdo->prepare("SELECT VertragspartnerID FROM user_vertragspartner WHERE UserID = ".$_SESSION['userID']);
		$statement->execute(array());
        $vertragspartnerListe = array();
		while($vpID = $statement->fetch()) {
            $sql = "SELECT E_Mail FROM vertragspartner WHERE ID = ".$vpID[0];
            foreach ($pdo->query($sql) as $partner) {
                $vertragspartnerListe[] = $partner[0];
            };
		};
		// Vertragspartner werden via DropDown-Menü angezeigt und es gibt die Option einen neuen anzulegen
		// $type wird an Weiterleitung gehangen, damit klar ist, von wo diese erfolgt ist -> Rueckkehr moeglich
		echo "<input class=\"felder-input\" type=\"text\" name=\"vertragspartner\" id=\"vertragspartner\" class=\"felder-input\" list=\"vertragspartnerListe\" required>";
		echo "<input type=\"button\" class=\"btn_partner\" onclick=\"parent.location='../forms/vertragspartner.php?type=".$type."'\" value=\"Weitere VP hinzufuegen!\"></button>";
		echo "<datalist id=\"vertragspartnerListe\">";
		foreach($vertragspartnerListe as $partner) {
			echo	"<option value=$partner>";
		};
		// falls keine Vertragspartner in der Datenbank vorhanden
		echo "<option value =\"ich selbst\">";
		echo "</datalist>";
	}






?>
