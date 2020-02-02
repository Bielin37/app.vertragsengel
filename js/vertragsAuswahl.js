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

var f = "";
var g = "";
var h = "";
var i = "";

var Array = [];
var Array1 = [];
var Array2 = [];

var x = window.matchMedia("(max-width: 1000px)");

var boxShadowFnc = (m, n) => {
  var auswahlCard = document.getElementById(m);
  var background = document.getElementById(n);
  background.addEventListener("mouseover", () => {
    auswahlCard.style.boxShadow = "0px 6px 5px 2px #ccccccb2";
    auswahlCard.style.transitionDuration = "0.5s";
  });
  background.addEventListener("mouseout", () => {
    auswahlCard.style.boxShadow = "none";
    auswahlCard.style.transitionDuration = "0.5s";
  });
};

var showAuswahlList = function(f, g, h, i) {
  var auswahlPanel = document.querySelector(".auswahl-panel");
  var vertragspanel = document.getElementById("vertragspanel");
  var auswahlList = document.querySelector(".auswahl-list");
  var background = document.getElementById(f);
  background.addEventListener("click", function() {
    var auswahlSelect = document.getElementById(g);
    var auswahlCard = document.getElementById(i);
    var box = document.getElementById(h);
    var titel = document.querySelector(".titel");

    Array.push(auswahlCard.children[2].id);
    Array2.unshift(auswahlCard.parentNode.id);

    if (
      auswahlSelect.style.display === "block" &&
      Array[0] === auswahlCard.children[2].id
    ) {
      console.log("0");
      box.className = "box";

      auswahlSelect.style.display = "none";
      Array.splice(0, 1);
    } else if (Array[1] == auswahlCard.children[2].id && Array[1] !== "") {
      console.log("2");

      var box1 = document.getElementById(Array2[1]);
      box1.style.zIndex = "1";
      box.style.zIndex = "10";

      box1.className = "box";
      box.className = "box-is-active";

      var f = document.getElementById(Array[0]);
      f.style.display = "none";
      auswahlSelect.style.display = "block";
      Array1.push(auswahlCard.parentNode.id);
      Array.splice(0, 1);
      Array1.splice(0, 1);
    } else {
      console.log("3");

      box.className = "box-is-active";

      box.style.zIndex = "10";
      auswahlSelect.style.display = "block";
      Array1.push(auswahlCard.parentNode.id);
    }

    myFunction(x);
    x.addListener(myFunction);
    function myFunction(x) {
      var boxClass = document.querySelectorAll("div.box");
      if (
        x.matches &&
        Array2[0] !== Array2[1] &&
        box.className === "box-is-active"
      ) {
        boxClass.forEach(function(box) {
          box.style.display = "none";
        });
        console.log("1.1");
        background.style.maxWidth = "100%";
        background.style.height = "270px";
        background.style.left = "50px";
        background.style.right = "50px";
        background.style.top = "50px";
        background.style.width = "auto";

        auswahlPanel.style.margin = "0px";
        vertragspanel.style.display = "none";
        mainVA.style.bottom = "0px";
        mainVA.style.overflowY = "hidden";
        mainVA.style.height = "100%";
        auswahlSelect.style.overflowY = "hidden";
        auswahlSelect.style.height = "auto";
        auswahlSelect.style.bottom = "0px";
        auswahlSelect.style.border = "none";
        auswahlSelect.style.position = "static";
        auswahlCard.style.height = "auto";
        box.style.width = "100%";
        box.style.height = "100%";
        box.style.overflowY = "auto";
        box.style.boxSizing = "border-box";
        box.style.padding = "50px";
        box.style.margin = "0px";
        box.style.position = "absolute";
        titel.style.display = "none";
        auswahlList.style.margin = "0px";
      } else if (box.className === "box-is-active" && x.matches) {
        console.log("1.2");
        boxClass.forEach(function(box) {
          box.style.display = "none";
          console.log("1.2.1.2");
        });
        background.style.maxWidth = "100%";
        background.style.height = "270px";
        background.style.left = "50px";
        background.style.right = "50px";
        background.style.top = "50px";
        background.style.width = "auto";
        auswahlPanel.style.margin = "0px";
        vertragspanel.style.display = "none";
        mainVA.style.bottom = "0px";
        mainVA.style.overflowY = "hidden";
        mainVA.style.height = "100%";
        auswahlSelect.style.overflowY = "hidden";
        auswahlSelect.style.height = "auto";
        auswahlSelect.style.bottom = "0px";
        auswahlSelect.style.border = "none";
        auswahlSelect.style.position = "static";
        auswahlCard.style.height = "auto";
        box.style.width = "100%";
        box.style.height = "100%";
        box.style.overflowY = "auto";
        box.style.boxSizing = "border-box";
        box.style.padding = "50px";
        box.style.margin = "0px";
        box.style.position = "absolute";
        titel.style.display = "none";
        auswahlList.style.margin = "0px";
      } else if (
        x.matches &&
        Array2[0] === Array2[1] &&
        box.className === "box-is-active"
      ) {
        console.log("oj");
        return;
      } else if (
        box.className === "box-is-active" &&
        !x.matches &&
        box.style.width === "100%"
      ) {
        boxClass.forEach(function(box) {
          box.style.display = "block";
        });
        Array3.forEach(function(box1) {
          var array3box = document.getElementById(box1);
          array3box.style.display = "none";
        });
        box.style.width = "48%";
        box.style.zIndex = "10";
        console.log("1.3");
        background.style.height = "100%";
        background.style.left = "0px";
        background.style.right = "0px";
        background.style.top = "0px";
        background.style.width = "100%";
        box.style.overflowY = "visible";
        box.style.boxSizing = "border-box";
        box.style.padding = "0px";
        box.style.margin = "1%";
        box.style.height = "270px";
        box.style.position = "relative";
        vertragspanel.style.display = "flex";
        mainVA.style.bottom = "0px";
        mainVA.style.overflowY = "auto";
        auswahlPanel.style.margin = "10px";
        auswahlSelect.style.overflowY = "auto";
        auswahlSelect.style.height = "300px";
        auswahlSelect.style.bottom = "-295px";
        auswahlSelect.style.border = "1px solid #9798a233";
        auswahlSelect.style.position = "absolute";
        auswahlSelect.style.paddingTop = "0px";
        auswahlCard.style.height = "270";
        titel.style.display = "block";
      } else if (box.className === "box-is-active" && !x.matches) {
        box.style.zIndex = "10";
        console.log("1.4");
        box.style.overflowY = "visible";
        box.style.boxSizing = "border-box";
        box.style.padding = "0px";
        box.style.margin = "1%";
        box.style.minWidth = "23%";
        box.style.height = "270px";
        box.style.position = "relative";
        vertragspanel.style.display = "flex";
        mainVA.style.bottom = "0px";
        mainVA.style.overflowY = "auto";
        auswahlPanel.style.margin = "10px";
        auswahlSelect.style.overflowY = "auto";
        auswahlSelect.style.height = "300px";
        auswahlSelect.style.bottom = "-295px";
        auswahlSelect.style.border = "1px solid #9798a233";
        auswahlSelect.style.position = "absolute";
        auswahlSelect.style.paddingTop = "0px";
        auswahlCard.style.height = "270";
        titel.style.display = "block";
      } else if (box.className === "box" && x.matches) {
        console.log("siema");
        console.log(Array3);
        boxClass.forEach(function(box) {
          box.style.display = "block";
        });
        Array3.forEach(function(box1) {
          var array3box = document.getElementById(box1);
          array3box.style.display = "none";
        });
        console.log(Array3);
        background.style.height = "100%";
        background.style.left = "0px";
        background.style.right = "0px";
        background.style.top = "0px";
        background.style.width = "100%";

        auswahlPanel.style.margin = "10px";
        vertragspanel.style.display = "flex";
        mainVA.style.bottom = "180px";
        mainVA.style.overflowY = "auto";
        mainVA.style.height = "auto";
        auswahlSelect.style.overflowY = "auto";
        auswahlSelect.style.height = "300px";
        auswahlSelect.style.bottom = "-295px";
        auswahlSelect.style.border = "1px solid #9798a233";
        auswahlSelect.style.position = "absolute";
        auswahlCard.style.height = "270px";
        box.style.width = "48%";
        box.style.height = "270px";
        box.style.overflowY = "hidden";
        box.style.boxSizing = "border-box";
        box.style.padding = "0px";
        box.style.margin = "1%";
        box.style.position = "relative";
        titel.style.display = "block";
        auswahlList.style.margin = "0px";
      } else {
        if (x.matches) {
          mainVA.style.bottom = "180px";
        } else {
          console.log("1.5");
          boxClass.forEach(function(box) {
            box.style.display = "block";
          });
          Array3.forEach(function(box1) {
            var array3box = document.getElementById(box1);
            array3box.style.display = "none";
          });
          box.style.zIndex = "1";
          box.style.overflowY = "visible";
          box.style.boxSizing = "border-box";
          box.style.padding = "0px";
          box.style.margin = "1%";
          box.style.minWidth = "23%";
          box.style.height = "270px";
          box.style.position = "relative";
          vertragspanel.style.display = "flex";
          mainVA.style.bottom = "0px";
          mainVA.style.overflowY = "auto";
          auswahlPanel.style.margin = "10px";
          auswahlSelect.style.overflowY = "auto";
          auswahlSelect.style.height = "300px";
          auswahlSelect.style.bottom = "-295px";
          auswahlSelect.style.border = "1px solid #9798a233";
          auswahlSelect.style.position = "absolute";
          auswahlSelect.style.paddingTop = "0px";
          auswahlCard.style.height = "270";
          titel.style.display = "block";
        }
      }
    }
  });
};

