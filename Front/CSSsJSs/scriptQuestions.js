var questionMatrix = []; //En realidad es un array con objetos, por ser JSON
var questionNumber = []; 
var puntos = 0;

var CorrectAudio = new Audio("../CSSsJSs/sounds/Incorrect.mp3");
var IncorrectAudio = new Audio("../CSSsJSs/sounds/Correct.mp3");

//RECUERDA, ANTES DE MOSTRAR, DEBERÁS LIMPIAR LO QUE EL ALUMNO ESCRIBIÓ ANTES

window.onload = function () {
    createArrayWithQuestions();
    loadNewQuestion(questionNumber[0]);
};

function createArrayWithQuestions() {
  for (var i = 1001; i <= 1100; i++) {
    if (document.getElementById(i)) {
      questionNumber.push(i);
    }
  }
}


function loadNewQuestion(questionID) {
  enableNextQuestionButtons(questionID);
  colorNextQuestionButtons(questionID);
  displayNextQuestion(questionID);
  displayNextAnswer(questionID);
  //displayQuestionContainers(questionID);
  //loadInfoInContainers(questionID);
}

function enableNextQuestionButtons(questionID) {
  //document.getElementById("Opcion1SinImagen").disabled = false;
}
function colorNextQuestionButtons(questionID) {
  //document.getElementById("Opcion1SinImagen").className = "Opcion1";
  //document.getElementById("acceptSinImagen").className = "miniBoton";
}

function displayNextQuestion(questionID) {
}

function displayNextAnswer(questionID){

}
///////////////////////////////////TE QUEDASTE AQUI, RECOMIENDO CREAR LAS 4 FUNCIONES PREVIAS

