//Service Worker registrieren
///wird SW unterstuetzt?
// if ('serviceWorker' in navigator) {
// 	//wenn ja, dann registriere sw.js und bestaetige
// 	navigator.serviceWorker.register('sw.js')
// 	.then(function() {
// 		console.log('Service Worker registered');
// 	});
// }

var deferredPrompt;
//
window.addEventListener('beforeinstallprompt', function(event) {
	console.log('beforeinstallprompt fired');
	event.preventDefault();
	deferredPrompt = event;
	return false;
})

function a2hs() {
	if (deferredPrompt) {
		deferredPrompt.prompt();

		deferredPrompt.userChoice.then(function(choiceResult) {
			console.log(choiceResult.outcome);

			if (choiceResult.outcome === 'dismissed') {
				console.log('user canceled installation');
			} else {
				console.log('user added to HS');
			}
		});
	deferredPrompt = null; 
	}
}

// globale Variablien	
var n = 0;	// Bezeichner fuer FileInput
var fileArray = new Array();  //Array aus fileObjects
var nameArray = [];
formName = "";

// function engelPicture(+String)
function engelPicture(formName) {
	this.formName = formName;
	var engel = [];
	for (var i=1;i<6;i++) {
		engel = (document.getElementsByClassName('engelImage'+i));
	for (var n=0;n<engel.length;n++) {
		// Dateipfad 
		engel[n].setAttribute("src","../img/"+formName+"EngelUnchecked.png");
		}
	}
}

//aendert Farbe der Engel
//strom.php, gas.php, internet.php, mobilfunk.php, TV.php, krankenkasse.php 
function engelPicChangeList(string) {
	var count = document.getElementsByName(string);
	var x = 1;
	for(var i=0;i<4;i++) {
		if(count[i].checked) {			
			// Dateipfad
			document.getElementById(string+"_"+x).innerHTML = 
				"<input class=\"input_engel\" type=\"radio\" name=\""+string+"\" value=\""+x+"\" checked onchange=\"engelPicChangeList('"+string+"') \"><img class=\"engelImage"+x+"\" src=\"../img/"+formName+"EngelChecked.png\" >";
		} else {
			// Dateipfad 
			document.getElementById(string+"_"+x).innerHTML = 
				"<input class=\"input_engel\" type=\"radio\" name=\""+string+"\" value=\""+x+"\" onchange=\"engelPicChangeList('"+string+"')         \"><img class=\"engelImage"+x+"\" src=\"../img/"+formName+"EngelUnchecked.png\" >";
		}
		x++;
	}
}

//pruefen ob als Beruf "sonstiges" gewählt wurde und anschließend ein neues inputfeld erstellen
//sowie den required-wert entsprechend neu verteilen
//profilBasis.php
function newInput() {
	if(document.getElementById('beruf').value == "sonstiges") {
		document.getElementById('hiddenBeruf').setAttribute("type", "text");
		document.getElementById('hiddenBeruf').required = true; 
		document.getElementById('beruf').required = false; 
	}
	else {
		document.getElementById('hiddenBeruf').setAttribute("type", "hidden");
		document.getElementById('hiddenBeruf').required = false; 
		document.getElementById('beruf').required = true; 
	}
}

//fuegt inputfield entsprechend der Anzahl der Kinder hinzu 
//profil.php
function insertInputFieldChild(pform) {
	// Pruefe ob bereits Elemente vorhanden sind //
	var c = 1;
	if (document.getElementById('br'+c)) {
		do {
			var elemField = document.getElementById('field'+c)
			elemField.parentNode.removeChild(elemField);
			
			var elemBR = document.getElementById('br'+c);
			elemBR.parentNode.removeChild(elemBR);
			c++;
		} while (document.getElementById('br'+c));
		var elemButton = document.getElementById('buttonRemove');
		elemButton.parentNode.removeChild(elemButton);
	}
	
	var n = document.getElementById('anzahlKinder').value;
	// Wenn keine Eingabe Erfolgte //
	if (!(n == 0 || n == null)) {
		for (i=1;i<=n;i++) {
			var inputField = document.createElement("input");
			inputField.setAttribute("type","text");
			inputField.setAttribute("name","field"+i);
			inputField.setAttribute("id","field"+i);
			// inputField.setAttribute("class","kinderAnzahlEditField");
			inputField.setAttribute("placeholder",'Alter von Ihrem ' + i + '-ten Kind...');

			var br = document.createElement("br");
			br.setAttribute("id", "br"+i);
			document.getElementById(pform).appendChild(br);
			document.getElementById(pform).appendChild(inputField);
		}
		var removeButton = document.createElement("button");
		removeButton.setAttribute("type", "button");
		removeButton.setAttribute("name","buttonRemove");
		removeButton.setAttribute("id","buttonRemove");
		removeButton.appendChild(document.createTextNode("-"));
		removeButton.onclick = function() {removeInputFieldChild(n)};
		document.getElementById(pform).appendChild(removeButton);
	}
}

