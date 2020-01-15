var profil = document.getElementById("show-profil");
var element2 = document.getElementById("nav-profil-element-2");
var caret = document.getElementById("caret");
profil.addEventListener("click", function(event) {
  if (element2.style.display == "block") {
    element2.style.display = "none";
    caret.style.transform = "rotate(360deg)";
  } else {
    element2.style.display = "block";
    caret.style.transform = "rotate(180deg)";
  }
});
var einstellungen = document.getElementById("show-einstellungen");
var element3 = document.getElementById("nav-einstellungen-element-2");
var caret1 = document.getElementById("caret1");
einstellungen.addEventListener("click", function(event) {
  if (element3.style.display == "block") {
    element3.style.display = "none";
    caret1.style.transform = "rotate(360deg)";
  } else {
    element3.style.display = "block";
    caret1.style.transform = "rotate(180deg)";
  }
});
var button = document.getElementById("button");
var nav = document.getElementById("nav");
button.addEventListener("click", function(event) {
  if (nav.style.display == "block") {
    nav.style.display = "none";
  } else {
    nav.style.display = "block";
  }
});
var infoHeaderBack = document.getElementById("info-header-back");
var kontaktButton = document.getElementById("kontakt-aufnehmen-button");
var rightContainer = document.getElementById("right-container-info");
kontaktButton.addEventListener("click", function(event) {
  if (rightContainer.style.display == "block") {
    rightContainer.style.display = "block";
  } else {
    rightContainer.style.display = "block";
  }
});
var main = document.getElementById("mainVU");
var buttonCloseInfoVertragUebersicht = document.getElementById(
  "button-close-info-vertrag-uebersicht"
);
var display = document.getElementById("info-vertrag-uebersicht");
var rowCenter1 = document.querySelector(".row-center-1");
var rowCenter2 = document.querySelector(".row-center-2");
var rowCenter3 = document.querySelector(".row-center-3");
var twoRowCenter = document.querySelector(".two-row-center");
var rowCenterContent2 = document.querySelector(".row-center-content-2");
var rowCenterContent3 = document.querySelector(".row-center-content-3");
var gesamtkosten = document.querySelector(".gesamtkosten");
var gesamtkostenAfter = document.querySelector(".gesamtkostenAfter");
var laufendeVertrage = document.querySelector(".laufende-vertrage");
buttonCloseInfoVertragUebersicht.addEventListener("click", function() {
  if (display.style.display == "block") {
    display.style.display = "none";
    main.style.right = "0%";
    buttonCloseInfoVertragUebersicht.style.display = "none";
    rowCenter1.style.width = "33.4%";
    rowCenter2.style.width = "50%";
    rowCenter2.style.height = "140px";
    rowCenter3.style.width = "50%";
    rowCenter3.style.height = "140px";
    twoRowCenter.style.height = "142px";
    twoRowCenter.style.width = "66.7%";
    twoRowCenter.style.flexDirection = "row";
    twoRowCenter.style.left = "33.3%";
    rowCenterContent2.style.margin = "10px";
    rowCenterContent2.style.height = "118px";
    rowCenterContent3.style.margin = "10px";
    rowCenterContent3.style.height = "118px";
    rowCenterContent3.style.borderTop = "none";
    gesamtkosten.style.fontSize = "70px";
    laufendeVertrage.style.fontSize = "70px";
    gesamtkostenAfter.style.fontSize = "30px";
    gesamtkostenAfter.style.margin = "15px 0 0 5px";
  }
});
var rightContainerSelect = document.getElementById("right-container-select");
var rightContainerSelect2 = document.getElementById("right-container-select-2");
var rightContainerInfoForm = document.getElementById(
  "right-container-info-form"
);
var rightContainerInfoHandy = document.getElementById(
  "right-container-info-handy"
);
var rightContainerInfoFormFields2 = document.getElementById(
  "right-container-info-form-fields2"
);
var rightContainerInfoFormFields3 = document.getElementById(
  "right-container-info-form-fields3"
);
var rightContainerTextarea = document.getElementById(
  "right-container-textarea"
);
var rightContainerButtonSubmit = document.getElementById(
  "right-container-button-submit"
);
rightContainerSelect.addEventListener("change", function() {
  if (this.value === "1") {
    rightContainerInfoForm.style.display = "none";
    rightContainerInfoHandy.style.display = "block";
  } else if (this.value === "2") {
    rightContainerInfoFormFields2.style.display = "block";
    rightContainerSelect2.addEventListener("change", function() {
      if (this.value === "Vertrag" || this.value === "Benutzerkonto") {
        rightContainerInfoForm.style.display = "none";
        rightContainerInfoHandy.style.display = "block";
      } else if (
        this.value === "Kündigung" ||
        this.value === "Rechnung" ||
        this.value === "Sonstiges"
      ) {
        rightContainerInfoFormFields3.style.display = "flex";
        rightContainerTextarea.addEventListener("input", function() {
          var text = this.value;
          if (text !== "") {
            rightContainerButtonSubmit.style.display = "block";
          } else {
            rightContainerButtonSubmit.style.display = "none";
          }
        });
      }
    });
  }
});
var rightContainerInfoErledigt = document.getElementById(
  "right-container-info-erledigt"
);
rightContainerButtonSubmit.addEventListener("click", function() {
  rightContainerInfoForm.style.display = "none";
  rightContainerInfoErledigt.style.display = "block";
});
var rightContainer = document.getElementById("right-container-info");
var infoHeaderClose = document.getElementById("info-header-close");
infoHeaderClose.addEventListener("click", function(event) {
  if (rightContainer.style.display == "none") {
    rightContainer.style.display = "block";
  } else {
    rightContainer.style.display = "none";
    rightContainerInfoErledigt.style.display = "none";
    rightContainerInfoForm.style.display = "block";
    document.getElementById("right-container-select").selectedIndex = 0;
    document.getElementById("right-container-select-2").selectedIndex = 0;
    rightContainerInfoFormFields2.style.display = "none";
    rightContainerInfoFormFields3.style.display = "none";
    if (rightContainerInfoHandy.style.display == "block") {
      rightContainerInfoHandy.style.display = "none";
    }
  }
});
var a = "";
var b = "";
var x = "";
var y = "";
var z = "";
var addVertrag = function(a, b, x, y, z) {
  var vertragMain1 = document.querySelector(".vertrag-main1");
  if (localStorage.getItem(x)) {
    var div = document.createElement("div");
    var div1 = document.createElement("div");
    var div2 = document.createElement("div");
    var div3 = document.createElement("div");
    var i = document.createElement("i");
    div.className = "container-for-rowlist";
    div1.id = "image-container";
    div2.className = "rest-info-container";
    div3.className = "row-list";
    div3.id = x;
    i.className = "fas fa-tv";
    div2.innerHTML = x + "<br>" + localStorage.getItem(x);
    vertragMain1.append(div);
    div.append(div3);
    div3.append(div1);
    div1.append(i);
    div3.append(div2);

    var z = document.getElementById(x);
    z.addEventListener("click", function() {
      var body = document.getElementById("body");
      var div4 = document.createElement("div");
      var div5 = document.createElement("div");
      div4.id = "panel-ausfullen";
      div5.id = "panel-ausfullen-details";
      body.append(div4);
      div4.append(div5);

      var xmlhttp = new XMLHttpRequest();
      var item = localStorage.getItem(x);
      xmlhttp.open("GET", y + item);
      xmlhttp.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
      );
      xmlhttp.send();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          div5.innerHTML = this.responseText;
          var faTimesCircle = document.getElementById("fa-times-circle");
          faTimesCircle.addEventListener("click", function() {
            div4.remove();
          });
          var buttonSpeichern = document.querySelector(".button-speichern");
          var felderKosten = document.querySelector(".felder-kosten");
          var kosten = document.getElementById("kosten");
          kosten.addEventListener("input", function() {
            if (isNaN(kosten.value) && felderKosten.childNodes.length === 5) {
              var div6 = document.createElement("div");
              felderKosten.append(div6);
              div6.className = "error";
              div6.innerHTML =
                "Bitte einen Wert zwischen 0,00 und 9999,99 € eingeben.";
              buttonSpeichern.disabled = true;
            } else if (
              !isNaN(kosten.value) &&
              felderKosten.childNodes.length === 6
            ) {
              buttonSpeichern.disabled = false;
              var error = document.querySelector(".error");
              error.remove();
            }
          });
          var buttonLoschen = document.querySelector(".button-loschen");
          var formular = document.getElementById(b);
          formular.addEventListener("submit", function(e) {
            formData = new FormData(formular);
            formData.append(a, "Speichern");
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "db/sendRequest.php", true);
            xhr.send(formData);
            e.preventDefault();
            xhr.onload = function() {
              if (this.readyState === 4 && this.status === 200) {
                var div6 = document.createElement("div");
                div6.id = "fenster-erfolg";
                div6.innerText = "Der Vertrag wurde aktualisiert!";
                main.append(div6);
                localStorage.removeItem(x);
                z.remove();
                div4.remove();
                setTimeout(function() {
                  location.reload();
                  div6.remove();
                }, 1500);
              } else {
                console.log("Loading...");
              }
            };
          });
          buttonLoschen.addEventListener("click", function() {
            if (
              confirm(
                "Vertrag wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden."
              )
            ) {
              localStorage.removeItem(x);
              z.remove();
              div4.remove();
            }
          });
        } else {
          div5.innerHTML = "Loading...";
        }
      };
    });
  }
};
addVertrag(
  "submit_TV",
  "strom-formular",
  "Fernsehen",
  "forms/4TV.php?item=",
  "fernsehen"
);
addVertrag("submit_gas", "gas-formular", "Gas", "forms/2Gas.php?item=", "gas");
