var lastQuestion = 0;
var questionNumberArray = [];
var puntos = 0;
var questionWasAnswered = false;
var firstTimeToSaveGrade = 0;
var timeIntervalX = setInterval(function () {
  var i = 1;
}, 500);
var segundosTotales = 0;
var segundosTotales_2_3 = 0;
var segundosTotales_1_3 = 0;
var idioma = "e";
var segundosActuales = 0;
var acumulador = 0;

var CorrectAudio = new Audio("../../CSSsJSs/sounds/Incorrect.mp3");
var IncorrectAudio = new Audio("../../CSSsJSs/sounds/Correct.mp3");

//RECUERDA, ANTES DE MOSTRAR, DEBERÁS LIMPIAR LO QUE EL ALUMNO ESCRIBIÓ ANTES

window.onload = function () {
  contarTiempo();
  idioma = document.getElementById("idioma").innerHTML.trim();
  getTimeForSprint();
};

function contarTiempo() {
  window.setInterval(function () {
    acumulador++;
  }, 1000);
}

function getTimeForSprint() {
  leccion = document.getElementById("leccionID").innerHTML.trim();
  $.ajax({
    type: "POST",
    url: "getTimeForSprint.php",
    dataType: "json",
    data: { leccion: leccion },
    success: function (data) {
      console.log(data.seconds);
      console.log(data.response);
      if (data.response == "true") {
        segundosTotales = parseInt(data.seconds);
        segundosTotales_2_3 = parseInt((segundosTotales * 2) / 3);
        segundosTotales_1_3 = parseInt(segundosTotales / 3);
        createArrayWithQuestions();
      } else {
        alert("Error en el tiempo.");
      }
    },
  });
  //return segundosTotales;
}

function createArrayWithQuestions() {
  for (var i = 1001; i <= 1100; i++) {
    if (document.getElementById(i)) {
      questionNumberArray.push(i - 1000);
    } else {
      break;
    }
  }
  loadNewQuestion(questionNumberArray[0]);
}

function loadNewQuestion(questionNumber) {
  enableNextQuestionButtons(questionNumber);
  colorNextQuestionButtons(questionNumber);
  displayNextQuestion(questionNumber);
  displayNextAnswer(questionNumber);
  questionWasAnswered = false;
  startClock();
  //displayQuestionContainers(questionNumber);
  //loadInfoInContainers(questionNumber);
}

function enableNextQuestionButtons(questionNumber) {
  //Si existe el ID 10*numeroDePregunta, es porque es pregunta tipo 1, de opción múltiple
  //Por lo tanto debemos habilitar los 4 botones de opción múltiple. De lo contrario
  //Habilitar el boton de Aceptar
  if (document.getElementById(10 * questionNumber)) {
    document.getElementById(10 * questionNumber).disabled = false;
    document.getElementById(10 * questionNumber - 1).disabled = false;
    document.getElementById(10 * questionNumber - 2).disabled = false;
    document.getElementById(10 * questionNumber - 3).disabled = false;
  } else {
    document.getElementById(10 * questionNumber - 4).disabled = false;
  }
}
function colorNextQuestionButtons(questionNumber) {
  //Se deben colorear las opciones, esto no afecta al principio, pero si en las preguntas
  //que se repiten, porque el usuario se equivocó, se deben volver a colorear
  //QUIZÁ debamos llamar otra pantalla, ya que las preguntas no se vuelven a revolver

  //Si existe el ID 10*numeroDePregunta, es porque es pregunta tipo 1, de opción múltiple
  //Por lo tanto debemos habilitar los 4 botones de opción múltiple. De lo contrario
  //Habilitar el boton de Aceptar
  if (document.getElementById(10 * questionNumber)) {
    document.getElementById(10 * questionNumber).className = "Opcion4";
    document.getElementById(10 * questionNumber - 1).className = "Opcion3";
    document.getElementById(10 * questionNumber - 2).className = "Opcion2";
    document.getElementById(10 * questionNumber - 3).className = "Opcion1";
  } else {
    document.getElementById(10 * questionNumber - 4).className = "miniBoton";
  }
  //Limpiar si es necesario y Colorear a negro de nuevo el campo de respuesta
  if (document.getElementById(questionNumber * 10 - 5)) {
    document.getElementById(questionNumber * 10 - 5).value = "";
    document.getElementById(questionNumber * 10 - 5).style.color = "black";
  }
}

