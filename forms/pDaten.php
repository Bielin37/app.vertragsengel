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
		margin-top: 25px;
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
			float: right; 
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
			position: absolute;
			right: 20%;
			top: 10%;
		}
		
		#btnLeft2{
			float:left; 
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
		#btnRight:hover, #btnLeft:hover{
			transition: background 2s #383838;
			-webkit-box-shadow: 0px 9px 2px #a4338a;
			-moz-box-shadow: 0px 9px 2px #a4338a;
			box-shadow: 0px 0px 9px #a4338a;
		}
		.text-1{
			display: flex;
			margin-left: 5%;
			margin-bottom: 2%;
		}
		.text-2{
			margin-left: 10%;
		}
		.text-3{
			margin-left: 15%;
		}
		@media screen and (max-width: 400px) {
    	.text-2 {
			white-space: nowrap;
			overflow: auto;
			text-overflow: ellipsis;
			-moz-text-overflow: ellipsis;
			-ms-text-overflow: ellipsis;
			-o-text-overflow: ellipsis;
			-webkit-text-overflow: ellipsis;
		} }
		@media screen and (max-width: 400px) {
    	#btnLeft {
			position: absolute;
			right: 5%;
		} }
		
	</style>
</head>		
<body>
	<div>
		<span>
			<h1 class="alert alert-success" style="width: 105.5vw;">Persönliche Daten</h1>  <!-- Anzeige im Header -->
		</span>
	</div>
	<div id="wrapper"style="display: flex;">
		<div class="navbar-collapse navbar-ex1-collapse" style="min-width: 20%; z-index: 1; padding-right: 20px;">
					<ul class="nav navbar-nav side-nav" style="display: flex; flex-direction: column; ">
						<li>
							<a href="../vertragsAuswahl.php"><i class="glyphicon glyphicon-th"></i><span class="text">Vertrag Auswahl</span><i class="fa fa-fw fa-caret-down"></i></a>
						</li>                    
						<li>
							<a href="../vertragsUebersicht.php"><i class="glyphicon glyphicon-list-alt"></i><span class="text">Vertrag Ubersicht</span><i class="fa fa-fw fa-caret-down"></i></a>
						</li>
						<li>
							<a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="glyphicon glyphicon-user"></i><span class="text">Profil</span><i class="fa fa-fw fa-caret-down"></i></a>
							<ul id="demo1" class="collapse">
								<li class="nav-item"><a href="pDaten.php"><i class="glyphicon glyphicon-pushpin"></i><span>Mein Profil</span></a></li>
								<li class="nav-item"><a href="profil.php"><i class="glyphicon glyphicon-pushpin"></i> <span>Alle Daten bearbaiten</span></a></li>
								<li class="nav-item"><a href="vertragspartner.php"><i class="glyphicon glyphicon-pushpin"></i> <span>Partner hinzufügen</span></a></li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="glyphicon glyphicon-cog"></i><span class="text">Einstellungen</span><i class="fa fa-fw fa-caret-down"></i></a>
							<ul id="demo" class="collapse">
								<li class="nav-item"><a href="datenschutz.php"><i class="glyphicon glyphicon-info-sign"></i> <span>Datenschutz</span></a></li>
								<li class="nav-item"><a href="agb.php"><i class="glyphicon glyphicon-info-sign"></i> <span>AGB</span></a></li>
								<li class="nav-item"><a href="faq.php"><i class="glyphicon glyphicon-info-sign"></i> <span>FAQ</span></a></li>
								<li class="nav-item"><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
					</ul>
			</div>
		<div class="row" style="display:flex; flex-direction: column; width: 100vw;">
		<div class="col-md-12" style="display: flex; justify-content: center; position: relative; flex-direction: column;">

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
						echo 'alert("<p class="alert alert-success"> Passwort erfolgreich geändert! </p>")';
						echo '</script>';
						// Fehlermeldung
					} else {
						echo '<script>';
						echo 'alert("<p class="alert alert-danger">Passwörter stimmen nicht überein! </p>")';
						echo '</script>';
					}
				}
				// altes Passwort war falsch 
				else if($passwortAlt !== false && !password_verify($passwortAlt, $passwort_db['Passwort'])){
					echo '<script>';
					echo 'alert("<p class="alert alert-danger">Passwort ungueltig</p>")';
					echo '</script>';
				}
			}
		?>

	
	<!-- idealerweise auf einer Seite mit Vertraegen, eventuell in unterschiedlichen Tabs -->
	<!-- bei erstmaligem Aufruf das komplette Formular zur Änderung anbieten, dann dafuer sorgen, dass es nach dem ersten ausfüllen nie wieder auftaucht -->
	<!-- Felder, die editierbar sein sollen, verwenden die JavaScript-Funktion new_Input(String) mittels onclick() -->
	<!-- das Editieren wird mit der JavaScript-Funktion cancelNew_Input(String) wieder zurückgesetzt  -->
		<?php 
			// persoenliche Daten aus der Datenbank in ein Array $user stecken und im Dokument anzeigen
			$statement = $pdo->prepare("SELECT * FROM user WHERE ID = ".$_SESSION['userID']);
			$statement->execute(array());
			while($user = $statement->fetch()) {
				?>
					<div class="row column" style="display: flex; width: 80vw; flex-direction: column;">
						<p class="text-1">Erstanmeldung:</p>
						<div class="text-2"><?php echo $user['Registrierung']; ?></div>
					</div>
				
					<div class="row" style="display: flex; width: 80vw; flex-direction: column; position: relative;">
						<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setName" onclick='new_Input("changeName")'></button>
						<p class="text-1" >Name:</p>
						<div class="text-2"><?php echo $user['Vorname']." ".$user['Nachname']."<br>"; ?></div>
						<div id="changeName" style="display: none;">
							<form id="changeName" method="post" action="../db/sendRequest.php">
								<p class="text-2">Vorname:</p>
								<input class="text-3" type="text" name="newVorname" value="<?php echo $user['Vorname']; ?>" required>
								<p class="text-2">Nachname:</p>
								<input class="text-3" type="text" name="newNachname" value="<?php echo $user['Nachname']; ?>" required>
								<button class="glyphicon glyphicon-ok" type="submit" name="submit_newName" value="ok"></button>
								<button class="glyphicon glyphicon-remove" type="button" onclick='cancelNew_Input("changeName")'></button>
							</form>
						</div>
					</div>				
					
					<div class="row" style="display: flex; width: 80vw; flex-direction: column; position: relative;">
						<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setAdress" onclick="new_Input('changeAdress')"></button>
						<p class="text-1">Anschrift:</p>
						<div class="text-2"><?php echo $user['Strasse']." ".$user['Hausnummer']."<dd>".$user['PLZ']." ".ortAusgabe($user['PLZ'], $pdo)."<p>"; ?></div>
						<form id="changeAdress" method="post" action="../db/sendRequest.php" style="display:none">
							<p class="text-2">Strasse:</p>
							<input type="text" class="text-3" name="newStrasse" value="<?php echo $user['Strasse']." ".$user['Hausnummer']; ?>" required>
							<p class="text-2">PLZ:</p>
							<input type="text" class="text-3" name="newPLZ" value="<?php echo $user['PLZ']; ?>"  required>
							<p class="text-2">Ort:</p>
							<input type="text" class="text-3" name="newOrt" value="<?php echo ortAusgabe($user['PLZ'], $pdo); ?>"  required>
							<button class="glyphicon glyphicon-ok" type="submit" name="submit_NewAnschrift" value="ok"></button>
							<button class="glyphicon glyphicon-remove" type="button" onclick="cancelNew_Input('changeAdress')"></button>
						</form>
					</div>
					
					<div class="row" style="display: flex; width: 80vw; flex-direction: column; position: relative;">
						<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setDate" onclick='new_Input("changeDate")'></button>
						<p class="text-1">Geburtstag:</p>
						<div class="text-2"><?php echo $user['Geburtsdatum']."<br<dd>"; ?></div>
							<form id="changeDate" method="post" action="../db/sendRequest.php" style="display:none">
								<p class="text-2">Datum:</p>
								<input class="text-3" type="date" name="newGeburtsdatum" required>
								<button class="glyphicon glyphicon-ok" type="submit" name="submit_NewDate" value="ok"></button>
								<button class="glyphicon glyphicon-remove" type="button" onclick="cancelNew_Input('changeDate')"></button>
							</form>
					</div>				
					
					<div class="row" style="display: flex; width: 80vw; flex-direction: column; position: relative;">
						<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setTelefon" onclick='new_Input("changeTelefon")'></button>
						<p class="text-1">Telefon</p>
						<div class="text-2"><?php echo "Festnetz: ".$user['Telefon']."<dd>Mobilfunknummer: ".$user['Mobil']; ?></div>
							<form id="changeTelefon" method="post" action="../db/sendRequest.php" style="display:none">
								<p class="text-2">Festnetznummer:</p>
								<input type="text" class="text-3" name="newTelefon" inputmode="numeric" value="<?php echo $user['Telefon']; ?>" required>
								<p class="text-2">Mobilfunknummer:</p>
								<input type="text" class="text-3" name="newMobil" inputmode="numeric" value="<?php echo $user['Mobil']; ?>"  required>
								<button class="glyphicon glyphicon-ok" type="submit" name="submit_NewTelefon" value="ok"></button>
								<button class="glyphicon glyphicon-remove" type="button" onclick="cancelNew_Input('changeTelefon')"></button>
							</form>
					</div>

					<div class="row" style="display: flex; width: 80vw; flex-direction: column; position: relative;">
						<button class="glyphicon glyphicon-pencil" id="btnLeft" type="button" id="setBeruf" onclick='new_Input("changeBeruf")'></button>	
						<p class="text-1">Beruf:</p>
						<div class="text-2"><?php echo $user['Beruf']."<dd>"; ?></div>
							<form id="changeBeruf" method="post" action="../db/sendRequest.php" style="display:none">
								<p class="text-2">beruflicher Status:</p>
								<input class="text-3" type="text" name="beruf" value="<?php echo $user['Beruf']; ?>" required>
								<button class="glyphicon glyphicon-ok" type="submit" name="submit_NewBeruf" value="ok"></button>
								<button class="glyphicon glyphicon-remove" type="button" onclick="cancelNew_Input('changeBeruf')"></button>
							</form>
					</div>
					
					<div class="row" style="display: flex; width: 80vw; flex-direction: column; position: relative; margin-bottom: 5%;">
						<p class="text-1">Vertragspartner:</p>
						<div class="text-2">
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
									<form method="post" action="../db/sendRequest.php" name="vertragspartnerForm" id="vertragspartnerFormID" hidden>
										<input class="text3" type="text" id="vertragspartnerDeleteID" name="vertragspartnerDelete" value="">
									</form>	
									<form method="post" action="vertragspartnerEdit.php" name="vertragspartnerEditForm" id="vertragspartnerEditFormID" hidden>
										<input class="text-3" type="text" id="vertragspartnerEdit" name="vertragspartnerEdit" value="<?php echo $partner['ID']; ?>"s>
									</form>		
										<button class="glyphicon glyphicon-pencil" type="button" onclick="editVertragspartner(<?php echo $partner['ID']; ?>)"></button>
										<button class="glyphicon glyphicon-remove" type="button" onclick="deleteVertragspartner(<?php echo $i; ?>)"></button>	
						<?php
							$i++;
							}
						?>
						</div>
					</div>

					<div class="row" style="display: flex; width: 80vw; flex-direction: column; position: relative;">
						<button class="glyphicon glyphicon-pencil" type="button" id="btnLeft" onclick='new_Input("changeMail")'></button>
						<p class="text-1">E-mail:</p>
						<div class="text-2"><?php echo $user['E_Mail']."<br>"; ?></div>
							<form id="changeMail" method="post" action="../db/sendRequest.php" style="display:none">
								<p class="text-2">E-Mail adresse:</p>
								<input class="text-3" type="email" name="newE_Mail" value="<?php echo $user['E_Mail']; ?>"  required>
								<button class="glyphicon glyphicon-ok" type="submit" name="submit_NewEmail" value="ok"></button>
								<button class="glyphicon glyphicon-remove" type="button" onclick='cancelNew_Input("changeMail")'></button>
							</form>
					</div>
					
					<div class="row" style="display: flex; width: 80vw; flex-direction: column; position: relative; margin-bottom: 2%;">
						<button class="glyphicon glyphicon-pencil" type="button" id="btnLeft" onclick='new_Input("changePasswort")'></button>
						<p class="text-1">Passwort aendern</p>
							<form id="changePasswort" method="post" action="?pw=1" style="display: none">
								<p class="text-2">bitte passwort bestätigen:</p>
								<input class="text-3" type="password" name="passwortAlt" required>
								<p class="text-2">neues Passwort:</p>
								<input class="text-3" type="password" name="newPasswort1" required>
								<p class="text-2">neues Passwort bestaetigen:</p>
								<input class="text-3" type="password" name="newPasswort2" required>
								<button class="glyphicon glyphicon-ok" type="submit" name="submit_newPasswort" value="ok"></button>
								<button class="glyphicon glyphicon-remove" type="button" onclick='cancelNew_Input("changePasswort")'></button>
							</form>
					</div>

			<!--		<div class="row" style="display: flex; width: 80vw; flex-direction: column; position: relative;">
						<div class="row text-1" style="margin-top: 2%;">
							<a href="profil.php"><button type="button" id="btnLeft2">Alle Daten bearbeiten</button></a>
						</div> 
						<div class="row text-1" style="margin-top: 2%;">
							<button type="button" id="btnLeft2" onclick='new_Input("changePasswort")'>Passwort aendern</button>
							<form id="changePasswort" method="post" action="?pw=1" style="display: none">
								<p>bitte passwort bestätigen:</p>
								<input type="password" name="passwortAlt" required>
								<p>neues Passwort:</p>
								<input type="password" name="newPasswort1" required>
								<p>neues Passwort bestaetigen:</p>
								<input type="password" name="newPasswort2" required>
								<button class="glyphicon glyphicon-ok" type="submit" name="submit_newPasswort" value="ok"></button>
								<button class="glyphicon glyphicon-remove" type="button" onclick='cancelNew_Input("changePasswort")'>Abbrechen</button>
							</form>
						</div>
						<div class="row text-1" style="margin-top: 2%;">
// es fehlt noch der $type, sonst kommt man nicht wieder zurück auf diese Seite //
							<a href="vertragspartner.php"><dd>
							<button class="btnLeft" type="button" id="btnLeft2">Partner hinzufügen</button></a>
							<div id="test"></div>
						</div> -->
						
					
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
		</div>
	</div>
	<!-- Javascript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script>
</body>

</html>
