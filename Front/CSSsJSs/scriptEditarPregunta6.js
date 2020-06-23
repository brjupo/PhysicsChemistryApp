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
    url: "../../Servicios/updateFullQuestionInfo.php",
    dataType: "json",
    data: {
      leccion: document.getElementById("idLeccion").value,
      numeroPregunta: document.getElementById("numeroPregunta").value,
      pregunta: document.getElementById("pregunta").value.replace("\\", "\\\\"),
      respuesta_correcta: document.getElementById("respuesta_correcta").value.replace("\\", "\\\\"),
      respuesta2: document.getElementById("respuesta2").value.replace("\\", "\\\\"),
      respuesta3: document.getElementById("respuesta3").value.replace("\\", "\\\\"),
      respuesta4: document.getElementById("respuesta4").value.replace("\\", "\\\\"),
      question: document.getElementById("question").value.replace("\\", "\\\\"),
      correct_answer: document.getElementById("correct_answer").value.replace("\\", "\\\\"),
      answer2: document.getElementById("answer2").value.replace("\\", "\\\\"),
      answer3: document.getElementById("answer3").value.replace("\\", "\\\\"),
      answer4: document.getElementById("answer4").value.replace("\\", "\\\\"),
      tipo: document.getElementById("tipo").value,
    },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        alert("Pregunta actualizada en Base de datos");
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
    url: "../../Servicios/getFullQuestionInfo.php",
    dataType: "json",
    data: {
      leccion: document.getElementById("idLeccion").value,
      numeroPregunta: document.getElementById("numeroPregunta").value,
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
  document.getElementById("pregunta").value = data.pregunta;
  document.getElementById("respuesta_correcta").value = data.respuesta_correcta;
  document.getElementById("respuesta2").value = data.respuesta2;
  document.getElementById("respuesta3").value = data.respuesta3;
  document.getElementById("respuesta4").value = data.respuesta4;
  document.getElementById("question").value = data.question;
  document.getElementById("correct_answer").value = data.correct_answer;
  document.getElementById("answer2").value = data.answer2;
  document.getElementById("answer3").value = data.answer3;
  document.getElementById("answer4").value = data.answer4;
  document.getElementById("tipo").value = data.tipo;
}
