document.addEventListener("click", function (evt) {
  var guardarEnBBDD = document.getElementById("guardarEnBBDD");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == guardarEnBBDD) {
      saveInDB();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});



function saveInDB() {
    $.ajax({
        type: "POST",
        url: "../SERVICIOS/crearTema.php",
        dataType: "json",
        data: {
          id_asignatura: document.getElementById("id_asignatura").innerHTML.trim(),
          nuevoTema: document.getElementById("nuevoTema").value.trim()
        },
        success: function (data) {
          if (data.response == "exito") {
            alert("Creado en Base de datos");
          } else {
            console.log(data.response);
            alert("Error: " + data.response);
          }
        },
        error: function () {
          alert("ERROR Desconocido, Actualice la página y reintente");
        },
      });
}
