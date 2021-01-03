var nodoPadre = null;
var nombreImagen;

window.onload = function () {};

document.addEventListener("click", function (evt) {
  var lections = document.getElementById("botonLecciones");
  var profile = document.getElementById("botonPerfil");
  var logout = document.getElementById("botonLogout");
  var grupal = document.getElementById("topGrupalButton");
  var semestral = document.getElementById("topSemestralButton");
  var nacional = document.getElementById("topNacionalButton");
  targetElement = evt.target; // clicked element
  elID = targetElement.id;

  do {
    if (targetElement == lections) {
      lectionsv();
      return;
    }
    if (targetElement == profile) {
      profilev();
      return;
    }
    if (targetElement == logout) {
      do_logout();
      return;
    }
    if (targetElement == grupal) {
      showTopGrupal();
      return;
    }
    if (targetElement == semestral) {
      showTopSemestral();
      return;
    }
    if (targetElement == nacional) {
      showTopNacional();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function lectionsv() {
  var asignatura = document.getElementById("asignatura").innerHTML;
  var url = "temas.php?asignatura=";
  location.replace(url.concat(asignatura));
}
function profilev() {
  var asignatura = document.getElementById("asignatura").innerHTML;
  var url = "perfil.php?asignatura=";
  location.replace(url.concat(asignatura));
}
function topv() {
  var asignatura = document.getElementById("asignatura").innerHTML;
  var url = "top.php?asignatura=";
  location.replace(url.concat(asignatura));
}
function do_logout() {
  location.replace("../../../index.php");
}
function hideAllTops() {
  document.getElementById("topGrupal").style.display = "none";
  document.getElementById("topSemestral").style.display = "none";
  document.getElementById("topNacional").style.display = "none";
}
function blueAllButtons() {
  document.getElementById("topGrupalButton").classList.remove('btn-primary');
  document.getElementById("topSemestralButton").classList.remove('btn-primary');
  document.getElementById("topNacionalButton").classList.remove('btn-primary');
}
function showTopGrupal() {
  hideAllTops();
  document.getElementById("topGrupal").style.display = "block";
  blueAllButtons();
  document.getElementById("topGrupalButton").classList.add('btn-light');
}
function showTopSemestral() {
  hideAllTops();
  document.getElementById("topSemestral").style.display = "block";
  blueAllButtons();
  document.getElementById("topSemestralButton").classList.add('btn-light');
}
function showTopNacional() {
  hideAllTops();
  document.getElementById("topNacional").style.display = "block";
  blueAllButtons();
  document.getElementById("topNacionalButton").classList.add('btn-light');
}
