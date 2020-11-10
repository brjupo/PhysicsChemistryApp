document.addEventListener("click", function (evt) {
  var cargarInformacion = document.getElementById("cargarInformacion");
  var siguientePregunta = document.getElementById("siguientePregunta");
  var guardarEnBBDD = document.getElementById("guardarEnBBDD");
  targetElement = evt.target; // clicked element

  do {
    var number = parseInt(document.getElementById("IDPregunta").value.trim());
    if (targetElement == cargarInformacion) {
      if (Number.isInteger(number)) {
        loadInformation();
      } else {
        alert("ERROR!. Verifique ID pregunta");
      }
      return;
    }
    if (targetElement == siguientePregunta) {
      if (Number.isInteger(number)) {
        document.getElementById("IDPregunta").value = number + 1;
        loadInformation();
      } else {
        alert("ERROR!. Verifique ID pregunta");
      }
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
    url: "../../servicios/updateFullQuestionInfoByID.php",
    dataType: "json",
    data: {
      IDPregunta: document.getElementById("IDPregunta").value,
      pregunta: document
        .getElementById("pregunta")
        .value.replace(/\\/g, "\\\\"),
      respuesta_correcta: document
        .getElementById("respuesta_correcta")
        .value.replace(/\\/g, "\\\\"),
      respuesta2: document
        .getElementById("respuesta2")
        .value.replace(/\\/g, "\\\\"),
      respuesta3: document
        .getElementById("respuesta3")
        .value.replace(/\\/g, "\\\\"),
      respuesta4: document
        .getElementById("respuesta4")
        .value.replace(/\\/g, "\\\\"),
      question: document
        .getElementById("question")
        .value.replace(/\\/g, "\\\\"),
      correct_answer: document
        .getElementById("correct_answer")
        .value.replace(/\\/g, "\\\\"),
      answer2: document.getElementById("answer2").value.replace(/\\/g, "\\\\"),
      answer3: document.getElementById("answer3").value.replace(/\\/g, "\\\\"),
      answer4: document.getElementById("answer4").value.replace(/\\/g, "\\\\"),
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
    url: "../../servicios/getFullQuestionInfoByID.php",
    dataType: "json",
    data: {
      IDPregunta: document.getElementById("IDPregunta").value,
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
