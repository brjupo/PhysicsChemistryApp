window.onload = function() {
  var number = parseInt(document.getElementById("IDPregunta").value.trim());
  loadInformation();
  if (Number.isInteger(number)) {
    loadInformation();
  } else {
    alert("ERROR!. Verifique ID pregunta");
  }
};

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
      //Por ser un proceso dependiente y quieren que todo se suba con un boton
      //Primero subiremos la imagen
      uploadImage();
      //Luego preparamos la informacion
      //getDataToSaveInDDBB();
      //Al final subiremos la informacion
      //saveInDDBB();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function uploadImage() {
  if (document.getElementById("nuevaImagen").files.length != 0) {
    var data = new FormData(),
      files = document.getElementById("nuevaImagen").files;
    path = "../../../../IMAGENES/";

    data.append("fileToUpload", files[0]);
    data.append("path", path);
    data.append("idPregunta", document.getElementById("IDPregunta").value);

    $.ajax({
      url: "../servicios/uploadOneImage.php",
      type: "post",
      dataType: "json",
      data: data,
      processData: false,
      contentType: false,
      success: function (data) {
        if (data.response == "exito") {
          console.log("Segun se subió la imagen");
          getDataToSaveInDDBB();
        } else {
          //alert(data.response);
          console.log("Problema con la carga de la imagen");
        }
      },
    });
  }
  else{
    console.log("No subió una nueva imagen");
    getDataToSaveInDDBB();
  }
}

function getDataToSaveInDDBB() {
  //Crear objeto informacion
  //var person = {firstName:"John", lastName:"Doe", age:50, eyeColor:"blue"};
  var informacion = {
    IDPregunta: document.getElementById("IDPregunta").value,
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

  informacion = {
    IDPregunta: informacion.IDPregunta,
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
    url: "../servicios/updateFullQuestionInfoByID.php",
    dataType: "json",
    data: {
      IDPregunta: informacion.IDPregunta,
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
    url: "../servicios/getQuestionInfo.php",
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
  //Traer si tiene imagen, si tiene, que me regrese la extension, sino tiene que me regrese null
  if (data.idImagen == null) {
    document.getElementById("imagenPregunta").src =
      "../../../../IMAGENES/sinImagen.jpg";
      console.log("sin imagen");
  } else {
    document.getElementById("imagenPregunta").src =
      "../../../../IMAGENES/" + data.idImagen;
      console.log("mostrando imagen");
  }
}
