/*
// **********************************Service-Worker******************************************* //
//Service Worker registrieren
///wird SW unterstuetzt?
// if ('serviceWorker' in navigator) {
// 	//wenn ja, dann registriere sw.js und bestaetige
// 	navigator.serviceWorker.register('sw.js')
// 	.then(function() {
// 		console.log('Service Worker registered');
// 	});
// }

// var deferredPrompt;
//
// die Standardfrage nach Installation der Verkuepfung wird unterdrueckt
// window.addEventListener('beforeinstallprompt', function(event) {
// 	console.log('beforeinstallprompt fired');
// 	event.preventDefault();
// 	deferredPrompt = event;
// 	return false;
// })

// Versuch die Installationsabfrage selbstbestimmt zu "werfen"
// function a2hs() {
// 	if (deferredPrompt) {
// 		deferredPrompt.prompt();

// 		deferredPrompt.userChoice.then(function(choiceResult) {
// 			console.log(choiceResult.outcome);

// 			if (choiceResult.outcome === 'dismissed') {
// 				console.log('user canceled installation');
// 			} else {
// 				console.log('user added to HS');
// 			}
// 		});
// 	deferredPrompt = null;
// 	}
// }
// ******************************************************************************************** //


// globale Variablien
var n = 0;	// Bezeichner fuer FileInput
var fileArray = new Array();  //Array aus fileObjects
var nameArray = []; //Array enthaelt die Dateinamen
formName = "";

// function engelPicture(+String)
// strom.php, gas.php, internet.php, mobilfunk.php, TV.php, krankenkasse.php
function engelPicture(formName) {
	this.formName = formName;
	var engel = [];
	for (var i=1;i<6;i++) {
		// alle Engel einer Reihe auswaehlen (ElementS)
		engel = (document.getElementsByClassName('engelImage'+i));
		for (var n=0;n<engel.length;n++) {
			// Engel der Reihe mit Bild belegen
			engel[n].setAttribute("src","../img/"+formName+"EngelUnchecked.png");
		}
	}
}

// aendert Farbe der Engel
// strom.php, gas.php, internet.php, mobilfunk.php, TV.php, krankenkasse.php
// string enthaelt Dateiname des Engels
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

// pruefen ob als Beruf "sonstiges" gewählt wurde und anschließend ein neues inputfeld erstellen
// sowie den required-wert entsprechend neu verteilen
// profilBasis.php
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

// fuegt inputfield entsprechend der Anzahl der Kinder hinzu
// profil.php
function insertInputFieldChild(pform) {
	// Pruefe ob bereits Elemente vorhanden sind //
	var c = 1;
	if (document.getElementById('br'+c)) {
		// alte Inputfelder werden entfernt
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
	// Wenn keine Eingabe erfolgte //
	// Eingabe nicht 0 oder keine Eingabe //
	if (!(n == 0 || n == null)) {
		for (i=1;i<=n;i++) {
			// neue Inputfelder werden angelegt
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
		// Button zum entfernen des letzten Kindes wird angelegt
		var removeButton = document.createElement("button");
		removeButton.setAttribute("type", "button");
		removeButton.setAttribute("name","buttonRemove");
		removeButton.setAttribute("id","buttonRemove");
		removeButton.appendChild(document.createTextNode("-"));
		removeButton.onclick = function() {removeInputFieldChild(n)}; // Funktion siehe Zeile 150
		document.getElementById(pform).appendChild(removeButton);
	}
}

// entfernt inputfield Kinder
// Anzahl der Kinder in n global gespeichert
// profil.php
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

// Warnung fuer falsche Dateiendungen (Bildupload)
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

// oeffnet Felder, in die Aenderungen eingetragen werden
// pDaten.php
function new_Input(string) {
	var x = document.getElementById(string);
	x.style.display = 'inline';
}
// laesst die neue Eingabe wieder verschwinden -> Nutzer ueberlegt es sich anders
// pDaten.php
function cancelNew_Input(string) {
	var x = document.getElementById(string);
	x.style.display = 'none';
}
// Titel der Seite auslesen und dann den Inhalt von id=string ersetzen
function titleLesen(string) {
	var title = document.title;
	document.getElementById(string).innerHTML = title;
}
// entfernt VertragsPartner
// pDaten.php
function deleteVertragspartner(n) {
	var value=n+1;
	var con = confirm("Lösche deinen " + value + ". Vertragspartner!");
	if (con == true) {
		document.getElementById('vertragspartnerDeleteID').value = n;
		document.forms.vertragspartnerForm.submit();
	}
}

// bietet die Möglichkeit Vertragspartner zu editieren
// pDaten.php
function editVertragspartner(id) {
		document.getElementById('vertragspartnerEdit').value = id;
		document.forms.vertragspartnerEditForm.submit();
}

// Anpassung fuer das Menue auf der Index-, Login- und RegistrierungsSeite,
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
} */

