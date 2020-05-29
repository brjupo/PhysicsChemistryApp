
var nodoPadre = null;
var nombreImagen;

window.onload = function () {
}

document.addEventListener("click", function (evt) {
    var lections = document.getElementById("botonLecciones");
    var logout = document.getElementById("botonLogout");
    var editarAvatar = document.getElementById("editarAvatar");
    var botonGuardar = document.getElementById("guardarAvatar");
    targetElement = evt.target; // clicked element
    elID= targetElement.id;

    do {
        if (targetElement == lections) {
            lectionsv();
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
        if(elID.startsWith("avatar")){
            if(nodoPadre==null){
                targetElement.parentNode.style.backgroundColor = "rgb(200,200,255)";
            }
            else{
                nodoPadre.style.backgroundColor = "transparent";
                targetElement.parentNode.style.backgroundColor = "rgb(200,200,255)";
            }
            nombreImagen = targetElement.src;
            nodoPadre = targetElement.parentNode;
            return;
        }
        if (targetElement == botonGuardar) {
            console.log("save");
            document.getElementById("editarAvatar").src=nombreImagen;
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
function toggleAvatar(){
    document.getElementById("avatarElegir").classList.toggle("mostrarOpciones");
    document.getElementById("avatarElegir").classList.toggle("ocultarOpciones");
}
function do_logout(){
    location.replace("../../index.php");
}




function guardarAvatarEnBBDD(nombreImagen){
    var userID = document.getElementById("matricula").innerHTML.trim();
  
    $.ajax({
      type: "POST",
      url: "../../Servicios/subirPuntos.php",
      dataType: "json",
      data: { id: userID, imagen: nombreImagen },
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