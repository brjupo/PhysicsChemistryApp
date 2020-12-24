document.addEventListener("click", function (evt) {
  var guardarEnBBDD = document.getElementById("guardarEnBBDD");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == guardarEnBBDD) {
      validateData();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});
function validateData() {
  if (document.getElementById("id_asignatura").value <= 0) {
    alert("Error en asignatura");
  } else if (document.getElementById("id_usuario").value <= 0) {
    alert("Error en usuario");
  } else if (
    document.getElementById("nombre_grupo").value == null ||
    document.getElementById("nombre_grupo").value == ""
  ) {
    alert("Error en grupo");
  } else if (
    document.getElementById("codigo_grupo").value == null ||
    document.getElementById("codigo_grupo").value == ""
  ) {
    alert("Error en codigo");
  } else {
    saveInDB();
  }
}
function saveInDB() {
  $.ajax({
    type: "POST",
    url: "../servicios/createGrupo.php",
    dataType: "json",
    data: {
      id_asignatura: document.getElementById("id_asignatura").value,
      id_usuario: document.getElementById("id_usuario").value,
      nombre_grupo: document.getElementById("nombre_grupo").value,
      codigo_grupo: document.getElementById("codigo_grupo").value,
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
