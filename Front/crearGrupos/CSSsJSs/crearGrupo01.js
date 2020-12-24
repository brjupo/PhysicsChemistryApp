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
    url: "../servicios/createGrupo.php",
    dataType: "json",
    data: {
      id_asignatura: document.getElementById("id_asignatura").value,
      id_usuario: document.getElementById("id_usuario").value,
      nombre_grupo: document.getElementById("nombre_grupo").value,
      codigo_grupo: document.getElementById("codigo_grupo").value
    },
    success: function (data) {
      if (data.response == "exito") {
        alert("Creado en Base de datos");
        location.reload();
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
