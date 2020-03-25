
window.onload = function () {
    misionf();
}

document.addEventListener("click", function (evt) {
    var mision = document.getElementById("mision");
    var vision = document.getElementById("vision");
    var autores = document.getElementById("autores");
    var agradecimientos = document.getElementById("agradecimientos");
    targetElement = evt.target; // clicked element

    do {
        if (targetElement == mision) {
            misionf();
            return;
        }
        if (targetElement == vision) {
            visionf();
            return;
        }
        if (targetElement == autores) {
            autoresf();
            return;
        }
        if (targetElement == agradecimientos) {
            agradecimientosf();
            return;
        }
        // Go up the DOM
        targetElement = targetElement.parentNode;
    } while (targetElement);
});

function hideAll() {
    document.getElementById("misionC").style.display = "none";
    document.getElementById("visionC").style.display = "none";
    document.getElementById("autoresC").style.display = "none";
    document.getElementById("agradecimientosC").style.display = "none";
}

function misionf() {
    hideAll();
    document.getElementById("misionC").style.display = "block";
}
function visionf() {
    hideAll();
    document.getElementById("visionC").style.display = "block";
}
function autoresf() {
    hideAll();
    document.getElementById("autoresC").style.display = "block";
}
function agradecimientosf() {
    hideAll();
    document.getElementById("agradecimientosC").style.display = "block";
}