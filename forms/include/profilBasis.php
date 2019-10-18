<!DOCTYPE html>
<html lang="de">

<head>    
	<style>
		.text-1{
			display: flex;
			margin-left: 4%;
		}
		#name, #vorname, #geburtsdatum, #beruf, #hiddenBeruf, #mobil, #telefon, #strasse, #plz, #ort{
			margin-left: 15%;
			border-radius: 5px 20px 5px;
  			border-color: #a4338a;
		}
		
		
	</style>
	</head>


<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
	<p class="text-1">Name:</p>
	<input type="text" id="name" name="name" placeholder="Mustermann" required>
</div>
<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
	<p class="text-1">Vorname:</p>
	<input type="text" id="vorname" name="vorname" placeholder="Max" required>
</div>
<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
	<p class="text-1">Telefonnummer:</p>
	<input type="text" id="telefon" name="telefon" placeholder="inklusive Vorwahl">
</div>
<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
	<p class="text-1">Mobilfunknummer:</p>
	<input type="text" id="mobil" name="mobil" placeholder="inklusive Vorwahl">
</div>

<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
	<p class="text-1">Strasse:</p>
	<input type="text" id="strasse" name="strasse" placeholder="inklusive Hausnummer">
</div>

<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
	<p class="text-1">Postleitzahl:</p>
	<input type="text" id="plz" name="plz" placeholder="14478">
</div>
<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
	<p class="text-1">Ort:</p>
	<input  type="text" id="ort" name="ort" placeholder="Potsdam">
</div>
<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
	<p class="text-1">Geburtsdatum:</p>
	<input type="date" id="geburtsdatum" name="geburtsdatum" value="<?php echo date('Y-m-d'); ?>" required>
</div>
<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
	<p class="text-1">Beruflicher Status:</p>
	<select id="beruf" name="beruf" placeholder="bitte wählen..." required onclick="newInput()">
		<option value="angestellt">angestellt</option>
		<option value="selbstständig">selbstständig</option>
		<option value="arbeitssuchend">arbeitssuchend</option>
		<option value="sonstiges">sonstiges</option> 
	</select>
	<input type="hidden" id="hiddenBeruf" name="altberuf" placeholder="bitte Beruf eingeben">
</div>