//entfernt inputfield Kinder
//profil.php
function removeInputFieldChild(n) {
	var elemField = document.getElementById('field'+n)
	elemField.parentNode.removeChild(elemField);
	
	var elemBR = document.getElementById('br'+n);
	elemBR.parentNode.removeChild(elemBR);
	
	n--;
	if (n > 0) { 
		var removeButton = document.getElementById('buttonRemove')
		removeButton.onclick = function() {removeInputFieldChild(n)};
	} else {
		var elemButton = document.getElementById('buttonRemove');
		elemButton.parentNode.removeChild(elemButton);
		
		document.getElementById('anzahlKinder').value = null;
		document.getElementById('anzahlKinder').placeholder = "Wie viele Kinder haben Sie?";
	}
}

// Loescht required-Attribut wenn Bilder ausgewaehlt worden sind
function removeRequireAttribute() {
	var matches = document.querySelectorAll('[required]');
	for (var i=0;i<matches.length; i++) {
		if ((matches[i].name != "kosten") && (matches[i].name != "verbrauch") && (matches[i].name != "gekuendigt")) {
			matches[i].required = false;
		}
	}
}

// Speichere Bilder aus InputFeld
// Generiere neues InputFeld
function savePart() {
	var string = "fileInput"+n;
	
	var fl = document.getElementById('fileInput'+n);

	if(fl) { 
		fl.addEventListener('change', alertFalseType, false); 
	}	
	var part = document.getElementById(string).files;
	for(var i=0,f;f=part[i];i++) {
		fileArray.push(f);
		nameArray.push(f.name);	
	}
	document.getElementById(string).style.display = "none";
	n++;
	
	string = "fileInput"+n;
	document.getElementById("cameraLabel").setAttribute("for",string);
	var newInputField = document.createElement("input");
		newInputField.setAttribute("name", "fileInput[]");
		newInputField.setAttribute("id", string);
		newInputField.setAttribute("type", "file");
		newInputField.setAttribute("multiple", "multiple");
		newInputField.setAttribute("value", "null");
		newInputField.setAttribute("accept", ".png, .jpg, jpeg, .pdf");
		newInputField.setAttribute("style", "display:none;");
		newInputField.onchange = function(){savePart();};
		// TODO: Auf das alte Feld drauf legen
	document.getElementById("formular").appendChild(newInputField);
	document.getElementById("anzahlFiles").innerHTML = "<li>"+nameArray.join(' ')+"</li>"
	
	removeRequireAttribute();
}

// Warnung fuer falsche Dateiendungen
function alertFalseType(evt) {
	var files = document.getElementById("fileInput"+n).files; 
	document.getElementById("out").innerHTML = files.length;	
		for(var i = 0, f; f=files[i]; i++) {
			var endung = f.name.substr(f.name.lastIndexOf('.') +1);
			if(endung != "png" && endung != "pdf" && endung != "jpg" && endung != "jpeg") {
				alert("Leider der falsche Dateityp");
				document.getElementById("fileInput").reset();
				document.formular.fileInput.focus();
				return false;
			}
		}	
	return true;
}

//oeffnet Felder, in die Aenderungen eingetragen werden
//pDaten.php
function new_Input(string) {
	var x = document.getElementById(string);
	x.style.display = 'inline';
}
//laesst die neue Eingabe wieder verschwinden -> Nutzer ueberlegt es sich anders
function cancelNew_Input(string) {
	var x = document.getElementById(string);
	x.style.display = 'none';
}
//Titel der Seite auslesen und dann den Inhalt von id=string ersetzen 
function titleLesen(string) { 
	var title = document.title;
	document.getElementById(string).innerHTML = title;
}

function deleteVertragspartner(n) {
	var value=n+1;
	var con = confirm("Lösche deinen " + value + ". Vertragspartner!");	
	if (con == true) {
		document.getElementById('vertragspartnerDeleteID').value = n;
		document.forms.vertragspartnerForm.submit();
	} 	
}

function editVertragspartner(id) {
		document.getElementById('vertragspartnerEdit').value = id;
		document.forms.vertragspartnerEditForm.submit();	
}

function menuChange() {
	var x = document.title; 	
	console.log(x);
	if (document.title == "Login_VertragsengelApp") {
		document.getElementById('liLog').style.display = "none";
		document.getElementById('liReg').style.display = "inline";
		console.log("loop 1");
	} 
	 else if (document.title == "Registrieren") {
		document.getElementById('liLog').style.display = "inline";
		document.getElementById('liReg').style.display = "none";	
		console.log("loop 2");
	}
	else {
		document.getElementById('liLog').style.display = "inline";
		document.getElementById('liReg').style.display = "inline";
		console.log("loop 3");
	}
}