var a = "";
var b = "";
var c = "";
var d = "";
var e = "";
var f = "";
var Array3 = [];
var vertragsArray = [];
var vertragsList = document.getElementById("vertragspanel-vertragslist");

function remove(array, element) {
  const index = array.indexOf(element);
  array.splice(index, 1);
}

function vertragWahlen(a, b, c, d, e, f) {
  var x = window.matchMedia("(max-width: 1000px)");
  var itemSelect = document.getElementById(d);
  var c = document.getElementById(a);
  var itemBox = document.getElementById(e);
  var auswahlPanel = document.querySelector(".auswahl-panel");
  var vertragspanel = document.getElementById("vertragspanel");
  /* var auswahlList = document.querySelector(".auswahl-list"); */
  var titel = document.querySelector(".titel");
  var background = document.getElementById(f);
  itemSelect.addEventListener("click", function(e) {
    console.log("0");
    var auswahlCard = document.getElementById(
      e.target.parentNode.parentNode.id
    );
    /*   var auswahlSelect = document.getElementById(
      e.target.parentNode.parentNode.parentNode.id
    ); */
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
        console.log(vertragsArray[0].key);
        console.log(itemBox.children[0].id);
        myFunction(x);
        x.addListener(myFunction);
        function myFunction(x) {
          if (Array3.includes(itemBox.id)) {
            console.log("ok1");
          } else {
            Array3.unshift(itemBox.id);
            console.log("ok");
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
            });
            for (let i = 0; i < vertragsArray.length; i++) {
              console.log(vertragsArray[i].key);
              var boxStyleDisplayNone1 = document.getElementById(
                vertragsArray[i].key
              );
              var vertragsBoxesDisplayNone = document.getElementById(
                boxStyleDisplayNone1.parentNode.id
              );
              vertragsBoxesDisplayNone.className = "box";
            }
            itemBox.style.display = "none";
            vertragspanel.style.display = "flex";
            mainVA.style.height = "100%";
            mainVA.style.bottom = "180px";
            mainVA.style.overflowY = "auto";
            auswahlPanel.style.margin = "10px";
            titel.style.display = "block";
            if (itemBox.className === "box") {
              mainVA.style.height = "auto";
            }
          } else if (!x.matches && itemBox.className === "box-is-active") {
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
          } else if (x.matches && itemBox.className === !"box-is-active") {
            console.log("2.2");
            boxClass.forEach(function(itemBox) {
              console.log("2.2.1");
              itemBox.style.display = "block";
            });
            Array3.forEach(function(boxElement) {
              console.log("2.2.2");
              var boxStyleDisplayNone = document.getElementById(boxElement);
              boxStyleDisplayNone.style.display = "none";
            });
            vertragspanel.style.display = "flex";
            mainVA.style.height = "100%";
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
          //////////////////////////////////////////////////////////
          var vertragspanelTitel = document.querySelector(
            ".vertragspanel-titel"
          );
          var vertragsPanelTitelP = document
            .querySelector(".vertragspanel-titel")
            .querySelector("p");
          var vertragsPanelTitelH1 = document
            .querySelector(".vertragspanel-titel")
            .querySelector("h1");
          var topNav = document.querySelector(".top-nav");
          console.log(vertragspanelTitel.children.length);
          if (x.matches) {
            vertragspanel.style.overflowY = "hidden";
            if (
              vertragsArray.length !== 0 &&
              vertragspanelTitel.children.length <= 2
            ) {
              vertragsPanelTitelH1.style.top = "10px";
              var arrow = document.createElement("div");
              arrow.className = "fas fa-angle-double-up";
              arrow.id = "arrow";
              vertragspanelTitel.insertBefore(arrow, vertragsPanelTitelP);
              arrow.addEventListener("click", function() {
                if (vertragspanel.className === "vertragspanel") {
                  vertragspanel.className = "vertragspanel-isOpened";
                  vertragspanel.style.position = "absolute";
                  vertragspanel.style.height = "auto";
                  vertragspanel.style.transitionDuration = "0.5s";
                  vertragspanel.style.overflowY = "auto";
                  vertragsPanelTitelH1.style.margin = "0px";
                  vertragsPanelTitelH1.style.padding = "0px";
                  vertragspanelTitel.style.height = "150px";
                  vertragspanelTitel.style.padding = "0px";
                  vertragspanelTitel.style.marginBottom = "0px";
                  arrow.style.transform = "rotate(180deg)";
                  arrow.style.animation =
                    "arrow2 normal 1.5s linear 0s 500000 both";
                  vertragspanelButton.style.display = "block";
                } else if (
                  vertragspanel.className === "vertragspanel-isOpened"
                ) {
                  vertragspanel.className = "vertragspanel";
                  vertragspanel.style.position = "fixed";
                  vertragspanel.style.height = "180px";
                  vertragspanel.style.bottom = "0px";
                  vertragspanel.style.transitionDuration = "0.5s";
                  vertragspanel.style.overflowY = "hidden";
                  vertragsPanelTitelH1.style.paddingTop = "20px";
                  vertragspanelTitel.style.height = "180px";
                  vertragspanelTitel.style.padding = "10px 0 10px 0px";
                  vertragspanelTitel.style.marginBottom = "10px";
                  arrow.style.transform = "rotate(0deg)";
                  arrow.style.animation =
                    "arrow normal 1.5s linear 0s 500000 both";
                  vertragspanelButton.style.display = "none";
                }
              });
            }
          } else {
            vertragsPanelTitelH1.style.top = "0px";
            vertragsPanelTitelP.innerHTML =
              "Klicke jetzt auf eine Kategorie und wähle deinen Anbieter aus.";
            vertragspanel.style.overflowY = "auto";
            var arrowDelete = document.getElementById("arrow");
            if (arrowDelete) {
              arrowDelete.remove();
            }
          }
          if (vertragsArray.length === 0) {
            vertragsPanelTitelP.innerHTML =
              "Klicke jetzt auf eine Kategorie und wähle deinen Anbieter aus.";
          } else if (vertragsArray.length === 1) {
            vertragsPanelTitelP.innerHTML = `Du hast ${vertragsArray.length} Vertrag ausgewählt`;
          } else if (vertragsArray.length > 1) {
            vertragsPanelTitelP.innerHTML = `Du hast ${vertragsArray.length} Verträge ausgewählt`;
          }
          //////////////////////////////////////////////////////////
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
          console.log(Array3);
          myFunction(x);
          x.addListener(myFunction);
          function myFunction(x) {
            if (x.matches && itemBox.className === !"box-is-active") {
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
            } else if (x.matches && itemBox.className === !"box-is-active") {
              console.log("2.4");
              remove(Array3, itemBox.id);
              console.log(Array3);
              itemBox.style.display = "block";
              itemBox.style.width = "48%";
              return;
            } else if (itemBox.className === "box-is-active" && x.matches) {
              console.log("2.4.1");
              itemBox.style.display = "block";
              itemBox.style.right = "0px";
              vertragspanel.style.display = "none";
              mainVA.style.bottom = "0px";
              remove(Array3, itemBox.id);
              boxClass.forEach(function(itemBox) {
                console.log(vertragsArray.length);
                console.log("2.1.1");
                itemBox.style.display = "none";
              });
              return;
            } else {
              console.log("2.4.2");
              remove(Array3, itemBox.id);
              console.log(Array3);
              console.log(itemBox.children[0].id);
              console.log(vertragsArray);
              console.log(itemBox.id);
              itemBox.style.display = "block";
              itemBox.style.width = "48%";

              return;
            }
          }
          return;
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
          console.log("ok1");
        } else {
          Array3.unshift(itemBox.id);
          console.log("ok");
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
          });
          for (let i = 0; i < vertragsArray.length; i++) {
            console.log(vertragsArray[i].key);
            var boxStyleDisplayNone1 = document.getElementById(
              vertragsArray[i].key
            );
            var vertragsBoxesDisplayNone = document.getElementById(
              boxStyleDisplayNone1.parentNode.id
            );
            vertragsBoxesDisplayNone.className = "box";
          }
          itemBox.style.display = "none";
          vertragspanel.style.display = "flex";
          mainVA.style.height = "auto";
          mainVA.style.bottom = "180px";
          mainVA.style.overflowY = "auto";
          auswahlPanel.style.margin = "10px";
          titel.style.display = "block";
        } else if (!x.matches && itemBox.className === "box-is-active") {
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
        } else if (x.matches && itemBox.className === !"box-is-active") {
          console.log("2.2");
          boxClass.forEach(function(itemBox) {
            console.log("2.2.1");
            itemBox.style.display = "block";
          });
          Array3.forEach(function(boxElement) {
            console.log("2.2.2");
            var boxStyleDisplayNone = document.getElementById(boxElement);
            boxStyleDisplayNone.style.display = "none";
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
          if (x.matches && itemBox.className === !"box-is-active") {
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
          } else if (x.matches && itemBox.className === !"box-is-active") {
            console.log("2.4");
            remove(Array3, itemBox.id);
            console.log(Array3);
            itemBox.style.display = "block";
            itemBox.style.width = "48%";
            return;
          } else if (itemBox.className === "box-is-active" && x.matches) {
            console.log("2.4.1");
            itemBox.style.display = "block";
            itemBox.style.right = "0px";
            vertragspanel.style.display = "none";
            mainVA.style.bottom = "0px";
            remove(Array3, itemBox.id);
            boxClass.forEach(function(itemBox) {
              console.log(vertragsArray.length);
              console.log("2.1.1");
              itemBox.style.display = "none";
            });
            return;
          } else {
            console.log("2.4.2");
            remove(Array3, itemBox.id);
            console.log(Array3);
            console.log(itemBox.children[0].id);
            console.log(vertragsArray);
            console.log(itemBox.id);
            itemBox.style.display = "block";
            itemBox.style.width = "48%";
            return;
          }
        }
      });
    }
  });
}

