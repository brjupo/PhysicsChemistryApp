
window.onload = function () {
    lectionsv();
}

document.addEventListener("click", function (evt) {
    var profile = document.getElementById("botonPerfil");
    var lections = document.getElementById("botonLecciones");
    var autores = document.getElementById("autores");
    var agradecimientos = document.getElementById("agradecimientos");
    targetElement = evt.target; // clicked element

    do {
        if (targetElement == profile) {
            profilev();
            return;
        }
        if (targetElement == lections) {
            lectionsv();
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