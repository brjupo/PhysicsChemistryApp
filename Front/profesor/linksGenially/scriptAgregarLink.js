document.addEventListener("click", function (evt) {
  var cargarInformacion = document.getElementById("cargarInformacion");
  var guardarEnBBDD = document.getElementById("guardarEnBBDD");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == cargarInformacion) {
      loadInformation();
      return;
    }
    if (targetElement == guardarEnBBDD) {
      saveInDDBB();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function saveInDDBB() {
  $.ajax({
    type: "POST",
    url: "../../Servicios/updateSubtopicLink.php",
    dataType: "json",
    data: {
      subtema: document.getElementById("subtema").value,
      linkGenially: document.getElementById("linkGenially").value
    },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        alert("Subtema actualizado en Base de datos");
      } else {
        alert("Error: " + data.response);
      }
    },
    error: function () {
      alert("ERROR Desconocido");
    },
  });
}

function loadInformation() {
  $.ajax({
    type: "POST",
    url: "../../Servicios/getSubtopicLinkInfo.php",
    dataType: "json",
    data: {
      leccion: document.getElementById("subtema").value,
      linkGenially: document.getElementById("linkGenially").value,
    },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        alert("Información mostrada");
        showData(data);
      } else {
        alert("Error: " + data.response);
      }
    },
    error: function () {
      alert("ERROR Desconocido");
    },
  });
}

function showData(data) {
  document.getElementById("subtema").value = data.subtema;
  document.getElementById("linkGenially").value = data.linkGenially;
}
