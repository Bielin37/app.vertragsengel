var auswahlIconFernsehen = document.getElementById("auswahl-icon-fernsehen");
var vertragsPanel = document.getElementById("vertragspanel");
var main = document.getElementById("main");
auswahlIconFernsehen.addEventListener("click", function(event) {
  if (vertragsPanel.style.display == "none") {
    vertragsPanel.style.display = "flex";
    main.style.right = "322px";
  } else {
    vertragsPanel.style.display = "flex";
    main.style.right = "322px";
  }
});

var faTimesCircle = document.getElementById("fa-times-circle");
var vartragspanel = document.getElementById("vertragspanel");
var main1 = document.getElementById("main");
faTimesCircle.addEventListener("click", function(event) {
  if (vartragspanel.style.display == "flex") {
    vartragspanel.style.display = "none";
    main1.style.right = "0px";
  }
});

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

var titel2 = document.getElementById("titel2");
var auswahlPanel = document.getElementById("auswahl-panel-1");
var caret2 = document.getElementById("caret2");
titel2.addEventListener("click", function(event) {
  if (auswahlPanel.style.display == "flex") {
    auswahlPanel.style.display = "none";
    caret2.style.transform = "rotate(360deg)";
  } else {
    auswahlPanel.style.display = "flex";
    caret2.style.transform = "rotate(180deg)";
  }
});

var titel3 = document.getElementById("titel3");
var auswahlPanel2 = document.getElementById("auswahl-panel-2");
var caret3 = document.getElementById("caret3");
titel3.addEventListener("click", function(event) {
  if (auswahlPanel2.style.display == "flex") {
    auswahlPanel2.style.display = "none";
    caret3.style.transform = "rotate(360deg)";
  } else {
    auswahlPanel2.style.display = "flex";
    caret3.style.transform = "rotate(180deg)";
  }
});

const titel4 = document.getElementById("titel4");
var auswahlPanel3 = document.getElementById("auswahl-panel-3");
var caret4 = document.getElementById("caret4");
titel4.addEventListener("click", function(event) {
  if (auswahlPanel3.style.display == "block") {
    auswahlPanel3.style.display = "none";
    caret4.style.transform = "rotate(360deg)";
  } else {
    auswahlPanel3.style.display = "block";
    caret4.style.transform = "rotate(180deg)";
  }
});
