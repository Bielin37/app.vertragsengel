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
var vertragsArray = [];
var auswahlList = document.querySelector(".auswahl-list");
var vertragslistElement = document.querySelector(".vertragslist-element");
var fernsehen = document.getElementById("Fernsehen");
var vertragsList = document.getElementById("vertragspanel-vertragslist");
var fernsehenSelect = document.querySelector("#fernsehen-select");
fernsehenSelect.addEventListener("click", function(e) {
  key = "Fernsehen";
  value = e.target.innerHTML;
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
  i.className = "fas fa-tv";
  div1.innerHTML =
    "<b id='key'>Fernsehen:</b><br>" +
    "<b id='value'>" +
    e.target.innerHTML +
    "</b>";
  vertragsList.append(div2);
  div2.append(i);
  vertragsList.append(div);
  div.append(div2);
  div.append(div1);
  div.append(i1);
  fernsehen.style.display = "none";
  vertragsList.children.length > 1
    ? (vertragsList.style.display = "block")
    : true;
  var vertragslistElementClose = document.getElementById("fa-times-circle");
  vertragslistElementClose.addEventListener("click", function(e) {
    for (let i = 0; i < vertragsArray.length; i++) {
      if (vertragsArray[i].key === "Fernsehen") {
        vertragsArray.splice(i, 1);
        i--;
      }
    }
    e.target.parentNode.remove();
    vertragsList.children.length === 1
      ? (vertragsList.style.display = "none")
      : true;
    fernsehen.style.display = "block";
  });
});

var gas = document.getElementById("Gas");
var gasSelect = document.querySelector("#gas-select");
gasSelect.addEventListener("click", function(e) {
  key = "Gas";
  value = e.target.innerHTML;
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
  i1.id = "fa-times-circle1";
  i.className = "fas fa-burn";
  div1.innerHTML = key + "<br>" + e.target.innerHTML;
  vertragsList.append(div2);
  div2.append(i);
  vertragsList.append(div);
  div.append(div2);
  div.append(div1);
  div.append(i1);
  gas.style.display = "none";
  vertragsList.children.length > 1
    ? (vertragsList.style.display = "block")
    : true;
  var vertragslistElementClose = document.getElementById("fa-times-circle1");
  vertragslistElementClose.addEventListener("click", function(e) {
    for (let i = 0; i < vertragsArray.length; i++) {
      if (vertragsArray[i].key === "Gas") {
        vertragsArray.splice(i, 1);
        i--;
      }
    }
    e.target.parentNode.remove();
    vertragsList.children.length === 1
      ? (vertragsList.style.display = "none")
      : true;
    gas.style.display = "block";
  });
});
var vertragspanelButton = document.querySelector(".vertragspanel-button");
vertragspanelButton.addEventListener("click", function() {
  vertragsArray.forEach(element => {
    let key = element.key;
    const value = element.value;
    localStorage.setItem(key, value);
    window.location.replace("vertragsUebersicht.php");
  });
});