function displayNextQuestion(questionNumber) {
  //document.getElementById("PreguntaTipo1").style.display = "block";
  //Se deben mostrar los bloques de pregunta y respuesta. Dado que ya tenemos un arreglo
  //Con el numero relativo de cada pregunta, por ejemplo si en esta lección existen 5 preguntas
  //Tenemos un arreglo {1,2,3,4,5}.
  //El bloque de pregunta es numeroDePregunta + 1000
  //El bloque de respuestas/botones es numeroDePregunta + 2000
  document.getElementById(questionNumber + 1000).style.display = "block";
}

function displayNextAnswer(questionNumber) {
  //document.getElementById("PreguntaTipo1").style.display = "block";
  //Se deben mostrar los bloques de pregunta y respuesta. Dado que ya tenemos un arreglo
  //Con el numero relativo de cada pregunta, por ejemplo si en esta lección existen 5 preguntas
  //Tenemos un arreglo {1,2,3,4,5}.
  //El bloque de pregunta es numeroDePregunta + 1000
  //El bloque de respuestas/botones es numeroDePregunta + 2000
  document.getElementById(questionNumber + 2000).style.display = "block";
}

/*
disableAllButtons();
colorAllButtonsToWhite();
verifyIfCorrectOption(targetElement.id);
showContinueButton();
*/

/*
disableAllButtons();
colorAllButtonsToWhite();
verifyIfTextIsCorrect();
showContinueButton();
*/

//nextQuestion();

//questionNumberArray[0]

