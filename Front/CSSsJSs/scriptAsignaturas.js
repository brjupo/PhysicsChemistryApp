window.onload = function () {
    //lectionsv();
    if (window.history.replaceState) { // verificamos disponibilidad
        window.history.replaceState(null, null, window.location.href);
      }
}

document.addEventListener("click", function (evt) {
    var logout = document.getElementById("botonLogout");
    targetElement = evt.target; // clicked element

    do {
        if (targetElement == logout) {
            do_logout();
            return;
        }
        // Go up the DOM
        targetElement = targetElement.parentNode;
    } while (targetElement);
});

function do_logout(){
    location.replace("../../index.php");
}