document.addEventListener("click", function (evt) {
  cruzCerrar = document.getElementById("cruzCerrar");
  targetElement = evt.target; // clicked element

  do {
    console.log(targetElement.id);
    if (targetElement == cruzCerrar) {
      seguroRegresar();
      return;
    }
    if (
      targetElement == Opcion1SinImagen ||
      targetElement == Opcion2SinImagen ||
      targetElement == Opcion3SinImagen ||
      targetElement == Opcion4SinImagen
    ) {
      disableAllButtons();
      colorAllButtonsToWhite();
      verifyIfCorrectOption(targetElement.id);
      showContinueButton();
      return;
    }
    if (
      targetElement == Opcion1ConImagen ||
      targetElement == Opcion2ConImagen ||
      targetElement == Opcion3ConImagen ||
      targetElement == Opcion4ConImagen
    ) {
      disableAllButtons();
      colorAllButtonsToWhite();
      verifyIfCorrectOption(targetElement.id);
      showContinueButton();
      return;
    }
    if (targetElement == acceptConImagen) {
      disableAllButtons();
      colorAllButtonsToWhite();
      verifyIfTextIsCorrect();
      showContinueButton();
      return;
    }
    if (targetElement == acceptSinImagen) {
      disableAllButtons();
      colorAllButtonsToWhite();
      verifyIfTextIsCorrect();
      showContinueButton();
      return;
    }
    if (targetElement == botonSiguientePregunta) {
      nextQuestion();
      return;
    }

    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function seguroRegresar() {
  if (
    confirm(
      "¿Estás seguro de regresar?\n Si regresas perderás todo tu avance de este tema"
    )
  ) {
    var stringLiga = "https://kaanbal.net/Front/Inicio/lecciones.php?subtema=";
    window.location.href = stringLiga.concat(
      document.getElementById("subtemaPrevio").innerHTML.trim()
    );
  }
}

function disableAllButtons() {
  document.getElementById("Opcion1SinImagen").disabled = true;
  document.getElementById("Opcion2SinImagen").disabled = true;
  document.getElementById("Opcion3SinImagen").disabled = true;
  document.getElementById("Opcion4SinImagen").disabled = true;
  document.getElementById("Opcion1ConImagen").disabled = true;
  document.getElementById("Opcion2ConImagen").disabled = true;
  document.getElementById("Opcion3ConImagen").disabled = true;
  document.getElementById("Opcion4ConImagen").disabled = true;
  document.getElementById("acceptConImagen").disabled = true;
  document.getElementById("acceptSinImagen").disabled = true;
}

function colorAllButtonsToWhite() {
  document.getElementById("Opcion1SinImagen").className = "OpcionBlanco";
  document.getElementById("Opcion2SinImagen").className = "OpcionBlanco";
  document.getElementById("Opcion3SinImagen").className = "OpcionBlanco";
  document.getElementById("Opcion4SinImagen").className = "OpcionBlanco";
  document.getElementById("Opcion1ConImagen").className = "OpcionBlanco";
  document.getElementById("Opcion2ConImagen").className = "OpcionBlanco";
  document.getElementById("Opcion3ConImagen").className = "OpcionBlanco";
  document.getElementById("Opcion4ConImagen").className = "OpcionBlanco";
  document.getElementById("acceptConImagen").className = "OpcionMiniBlanco";
  document.getElementById("acceptSinImagen").className = "OpcionMiniBlanco";
}

function verifyIfCorrectOption(targetID) {
  var res = targetID.split("");
  // res[6]; == 1|2|3|4
  document.getElementById(targetID).className = "OpcionIncorrecta";
  patronaMasUno = parseInt(questionMatrix[questionNumber[0]]["patrona"]) + 1;
  document.getElementById(
    "Opcion" +
    patronaMasUno +
      res[7] +
      res[8] +
      "nImagen"
  ).className = "OpcionCorrecta";
  //AUN NO DESPLAZAMOS EL ARREGLO questionNumber[], por lo que podemos seguir leyendo de la posicion [0]
  if (res[6] == patronaMasUno) {
    questionNumber.shift();
    puntos = puntos + 1;
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
    CorrectAudio.play();
  } else {
    questionNumber.push(questionNumber[0]);
    questionNumber.shift();
    IncorrectAudio.play();
  }
}

function verifyIfTextIsCorrect() {
  if (questionMatrix[questionNumber[0]]["patrona"] == 1) {
  }
  //NORMALIZAR la respuesta CORRECTA
  var respuestaCorrectaNormalizada = 
    questionMatrix[questionNumber[0]]["patrona"]
    .normalize("NFD")
    .replace(
      /([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,
      "$1"
    )
    .normalize();
  var respuestaCorrectaUpper = respuestaCorrectaNormalizada.toUpperCase();

  //NORMALIZAR la respuesta ESCRITA
  var respuestaEscritaTrim = document.getElementById("idTextoEscrito").value.trim();
  var respuestaEscritaNormalizada = respuestaEscritaTrim
    .normalize("NFD")
    .replace(
      /([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,
      "$1"
    )
    .normalize();
  var respuestaEscritaUpper = respuestaEscritaNormalizada.toUpperCase();
  //Muestras la respuesta correcta en el Boton
  document.getElementById("acceptConImagen").innerHTML = questionMatrix[questionNumber[0]]["patrona"];
  document.getElementById("acceptSinImagen").innerHTML = questionMatrix[questionNumber[0]]["patrona"];
  if (respuestaEscritaUpper == respuestaCorrectaUpper) {
    questionNumber.shift();
    document.getElementById("idTextoEscrito").style.color = "green";
    document.getElementById("idTextoEscrito").value = document
      .getElementById("idTextoEscrito")
      .value.toLowerCase();
    puntos = puntos + 1;
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
    CorrectAudio.play();
  } else {
    questionNumber.push(questionNumber[0]);
    questionNumber.shift();
    document.getElementById("idTextoEscrito").style.color = "red";
    document.getElementById("idTextoEscrito").value = document
      .getElementById("idTextoEscrito")
      .value.toLowerCase();
    IncorrectAudio.play();
  }
}

function barWidth(puntos) {
  anchoBarra = 100 * puntos;
  anchoBarra = anchoBarra / questionMatrix.length;
  anchoBarra = parseInt(anchoBarra).toString(10);
  //barraAvance
  stringPorcentaje = anchoBarra.concat("%");
  document.getElementById("barraAvance").style.width = stringPorcentaje;
}

function showContinueButton() {
  document.getElementById("botonSiguientePregunta").style.display = "block";
}

function hiddeAll() {
  document.getElementById("PreguntaTipo1").style.display = "none";
  document.getElementById("RespuestasTipo1ConImagen").style.display = "none";
  document.getElementById("RespuestasTipo1SinImagen").style.display = "none";

  document.getElementById("PreguntaTipo2").style.display = "none";
  document.getElementById("RespuestasTipo2ConImagen").style.display = "none";
  document.getElementById("RespuestasTipo2SinImagen").style.display = "none";

  document.getElementById("botonSiguientePregunta").style.display = "none";
}

function nextQuestion() {
  hiddeAll();
  document.getElementById("acceptConImagen").innerHTML = "Accept";
  document.getElementById("acceptSinImagen").innerHTML = "Accept";
  if (questionNumber.length == 0) {
    enviarCalificacion();
  } else {
    loadNewQuestion(questionNumber[0]);
  }
}

function enviarCalificacion() {
  var userID = document.getElementById("userID").innerHTML.trim();
  var leccionID = document.getElementById("leccionID").innerHTML.trim();
  //alert(userID+ " "+ puntos+ " "+ leccionID);

  $.ajax({
    type: "POST",
    url: "../../Servicios/subirPuntos.php",
    dataType: "json",
    data: { id: userID, leccion: leccionID, puntos: puntos },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        //alert("Etcito");
        console.log("Valores enviados correctamente");
        var stringLiga =
          "https://kaanbal.net/Front/Inicio/lecciones.php?subtema=";
        window.location.replace(
          stringLiga.concat(
            document.getElementById("subtemaPrevio").innerHTML.trim()
          )
        );
      } else {
        //alert(data.response);
        console.log("Algo salio mal");
      }
    },
  });
}
