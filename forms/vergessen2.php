<?php
	include('../db/database.php');

	if(!isset($_GET['userid']) || !isset($_GET['code'])) {
	 	die("Leider wurde beim Aufruf dieser Website kein Code zum Zurücksetzen deines Passworts übermittelt");
	}
	 
	$userid = $_GET['userid'];
	$code = $_GET['code'];
	 
	//Abfrage des Nutzers
	$statement = $pdo->prepare("SELECT * FROM user_passwortvergessen WHERE ID = ?");
	$result = $statement->execute(array($userid));
	$user_code = $statement->fetch();	
	
	$statement = $pdo->prepare("SELECT * FROM user WHERE ID = ?");
	$result = $statement->execute(array($userid));
	$user = $statement->fetch();	



	//Überprüfe dass ein Nutzer gefunden wurde und dieser auch ein Passwortcode hat
	if($user === null || $user_code['Code'] === null) {
		die("Es wurde kein passender Benutzer gefunden");
	}
	 
	if($user_code['Zeit'] === null || strtotime($user_code['Zeit']) < (time()-24*3600) ) {
		die("Dein Code ist leider abgelaufen");
	}
	 
	//Überprüfe den Passwortcode
	if(sha1($code) != $user_code['Code']) {
		die("Der übergebene Code war ungültig. Stell sicher, dass du den genauen Link in der URL aufgerufen hast.");
	}
	 
	//Der Code war korrekt, der Nutzer darf ein neues Passwort eingeben
	 
	if(isset($_GET['send'])) {
		$passwort = $_POST['passwort'];
		$passwort2 = $_POST['passwort2'];
	 
		if($passwort != $passwort2) {
			echo "Bitte identische Passwörter eingeben";
		} else { //Speichere neues Passwort und lösche den Code
			$passworthash = password_hash($passwort, PASSWORD_DEFAULT);
			$statement = $pdo->prepare("UPDATE user_passwort SET Passwort = ? WHERE ID = ?");
			$result = $statement->execute(array($passworthash, $userid));
			$statement = $pdo->prepare("UPDATE user_passwortvergessen SET Code = NULL, Zeit = NULL WHERE ID = ?");
			$result = $statement->execute(array($userid));

			if($result) {
				header('refresh:2,../page-login.php');
				die("Dein Passwort wurde erfolgreich geändert");
			}
		}
	}

include('../forms/include/meta.php');

?>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box lockscreen clearfix">
					<div class="content">
						<h1 class="sr-only">Vertragsengel - Dein Vertragsmanager</h1>
						<div class="logo text-center"><img src="../img/logo2.png" alt="Vertragsengel Logo" width="200" height="90" ></div>
						<div class="user text-center">
							<h3 class="name">Neues Passwort vergeben</h3>
							<form action="?send=1&amp;userid=<?php echo htmlentities($userid); ?>&amp;code=<?php echo htmlentities($code); ?>" method="post">
								<p class="text-center text-primary">Bitte gib ein neues Passwort ein:</p>
							<div class="input-group">
								<input type="password" class="form-control" name="passwort">
								<p class="text-center text-primary">Passwort erneut eingeben:</p>
								<input type="password" class="form-control" name="passwort2">
								<button type="submit" value="Passwort speichern" class="btn btn-primary btn-lg btn-block">Passwort speichern</button>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>