var nodoPadre = null;
var nombreImagen;

window.onload = function () {};

document.addEventListener("click", function (evt) {
  var profile = document.getElementById("botonPerfil");
  var top5 = document.getElementById("botonTop");
  var logout = document.getElementById("botonLogout");
  targetElement = evt.target; // clicked element
  elID = targetElement.id;

  do {
    if (targetElement == profile) {
      profilev();
      return;
    }
    if (targetElement == top5) {
      top();
      return;
    }
    if (targetElement == logout) {
      do_logout();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function profilev() {
  var asignatura = document.getElementById("asignatura").innerHTML;
  var url = "perfil.php?asignatura=";
  location.replace(url.concat(asignatura));
}
function top() {
  var asignatura = document.getElementById("asignatura").innerHTML;
  var url = "top.php?asignatura=";
  location.replace(url.concat(asignatura));
}
function do_logout() {
  location.replace("../../index.php");
}