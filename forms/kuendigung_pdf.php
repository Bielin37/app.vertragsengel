<?php
	
	include('include/tcpdf/tcpdf.php');
	include('../db/database.php');	

	//Vertragsdetails
	//Vertragssparten (v0) und VertragsID (v1) aus dem GET in Vertragsübersicht
	$statement 	= $pdo->prepare("SELECT * FROM vertrag_".$sparten[$_GET['v0']]." WHERE ID = ?");
	$statement->execute(array($_GET['v1']));
	$vertrag 	= $statement->fetch();

	//Kundendetails
	$statement 	= $pdo->prepare("SELECT * FROM user WHERE ID = ?");
	$statement->execute(array($_SESSION['userID']));
	$userDetail	= $statement->fetch();

	$geburtstag	= $userDetail['Geburtsdatum'];
	$telefon	= $userDetail['Telefon'];
	$adresse	= $userDetail['Strasse']." ".$userDetail['Hausnummer'];

	$statement	= $pdo->prepare("SELECT Ort FROM postleitzahl WHERE PLZ = ?");
	$statement->execute(array($userDetail['PLZ']));
	$ort 		= $statement->fetch();

	$statement 	= $pdo->prepare("SELECT * FROM kuendigung ORDER BY ID DESC LIMIT 1");
	$statement->execute(array());
	$signature = $statement->fetch();


// es fehlen noch alle Informationen zum Anbieter, da diese Datenbank noch nicht erschlossen wurde (Herr Schirner fragen)

	$html 		='
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
<tr>
	<td>'.$userDetail['Vorname'].' '.$userDetail['Nachname'].'<br>'.$adresse.'<br>'.$userDetail['PLZ'].' '.$ort[0].'<br>Kundennummer '.$vertrag['Kundennummer'].'</td>
	<td style="text-align: right">Datum: '.date('d.m.Y').'<br></td>
</tr>

<tr>
	<td colspan="2">Anbieter<br>AnbieterStrasse und Nummer<br>Anbieterplz und Ort</td>
</tr>
<br>

<tr>
	<td style="font-size:1.3em; font-weight: bold;"><br><br>Kündigung</td>
</tr>
</table>

<br>
'.$vertrag['grund'].' <br>
'.$userDetail['Vorname'].' '.$userDetail['Nachname'].'
<img src="'.$signature['Unterschrift'].'" />
';

// Erstellung des PDF Dokuments
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("vertragsengel");

// Header und Footer Informationen
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Auswahl des Font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Auswahl der MArgins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Automatisches Autobreak der Seiten
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Image Scale 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Schriftart
$pdf->SetFont('dejavusans', '', 10);

// Neue Seite
$pdf->AddPage();

// Fügt den HTML Code in das PDF Dokument ein
$pdf->writeHTML($html, true, false, true, false, '');

//Ausgabe der PDF

// Variante 1: PDF direkt an den Benutzer senden:
// $pdf->Output('Kuendigung', 'I');

//Variante 2: PDF im Verzeichnis abspeichern:
// $pdfName = 'Kündigung'.$vertrag['Anbieter'].'_id'.$vertrag['ID'].'.pdf';
// $pdf->Output(dirname(__FILE__).'/kuendigungen/'.$pdfName, 'F');
// echo 'PDF herunterladen: <a href="kuendigungen/'.$pdfName.'">'.$pdfName.'</a>';

//Variante 3: PDF-Datei in Datenbank ablegen
$pdfstring = $pdf->Output($pdfName, 'S');

$statement 	= $pdo->prepare("UPDATE kuendigung SET Datei = ? ORDER BY ID DESC LIMIT 1");
$statement->execute(array($pdfstring));


header('refresh:0, ../vertragsUebersicht.php');
?>