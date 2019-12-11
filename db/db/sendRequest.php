<?php
	//Session starten
	session_start();
	//Pruefung ob ein Nutzer eingeloggt ist	
	include('../forms/include/logged.php');
	//Sparten-Array 
	$sparten = [1 =>'strom',2 =>'gas',3 =>'mobilfunk',4 =>'tv',5 =>'internet'];
	//Anmeldung Datenbank
	try {
		$pdo = new PDO('mysql:host=127.0.0.3; dbname=db385776_41', 'db385776_41', 'Datenbank41!');
	} catch (PDOException $e) {
		echo 'Verbindung fehlgeschlagen';
		// Exception nur ausgeben, wenn getestet wird, sonst werden fuer jeden sichtbar alle Verbindungsdaten inklusive Passwort ausgegeben
		// echo $e->getMessage();
		exit;
	}

	//Funktion, die das verzögerte Weiterleiten auf andere Seiten ermöglicht
	//dient hauptsächlich Testzwecken
	function holding() {
		header("refresh:0; ../vertragsUebersicht.php");
	}
	
	// es wird geprüft ob der Nutzer bei den Engeln einen Auswahl vorgenommen hat, wenn nicht wird der Wert auf 0 gesetzt
	// gibt am Ende ein Array $engel mit den Werten für die 5 Engel-Fragen aus
	// $n ist die Anzahl der Engel-Fragen....sollten es zukünftige mehr oder weniger als 5 sein, einfach weiter unten anpassen
	function engelAuswahl($n){	
		$engel = [];
		for ($i=1;$i<=$n;$i++) {
			if (isset($_POST['engel'.$i])) {
				$engel[] = $_POST['engel'.$i];
			} else {
				$engel[] = 0;
			}
		}
		return $engel;
	}
	
	//Nutzer kann Straßenname + Hausnummer zusammen eingeben, Eingabe muss aber nachträglich getrennt werden, da Information in 2 verschiedene Datenbank-Tabellen abgelegt wird
	//TODO Straßennamen von Mannheim (D4 3) 
	function parse_street_number($address) {
		preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $address, $match);
		$street = new StdClass();
		if (count($match) == 0) {
			$street->street = $address;
			$street->street_number = "";
		} else {
			$street->street = $match[1];
			$street->street_number = $match[2];
		}
		return $street;
	}
	
	function sendRequestDeleteVertragspartner($pdo) {
		holding();
		$statementVertragspartnerID = $pdo->prepare(
			"SELECT VertragspartnerID FROM user_vertragspartner WHERE UserID = ".$_SESSION['userID']." LIMIT ".$_POST['vertragspartnerDelete'].", 1");
		$statementVertragspartnerID->execute(array());
		$toDelete = $statementVertragspartnerID->fetch();		
				
		$statementDelete = $pdo->prepare(
			"DELETE FROM vertragspartner WHERE ID = ".$toDelete[0]);
		if (!$statementDelete->execute(array())) {
			echo "Error\n";
		};
		$statementDelete = $pdo->prepare(
			"DELETE FROM user_vertragspartner WHERE VertragspartnerID = ".$toDelete[0]);
		if (!$statementDelete->execute(array())) {
			echo "Error\n";
		};
		
	}

	//erstellt Array $dataArray, das Arrays bestehend aus den Werten $data + $type für jedes hochzuladende Bild
	//gleichzeitig wird geprüft ob Datei im erlaubten Format vorliegt
	function getVertragsbilderArray() {
		//array bestimmt alle zugelassenen Dateitypen
		$arrayDateitypPruef = array("image/png", "image/jpg", "image/jpeg", "image/pdf", "image/gif");
		$dataArray = [];
		for ($i=0;$i<20;$i++) {
			//datei ist im verzeichniss und typ ist jpg/png/jpeg/pdf/gif
			if(isset($_FILES['fileInput']['tmp_name'][$i]) && in_array($_FILES['fileInput']['type'][$i], $arrayDateitypPruef)) {
				echo "datei ".$i." ist ".$_FILES['fileInput']['name'][$i]." + ".$_FILES['fileInput']['type'][$i]."<br>";	  
				$tmpname 	= $_FILES['fileInput']['tmp_name'][$i];
				$type 		= $_FILES['fileInput']['type'][$i];
				$hndFile = fopen($tmpname, "r");	
				$data = addslashes(fread($hndFile, filesize($tmpname)));
				$dataArray[$i] = [$data,$type];
			}
			//datei ist im verzeichniss aber vom falschen typ 
			else if(!empty($_FILES['fileInput']['tmp_name'][$i]) && (!in_array($_FILES['fileInput']['type'][$i], $arrayDateitypPruef))) {
				$dataArray[$i] = [null, null];
				echo $_FILES['fileInput']['name'][$i]." hat keinen gültigen Dateitypen (jpg, pdf, png, gif) und wird nicht gespeichert <br>";
			} 
			//alles andere
			else {
				$dataArray[$i] = [null,null];
				echo "datei ".$i." ist leer <br>";
			}
		}
		return $dataArray;
	}
	//$string enthält Namen der Tabelle
	//generiert sql-statement für die entsprechenden Spartentabellen
	function getInsertIntoVertragsbilder($string) {
		return "INSERT INTO vertragsbilder_".$string." 
				(ID, 
				Data_01, Type_01, Data_02, Type_02,
				Data_03, Type_03, Data_04, Type_04,
				Data_05, Type_05, Data_06, Type_06,
				Data_07, Type_07, Data_08, Type_08,
				Data_09, Type_09, Data_10, Type_10,
				Data_11, Type_11, Data_12, Type_12,
				Data_13, Type_13, Data_14, Type_14,
				Data_15, Type_15, Data_16, Type_16,
				Data_17, Type_17, Data_18, Type_18,
				Data_19, Type_19, Data_20, Type_20) VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
				 ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
				 ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
				 ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
				 ?)";
	}
	
	//$string enthält Sparte des Vertrags, $pdo ist für die Datenbankanmeldung nötig (siehe Zeile 10)
	//schreibt die Bilder (Data/Type) in die Datenbank 
	function bildWrite($string, $pdo) {
		// getVertragsID aus DB
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		//IDs absteigend sortiert, mit limit das erste element ausgegeben (sozusagen letzter Vertrag)
		$statementVertragsID = $pdo->prepare("SELECT ID FROM vertrag_".$string." ORDER BY ID DESC LIMIT :limit");
		$statementVertragsID->execute(array('limit' => 1));
		$vertragsID = '';
		while ($vertragsIDTemp = $statementVertragsID->fetch()) {
			$vertragsID = $vertragsIDTemp['ID'];
		}
		//gibt es dateien für die Datenbank? (Bildupload)	
		if(empty($_FILES['fileInput']['tmp_name'][0])) {
			echo ("<p>kein Fileupload</p>");
			return false;
		}
		else {

			$dataArray = getVertragsbilderArray(); 	
			// Bilder in DB schreiben		
			$statementInsertDataArray = $pdo->prepare(getInsertIntoVertragsbilder($string)); 
			$statementInsertDataArray->execute(array('',
			$dataArray[0][0], $dataArray[0][1],$dataArray[1][0], $dataArray[1][1],
			$dataArray[2][0], $dataArray[2][1],$dataArray[3][0], $dataArray[3][1],
			$dataArray[4][0], $dataArray[4][1],$dataArray[5][0], $dataArray[5][1],
			$dataArray[6][0], $dataArray[6][1],$dataArray[7][0], $dataArray[7][1],
			$dataArray[8][0], $dataArray[8][1],$dataArray[9][0], $dataArray[9][1],
			$dataArray[10][0], $dataArray[10][1],$dataArray[11][0], $dataArray[11][1],
			$dataArray[12][0], $dataArray[12][1],$dataArray[13][0], $dataArray[13][1],
			$dataArray[14][0], $dataArray[14][1],$dataArray[15][0], $dataArray[15][1],
			$dataArray[16][0], $dataArray[16][1],$dataArray[17][0], $dataArray[17][1],
			$dataArray[18][0], $dataArray[18][1],$dataArray[19][0], $dataArray[19][1]));
			
			//ID aus bildtabelle holen
			$statementBildID = $pdo->prepare("SELECT ID FROM vertragsbilder_".$string." ORDER BY ID DESC LIMIT :limit");
			$statementBildID->execute(array('limit' => 1));
			$bildID = $statementBildID->fetch()[0]; //mal sehen ob das geht...
			//vermerk in zwischentabelle vertragsid/bildid schreiben
			$statement = $pdo->prepare("INSERT INTO vertrag_vertragsbilder_".$string." (VertragsID, BildID) VALUES (?,?)");
			$statement->execute(array($vertragsID, $bildID));

			return true;
		}
	}
	
	//$pdo für Datenbankanmeldung (siehe Zeile 10), $type = Nummer der Vertragssparte
	//neu angelegte Verträge werden in den entsprechenden Datenbanken abgelegt, verarbeitet die Inputfelder der Vertragsformulare
	//muss mit zunehmender Anzahl an Vertragssparten entsprechend erweitert werden
	function insertNewVertrag($pdo, $type) {
        holding();
		//Basis Daten        
		//Vertragspartner 
		if ($_POST['vertragspartner'] != 'ich selbst') {
            $statement = $pdo->prepare("SELECT ID FROM vertragspartner WHERE E_Mail = ?");
            $statement->execute(array($_POST['vertragspartner']));
            $vertragspartner = $statement->fetch();
        } else {
            $vertragspartner[0] = NULL;
        }            
        //Anbieter
		$anbieter  			= $_POST['anbieter'];
		//Notiz
		$notiz				= $_POST['notiz'];

		//Krankenkassevertraege werden ohne Kundennummer, Kosten, Vertragsende und Kuendigungsstatus erfasst
		if ($type !== 6) {
			$kundennummer 		= $_POST['kundennummer'];
			$kosten 			= str_replace(',','.',$_POST['kosten']);
			$vertragsende 		= $_POST['vertrag'];
			$vertragsanfang		= $_POST['vertragsanfang'];
			if (isset($_POST['gekuendigt'])) {
				$gekuendigt = true;
			} else {
				$gekuendigt = false;
			}
			
		}

		//Pruefung ob der Anbieter bereits in der Datenbank enthalten
		$statementIsAnbieter = $pdo->prepare(
			"SELECT * FROM anbieter WHERE Name = :Name AND Sparten LIKE '%.$type.%'");
		$statementIsAnbieter->execute(array('Name' => $anbieter));
		if (!$statementIsAnbieter->fetch()) {
            // wenn nicht, in anbieter_temporary einfuegen
            $statementInsertTemp = $pdo->prepare(
                "INSERT INTO anbieter_temporary (ID, Name, Sparte) VALUES (?,?,?)");
            $statementInsertTemp->execute(array('', $anbieter, $type));
            //anbieterCheck auf 1 setzen (d.h. Ueberpruefung durch Mitarbeiter noetig)
            $anbieterCheck = 1;
        } else {
            $anbieterCheck = 0;
        }

        //$type == 1 kann als Vorlage für alle weiteren $type > 1 verwendet werden
        if ($type == 1) {   // Strom
        	//$string wird zum Festlegen der Zieltabelle verwendet
			$string = "strom";
            $zaehlernummer   = $_POST['zaehlernummer'];
            $verbrauch       = $_POST['verbrauch'];
			$engel = engelAuswahl(5);
            $sqlInsertString = 
                "INSERT INTO vertrag_strom (ID, Vertragspartner, Anbieter, AnbieterCheck, Kundennummer, Zaehlernummer, Kosten, Notiz, Verbrauch, Vertragsende, Gekuendigt,
                Engel_Oekostrom, Engel_Preisgarantie, Engel_Kuendigungsfrist, Engel_Zahlweise, Engel_Neukundenbonus) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $statement = $pdo->prepare($sqlInsertString);
            $statement->execute(array('', $vertragspartner[0], $anbieter, $anbieterCheck, $kundennummer, $zaehlernummer, $kosten, $notiz, $verbrauch, $vertragsende, $gekuendigt, $engel[0], $engel[1], $engel[2], $engel[3], $engel[4]));
            //Kuendigungstatus wird in user_vertrag_* angepasst
            $statementKuendigung = $pdo->prepare("INSERT INTO user_vertrag_strom Gekuendigt = ?");
            $statementKuendigung->execute(array($gekuendigt));

            //Bilder, wenn vorhanden, werden abgelegt (Zeile 120)
            bildWrite($string,$pdo);
        }
		
        if ($type == 2) {   // Gas
			$string = "gas";
            $zaehlernummer   = $_POST['zaehlernummer'];
            $verbrauch       = $_POST['verbrauch'];
			$engel = engelAuswahl(5);
            $sqlInsertString = 
                "INSERT INTO vertrag_gas (ID, Vertragspartner, Anbieter, AnbieterCheck, Kundennummer, Zaehlernummer, Kosten, Notiz, Verbrauch, Vertragsende, Gekuendigt,
                Engel_Oekostrom, Engel_Preisgarantie, Engel_Kuendigungsfrist, Engel_Zahlweise, Engel_Neukundenbonus) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $statement = $pdo->prepare($sqlInsertString);
            $statement->execute(array('', $vertragspartner[0], $anbieter, $anbieterCheck, $kundennummer,
                    $zaehlernummer, $kosten, $notiz, $verbrauch, $vertragsende, $gekuendigt, $engel[0], $engel[1], $engel[2], $engel[3], $engel[4]));  

            bildWrite($string,$pdo);
		}
		
        if ($type == 3) {   // Mobilfunk
			$string = "mobilfunk";
			$engel = engelAuswahl(5);
            $sqlInsertString = 
                "INSERT INTO vertrag_mobilfunk (ID, Vertragspartner, Anbieter, AnbieterCheck, Kundennummer, Kosten, Notiz, Vertragsende, Gekuendigt,
                Engel_Netzqualitaet, Engel_ALLNetFlat, Engel_SMSFlat, Engel_InternetFlat, Engel_Handyversicherung) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $statement = $pdo->prepare($sqlInsertString);
            $statement->execute(array('', $vertragspartner[0], $anbieter, $anbieterCheck, $kundennummer,
                    $kosten, $notiz, $vertragsende, $gekuendigt, $engel[0], $engel[1], $engel[2], $engel[3], $engel[4]));  
		
            bildWrite($string,$pdo);
		}
				
        if ($type == 4) {   // TV
			$string = "tv";
			$tarif = $_POST['tarif'];
			$engel = engelAuswahl(5);
            $sqlInsertString = 
                "INSERT INTO vertrag_tv (ID, Vertragspartner, Anbieter, AnbieterCheck, Kundennummer, Kosten, Tarif, Notiz, Vertragsende, Gekuendigt,
                Engel_HD, Engel_FilmeSerien, Engel_Fussball, Engel_Kinder, Engel_Dokumentationen, Vertragsanfang)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $statement = $pdo->prepare($sqlInsertString);
            $statement->execute(array('', $vertragspartner[0], $anbieter, $anbieterCheck, $kundennummer,
                    $kosten, $tarif, $notiz, $vertragsende, $gekuendigt, $engel[0], $engel[1], $engel[2], $engel[3], $engel[4], $vertragsanfang));  
		
            bildWrite($string,$pdo);
		}
						
        if ($type == 5) {   // Internet
			$string = "internet";
			$tarif = $_POST['tarif'];
			$engel = engelAuswahl(5);
            $sqlInsertString = 
                "INSERT INTO vertrag_internet (ID, Vertragspartner, Anbieter, AnbieterCheck, Kundennummer, Kosten, Tarif, Notiz, Vertragsende, Gekuendigt,
                Engel_Nutzung, Engel_WLAN, Engel_Festnetz, Engel_Mobilfunknetz, Engel_Streaming)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $statement = $pdo->prepare($sqlInsertString);
            $statement->execute(array('', $vertragspartner[0], $anbieter, $anbieterCheck, $kundennummer,
                    $kosten, $tarif, $notiz, $vertragsende, $gekuendigt, $engel[0], $engel[1], $engel[2], $engel[3], $engel[4]));  
		
            bildWrite($string,$pdo);
		}

		if ($type == 6) {	//Krankenkasse
			$string = "krankenkasse";
			$art = $_POST['art']; 

			if (isset($_POST['bonus'] )) { 
				$jahresbonus = true;	
			} else { 
				$jahresbonus = false; 
			}
			if (isset($_POST['zusatz'] )) { 
				$zusatzversicherung = true; 
			} else { 
				$zusatzversicherung = false;
			}
			
			$engel = engelAuswahl(5);
            $sqlInsertString = 
                "INSERT INTO vertrag_krankenkasse (ID, Vertragspartner, Anbieter, AnbieterCheck, Art,  
									   Zusatzversicherung, Jahresbonus, Notiz, 
						Engel_ZuschussZahn, Engel_ZuschussBrille, Engel_StatusPrivat, Engel_Alternativ, Engel_Vorsorgeimpfung) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $statement = $pdo->prepare($sqlInsertString);
            $statement->execute(array('', $vertragspartner[0], $anbieter, $anbieterCheck, $art,
                    $zusatzversicherung, $jahresbonus, $notiz, $engel[0], $engel[1], $engel[2], $engel[3], $engel[4]));  	

            bildWrite($string, $pdo);
		}
		
		// Insert into user_vertrag_typ
		//$string wird in den vorhergehnden if-schleifen festgelegt
		$statement = $pdo->prepare("INSERT INTO user_vertrag_".$string." (ID, VertragsID) VALUE (?,?)");
		$statement->execute(array($_SESSION['userID'],''));	
        
    }

	//notwendig zur Erfassung der Inputfelder aus dem Formular /forms/profil.php
	function sendRequestProfil($pdo){
		header("refresh:5; ../forms/pDaten.php");
		
		if(isset($_POST['beruf']) && $_POST['beruf'] != 'sonstiges') {
			$beruf	 		= $_POST['beruf'];
		}else if(isset($_POST['altberuf'])) {
			$beruf 			= $_POST['altberuf'];
		}

		$strasseTemp = parse_street_number($_POST['strasse']);		
		$strasse = $strasseTemp->street;
		$hausnummer = $strasseTemp->street_number;	

		$i = 1;
		$kinderTemp = array();
		if (isset($_POST['field'.$i])) {
			do {
				$kinderTemp[] = $_POST['field'.$i];
				$i++;
			} while (isset($_POST['field'.$i]));
		};
		$kinder = implode(',',$kinderTemp);

		//E-Mail kann nicht über dieses Formular geändert werden
		//$email				= $_POST['email'];
		
		// SQL UPDATE 
		$sqlUpdateString = 
            "UPDATE user SET 
                (Nachname = ?, Vorname = ?, Geburtsdatum = ?, Beruf = ?, Telefon = ?, Mobil = ?,
                 Strasse = ?, Hausnummer = ?, PLZ = ?, Kinder = ?, BeraterID = ?) 
            WHERE ID = ".$_SESSION['userID'];
            
		$statement = $pdo->prepare($sqlUpdateString);
		$statement->execute(array($_POST['name'], $_POST['vorname'], $_POST['geburtsdatum'], $beruf, $_POST['telefon'], $_POST['mobil'], $strasse, $hasunummer, $_POST['plz'], $kinder, $_POST['beraterID']));

		isPLZ($pdo,$_POST['plz'],$_POST['ort']);    //Abfrage ob PLZ schon in der Datenbank (Zeile 435)
	}
	
	//erfasst Daten aus Inputfeldern /forms/vertragspartner.php zum Anlegen neuer Vertragspartner
	function sendRequestVertragspartner($pdo){
		if (isset($_POST['type'])) {
			header("refresh:2; ../forms/".$_POST['type'].".php");
		} else {
			header("refresh:2; ../forms/pDaten.php");
		}
		if(isset($_POST['beruf']) && $_POST['beruf'] != 'sonstiges') {
			$beruf	 		= $_POST['beruf'];
		}else if(isset($_POST['altberuf'])) {
			$beruf 			= $_POST['altberuf'];
		}

		$strasseTemp = parse_street_number($_POST['strasse']);		
		$strasse = $strasseTemp->street;
		$hausnummer = $strasseTemp->street_number;
		
		$email				= $_POST['email'];
		
		// SQL INSERT in vertragspartner
		$statementInsert = $pdo->prepare(
			"INSERT INTO vertragspartner (ID, Nachname, Vorname, E_Mail, Geburtsdatum,  
									   Beruf, Telefon, Mobil, Strasse, Hausnummer, PLZ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$statementInsert->execute(array('', $_POST['name'], $_POST['vorname'], $email, $_POST['geburtsdatum'], $beruf, $_POST['telefon'], $_POST['mobil'], $strasse, $hausnummer, $_POST['plz']));
		// SQL INSERT in user_vertragspartner
		$statement = $pdo->prepare("INSERT INTO user_vertragspartner (UserID, VertragspartnerID) VALUES (?, ?)");
		$statement->execute(array($_SESSION['userID'], ''));
		// SQL INSERT in ort
		isPLZ($pdo, $_POST['plz'], $_POST['ort']);   // Abfrage ob PLZ schon in der Datenbank (Zeile 435)
	}
	
	// TODO EMAIL
	function sendRequestVertragspartnerUpdate($pdo){
		header("refresh:5; ../forms/pDaten.php");
		$vpID = $_POST['VertragspartnerID'];
		
			echo "Foglende NutzerID wird bearbeitet: ".$_POST['VertragspartnerID'];
		
		$nachname 			= $_POST['name'];
		$vorname  			= $_POST['vorname'];
		$geburtsdatum 		= $_POST['geburtsdatum'];
		if(isset($_POST['beruf']) && $_POST['beruf'] != 'sonstiges') {
			$beruf	 		= $_POST['beruf'];
		}else if(isset($_POST['altberuf'])) {
			$beruf 			= $_POST['altberuf'];
		}
		$telefon 			= $_POST['telefon'];
		echo $telefon;
		echo "<br>";
		echo $_POST['telefon'];
		$mobil 			= $_POST['mobil'];
		//$email				= $_POST['email'];

		$strasseTemp = parse_street_number($_POST['strasse']);		
		$strasse = $strasseTemp->street;
		$hausnummer = $strasseTemp->street_number;	
		
		$plz				= $_POST['plz'];
		$ort				= $_POST['ort'];

		// SQL UPDATE 
		$statement = $pdo->prepare("UPDATE vertragspartner SET 
                Nachname = ?, Vorname = ?, Geburtsdatum = ?, Beruf = ?, Telefon = ?, Mobil = ?,
                Strasse = ?, Hausnummer = ?, PLZ = ? WHERE ID = ?");
		$statement->execute(array($nachname, $vorname, $geburtsdatum, $beruf, $telefon, $mobil, $strasse, $hausnummer, $plz, $vpID)); 
        isPLZ($pdo, $_POST['plz'], $_POST['ort']); // Abfrage ob PLZ schon in der Datenbank (Zeile 435)
	}

/*
*   Abfrage ob PLZ schon in der Datenbank
*	Wenn nicht, entsprechend mit Ort ablegen 
*   isPLZ(+$pdo,+$PLZ)
*/
    function isPLZ($pdo, $plz, $ort) {
		$statement = $pdo->prepare("SELECT * FROM postleitzahl WHERE PLZ = ".$plz);
		$statement->execute(array());
		$data = $statement->fetch();
		if (empty($data)) {
			$statement = $pdo->prepare("INSERT INTO postleitzahl (Ort, PLZ) VALUES (?,?)");
			$statement->execute(array($ort, $plz));
        }
    }

/*
*   Aendere Daten fuer beliebige Typen /forms/pDaten.php
*   sendRequest(+$pdo, ?$typen)
*/
    function sendRequestChange($pdo) {
        header("refresh:0; ../forms/pDaten.php");
        //array mit allen übergebenen Parametern, das dann auf seine ganze Laenge nach Stichworten durchsucht wird
        //bei Uebereinstimmung wird der entsprechende Wert geändert
        $type = func_get_args();
        for ($i=1;$i<count($type);$i++) {
            if ($type[$i] == 'Strasse') {
                $temp = parse_street_number($_POST['newStrasse']);
                $value = $temp->street;
            } else if ($type[$i] == 'Hausnummer') {
                $temp = parse_street_number($_POST['newStrasse']);
                $value = $temp->street_number;
            } else if ($type[$i] == 'PLZ'){
                isPLZ($pdo,$_POST['newPLZ'],$_POST['newOrt']);
                $value = $_POST['newPLZ'];
            } else if ($type[$i] == 'Beruf') {
                if(isset($_POST['beruf']) && $_POST['beruf'] != 'sonstiges') {
                    $value = $_POST['beruf'];
                }else if(isset($_POST['altberuf'])) {
                    $value = $_POST['altberuf'];
                }
            } else if ($type[$i] == 'Kinder') {
                $i = 1;
                $kinderTemp = array();
                if (isset($_POST['field'.$i])) {
                    do {
                        $kinderTemp[] = $_POST['field'.$i];
                        $i++;
                    } while (isset($_POST['field'.$i]));
                };
                $value = implode(',',$kinderTemp);                
            } else {
                $value = $_POST['new'.$type[$i]];
            }
            $statement = $pdo->prepare("UPDATE user SET ".$type[$i]." = ? WHERE ID = ?");
            $statement->execute(array($value, $_SESSION['userID']));
        }
    }
	
	//submit im entsprechenden Formular ausgeloest + sessionid gesetzt (also Nutzer eingeloggt)
	
    //Pruefung ob nicht eingeloggt
	if(!isset($_SESSION['userID'])) {
		die('Bitte zuerst <a href="../page-login.php"><button type="button" id="loginBt">einloggen</button></a> beziehungsweise <a href="register.php"><button type="button" id="registerBt">registrieren</button></a>.');	
	} else {
	
//Formulare (1Strom.php, 2Gas.php, .... etc.)
// A*******************************************************************************************************************
		// STROM
		if(isset($_POST['submit_strom'])) {
			insertNewVertrag($pdo, 1);
		}
		//GAS
		if(isset($_POST['submit_gas'])) {
			insertNewVertrag($pdo, 2);
		}
		//MOBILFUNK
		if(isset($_POST['submit_mobilfunk'])) {
			insertNewVertrag($pdo, 3);
		}
		//TV
		if(isset($_POST['submit_TV'])) {
			insertNewVertrag($pdo, 4);
		}
		//INTERNET/FESTNETZ
		if(isset($_POST['submit_internet'])) {
			insertNewVertrag($pdo, 5);
		}
		//KRANKENKASSE
		if(isset($_POST['submit_krankenkasse'])) {
			insertNewVertrag($pdo, 6);
		}

// E*******************************************************************************************************************

		//PROFIL
		if(isset($_POST['submit_profil'])) {
			sendRequestProfil($pdo);
		}
		//Vertragspartner hinzufügen
		if(isset($_POST['submit_vertragspartner'])) {
			sendRequestVertragspartner($pdo);
		}

//pDaten.php
// A*******************************************************************************************************************
		//User Name aendern
		if(isset($_POST['submit_newName'])) {
			sendRequestChange($pdo,'Nachname','Vorname');
		}
		//User Anschrift aendern
		if(isset($_POST['submit_NewAnschrift'])) {
			sendRequestChange($pdo,'Strasse','Hausnummer','PLZ');
		}
		//User Geburtstag aendern
		if(isset($_POST['submit_NewDate'])) {
			sendRequestChange($pdo,'Geburtsdatum');
		}
		//User Beruf aendern
		if(isset($_POST['submit_NewBeruf'])) {
			sendRequestChange($pdo,'Beruf');
		}
		//User Email aendern
		if(isset($_POST['submit_NewEmail'])) {
			sendRequestChange($pdo,'E_Mail');
		}
		//User Telefondaten aendern
		if(isset($_POST['submit_NewTelefon'])) {
			sendRequestChange($pdo,'Telefon','Mobil');
		}
		//User Kinder aendern
		if(isset($_POST['submit_NewKinder'])) {
			sendRequestChange($pdo,'Kinder');
        }
		//Vertragspartner loeschen
		if(isset($_POST['vertragspartnerDelete'])) {
			sendRequestDeleteVertragspartner($pdo);
		} 
		//Vertragspartner editieren
		if(isset($_POST['submit_vertragspartnerEdit'])) {
			sendRequestVertragspartnerUpdate($pdo);
		}
// E*******************************************************************************************************************

// kuendigung.php
// A*******************************************************************************************************************	
	// Formulardaten werden erfasst, in Tabelle kuendigung gespeichert (1)
	// ID der letzten Kuendigung, also der gerade gespeicherten wird via SELECT in Variable gespeichert (2)
	// Werte aus $_SESSION['test'] (initalisiert in kuendigung.php) werden zusammen mit $lastID in user-kuendigung_vertrag gespeichert (3)
	// user_vertrag_"sparte" wird geupdatet (4)
	// Weiterleitung an kuendigung_pdf.php inklusive Informationen (GET) (5)

		//Kuendigung annehmen
		if(isset($_POST['signature'])) {
			
			//Daten in Kuendigung ablegen (1)
			$statement = $pdo->prepare("INSERT INTO kuendigung (ID, Unterschrift, Grund) VALUES (?,?,?)");
			$statement->execute(array('',$_POST['signature'], $_POST['grund']));

			//letzte KuendigungsID in $lastID speichern (2)
			$statement = $pdo->prepare("SELECT MAX(ID) FROM kuendigung");
			$statement->execute(array());
			$lastID = $statement->fetch();

			//Kuendigung mit User verbinden (3)
			$statement = $pdo->prepare("INSERT INTO user_kuendigung_vertrag (ID, Kuendigung, Vertrag, Sparte) VALUES (?,?,?,?)");
			$statement->execute(array($_SESSION['test']['user'], $lastID[0], $_SESSION['test']['vertragsID'], $_SESSION['test']['sparte'] ));

			//Vertragsstatus auf gekuendigt (0) setzen (4)
			$statement = $pdo->prepare("UPDATE user_vertrag_".$sparten[$_SESSION['test']['sparte']]." SET Status = ? WHERE VertragsID = ?");
			$statement->execute(array(false, $_SESSION['test']['vertragsID']));
			
			//Weiterleitung mit Variablen, die entsprechend von /forms/kuendigung_pdf.php aufgenommen werden (5)	
			header('refresh:0, ../forms/kuendigung_pdf.php?v0='.$_SESSION['test']['sparte'].'&v1='.$_SESSION['test']['vertragsID']);
			unset($_SESSION['test']);
		}
// E*******************************************************************************************************************

// VertragsAuswahl.php
// A*******************************************************************************************************************
		//Interesse-Vorsorge
		if(isset($_POST['submit_Vorsorge'])) {
			$statement = $pdo->prepare("UPDATE user_interessen SET Vorsorge = ? WHERE ID = ".$_SESSION['userID']);
			$statement->execute(array(1));
			header('refresh:0, ../vertragsAuswahl.php');
		}
		
		//Interesse-Versicherung
		if(isset($_POST['submit_Versicherung'])) {
			$statement = $pdo->prepare("UPDATE user_interessen SET Versicherung = ? WHERE ID = ".$_SESSION['userID']);
			$statement->execute(array(1));
			header('refresh:0, ../vertragsAuswahl.php');
		}
		//Interesse-Foerderung
		if(isset($_POST['submit_Foerderung'])) {
			$statement = $pdo->prepare("UPDATE user_interessen SET Foerderung = ? WHERE ID = ".$_SESSION['userID']);
			$statement->execute(array(1));
			header('refresh:0, ../vertragsAuswahl.php');
		}
		//Interesse-Policen
		if(isset($_POST['submit_Policen'])) {
			$statement = $pdo->prepare("UPDATE user_interessen SET Policen = ? WHERE ID = ".$_SESSION['userID']);
			$statement->execute(array(1));
			header('refresh:0, ../vertragsAuswahl.php');
		}
		//Sollte die Frage weggeklickt werden, Zeit updaten
		if(isset($_POST['cross'])) {
			$statement = $pdo->prepare("UPDATE user_interessen SET Last = NOW() WHERE ID = ".$_SESSION['userID']);
			$statement->execute(array());
			header('refresh:0, ../vertragsAuswahl.php');
		}
// E*******************************************************************************************************************
    }
?> 