itemSelect.addEventListener("click", function(e) {
  console.log("0");
  var auswahlCard = document.getElementById(e.target.parentNode.parentNode.id);
  var auswahlSelect = document.getElementById(
    e.target.parentNode.parentNode.parentNode.id
  );
  var boxClass = document.querySelectorAll("div.box");
  if (localStorage.getItem(a)) {
    if (
      confirm(
        "Sie haben bereits einen Vertrag zu erfüllen. Indem Sie dies hinzufügen, ersetzen Sie Ihre vorherige Auswahl. Bist du dir sicher?"
      )
    ) {
      key = a;
      value = e.target.innerHTML;
      e.target.parentNode.style.display = "none";
      vertragsArray.push({ key, value });
      var div = document.createElement("div");
      var div1 = document.createElement("div");
      var div2 = document.createElement("div");
      var i1 = document.createElement("i");
      var i = document.createElement("i");
      div.className = "vertragslist-element";
      div1.className = "vertragslist-element-text";
      div2.className = "vertragslist-element-image";
      i1.className = "far fa-times-circle";
      i1.id = "fa-times-circle";
      i.className = b;
      div1.innerHTML =
        "<b id='key'>" +
        a +
        ":</b><br>" +
        "<b id='value'>" +
        e.target.innerHTML +
        "</b>";
      vertragsList.append(div2);
      div2.append(i);
      vertragsList.append(div);
      div.append(div2);
      div.append(div1);
      div.append(i1);
      console.log(vertragsArray);

      myFunction(x);
      x.addListener(myFunction);
      function myFunction(x) {
        if (Array3.includes(itemBox.id)) {
        } else {
          Array3.unshift(itemBox.id);
        }
        console.log(Array3);
        if (x.matches && itemBox.className === "box-is-active") {
          console.log("2.1");
          boxClass.forEach(function(itemBox) {
            itemBox.style.display = "block";
            console.log("2.1.2.1");
          });
          Array3.forEach(function(boxElement) {
            var boxStyleDisplayNone = document.getElementById(boxElement);
            console.log("2.1.0");
            console.log(vertragsArray.length);
            boxStyleDisplayNone.style.display = "none";
            /* boxStyleDisplayNone.className = "box"; */
          });
          for (let i = 0; i < vertragsArray.length; i++) {
            /* boxStyleDisplayNone.className = "box"; */
            console.log(vertragsArray[i].key);
            var boxStyleDisplayNone1 = document.getElementById(
              vertragsArray[i].key
            );
            var vertragsBoxesDisplayNone = document.getElementById(
              boxStyleDisplayNone1.parentNode.id
            );
            vertragsBoxesDisplayNone.className = "box";
          }
          /* itemBox.className = "box"; */
          itemBox.style.display = "none";
          vertragspanel.style.display = "flex";
          mainVA.style.height = "auto";
          mainVA.style.bottom = "180px";
          mainVA.style.overflowY = "auto";
          auswahlPanel.style.margin = "10px";
          titel.style.display = "block";
        } /* else if (vertragsArray.length === 0) {
          itemBox.className = "box-is-active";
          console.log("2.1.0");
        }  */ else if (
          !x.matches &&
          itemBox.className === "box-is-active"
        ) {
          background.style.height = "100%";
          background.style.left = "0px";
          background.style.right = "0px";
          background.style.top = "0px";
          background.style.width = "100%";
          boxClass.forEach(function(itemBox) {
            console.log(vertragsArray.length);
            console.log("2.1.1");
            itemBox.style.display = "block";
          });
          Array3.forEach(function(boxElement) {
            console.log("2.1.2");
            var boxStyleDisplayNone = document.getElementById(boxElement);
            boxStyleDisplayNone.style.display = "none";
            for (let i = 0; i < vertragsArray.length; i++) {
              /* boxStyleDisplayNone.className = "box"; */
              console.log(vertragsArray[i].key);
              var boxStyleDisplayNone1 = document.getElementById(
                vertragsArray[i].key
              );
              var vertragsBoxesDisplayNone = document.getElementById(
                boxStyleDisplayNone1.parentNode.id
              );
              vertragsBoxesDisplayNone.className = "box";
            }
          });
          /* vertragsArray.forEach(function(boxElement) {
            console.log("2.1.2");
            console.log(vertragsArray);
            var boxStyleDisplayNone = document.getElementById(boxElement);
            boxStyleDisplayNone.style.display = "none";
            if (vertragsArray.length !== 0) {
              boxStyleDisplayNone.className = "box";
            }
          }); */
          console.log("2.1.3");
          /* itemBox.className = "box"; */
        } else if (x.matches) {
          console.log("2.2");
          boxClass.forEach(function(itemBox) {
            console.log("2.2.1");
            itemBox.style.display = "block";
          });
          Array3.forEach(function(boxElement) {
            console.log("2.2.2");
            var boxStyleDisplayNone = document.getElementById(boxElement);
            boxStyleDisplayNone.style.display = "none";
            /* boxStyleDisplayNone.className = "box" */
          });
          vertragspanel.style.display = "flex";
          mainVA.style.height = "auto";
          mainVA.style.bottom = "180px";
          mainVA.style.overflowY = "auto";
          auswahlPanel.style.margin = "10px";
          titel.style.display = "block";
          itemBox.style.display = "none";
          itemBox.className = "box";
        } else {
          console.log("2.2.3");
          itemBox.style.display = "none";
        }
      }
      vertragsList.children.length > 1
        ? (vertragsList.style.display = "block")
        : true;
      i1.addEventListener("click", function(e) {
        for (let i = 0; i < vertragsArray.length; i++) {
          if (vertragsArray[i].key === a) {
            vertragsArray.splice(i, 1);
            i--;
          }
        }
        e.target.parentNode.remove();
        vertragsList.children.length === 1
          ? (vertragsList.style.display = "none")
          : true;
        myFunction(x);
        x.addListener(myFunction);
        function myFunction(x) {
          if (x.matches) {
            console.log("2.3");
            remove(Array3, itemBox.id);
            console.log(Array3);
            itemBox.style.display = "block";
            itemBox.style.width = "48%";
            itemBox.style.height = "270px";
            itemBox.style.margin = "1%";
            itemBox.style.padding = "0px";
            itemBox.style.position = "relative";
            auswahlCard.style.height = "100%";
            background.style.height = "100%";
            background.style.left = "0px";
            background.style.right = "0px";
            background.style.top = "0px";
            background.style.width = "100%";
            return;
          } else {
            console.log("2.4");
            remove(Array3, itemBox.id);
            console.log(Array3);
            itemBox.style.display = "block";
            itemBox.style.width = "48%";
            return;
          }
        }
      });
    }
  } else {
    key = a;
    value = e.target.innerHTML;
    e.target.parentNode.style.display = "none";
    vertragsArray.push({ key, value });
    var div = document.createElement("div");
    var div1 = document.createElement("div");
    var div2 = document.createElement("div");
    var i1 = document.createElement("i");
    var i = document.createElement("i");
    div.className = "vertragslist-element";
    div1.className = "vertragslist-element-text";
    div2.className = "vertragslist-element-image";
    i1.className = "far fa-times-circle";
    i1.id = "fa-times-circle";
    i.className = b;
    div1.innerHTML =
      "<b id='key'>" +
      a +
      ":</b><br>" +
      "<b id='value'>" +
      e.target.innerHTML +
      "</b>";
    vertragsList.append(div2);
    div2.append(i);
    vertragsList.append(div);
    div.append(div2);
    div.append(div1);
    div.append(i1);

    myFunction(x);
    x.addListener(myFunction);
    function myFunction(x) {
      if (Array3.includes(itemBox.id)) {
        console.log("ok");
        console.log(Array3);
        return;
      } else {
        Array3.unshift(itemBox.id);
        console.log("ok1");
        console.log(Array3);
        /* if (vertragsArray.length !== 0) {
          itemBox.className = "box";
          console.log("NO-OK");
        } */
      }
      console.log(Array3);
      if (x.matches && itemBox.className === "box-is-active") {
        console.log("2.1");
        boxClass.forEach(function(itemBox) {
          itemBox.style.display = "block";
        });
        Array3.forEach(function(boxElement) {
          var boxStyleDisplayNone = document.getElementById(boxElement);
          boxStyleDisplayNone.style.display = "none";
          /* boxStyleDisplayNone.className = "box"; */
        });
        for (let i = 0; i < vertragsArray.length; i++) {
          /* boxStyleDisplayNone.className = "box"; */
          console.log(vertragsArray[i].key);
          var boxStyleDisplayNone1 = document.getElementById(
            vertragsArray[i].key
          );
          var vertragsBoxesDisplayNone = document.getElementById(
            boxStyleDisplayNone1.parentNode.id
          );
          vertragsBoxesDisplayNone.className = "box";
        }
        /* if (vertragsArray.length !== 0) {
          boxStyleDisplayNone.className = "box";
        } */
        /* itemBox.className = "box"; */
        itemBox.style.display = "none";
        vertragspanel.style.display = "flex";
        mainVA.style.height = "auto";
        mainVA.style.bottom = "180px";
        mainVA.style.overflowY = "auto";
        auswahlPanel.style.margin = "10px";
        titel.style.display = "block";
      } /* else if (vertragsArray.length === 0) {
        itemBox.className = "box-is-active";
        console.log("2.1.0");
      }  */ else if (
        !x.matches &&
        itemBox.className === "box-is-active"
      ) {
        console.log(vertragsArray.length);
        background.style.height = "100%";
        background.style.left = "0px";
        background.style.right = "0px";
        background.style.top = "0px";
        background.style.width = "100%";
        boxClass.forEach(function(itemBox) {
          console.log("2.1.1");
          itemBox.style.display = "block";
        });
        vertragsArray.forEach(function(boxElement) {
          console.log("2.1.2");
          console.log(vertragsArray);
          var boxStyleDisplayNone = document.getElementById(boxElement);
          boxStyleDisplayNone.style.display = "none";
          if (vertragsArray.length !== 0) {
            boxStyleDisplayNone.className = "box";
          }
          for (let i = 0; i < vertragsArray.length; i++) {
            /* boxStyleDisplayNone.className = "box"; */
            console.log(vertragsArray[i].key);
            var boxStyleDisplayNone1 = document.getElementById(
              vertragsArray[i].key
            );
            var vertragsBoxesDisplayNone = document.getElementById(
              boxStyleDisplayNone1.parentNode.id
            );
            vertragsBoxesDisplayNone.className = "box";
          }
        });
        console.log("2.1.3");
        /* itemBox.className = "box"; */
      } else if (x.matches) {
        console.log("2.2");
        boxClass.forEach(function(itemBox) {
          console.log("2.2.1");
          itemBox.style.display = "block";
        });
        Array3.forEach(function(boxElement) {
          console.log("2.2.2");
          var boxStyleDisplayNone = document.getElementById(boxElement);
          boxStyleDisplayNone.style.display = "none";
          /* boxStyleDisplayNone.className = "box" */
          for (let i = 0; i < vertragsArray.length; i++) {
            /* boxStyleDisplayNone.className = "box"; */
            console.log(vertragsArray[i].key);
            var boxStyleDisplayNone1 = document.getElementById(
              vertragsArray[i].key
            );
            var vertragsBoxesDisplayNone = document.getElementById(
              boxStyleDisplayNone1.parentNode.id
            );
            vertragsBoxesDisplayNone.className = "box";
          }
        });
        vertragspanel.style.display = "flex";
        mainVA.style.height = "auto";
        mainVA.style.bottom = "180px";
        mainVA.style.overflowY = "auto";
        auswahlPanel.style.margin = "10px";
        titel.style.display = "block";
        itemBox.style.display = "none";
        itemBox.className = "box";
      } else {
        console.log("2.2.3");
        itemBox.style.display = "none";
      }
    }
    vertragsList.children.length > 1
      ? (vertragsList.style.display = "block")
      : true;
    i1.addEventListener("click", function(e) {
      for (let i = 0; i < vertragsArray.length; i++) {
        if (vertragsArray[i].key === a) {
          vertragsArray.splice(i, 1);
          i--;
        }
      }
      e.target.parentNode.remove();
      vertragsList.children.length === 1
        ? (vertragsList.style.display = "none")
        : true;
      myFunction(x);
      x.addListener(myFunction);
      function myFunction(x) {
        if (x.matches) {
          console.log("2.7");
          remove(Array3, itemBox.id);
          console.log(background);
          itemBox.style.display = "block";
          itemBox.style.width = "48%";
          itemBox.style.height = "270px";
          itemBox.style.margin = "1%";
          itemBox.style.padding = "0px";
          itemBox.style.position = "relative";
          auswahlCard.style.height = "100%";
          background.style.height = "100%";
          background.style.left = "0px";
          background.style.right = "0px";
          background.style.top = "0px";
          background.style.width = "100%";
        } else {
          console.log("2.8");
          remove(Array3, itemBox.id);
          console.log(Array3);
          itemBox.style.display = "block";
          itemBox.style.width = "48%";
        }
        return;
      }
    });
  }
});
