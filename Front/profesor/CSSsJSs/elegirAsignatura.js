document.addEventListener("click", function (evt) {
    var buscarTemas = document.getElementById("buscarTemas");
    targetElement = evt.target; // clicked element

    do {
        if (targetElement == buscarTemas) {
            searchTopics();
            return;
        }
        // Go up the DOM
        targetElement = targetElement.parentNode;
    } while (targetElement);
});

function searchTopics(){
    IDtopic = document.getElementById("topics").value;
    window.location.href = "/editarTema.php?ID_Asignatura="+IDtopic;
}