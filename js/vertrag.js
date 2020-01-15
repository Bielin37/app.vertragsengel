var a = "";
var b = "";
var x = "";
var y = "";
var z = "";
var addVertrag = function(a, b, x, y, z) {
  var vertragMain1 = document.querySelector(".vertrag-main1");
  var main = document.getElementById("mainVU");
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
