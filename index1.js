var profil = document.getElementById("show-profil");
var element2 = document.getElementById("nav-profil-element-2");
var caret = document.getElementById("caret");
profil.addEventListener("click" , function(event) {
    if(element2.style.display == "block"){
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
einstellungen.addEventListener("click" , function(event) {
    if(element3.style.display == "block"){
        element3.style.display = "none";
        caret1.style.transform = "rotate(360deg)";
    } else {
        element3.style.display ="block";
        caret1.style.transform = "rotate(180deg)";
    }
});

var button = document.getElementById("button");
var nav = document.getElementById("nav");
button.addEventListener("click" , function(event) {
    if(nav.style.display == "block"){
        nav.style.display = "none";
    } else {
        nav.style.display = "block";
    }
});

var titel1 = document.getElementById("titel1");
var auswahlPanel = document.getElementById("auswahl-panel-1");
var caret2 = document.getElementById("caret2");
titel1.addEventListener("click" , function(event) {
    if(auswahlPanel.style.display == "block"){
        auswahlPanel.style.display = "none";
        caret2.style.transform = "rotate(360deg)";
    } else {
        auswahlPanel.style.display = "block";
        caret2.style.transform = "rotate(180deg)";
    }
});

var titel2 = document.getElementById("titel2");
var auswahlPanel2 = document.getElementById("auswahl-panel-2");
var caret3 = document.getElementById("caret3");
titel1.addEventListener("click" , function(event) {
    if(auswahlPanel2.style.display == "block"){
        auswahlPanel2.style.display = "none";
        caret3.style.transform = "rotate(360deg)";
    } else {
        auswahlPanel2.style.display = "block";
        caret3.style.transform = "rotate(180deg)";
    }
});





