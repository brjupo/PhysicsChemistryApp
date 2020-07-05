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
      getDataToSaveInDDBB();
      //saveInDDBB();//Llamada al finalizar la funcion previa. Ya que se necesitan multiples ocnversiones de info
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function getDataToSaveInDDBB() {
  //Crear objeto informacion
  //var person = {firstName:"John", lastName:"Doe", age:50, eyeColor:"blue"};
  var informacion = {
    leccion: document.getElementById("idLeccion").value,
    numeroPregunta: document.getElementById("numeroPregunta").value,
    pregunta: document.getElementById("pregunta").value.replace(/\\/g, "\\\\"),
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
    question: document.getElementById("question").value.replace(/\\/g, "\\\\"),
    correct_answer: document
      .getElementById("correct_answer")
      .value.replace(/\\/g, "\\\\"),
    answer2: document.getElementById("answer2").value.replace(/\\/g, "\\\\"),
    answer3: document.getElementById("answer3").value.replace(/\\/g, "\\\\"),
    answer4: document.getElementById("answer4").value.replace(/\\/g, "\\\\"),
    tipo: document.getElementById("tipo").value,
  };
  // En casos se debe transformar la informacion más de una vez
  //Curiosamente existe problema con los campos en objetos que tienen el guion bajo
  /*
  tempCorrecta = document
  .getElementById("respuesta_correcta")
  .value.replace(/\\/g, "\\\\");
  tempCorrecta = tempCorrecta.replace(/'/g, "''");

  tempCorrect = document
  .getElementById("correct_answer")
  .value.replace(/\\/g, "\\\\");
  tempCorrect = tempCorrect.replace(/'/g, "''");
  */

  informacion = {
    leccion: informacion.leccion,
    numeroPregunta: informacion.numeroPregunta,
    pregunta: informacion.pregunta.replace(/'/g, "''"),
    respuesta_correcta: informacion.respuesta_correcta.replace(/'/g, "''"),
    respuesta2: informacion.respuesta2.replace(/'/g, "''"),
    respuesta3: informacion.respuesta3.replace(/'/g, "''"),
    respuesta4: informacion.respuesta4.replace(/'/g, "''"),
    question: informacion.question.replace(/'/g, "''"),
    correct_answer: informacion.correct_answer.replace(/'/g, "''"),
    answer2: informacion.answer2.replace(/'/g, "''"),
    answer3: informacion.answer3.replace(/'/g, "''"),
    answer4: informacion.answer4.replace(/'/g, "''"),
    tipo: informacion.tipo,
  };
  saveInDDBB(informacion);
}


function saveInDDBB(informacion) {
  $.ajax({
    type: "POST",
    url: "../SERVICIOS/updateFullQuestionInfo.php",
    dataType: "json",
    data: {
      leccion: informacion.leccion,
      numeroPregunta: informacion.numeroPregunta,
      pregunta: informacion.pregunta,
      respuesta_correcta: informacion.respuesta_correcta,
      respuesta2: informacion.respuesta2,
      respuesta3: informacion.respuesta3,
      respuesta4: informacion.respuesta4,
      question: informacion.question,
      correct_answer: informacion.correct_answer,
      answer2: informacion.answer2,
      answer3: informacion.answer3,
      answer4: informacion.answer4,
      tipo: informacion.tipo,
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
    url: "../SERVICIOS/getFullQuestionInfo.php",
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
