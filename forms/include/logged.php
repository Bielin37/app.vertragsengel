<?php

	//random zeichenfolge um cookies zu füllen
	function rndCode() {
        if (phpversion() == '5.6.36') {
			$bytes = openssl_random_pseudo_bytes(16, $cstrong);
			return bin2hex($bytes);
		} else {
			return bin2hex(random_bytes(16));
		}
    }

    //ein user ist nicht eingeloggt, und die cookies sind gesetzt
	if(!isset($_SESSION['userID']) && isset($_COOKIE['identifier']) && isset($_COOKIE['security'])) {
		
		$statement = $pdo->prepare("SELECT * FROM user_securitytoken WHERE Identifier = ?");
		$statement->execute(array($_COOKIE['identifier']));
		$security = $statement->fetch();

		//pruefen ob der security-token der richtige ist
		if(sha1($_COOKIE['security']) !== $security['Securitytoken']) {
			// echo sha1($_COOKIE['security'])."<br>";
			// echo ($_COOKIE['security'])."<br>";
			die('Falscher Securitytoken!');
		
		//wenn ja, dann cookies neu setzen bzw nutzer einloggen	
		} else {
			$securityNew = rndCode();
			$statementInsert = $pdo->prepare("UPDATE user_securitytoken SET Securitytoken = ? WHERE Identifier = ".$_COOKIE['identifier']);
			$statementInsert->execute(array($securityNew));
			$id = $_COOKIE['identifier'];
			setcookie("identifier", $id, time()+3600*24*7*365);
            setcookie("security", $securityNew, time()+3600*24*7*365); 
			$_SESSION['userID'] = $security['ID'];
		}
	}
	if(!isset($_SESSION['userID'])) {
		die("bitte einloggen!");
	}
?>