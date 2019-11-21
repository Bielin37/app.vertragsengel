<?php
	//verwendete Variablen:
	//
	//
	//

	//Session wird gestartet
	session_start();
	//Anmeldung in der Datenbank
	try {
		// http://php.net/manual/de/pdo.connections.php
		$pdo = new PDO('mysql:host=127.0.0.3; dbname=db385776_41', 'db385776_41', 'Datenbank41!');
	} catch (PDOException $e) {
		echo 'Verbindung fehlgeschlagen';
		// Exception nur ausgeben, wenn getestet wird, sonst werden fuer jeden sichtbar alle Verbindungsdaten inklusive Passwort ausgegeben
		// echo $e->getMessage();
		exit;
	}


	$sparten = [1 =>'strom',2 =>'gas',3 =>'mobilfunk',4 =>'tv',5 =>'internet',6 =>'krankenkasse'];
	
	// Liste von Daten, die nicht in der details.php angezeigt werden sollen
	$blacklist = [
		"AnbieterCheck", "ID","Engel_Oekostrom", "Engel_Preisgarantie", "Engel_Kuendigungsfrist", "Engel_Zahlweise",
		"Engel_Neukundenbonus"
	];
?>