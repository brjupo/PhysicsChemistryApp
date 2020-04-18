
var nodoPadre = null;
var nombreImagen;

window.onload = function () {
    //lectionsv();
    if (window.history.replaceState) { // verificamos disponibilidad
        window.history.replaceState(null, null, window.location.href);
      }
}

document.addEventListener("click", function (evt) {
    var profile = document.getElementById("botonPerfil");
    var lections = document.getElementById("botonLecciones");
    var logout = document.getElementById("botonLogout");
    var editarAvatar = document.getElementById("editarAvatar");
    var botonGuardar = document.getElementById("guardarAvatar");
    targetElement = evt.target; // clicked element
    elID= targetElement.id;

    do {
        if (targetElement == profile) {
            //profilev();
            return;
        }
        if (targetElement == lections) {
            //lectionsv();
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

function profilev() {
    hideAll();
    document.getElementById("profile").style.display = "block";
}
function lectionsv() {
    hideAll();
    document.getElementById("lections").style.display = "block";
}
function toggleAvatar(){
    document.getElementById("avatarElegir").classList.toggle("mostrarOpciones");
    document.getElementById("avatarElegir").classList.toggle("ocultarOpciones");
}
function do_logout(){
    location.replace("../../index.php");
}