var mainVA = document.getElementById("mainVA");
var vertragspanelButton = document.querySelector(".vertragspanel-button");
vertragspanelButton.addEventListener("click", function() {
  vertragsArray.forEach(element => {
    localStorage.setItem("status-erfolg2", "vertragListe");
    if (localStorage.getItem("status-erfolg2")) {
      var div8 = document.createElement("div");
      div8.id = "fenster-erfolg";
      div8.innerText =
        "Die Liste der zu genehmigenden Verträge wurde aktualisiert!";
      mainVA.append(div8);
      setTimeout(function() {
        div8.remove();
        localStorage.removeItem("status-erfolg2");
      }, 4000);
    }
    let key = element.key;
    const value = element.value;
    localStorage.setItem(key, value);
    window.location.replace("vertragsUebersicht.php");
  });
});

boxShadowFnc(
  "Fernsehen",
  "background-fernsehen",
  showAuswahlList(
    "background-fernsehen",
    "fernsehen-select",
    "box-fernsehen",
    "Fernsehen",
    vertragWahlen(
      "Fernsehen",
      "fas fa-tv",
      "fernsehen",
      "fernsehen-select",
      "box-fernsehen",
      "background-fernsehen"
    )
  )
);

boxShadowFnc(
  "Gas",
  "background-gas",
  showAuswahlList(
    "background-gas",
    "gas-select",
    "box-gas",
    "Gas",
    vertragWahlen(
      "Gas",
      "fas fa-burn",
      "gas",
      "gas-select",
      "box-gas",
      "background-gas"
    )
  )
);

boxShadowFnc(
  "Mobilfunk",
  "background-mobilfunk",
  showAuswahlList(
    "background-mobilfunk",
    "mobilfunk-select",
    "box-mobilfunk",
    "Mobilfunk",
    vertragWahlen(
      "Mobilfunk",
      "fas fa-mobile-alt",
      "mobilfunk",
      "mobilfunk-select",
      "box-mobilfunk",
      "background-mobilfunk"
    )
  )
);
