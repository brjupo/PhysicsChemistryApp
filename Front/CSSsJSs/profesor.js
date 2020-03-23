document.addEventListener("click", function (evt) {
    var titulo = document.getElementById("titulo");
    targetElement = evt.target; // clicked element
    elID= targetElement.id;

    do {
        if (targetElement == titulo) {
            index();
            return;
        }
        // Go up the DOM
        targetElement = targetElement.parentNode;
    } while (targetElement);
});
function index(){
    window.location.href = "../index.html";
}