/*document.addEventListener("click", function (evt) {
    var flyoutElement = document.getElementById('botonCodigo');
    var flyoutElement2 = document.getElementById('botonSesion');
    targetElement = evt.target;  // clicked element

    do {
        if(targetElement.className==="continue") {
            document.getElementById("flyout-debug").textContent = "Clicked dentro de continue";
            return;
        }
        if (targetElement == flyoutElement) {
            // This is a click inside. Do nothing, just return.
            document.getElementById("flyout-debug").textContent = "Clicked inside!";
            return;
        }
        if (targetElement == flyoutElement2) {
            // This is a click inside. Do nothing, just return.
            document.getElementById("flyout-debug").textContent = "Clicked inside!";
            return;
        }
        // Go up the DOM
        targetElement = targetElement.parentNode;
    } while (targetElement);

    // This is a click outside.
    document.getElementById("flyout-debug").textContent = "Clicked outside!";
    hideAll();
});*/

document.addEventListener("click", function (evt) {
    var botonCodigo = document.getElementById('botonCodigo');
    var botonSesion = document.getElementById('botonSesion');
    var botonContrasenaOlvidada = document.getElementById('contraOlvidada');
    targetElement = evt.target;  // clicked element

    do {
        if (targetElement == botonCodigo) {
            showCode();
            return;
        }
        if (targetElement == botonSesion) {
            showSession();
            return;
        }
        if(targetElement.className==="continue") {
            //ENVIAR AL WEBSERVICE
            var els = document.getElementsByTagName("input");
            var i;
            for(i=0; i<els.length;i++){
                els[i].value="";
            }
            return;
        }
        if (targetElement == botonContrasenaOlvidada) {
            showContraOlvidada();
            return;
        }
        // Go up the DOM
        targetElement = targetElement.parentNode;
    } while (targetElement);
});

function showCode() {
    hideAll();
    document.getElementById("seccionCodigo").style.display = "block";
}
function showSession() {
    hideAll();
    document.getElementById("seccionSesion").style.display = "block";
}

function hideAll() {
    document.getElementById("seccionCodigo").style.display = "none";
    document.getElementById("seccionSesion").style.display = "none";
    document.getElementById("emailSent").style.display = "none";
}

function showContraOlvidada(){
    hideAll();
    document.getElementById("emailSent").style.display = "block";
}

window.onload = function () {
    this.hideAll();
};