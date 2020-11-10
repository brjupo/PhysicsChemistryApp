var nodoPadre = null;
var nombreImagen;

window.onload = function () {};

document.addEventListener("click", function (evt) {
  var lections = document.getElementById("botonLecciones");
  var top5 = document.getElementById("botonTop");
  var logout = document.getElementById("botonLogout");
  var editarAvatar = document.getElementById("editarAvatar");
  var botonGuardar = document.getElementById("guardarAvatar");
  var conFactura1 = document.getElementById("conFactura1");
  var conFactura2 = document.getElementById("conFactura2");
  var sinFactura1 = document.getElementById("sinFactura1");
  var sinFactura2 = document.getElementById("sinFactura2");
  targetElement = evt.target; // clicked element
  elID = targetElement.id;

  do {
    if (targetElement == lections) {
      lectionsv();
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
    if (targetElement == editarAvatar) {
      toggleAvatar();
      return;
    }
    if (targetElement == conFactura1 || targetElement == conFactura2) {
      toggleConFactura();
      return;
    }
    if (targetElement == sinFactura1 || targetElement == sinFactura2) {
      toggleSinFactura();
      return;
    }
    if (elID.startsWith("avatar")) {
      if (nodoPadre == null) {
        targetElement.parentNode.style.backgroundColor = "rgb(200,200,255)";
      } else {
        nodoPadre.style.backgroundColor = "transparent";
        targetElement.parentNode.style.backgroundColor = "rgb(200,200,255)";
      }
      nombreImagen = targetElement.src;
      nodoPadre = targetElement.parentNode;
      return;
    }
    if (targetElement == botonGuardar) {
      console.log("save");
      document.getElementById("editarAvatar").src = nombreImagen;
      guardarAvatarEnBBDD(nombreImagen);
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function hideAll() {
  document.getElementById("profile").style.display = "none";
  document.getElementById("lections").style.display = "none";
}

function lectionsv() {
  var asignatura = document.getElementById("asignatura").innerHTML;
  var url = "temas.php?asignatura=";
  location.replace(url.concat(asignatura));
}

function topv() {
  var asignatura = document.getElementById("asignatura").innerHTML;
  var url = "top.php?asignatura=";
  location.replace(url.concat(asignatura));
}

function toggleAvatar() {
  document.getElementById("avatarElegir").classList.toggle("mostrarOpciones");
  document.getElementById("avatarElegir").classList.toggle("ocultarOpciones");
}

function toggleConFactura() {
  document.getElementById("conFactura").classList.toggle("mostrarOpciones");
  document.getElementById("conFactura").classList.toggle("ocultarOpciones");
  console.log("toggleando con factura");
}
function toggleSinFactura() {
  document.getElementById("sinFactura").classList.toggle("mostrarOpciones");
  document.getElementById("sinFactura").classList.toggle("ocultarOpciones");
}

function do_logout() {
  location.replace("../../../index.php");
}

function guardarAvatarEnBBDD(nombreImagen) {
  var userID = document.getElementById("matricula").innerHTML.trim();
  var res = nombreImagen.split("/");
  nombreImagen = res[res.length - 1];
  $.ajax({
    type: "POST",
    url: "../../servicios/actualizarAvatar.php",
    dataType: "json",
    data: { matricula: userID, avatar: nombreImagen },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        //alert("Etcito");
        console.log("Valores enviados correctamente");
      } else {
        //alert(data.response);
        console.log("Algo salio mal");
      }
    },
  });
}
