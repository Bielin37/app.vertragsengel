<?php
    include('../db/database.php');
	header('refresh:3, page-login.php');
	if(!isset($_GET['code'])) {
		die("Dein Bestätigungscode ist falsch! Du wirst in kürze weitergeleitet...");
	} else {
		$code = ($_GET['code']);
		$statement = $pdo->prepare("SELECT * FROM user_passwort WHERE Bestaetigung = ?");
		$codeDb = $statement->execute(array($code));
		$codeDb = $statement->fetch();
		if($code == $codeDb['Bestaetigung']) {
			$statement = $pdo->prepare("UPDATE user_passwort SET Bestaetigung = ? WHERE ID = ?");
			$statement = $statement->execute(array("1", $codeDb['ID']));
		}
		echo "<script type=text/javascript>";
		echo "alert('Deine Registrierung ist jetzt abgeschlossen, viel Spaß mit unserer App.')";
		echo "</script>";
	}
?>
