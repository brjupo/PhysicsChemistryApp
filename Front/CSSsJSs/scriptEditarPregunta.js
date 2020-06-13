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
    url: "../../Servicios/updateQuestionInfo.php",
    dataType: "json",
    data: {
      leccion: document.getElementById("idLeccion").value,
      numeroPregunta: document.getElementById("numeroPregunta").value,
    },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        alert("Información obtenida");
        showData(data);
      } else {
        alert(data.response);
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
    url: "../../Servicios/getQuestionInfo.php",
    dataType: "json",
    data: {
      leccion: document.getElementById("idLeccion").value,
      numeroPregunta: document.getElementById("numeroPregunta").value,
      pregunta: document.getElementById("pregunta").value,
      respuesta_correcta: document.getElementById("respuesta_correcta").value,
      respuesta2: document.getElementById("respuesta2").value,
      respuesta3: document.getElementById("respuesta3").value,
      respuesta4: document.getElementById("respuesta4").value,
      tipo: document.getElementById("tipo").value,
    },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        alert("Información cargada");
      } else {
        alert(data.response);
      }
    },
    error: function () {
      alert("ERROR Desconocido");
    },
  });
}

function showData(data) {
  document.getElementById("pregunta").value = data.pregunta;
  document.getElementById("respuesta_correcta").value = data.respuesta_correcta;
  document.getElementById("respuesta2").value = data.respuesta2;
  document.getElementById("respuesta3").value = data.respuesta3;
  document.getElementById("respuesta4").value = data.respuesta4;
  document.getElementById("tipo").value = data.tipo;
}
