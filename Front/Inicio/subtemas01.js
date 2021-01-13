var cantidadIDs = 1;
window.onload = function () {
  contarIDs();
  entrada();
};

function opacity(shID) {
  document.getElementById(shID).style.opacity = 1.0;
}

function entrada() {
  function doSetTimeout(i) {
    var sesion = "seccion";
    sesion = sesion.concat(i);
    console.log("Cambiando opacidad a ", sesion);
    setTimeout(function () {
      opacity(sesion);
    }, i * 200);
  }
  for (var i = 1; i <= cantidadIDs; ++i) {
    doSetTimeout(i);
  }
}

function contarIDs() {
  for (var i = 1; i <= 100; i++) {
    var sesion = "seccion";
    sesion = sesion.concat(i);
    if (document.getElementById(sesion)) {
      console.log(sesion);
      //console.log(document.getElementById(i));
      cantidadIDs = i;
    }
  }
}

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
      topv();
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
  //var asignatura = document.getElementById("asignatura").innerHTML;
  //var url = "perfil.php?asignatura=";
  //location.replace(url.concat(asignatura));
  location.replace("perfil.php");
}
function topv() {
  //var asignatura = document.getElementById("asignatura").innerHTML;
  //var url = "topS.php?asignatura=";
  //location.replace(url.concat(asignatura));
  location.replace("topS.php");
}
function do_logout() {
  location.replace("../../../index.php");
}
