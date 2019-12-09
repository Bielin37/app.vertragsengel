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
var kontaktButton = document.getElementById("kontakt-aufnehmen-button");
var rightContainer = document.getElementById("right-container-info");
kontaktButton.addEventListener("click", function(event) {
  if (rightContainer.style.display == "block") {
    rightContainer.style.display = "block";
  } else {
    rightContainer.style.display = "block";
  }
});
var infoHeaderClose = document.getElementById("info-header-close");
infoHeaderClose.addEventListener("click", function(event) {
  if (rightContainer.style.display == "none") {
    rightContainer.style.display = "block";
  } else {
    rightContainer.style.display = "none";
  }
});