document.addEventListener("click", function (evt) {
  var cruzCerrar = document.getElementById("cruzCerrar");
  var botonSiguientePregunta = document.getElementById(
    "botonSiguientePregunta"
  );
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == cruzCerrar) {
      seguroRegresar();
      return;
    }
    if (targetElement == botonSiguientePregunta) {
      nextQuestion(lastQuestion);
      return;
    }
    if (
      parseInt(targetElement.id) >= 10 * questionNumberArray[0] - 3 &&
      parseInt(targetElement.id) <= 10 * questionNumberArray[0]
    ) {
      questionWasAnswered = true;
      clearInterval(timeIntervalX);
      disableAllButtons(questionNumberArray[0]);
      colorAllButtonsToWhite(questionNumberArray[0]);
      verifyIfCorrectOption(targetElement.id, questionNumberArray[0]);
      showContinueButton();
      return;
    }
    if (parseInt(targetElement.id) == 10 * questionNumberArray[0] - 4) {
      questionWasAnswered = true;
      clearInterval(timeIntervalX);
      disableAllButtons(questionNumberArray[0]);
      colorAllButtonsToWhite(questionNumberArray[0]);
      verifyIfTextIsCorrect(questionNumberArray[0]);
      showContinueButton();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function seguroRegresar() {
  if (idioma == "e") {
    var texto =
      "¿Seguro que quieres regresar?\nPerderás todo tu progreso de esta lección.";
  } else {
    var texto =
      "Are you sure to return?\nIf you return you will lose all your progress of this lesson.";
  }
  if (confirm(texto)) {
    var userID = document.getElementById("userID").innerHTML.trim();
    enviarAcumulador(userID);
    var stringLiga = "../../Inicio/lecciones.php?subtema=";
    window.location.href = stringLiga.concat(
      document.getElementById("subtemaPrevio").innerHTML.trim()
    );
  }
}

function disableAllButtons(questionNumber) {
  //Si existe el ID 10*numeroDePregunta, es porque es pregunta tipo 1, de opción múltiple
  //Por lo tanto debemos deshabilitar los 4 botones de opción múltiple. De lo contrario
  //Deshabilitar el boton de Aceptar
  if (document.getElementById(10 * questionNumber)) {
    document.getElementById(10 * questionNumber).disabled = true;
    document.getElementById(10 * questionNumber - 1).disabled = true;
    document.getElementById(10 * questionNumber - 2).disabled = true;
    document.getElementById(10 * questionNumber - 3).disabled = true;
  } else {
    document.getElementById(10 * questionNumber - 4).disabled = true;
  }
}

function colorAllButtonsToWhite(questionNumber) {
  //Se deben descolorear las opciones.
  //Si existe el ID 10*numeroDePregunta, es porque es pregunta tipo 1, de opción múltiple
  //Por lo tanto debemos habilitar los 4 botones de opción múltiple. De lo contrario
  //Habilitar el boton de Aceptar
  if (document.getElementById(10 * questionNumber)) {
    document.getElementById(10 * questionNumber).className = "OpcionBlanco";
    document.getElementById(10 * questionNumber - 1).className = "OpcionBlanco";
    document.getElementById(10 * questionNumber - 2).className = "OpcionBlanco";
    document.getElementById(10 * questionNumber - 3).className = "OpcionBlanco";
  } else {
    document.getElementById(10 * questionNumber - 4).className =
      "OpcionMiniBlanco";
  }
}

function verifyIfCorrectOption(targetID, questionNumber) {
  //Debido a que
  /*
    ID Pregunta = 1000 + Número de pregunta         Ejemplo: Pregunta1 id="1001"
    ID Respuesta = 2000 + Número de pregunta        Ejemplo: Respuesta1 id="2001"
    ID Respuesta correcta = 3000 + Número de pregunta   Ejemplo: ResCorrecta1 id="3001"

    ID Opción 4 = 10 * Número de pregunta           Ejemplo: class="Opcion4"  id="10"
    Correcta = 3  idOprimido-(numPreg-1)*10-7 [numPreg=1] ---- numpreg=2 idOprimido=20 idOprimido-(numPreg-1)*10-7
    ID Opción 3 = 10 * Número de pregunta - 1       Ejemplo: class="Opcion3"  id="9"
    Correcta = 2  idOprimido-(numPreg-1)*10-7 [numPreg=1] ---- numpreg=2 idOprimido=19 idOprimido-(numPreg-1)*10-7
    ID Opción 2 = 10 * Número de pregunta - 2       Ejemplo: class="Opcion2"  id="8"
    Corecta = 1 
    ID Opción 1 = 10 * Número de pregunta - 3       Ejemplo: class="Opcion4"  id="7"
    Correcta = 0
    ID Boton aceptar = 10 * Número de pregunta - 4  Ejemplo: class="miniBoton"  id="6"
    ID Texto Escrito = 10 * Número de pregunta - 5  Ejemplo: <input>          id="5"

    opcionCorrecta = idOprimido-(numPreg-1)*10-7
    opcionCorrecta = idOprimido - numPreg*10 + 10 - 7
    opcionCorrecta = idOprimido - numPreg*10 + 3
    En realidad
    opcionCorrecta = idBotonExistente - numPreg*10 + 3
    opcionCorrecta + numPreg*10 - 3 = idBotonExistente
    
  */
  //La ecuación para obtener el valor [entre 0 y 3] de la pregunta seleccionada es: selectedAnswer0to3
  selectedAnswer0to3 = parseInt(targetID) - 10 * questionNumber + 3;
  //De inmediato pintamos de rojo la elegida. Si selecciono la correcta
  //No te preocupes, en seguida se pinta de verde. className = "OpcionCorrecta";
  document.getElementById(targetID).className = "OpcionIncorrecta";
  correctOption = parseInt(
    document.getElementById(3000 + questionNumber).innerHTML.trim()
  );
  //Para encontrar la correcta y dadas las condiciones previas, la ecuacion queda como 10*questionNumber-3+correctOption
  document.getElementById(correctOption + 10 * questionNumber - 3).className =
    "OpcionCorrecta";
  //AUN NO DESPLAZAMOS EL ARREGLO questionNumberArray[], por lo que podemos seguir leyendo de la posicion [0]
  // INICIO ARRAY = {1,2,3,4,5}
  // APLICAMOS ARRAY.SHIFT();
  // AL FINAL QUEDA COMO ARRAY = {2,3,4,5}
  if (selectedAnswer0to3 == correctOption) {
    lastQuestion = questionNumber;
    questionNumberArray.shift();
    if (segundosActuales > segundosTotales_2_3) {
      puntos = puntos + 3;
    } else if (segundosActuales > segundosTotales_1_3) {
      puntos = puntos + 2;
    } else {
      puntos = puntos + 1;
    }
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
    CorrectAudio.play();
  } else {
    lastQuestion = questionNumber;
    questionNumberArray.push(questionNumber);
    questionNumberArray.shift();
    IncorrectAudio.play();
    enviarCalificacionRedirigir();
  }
}

function verifyIfTextIsCorrect(questionNumber) {
  //Debido a que
  /*
    ID Pregunta = 1000 + Número de pregunta         Ejemplo: Pregunta1 id="1001"
    ID Respuesta = 2000 + Número de pregunta        Ejemplo: Respuesta1 id="2001"
    ID Respuesta correcta = 3000 + Número de pregunta   Ejemplo: ResCorrecta1 id="3001"

    ID Opción 4 = 10 * Número de pregunta              
    ID Opción 3 = 10 * Número de pregunta - 1
    ID Opción 2 = 10 * Número de pregunta - 2
    ID Opción 1 = 10 * Número de pregunta - 3
    ID Boton aceptar = 10 * Número de pregunta - 4
    ID Texto Escrito = 10 * Número de pregunta - 5
  */
  //NORMALIZAR la respuesta CORRECTA
  correctText = document.getElementById(3000 + questionNumber).innerHTML.trim();
  respuestaCorrectaNormalizada = correctText
    .normalize("NFD")
    .replace(
      /([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,
      "$1"
    )
    .normalize();
  respuestaCorrectaUpper = respuestaCorrectaNormalizada.toUpperCase();

  //NORMALIZAR la respuesta ESCRITA
  respuestaEscritaTrim = document
    .getElementById(10 * questionNumber - 5)
    .value.trim();
  respuestaEscritaNormalizada = respuestaEscritaTrim
    .normalize("NFD")
    .replace(
      /([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,
      "$1"
    )
    .normalize();
  respuestaEscritaUpper = respuestaEscritaNormalizada.toUpperCase();
  //Muestras la respuesta correcta en el Boton
  document.getElementById(10 * questionNumber - 4).innerHTML = correctText;
  //Se valida si la respuesta es correcta
  if (respuestaEscritaUpper == respuestaCorrectaUpper) {
    lastQuestion = questionNumber;
    questionNumberArray.shift();
    document.getElementById(10 * questionNumber - 5).style.color = "green";
    document.getElementById(
      10 * questionNumber - 5
    ).value = document
      .getElementById(10 * questionNumber - 5)
      .value.toLowerCase();
    //segundosTotales_2_3 Significa la variable segundosTotales * 2 / 3
    if (segundosActuales > segundosTotales_2_3) {
      puntos = puntos + 3;
    } else if (segundosActuales > segundosTotales_1_3) {
      puntos = puntos + 2;
    } else {
      puntos = puntos + 1;
    }
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
    CorrectAudio.play();
  } else {
    lastQuestion = questionNumber;
    questionNumberArray.push(questionNumber);
    questionNumberArray.shift();
    document.getElementById(10 * questionNumber - 5).style.color = "red";
    document.getElementById(
      10 * questionNumber - 5
    ).value = document
      .getElementById(10 * questionNumber - 5)
      .value.toLowerCase();
    IncorrectAudio.play();
    enviarCalificacionRedirigir();
  }
}

function barWidth(puntos) {
  anchoBarra = 100 * puntos;
  intTotalPreguntas = parseInt(
    document.getElementById("totalPreguntas").innerHTML.trim()
  );
  anchoBarra = anchoBarra / (3 * intTotalPreguntas);
  anchoBarra = parseInt(anchoBarra).toString(10);
  stringPorcentaje = anchoBarra.concat("%");
  document.getElementById("barraAvance").style.width = stringPorcentaje;
}

function showContinueButton() {
  document.getElementById("botonSiguientePregunta").style.display = "block";
}

function hiddePreviousQuestion(lastQuestion) {
  //Se deben ocultar los bloques de pregunta y respuesta. Dado que ya tenemos un arreglo
  //Con el numero relativo de cada pregunta, por ejemplo si en esta lección existen 5 preguntas
  //Tenemos un arreglo {1,2,3,4,5}.
  //El bloque de pregunta es numeroDePregunta + 1000
  //El bloque de respuestas/botones es numeroDePregunta + 2000
  document.getElementById(lastQuestion + 1000).style.display = "none";
}
function hiddePreviousAnswers(lastQuestion) {
  //Se deben ocultar los bloques de pregunta y respuesta. Dado que ya tenemos un arreglo
  //Con el numero relativo de cada pregunta, por ejemplo si en esta lección existen 5 preguntas
  //Tenemos un arreglo {1,2,3,4,5}.
  //El bloque de pregunta es numeroDePregunta + 1000
  //El bloque de respuestas/botones es numeroDePregunta + 2000
  document.getElementById(lastQuestion + 2000).style.display = "none";
}

function nextQuestion(lastQuestion) {
  hiddePreviousQuestion(lastQuestion);
  hiddePreviousAnswers(lastQuestion);
  //Ocultamos esta seccion
  document.getElementById("botonSiguientePregunta").style.display = "none";
  //Si la pregunta previa contiene el boton de accept, quitarle la respuesta y volverle a poner Accept
  if (document.getElementById(10 * lastQuestion - 4)) {
    document.getElementById(10 * lastQuestion - 4).innerHTML = "Accept";
  }
  totalPreguntas = parseInt(
    document.getElementById("totalPreguntas").innerHTML.trim()
  );
  if (lastQuestion == totalPreguntas && firstTimeToSaveGrade == 0) {
    enviarCalificacionRedirigir();
    firstTimeToSaveGrade = 1;
  }
  if (questionNumberArray.length == 0) {
    /* var stringLiga =
      "sprintFinalizado.php?subtema=" +
      document.getElementById("subtemaPrevio").innerHTML.trim() +
      "&puntos=" +
      puntos +
      "&totalPreguntas=" +
      document.getElementById("totalPreguntas").innerHTML.trim();
    window.location.replace(stringLiga); */
  } else {
    loadNewQuestion(questionNumberArray[0]);
  }
}

function enviarCalificacionRedirigir() {
  var userID = document.getElementById("userID").innerHTML.trim();
  var leccionID = document.getElementById("leccionID").innerHTML.trim();
  $.ajax({
    type: "POST",
    url: "subirPuntosByType.php",
    dataType: "json",
    data: { id: userID, leccion: leccionID, puntos: puntos, flagTipo: "SP" },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        console.log("Valores enviados correctamente");
        var stringLiga =
          "sprintFinalizado.php?subtema=" +
          document.getElementById("subtemaPrevio").innerHTML.trim() +
          "&puntos=" +
          puntos +
          "&totalPreguntas=" +
          document.getElementById("totalPreguntas").innerHTML.trim();
        window.location.replace(stringLiga);
      } else {
        console.log("Algo salio mal");
      }
    },
  });
  enviarAcumulador(userID);
}

function enviarCalificacion() {
  var userID = document.getElementById("userID").innerHTML.trim();
  var leccionID = document.getElementById("leccionID").innerHTML.trim();
  //alert(userID+ " "+ puntos+ " "+ leccionID);

  $.ajax({
    type: "POST",
    url: "subirPuntosByType.php",
    dataType: "json",
    data: { id: userID, leccion: leccionID, puntos: puntos, flagTipo: "SP" },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        //alert("Etcito");
        console.log("Valores enviados correctamente");
        //var stringLiga =
        //  "https://kaanbal.net/Front/Inicio/lecciones.php?subtema=";
      } else {
        //alert(data.response);
        console.log("Algo salio mal");
      }
    },
  });
  enviarAcumulador(userID);
}

//Cada vez que se escribe sobre un input
//Firefox y o Google guardar la variable
//Para evitar que ya se tengan las respuestas, se limpiaran
//los campos input cada vez que se inicie [5,15,20,25]
function limpiarInputs(cantidadIDs) {
  console.log(cantidadIDs - 1000);
  for (var i = 1; i <= cantidadIDs - 1000; i++) {
    //borrar a los i*10-5
    if (document.getElementById(i * 10 - 5)) {
      document.getElementById(i * 10 - 5).value = "";
      console.log(i * 10 - 5);
    }
  }
}

function startClock() {
  // Set the date we're counting down to
  /*
  var minutos = 0;
  var segundos = 30;
  var milisegundos = segundos * 1000 + minutos * 60 * 1000;
  */
  var milisegundos = segundosTotales * 1000;
  var countDownDate = new Date(milisegundos).getTime();
  var unSegundo = new Date(1000).getTime();
  var sumaSegundos = new Date(1000).getTime();

  // Update the count down every 1 second
  timeIntervalX = setInterval(function () {
    var previous = countDownDate - sumaSegundos - unSegundo;
    var actual = countDownDate - sumaSegundos;
    var later = countDownDate - sumaSegundos + unSegundo;
    //----------------------------ACTUAL-----------------------------------
    segundosActuales = actual / 1000; //Con el objetivo de subir mas puntos en el SPRINT, en función del tiempo
    // Time calculations for days, hours, minutes and seconds
    var minutes = Math.floor((actual % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((actual % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    //document.getElementById("actual").innerHTML = seconds + "";
    if (seconds <= 9) {
      document.getElementById("actual").innerHTML =
        "0" + minutes + ":0" + seconds;
    } else {
      document.getElementById("actual").innerHTML =
        "0" + minutes + ":" + seconds;
    }
    //minutes + "m " + seconds + "s ";

    //----------------------------PREVIO-----------------------------------
    minutes = Math.floor(((actual - 1000) % (1000 * 60 * 60)) / (1000 * 60));
    seconds = Math.floor(((actual - 1000) % (1000 * 60)) / 1000);
    document.getElementById("previous").innerHTML =
      minutes + "m " + seconds + "s ";
    //----------------------------PREVIO-----------------------------------
    minutes = Math.floor(((actual + 1000) % (1000 * 60 * 60)) / (1000 * 60));
    seconds = Math.floor(((actual + 1000) % (1000 * 60)) / 1000);
    document.getElementById("later").innerHTML =
      minutes + "m " + seconds + "s ";

    // If the count down is over, write some text
    if (previous < 0) {
      document.getElementById("previous").innerHTML = "---";
    }
    if (actual < 0) {
      document.getElementById("actual").innerHTML = "TIEMPO!";
      if (questionWasAnswered == false) {
        //CONSECUENCIA POR TERMINARSE EL TIEMPO
        disableAllButtons(questionNumberArray[0]);
        colorAllButtonsToWhite(questionNumberArray[0]);
        incorrectByTime(questionNumberArray[0]);
        showContinueButton();
      }
      clearInterval(timeIntervalX);
    }
    sumaSegundos = sumaSegundos + unSegundo;
  }, 1000);
}

function incorrectByTime(questionNumber) {
  //Primero saber si es tipo 1 o tipo 2
  //Si es tipo 1
  if (document.getElementById(10 * questionNumber)) {
    //Marca color verde la opcion correcta
    correctOption = parseInt(
      document.getElementById(3000 + questionNumber).innerHTML.trim()
    );
    //Para encontrar la correcta y dadas las condiciones previas, la ecuacion queda como 10*questionNumber-3+correctOption
    document.getElementById(correctOption + 10 * questionNumber - 3).className =
      "OpcionCorrecta";
    //Almacena el valor de la pregunta previa
    lastQuestion = questionNumber;
    questionNumberArray.push(questionNumber);
    //Mueve el arreglo para quitar de la posición cero la pregunta que acaba de equivocarse
    questionNumberArray.shift();
    IncorrectAudio.play();
    enviarCalificacionRedirigir();
  } else {
    //NORMALIZAR la respuesta CORRECTA
    correctText = document
      .getElementById(3000 + questionNumber)
      .innerHTML.trim();
    respuestaCorrectaNormalizada = correctText
      .normalize("NFD")
      .replace(
        /([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,
        "$1"
      )
      .normalize();
    respuestaCorrectaUpper = respuestaCorrectaNormalizada.toUpperCase();

    //Muestras la respuesta correcta en el Boton
    document.getElementById(
      10 * questionNumber - 4
    ).innerHTML = respuestaCorrectaUpper;

    //Pinta de rojo lo escrito
    document.getElementById(10 * questionNumber - 5).style.color = "red";

    //Almacena el valor de la pregunta previa
    lastQuestion = questionNumber;
    questionNumberArray.push(questionNumber);
    //Mueve el arreglo para quitar de la posición cero la pregunta que acaba de equivocarse
    questionNumberArray.shift();
    IncorrectAudio.play();
    enviarCalificacionRedirigir();
  }
}

function enviarAcumulador(userID) {
  $.ajax({
    type: "POST",
    url: "../../../servicios/enviarAcumulador.php",
    dataType: "json",
    data: { id: userID, acmldr: acumulador, flagTipo: "acmlrSP" },
    success: function (data) {
      console.log(data.response);
      if (data.response == "exito") {
        console.log("Valores enviados correctamente");
      } else {
        console.log("Algo salio mal");
      }
    },
  });
}
