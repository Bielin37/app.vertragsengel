<?php 
	include('../db/database.php');
	include('include/logged.php');
?>
<!doctype html>
<html lang="en">

<head>
	<title>Persoenliche Daten</title>
	<?php include('include/meta.php'); ?>
	<style>
	@font-face { font-family: 'meine-schrift';
				 src: url('../fonts/Raleway-Medium.ttf') format('truetype'); }
		
		
		h1{
			font-size: 		16px;
			font-family:	meine-schrift;
		}
		
		h2{
			font-size: 		14px;
			font-family: 	meine-schrift;
		}
		
		body{
			font-family: 	meine-schrift;
			font-size: 		12px;
			color: 			#383838;
		}
		
	
	#wrapper{
		margin-top: 5%;
		margin-bottom: 3%;
		
	}
	
	#center{
		margin-left: 6%;
		margin-bottom: 30%;
	}
	
	.benennung{
		font-size: 1.2em;
		margin-left: 10px;
		margin-top: 3px;
	}
	
	
	
	
	/* linker Button*/		
		#btnRight{
			float:left; 
			margin-left: 5%;
			background-color: white;
			text-align: center;
			width: 30px;
			height: 30px;
			font-size: 12px;
			color: #c0c0c0;
			background-color: #ffffff;
			border-radius: 5%;
			box-shadow: 0 2px 2px -2px #333;
		}

		#btnLeft{
			float:right; 
			margin-right: 5%;
			background-color: white;
			text-align: center;
			width: 30px;
			height: 30px;
			font-size: 12px;
			color: #383838;
			background-color: #ffffff;
			border-radius: 5%;
			box-shadow: 0 1px 1px -1px #333;
		}
		
		#btnLeft2{
			float:left; 
			margin-left: 5%;
			background-color: white;
			text-align: center;
			width: 150px;
			height: 30px;
			font-size: 12px;
			color: green;
			background-color: #ffffff;
			border-radius: 5%;
			box-shadow: 0 2px 2px -2px #333;
		}
		
		form{
			padding-left: 5%;
			color: #383838;
			width: 80%;
			height: 60%;
		}
		
		
		#btnRight:hover, #btnLeft:hover{
			transition: background 2s #383838;
			-webkit-box-shadow: 0px 9px 2px #a4338a;
			-moz-box-shadow: 0px 9px 2px #a4338a;
			box-shadow: 0px 0px 9px #a4338a;
		}
	
		.col-md-4-2{
			margin-left: -5%;
			padding: 2%;
		}
		.panel panel-headline{
			padding: 3%;
			
		}
		/* weiter links ;) - sehr kreative namenswahl*/
		.wLinks{
			margin-left: 3%;
			margin-top: -3%;
		}
	
	</style>
</head>	
	
