<?php
	include('../db/database.php');
?>

<!DOCTYPE html>
<html lang="de">
	<head>    
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Vertragsengel</title>
		<link rel="stylesheet" href="normalize.css">
		<link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="content.css">
		<meta name="keywords" content="Vertragsengel, Verträge, Hilfe" />
		<meta name="author" content="Herr Schirner" />
		<link rel="icon" type="image/logo.png" href="img/vertragsengelkreis logo.png">
		<!-- <link rel="stylesheet" href="style.css"> -->
		<script src="./js/skripts_JS.js" type="text/javascript"></script>
	</head>

<body>
	<h2>Vertragspartner editieren</h2>
	
	<?php
		$statement = $pdo->prepare("SELECT * FROM vertragspartner WHERE ID = ".$_POST['vertragspartnerEdit']);
		$statement->execute(array());
		$vertragspartner = $statement->fetch();
	?>
	<form action="../db/sendRequest.php" method="post">
			<input type="hidden" id="id" name="VertragspartnerID" value="<?php echo $_POST['vertragspartnerEdit']; ?>">
		
		<p>Name</p>
			<input type="text" id="name" name="name" value="<?php echo $vertragspartner['Nachname']; ?>" required>
		<p>Vorname</p>
			<input type="text" id="vorname" name="vorname" value="<?php echo $vertragspartner['Vorname']; ?>" required>
		<p>Geburtsdatum</p>
			<input type="date" id="geburtsdatum" name="geburtsdatum" value="<?php echo $vertragspartner['Geburtsdatum']; ?>" required>
		<p>beruflicher Status</p>
			<select id="beruf" name="beruf" placeholder="bitte wählen..." required onchange="newInput()">
			
			<?php 
			if($vertragspartner['Beruf'] === "angestellt") { 
				echo "<option value=\"angestellt\" selected>angestellt</option>";
				echo "<option value=\"selbstständig\">selbststaendig</option>";
				echo "<option value=\"arbeitssuchend\">arbeitssuchend</option>";
				echo "<option value=\"sonstiges\">sonstiges</option>";
			} else if ($vertragspartner['Beruf'] === "selbststaendig") {
				echo "<option value=\"angestellt\">angestellt</option>";
				echo "<option value=\"selbstständig\" selected>selbststaendig</option>";
				echo "<option value=\"arbeitssuchend\">arbeitssuchend</option>";
				echo "<option value=\"sonstiges\">sonstiges</option>";
			} else if($vertragspartner['Beruf'] == "arbeitssuchend") {
				echo "<option value=\"angestellt\">angestellt</option>";
				echo "<option value=\"selbstständig\">selbststaendig</option>";
				echo "<option value=\"arbeitssuchend\" selected>arbeitssuchend</option>";
				echo "<option value=\"sonstiges\">sonstiges</option>";
			} else {
				echo "<option value=".$vertragspartner['Beruf'].">".$vertragspartner['Beruf']."</option>";
				echo "<option value=\"angestellt\">angestellt</option>";
				echo "<option value=\"selbstständig\">selbststaendig</option>";
				echo "<option value=\"arbeitssuchend\">arbeitssuchend</option>";
				echo "<option value=\"sonstiges\">sonstiges</option>";
			}
			?>	 
			</select>
			<input type="hidden" id="hiddenBeruf" name="altberuf" placeholder="bitte Beruf eingeben">
		<p>Telefonnummer</p>
			<input type="text" id="telefon" name="telefon" value="<?php echo $vertragspartner['Telefon']; ?>">
		<p>Mobilfunknummer</p>
			<input type="text" id="mobil" name="mobil" value="<?php echo $vertragspartner['Mobil']; ?>">
		<p>E-Mail</p>
			<!--noch sicherstellen, dass es sich wirklich um legitime Adresse handelt (regulärer Ausdruck)-->
			<input type="email" id="email" name="email"  value="<?php echo $vertragspartner['E_Mail']; ?>">
		<p>Strasse</p>
			<input type="text" id="strasse" name="strasse"  value="<?php echo $vertragspartner['Strasse']; echo $vertragspartner['Hausnummer'] ?>">
		<p>Postleitzahl</p>
			<input type="text" id="plz" name="plz" value="<?php echo $vertragspartner['PLZ']; ?>">
		<p>Ort</p>
			<input type="text" id="ort" name="ort" value="<?php echo ortAusgabe($vertragspartner['PLZ'],$pdo);?>">
		<input type="submit" name="submit_vertragspartnerEdit" value="Fertig">
	</form>

				<?php	
			 
			// TODO while schleife?
			function ortAusgabe($plz, $pdo) {
				$statement2 = $pdo->prepare("SELECT * FROM postleitzahl WHERE PLZ = ".$plz);
				$statement2->execute(array());
				while($plz = $statement2->fetch()) {
					if(empty($plz['Ort'])){
						return $ort_temp = "";
					}
					else {
						return $ort_temp = $plz['Ort'];
					}
				}	
			}
			?>
</body>
</html>
