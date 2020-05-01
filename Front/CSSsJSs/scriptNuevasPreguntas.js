var questionMatrix = []; //En realidad es un array con objetos, por ser JSON
var questionIDs = [];
function borrarParaLoBueno() {
  questionMatrix = [
    {
      estatus: "1",
      id_autor: "1",
      id_leccion: "2",
      id_pregunta: "10",
      orden: "1",
      patrona: "Factores bióticos",
      pregunta:
        "Comprende a todos los seres vivos de un ecosistema y las interrelaciones entre ellos",
      preguntaParte1:
        "Comprende a todos los seres vivos de un ecosistema y las interrelaciones entre ellos",
      preguntaParte2: "",
      respuesta2: "Fenómenos físicos",
      respuesta3: "Fenómenos químicos",
      respuesta4: "Factores bióticos",
      respuesta_correcta: "Lluvia",
      tipo: "1",
      tiene_imagen: "false",
    },
    {
      estatus: "1",
      id_autor: "1",
      id_leccion: "2",
      id_pregunta: "12",
      orden: "3",
      patrona: "ABIOTICOS",
      pregunta: "La humedad, la lluvia y la luz son ejemplos de factores:",
      preguntaParte1:
        "La humedad, la lluvia y la luz son ejemplos de factores:",
      preguntaParte2: "",
      respuesta2: null,
      respuesta3: null,
      respuesta4: "ABIOTICOS",
      respuesta_correcta: null,
      tipo: "2",
      tiene_imagen: "false",
    },
  ];
}

function getQuestionMatrix() {
  var leccionID = document.getElementById("leccionID").value.trim();
  var Usuario = document.getElementById("Usuario").value.trim();
  var Password = document.getElementById("Password").value.trim();
  alert(Usuario + " " + Password + " " + leccionID);

  $.ajax({
    type: "POST",
    url: "../../Servicios/preguntasGral.php",
    dataType: "json",
    //data: {leccion: leccionID, userID: Usuario, pass:Password},
    data: { IDLeccion: leccionID },
    success: function (data) {
      console.log(data);
    },
  });
}

window.onload = function () {
  borrarParaLoBueno();
  //questionMatrix = getQuestionMatrix();
  createArrayWithQuestions();
  loadNewQuestion(questionIDs[0]);
};

function createArrayWithQuestions() {
  console.log(questionMatrix.length);
  console.log(questionMatrix[0]["id_pregunta"]);
  console.log(questionMatrix[1]["id_pregunta"]);
  for (i = 0; i < questionMatrix.length; i++) {
    questionIDs.push(questionMatrix[i]["id_pregunta"]);
  }
}

function loadNewQuestion(questionID) {
  enableAllButtons();
  displayQuestionContainers(questionID);
  loadInfoInContainers(questionID);
}

function enableAllButtons() {
  document.getElementById("Opcion1SinImagen").disabled = false;
  document.getElementById("Opcion2SinImagen").disabled = false;
  document.getElementById("Opcion3SinImagen").disabled = false;
  document.getElementById("Opcion4SinImagen").disabled = false;
  document.getElementById("Opcion1ConImagen").disabled = false;
  document.getElementById("Opcion2ConImagen").disabled = false;
  document.getElementById("Opcion3ConImagen").disabled = false;
  document.getElementById("Opcion4ConImagen").disabled = false;
  document.getElementById("acceptConImagen").disabled = false;
  document.getElementById("acceptSinImagen").disabled = false;
}

function displayQuestionContainers(questionID) {
  if (questionMatrix[questionID]["tipo"] == "1") {
    document.getElementById("PreguntaTipo1").style.display = "block";
    if (questionMatrix[questionID]["tiene_imagen"] == "true") {
      document.getElementById("RespuestasTipo1ConImagen").style.display =
        "block";
    } else {
      document.getElementById("RespuestasTipo1SinImagen").style.display =
        "block";
    }
  } else if (questionMatrix[questionID]["tipo"] == "2") {
    document.getElementById("PreguntaTipo2").style.display = "block";
    if (questionMatrix[questionID]["tiene_imagen"] == "true") {
      document.getElementById("RespuestasTipo2ConImagen").style.display =
        "block";
    } else {
      document.getElementById("RespuestasTipo2SinImagen").style.display =
        "block";
    }
  }
}

function loadInfoInContainers(questionID) {
  //textoPreguntaTipo1  Opcion1ConImagen   imagenPreguntaTipo1  acceptConImagen
  // <input type="text" id="idTextoEscrito">
  //"../CSSsJSs/images/problemaFisica.jpg"
  if (questionMatrix[questionID]["tipo"] == "1") {
    document.getElementById("textoPreguntaTipo1").innerHTML =
      questionMatrix[questionID]["preguntaParte1"];
    if (questionMatrix[questionID]["tiene_imagen"] == "true") {
      document.getElementById("imagenPreguntaTipo1").src =
        "../../CSSsJSs/imagenes/" + questionID + ".jpg";
      document.getElementById("Opcion1ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta_correcta"];
      document.getElementById("Opcion2ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta2"];
      document.getElementById("Opcion3ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta3"];
      document.getElementById("Opcion4ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta4"];
    } else {
      document.getElementById("Opcion1SinImagen").innerHTML =
        questionMatrix[questionID]["respuesta_correcta"];
      document.getElementById("Opcion2SinImagen").innerHTML =
        questionMatrix[questionID]["respuesta2"];
      document.getElementById("Opcion3ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta3"];
      document.getElementById("Opcion4ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta4"];
    }
  } else if (questionMatrix[questionID]["tipo"] == "2") {
    document.getElementById("textoPreguntaTipo2").innerHTML =
      questionMatrix[questionID]["preguntaParte1"] +
      '<input type="text" id="idTextoEscrito">' +
      questionMatrix[questionID]["preguntaParte2"];
    if (questionMatrix[questionID]["tiene_imagen"] == "true") {
      document.getElementById("imagenPreguntaTipo2").src =
        "../../CSSsJSs/imagenes/" + questionID + ".jpg";
    }
  }
}

document.addEventListener("click", function (evt) {
    var cruzCerrar = document.getElementById("cruzCerrar");
    var botonSiguientePregunta = document.getElementById("sprintNext");
    targetElement = evt.target; // clicked element
  
    do {
      if (targetElement == cruzCerrar) {
        seguroRegresar();
        return;
      }
      if (targetElement == botonSiguientePregunta) {
        if (cantidadIDs - 1000 == preguntaActual) {
          primerVueltaTerminada = true;
          if (preguntasIncorrectas.length == 0) {
            enviarCalificacion();
          } else {
            siguientePregunta(preguntasIncorrectas[0]);
            preguntaPrevia2daVuelta = preguntasIncorrectas[0];
          }
        } else {
          siguientePregunta(0);
        }
        return;
      }
      if (
        parseInt(targetElement.id) >= 10 * preguntaActual - 3 &&
        parseInt(targetElement.id) <= 10 * preguntaActual &&
        popUpLevantado === false
      ) {
        //console.log(parseInt(targetElement.id));
        whiteButtons(targetElement.id);
        sprintNext();
        popUpLevantado = true;
        //console.log(popUpLevantado);
        return;
      }
      if (
        parseInt(targetElement.id) == 10 * preguntaActual - 4 &&
        popUpLevantado === false
      ) {
        //console.log(parseInt(targetElement.id));
        whiteButtonsType2(targetElement.id);
        sprintNextType2();
        popUpLevantado = true;
        //console.log(popUpLevantado);
        return;
      }
      // Go up the DOM
      targetElement = targetElement.parentNode;
    } while (targetElement);
  });