<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div><h1>Persönliche Daten</h1></div></nav>
	</div>
	<div id="center">
		<?php
			// wenn $_GET Variable gesetzt, soll Passwort geaendert werden
			if(isset($_GET['pw'])) {
				
				$passwortAlt = $_POST['passwortAlt'];
				$passwort1 = $_POST['newPasswort1'];
				$passwort2 = $_POST['newPasswort2'];

				// Ueberprüfung des Passworts
				// mit Datenbanktabelle user_passwort verbinden
				$statement = $pdo->prepare("SELECT Passwort FROM user_passwort WHERE ID = :id");
				$result = $statement->execute(array('id' => $_SESSION['userID']));
				$passwort_db = $statement->fetch();
				// altes Passwort wurde eingegeben und stimmt mit dem Eintrag aus der Datenbank ueberein
				if ($passwortAlt !== false && password_verify($passwortAlt, $passwort_db['Passwort'])) {
					// die beiden neuen Passwoerter sind identisch?
					if($passwort1 == $passwort2) {
						// Passwort hashen
						$passwort_hash = password_hash($passwort1, PASSWORD_DEFAULT);

						// Passworthash in Datenbank updaten
						$statementPW = $pdo->prepare("UPDATE user_passwort SET Passwort = ? WHERE ID = ".$_SESSION['userID']);
						$statementPW->execute(array($passwort_hash));
						echo '<script>';
						echo 'alert("Passwort erfolgreich geändert!")';
						echo '</script>';
						// Fehlermeldung
					} else {
						echo '<script>';
						echo 'alert("Passwörter stimmen nicht überein!")';
						echo '</script>';
					}
				}
				// altes Passwort war falsch 
				else if($passwortAlt !== false && !password_verify($passwortAlt, $passwort_db['Passwort'])){
					echo '<script>';
					echo 'alert("Passwort ungueltig")';
					echo '</script>';
				}
			}
		?>

	
	<!-- idealerweise auf einer Seite mit Vertraegen, eventuell in unterschiedlichen Tabs -->
	<!-- bei erstmaligem Aufruf das komplette Formular zur Änderung anbieten, dann dafuer sorgen, dass es nach dem ersten ausfüllen nie wieder auftaucht -->
	<!-- Felder, die editierbar sein sollen, verwenden die JavaScript-Funktion new_Input(String) mittels onclick() -->
	<!-- das Editieren wird mit der JavaScript-Funktion cancelNew_Input(String) wieder zurückgesetzt  -->
		</br></br>

		<br>
		<?php 
			// persoenliche Daten aus der Datenbank in ein Array $user stecken und im Dokument anzeigen
			$statement = $pdo->prepare("SELECT * FROM user WHERE ID = ".$_SESSION['userID']);
			$statement->execute(array());
			while($user = $statement->fetch()) {
				?>
				<dl>
				
				<div class="col-md-4-2">	
					<div class="panel panel-headline">
						<dt class="benennung">Erstanmeldung:</dt>
							</br>
							<dd><div class="wLinks"><?php echo $user['Registrierung']; ?></div></dd>
					</div>
				</div>
				
				<div class="col-md-4-2">	
					<div class="panel panel-headline">
					<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setName" onclick='new_Input("changeName")'></button></dd>
						
					<dt class="benennung" >Name:</dt></br>
					</br>
						<dd><div class="wLinks"><?php echo $user['Vorname']." ".$user['Nachname']."<br>"; ?></div>
						
						</br>
						<div class="wLinks"><form id="changeName" method="post" action="../db/sendRequest.php" style="display:none">
							<dd>Vorname:</dd>
							<dd><input  type="text" name="newVorname" value="<?php echo $user['Vorname']; ?>" required></dd>
							</br>
							<dd>Nachname:</dd>
							<dd><input type="text" name="newNachname" value="<?php echo $user['Nachname']; ?>" required></dd>
							</br>
							<dd><input class="glyphicon glyphicon-ok" type="submit" name="submit_newName" value="ok">
							<button class="glyphicon glyphicon-remove" type="button" onclick='cancelNew_Input("changeName")'></button></dd>
							</br>
						</form></div>
					</div>
				</div>				
						
				<div class="col-md-4-2">	
					<div class="panel panel-headline">
					<button class="glyphicon glyphicon-pencil" type="button" id="btnLeft" onclick='new_Input("changeMail")'></button></dd>
					
					<dt  class="benennung">E-mail:</dt></br>
					</br>
						<dd><div class="wLinks"><?php echo $user['E_Mail']."<br>"; ?></div>
						
						</br></br>
						<div class="wLinks"><form id="changeMail" method="post" action="../db/sendRequest.php" style="display:none">
							</br>
							<dd>E-Mail adresse:</dd>
							
							<dd><input type="email" name="newE_Mail" value="<?php echo $user['E_Mail']; ?>"  required></dd>
							</br>
							<dd><input class="glyphicon glyphicon-ok" type="submit" name="submit_NewEmail" value="ok">
							<button class="glyphicon glyphicon-remove" type="button" onclick='cancelNew_Input("changeMail")'></button></dd>
							</br>
						</form></div>
					</div>
				</div>		
					
				<div class="col-md-4-2">	
					<div class="panel panel-headline">
					<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setAdress" onclick="new_Input('changeAdress')"></button></dd>
						
					<dt class="benennung">Anschrift:</dt></br>
					</br>
							<dd><div class="wLinks"><?php echo $user['Strasse']." ".$user['Hausnummer']."<br>".$user['PLZ']." ".ortAusgabe($user['PLZ'], $pdo)."<br>"; ?></div>
						</br></br>
						<div class="wLinks"><form id="changeAdress" method="post" action="../db/sendRequest.php" style="display:none">
							<dd>Strasse:</dd>
							
							<dd><input type="text" name="newStrasse" value="<?php echo $user['Strasse']." ".$user['Hausnummer']; ?>" required></dd>
							</br><dd>PLZ:</dd>
							<dd><input type="text" name="newPLZ" value="<?php echo $user['PLZ']; ?>"  required></dd>
							</br><dd>Ort:</dd>
							<dd><input type="text" name="newOrt" value="<?php echo ortAusgabe($user['PLZ'], $pdo); ?>"  required></dd>
							</br>
							<dd><input type="submit" name="submit_NewAnschrift" value="ok">
							
							<button class="glyphicon glyphicon-remove" type="button" onclick="cancelNew_Input('changeAdress')"></button></dd>
							</br>
						</form></div>
						</br>
					</div>
				</div>
					
					
				<div class="col-md-4-2">	
					<div class="panel panel-headline">
					<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setDate" onclick='new_Input("changeDate")'></button></dd>
						
					<dt class="benennung">Geburtstag:</dt>
					</br>
							<dd><div class="wLinks"><?php echo $user['Geburtsdatum']."<br>"; ?></div>
							
						</br>
						<div class="wLinks"><form id="changeDate" method="post" action="../db/sendRequest.php" style="display:none">
							<dd>Datum:</dd>
							<dd><input type="date" name="newGeburtsdatum" required></dd></br>
							<dd><input type="submit" name="submit_NewDate" value="ok">
							
							<button class="glyphicon glyphicon-remove" type="button" onclick="cancelNew_Input('changeDate')"></button></dd>
							</br>
						</form></div>
					</div>
				</div>
					
					
				<div class="col-md-4-2">	
					<div class="panel panel-headline">
					<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setTelefon" onclick='new_Input("changeTelefon")'></button></dd>

					<dt class="benennung">Telefon</dt>
					</br>
						<dd><div class="wLinks"><?php echo "Festnetz: ".$user['Telefon']."<br>Mobilfunknummer: ".$user['Mobil']; ?></div>
						</br>
						<div class="wLinks"><form id="changeTelefon" method="post" action="../db/sendRequest.php" style="display:none">
							</br><dd>Festnetznummer:</dd>
							<dd><input type="text" name="newTelefon" inputmode="numeric" value="<?php echo $user['Telefon']; ?>" required></dd>
							</br><dd>Mobilfunknummer:</dd>
							<dd><input type="text" name="newMobil" inputmode="numeric" value="<?php echo $user['Mobilr']; ?>"  required></dd>
							</br>
							<dd><input type="submit" name="submit_NewTelefon" value="ok">
							<button class="glyphicon glyphicon-remove" type="button" onclick="cancelNew_Input('changeTelefon')"></button></dd>
							</br>
						</form></div>
					</div>
				</div>
					

				<div class="col-md-4-2">	
					<div class="panel panel-headline">
					<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setBeruf" onclick='new_Input("changeBeruf")'></button></dd>	
					<dt class="benennung">Beruf:</dt>
					</br>
						<dd><div class="wLinks"><?php echo $user['Beruf']."<br>"; ?></div>
						<div class="wLinks">
						
						<form id="changeBeruf" method="post" action="../db/sendRequest.php" style="display:none">
							</br></br><dd>beruflicher Status:</dd>
							<dd><input type="text" name="beruf" value="<?php echo $user['Beruf']; ?>" required></dd>
							</br>
							<dd><input type="submit" name="submit_NewBeruf" value="ok">
							<button class="glyphicon glyphicon-remove" type="button" onclick="cancelNew_Input('changeBeruf')"></button></dd>
							</br>
						</form></div>
					
					</div>
				</div>
					
					
				<div class="col-md-4-2">	
					<div class="panel panel-headline">
			
					<dt class="benennung">Vertragspartner:</dt>
					</br></br>
						<div class="wLinks">
						<?php 
							// Informationen zu Vertragspartnern werden aus der Datenbank-Tabelle user_vertragspartern herausgelesen
							$statement = $pdo->prepare("SELECT VertragspartnerID FROM user_vertragspartner WHERE UserID = ".$_SESSION['userID']);  
							$statement->execute(array());
							$i = 0;
							while ($vertragspartnerID = $statement->fetch()) {
								// mit der VertragspartnerID wird auf die Inhalte der vertragspartner-Tabelle zugegriffen und in $partner abgelegt
                                $statement1 = $pdo->prepare("SELECT * FROM vertragspartner WHERE ID = ".$vertragspartnerID['VertragspartnerID']);
								$statement1->execute(array());
								$partner = $statement1->fetch();
								echo ("<dd>".$partner['Vorname']." ".$partner['Nachname']." (".$partner['E_Mail'].")");?>
									<div class="wLinks"><form method="post" action="../db/sendRequest.php" name="vertragspartnerForm" id="vertragspartnerFormID" hidden>
										<input type="text" id="vertragspartnerDeleteID" name="vertragspartnerDelete" value="">
									</form></div>	
									<div class="wLinks"><form method="post" action="vertragspartnerEdit.php" name="vertragspartnerEditForm" id="vertragspartnerEditFormID" hidden>
										<input type="text" id="vertragspartnerEdit" name="vertragspartnerEdit" value="<?php echo $partner['ID']; ?>"s>
									</form></div>	
									
					</br>		
									<button  class="glyphicon glyphicon-pencil" type="button" onclick="editVertragspartner(<?php echo $partner['ID']; ?>)"></button>
									<button  class="glyphicon glyphicon-remove" type="button" onclick="deleteVertragspartner(<?php echo $i; ?>)"></button>
									</br></br>
									</dd>
						
						<?php
							$i++;
							}
						?>
						</div>
						</div>
					</div>
						
					<a href="profil.php"><button type="button" id="btnLeft2">Alle Daten bearbeiten</button></a>
					
			
					<button type="button" id="btnLeft2" onclick='new_Input("changePasswort")'>Passwort aendern</button>
					</br>
					</br>
					<div class="wLinks"><form id="changePasswort" method="post" action="?pw=1" style="display: none">
						<p>bitte passwort bestätigen:</p>
						<input type="password" name="passwortAlt" required></p>
						<p>neues Passwort:</p>
						<p><input type="password" name="newPasswort1" required></p>
						<p>neues Passwort bestaetigen:</p>
						<p><input type="password" name="newPasswort2" required></p>
						<p><input type="submit" name="submit_newPasswort" value="ok">
						<button type="button" id="btnLeft2" onclick='cancelNew_Input("changePasswort")'>Abbrechen</button></p>
					</form></div>
					
					</br>				
<!-- es fehlt noch der $type, sonst kommt man nicht wieder zurück auf diese Seite -->
					<a href="vertragspartner.php"><dd>
					<button class="btnLeft" type="button" id="btnLeft2">Partner hinzufügen</button></dd></a>
				
					<div id="test"></div>
						
					
				</dl>
			<?php	
			} 
			// While Schleife keine schoene Loesung
			// Funktion liest mit Hilfe der Postleitzahl den Ort aus der Datenbank heraus, insofern der dort hinterlegt ist
			function ortAusgabe($plz, $pdo) {
				$statement2 = $pdo->prepare("SELECT * FROM postleitzahl WHERE PLZ = ".$plz);
				$statement2->execute(array());
				while($plz2 = $statement2->fetch()) {
					if(empty($plz2['Ort'])){
						return $ort_temp = "";
					}
					else {
						return $ort_temp = $plz2['Ort'];
					}
				}	
			}
			?>
		</div>
	<?php
		include('include/footer.php');
	?>
	<!-- Javascript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script>
</body>

</html>
