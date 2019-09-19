<!DOCTYPE html>
<html lang="de">

<head>    
	<style>

		#telefon, #mobil, #name, #vorname,
		#strasse, #plz, #ort{
			height: 30%;
			width: 80%;
			margin-left: 2%;
			margin-bottom: 3%;
			border: 1px solid #383838;
			padding-left: 2%;
			
		}
	</style>
	</head>

</br>
<p>Name</p>
<input type="text" id="name" name="name" placeholder="Mustermann" required>

</br>
<p>Vorname</p>
<input type="text" id="vorname" name="vorname" placeholder="Max" required>

</br>
<p>Telefonnummer</p>
<input type="text" id="telefon" name="telefon" placeholder="inklusive Vorwahl">

</br>
<p>Mobilfunknummer</p>
<input type="text" id="mobil" name="mobil" placeholder="inklusive Vorwahl">


</br>
<p>Strasse</p>
<input type="text" id="strasse" name="strasse" placeholder="inklusive Hausnummer">


</br>
<p>Postleitzahl</p>
<input type="text" id="plz" name="plz" placeholder="hjh">

</br>
<p>Ort</p>
<input type="text" id="ort" name="ort" placeholder="hhh">

</br>
<p>Geburtsdatum</p>
<input type="date" id="geburtsdatum" name="geburtsdatum" value="<?php echo date('Y-m-d'); ?>" required>

</br>
<p>beruflicher Status</p>
<select id="beruf" name="beruf" placeholder="bitte wählen..." required onclick="newInput()">
	<option value="angestellt">angestellt</option>
	<option value="selbstständig">selbstständig</option>
	<option value="arbeitssuchend">arbeitssuchend</option>
	<option value="sonstiges">sonstiges</option> 
</select>
<input type="hidden" id="hiddenBeruf" name="altberuf" placeholder="bitte Beruf eingeben">
