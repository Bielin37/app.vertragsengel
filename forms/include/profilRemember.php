
<div>
	<?php	
		$stmt = $pdo->prepare(
			"SELECT * 
			FROM user 
			WHERE 
				(Beruf IS NULL OR 
				 Beruf = '' OR
				 Geburtsdatum IS NULL OR 
				 Geburtsdatum = '0000-00-00' OR
				 Hausnummer IS NULL OR
				 Hausnummer = '' OR
				 Kinder IS NULL OR
				 Mobil IS NULL OR
				 Mobil = '' OR
				 Telefon IS NULL OR
				 Telefon = '' OR
				 Nachname IS NULL OR
				 Nachname = '' OR
				 Vorname IS NULL OR
				 Vorname = '' OR
				 Strasse IS NULL OR
				 Strasse = '' OR
				 PLZ IS NULL OR 
				 PLZ = '')
				AND ID = ".$_SESSION['userID']);
		$stmt->execute();
		if ($stmt->fetch()) {
			echo "Bitte vervollst&auml;ndige dein Profil um deine Vertr&auml;ge anzulegen.";
		}
	?>	
</div>