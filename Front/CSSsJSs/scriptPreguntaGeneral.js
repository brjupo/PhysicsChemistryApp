var preguntaActual = 1;
var popUpLevantado = false;
var cantidadIDs = 0;
var puntos = 0;
var CorrectAudio = new Audio("../CSSsJSs/sounds/Correct.mp3");
var IncorrectAudio = new Audio("../CSSsJSs/sounds/Incorrect.mp3");

window.onload = function () {
  //startClock();
  contarIDs();
  limpiarInputs(cantidadIDs);
  showQuestion(1);
};

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
      if(cantidadIDs-1000 == preguntaActual){
        //var stringLiga = "https://kaanbal.net/Front/Inicio/lecciones.php?subtema=";
        //window.location.replace(stringLiga.concat(document.getElementById("subtemaPrevio").innerHTML.trim()));
        enviarCalificacion();
      }
      else{
        siguientePregunta();
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


function enviarCalificacion() {
  var userID= document.getElementById("userID").innerHTML.trim();
  var leccionID= document.getElementById("leccionID").innerHTML.trim();
  //alert(userID+ " "+ puntos+ " "+ leccionID);

  $.ajax({
    type: "POST",
    url: "../../Servicios/subirPuntos.php",
    dataType: "json",
    data: { id: userID, leccion: leccionID, puntos: puntos },
    success: function(data) {
      console.log(data.response);
      if (data.response == "exito") {
        //alert("Etcito");
        console.log("Valores enviados correctamente");
        var stringLiga = "https://kaanbal.net/Front/Inicio/lecciones.php?subtema=";
        window.location.replace(stringLiga.concat(document.getElementById("subtemaPrevio").innerHTML.trim()));
      } else {
        //alert(data.response);
        console.log("Algo salio mal");
      }
    }
  });
}

function seguroRegresar() {
  if (
    confirm(
      "¿Estás seguro de regresar?\n Si regresas perderás todo tu avance de este tema"
    )
  ) {
    var stringLiga = "https://kaanbal.net/Front/Inicio/lecciones.php?subtema=";
    window.location.href = stringLiga.concat(document.getElementById("subtemaPrevio").innerHTML.trim());
  }
}

function whiteButtons(seleccionada) {
  var numero = preguntaActual;
  var numeroCorrecta = 3000 + numero;
  respuestaCorrecta = document.getElementById(numeroCorrecta).innerHTML.trim();
  //console.log(respuestaCorrecta);
  var IDrespuestaCorrecta;
  for (var i = 10 * numero - 3; i <= 10 * numero; i++) {
    //Convertir todos a blanco de la pregunta en curso
    document.getElementById(i).className = "OpcionBlanco";
    //Buscar el id que contiene lo mismo que la respuesta correcta
    //console.log(document.getElementById(i).innerHTML);
    if (document.getElementById(i).innerHTML.trim() == respuestaCorrecta) {
      IDrespuestaCorrecta = i;
      //console.log(i);
    }
  }
  //Marcar en rojo la respuesta seleccionada
  document.getElementById(seleccionada).className = "OpcionIncorrecta";
  //Buscar la respuesta correcta
  document.getElementById(IDrespuestaCorrecta).className = "OpcionCorrecta";
  if (IDrespuestaCorrecta == seleccionada) {
    CorrectAudio.play();
    puntos = puntos + 1;
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
  }
  else{
    IncorrectAudio.play();    
  }
}

function barWidth(puntos){
  anchoBarra = 100*puntos;
  anchoBarra = anchoBarra / parseInt(document.getElementById("totalPreguntas").innerHTML.trim());
  anchoBarra = parseInt(anchoBarra).toString(10);
  //barraAvance
  stringPorcentaje = anchoBarra.concat("%");
  document.getElementById("barraAvance").style.width = stringPorcentaje;
}

//$IDTextoEscrito = 10 * $respuestas - 5; == inputEscrito
//$IDBotonAceptar = 10 * $respuestas - 4; == miniBoton
function whiteButtonsType2() {
  var numero = preguntaActual;
  var numeroCorrecta = 3000 + numero;

  //NORMALIZAR la respuesta CORRECTA
  var respuestaCorrectaTrim = document
    .getElementById(numeroCorrecta)
    .innerHTML.trim();
  var respuestaCorrectaNormalizada = respuestaCorrectaTrim
    .normalize("NFD")
    .replace(
      /([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,
      "$1"
    )
    .normalize();
  var respuestaCorrectaUpper = respuestaCorrectaNormalizada.toUpperCase();

  //Convertir a blanco el miniboton
  document.getElementById(10 * numero - 4).className = "OpcionMiniBlanco";

  var inputEscrito = 10 * numero - 5;
  //NORMALIZAR la respuesta ESCRITA
  var respuestaEscritaTrim = document.getElementById(inputEscrito).value.trim();
  var respuestaEscritaNormalizada = respuestaEscritaTrim
    .normalize("NFD")
    .replace(
      /([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,
      "$1"
    )
    .normalize();
  var respuestaEscritaUpper = respuestaEscritaNormalizada.toUpperCase();

  if (respuestaEscritaUpper == respuestaCorrectaUpper) {
    CorrectAudio.play();
    document.getElementById(inputEscrito).style.color = "green";
    document.getElementById(inputEscrito).value = document
      .getElementById(inputEscrito)
      .value.toLowerCase();
    puntos = puntos + 1;
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
  } else {
    IncorrectAudio.play();
    document.getElementById(inputEscrito).style.color = "red";
    document.getElementById(inputEscrito).value = document
      .getElementById(inputEscrito)
      .value.toLowerCase();
  }
}

function restoreInputColors() {
  if(document.getElementById(10 * preguntaActual - 5)){
    document.getElementById(10 * preguntaActual - 5).style.color = "black";
  }
}

function sprintNext() {
  disableAllButtons();
  document.getElementById("sprintNext").style.display = "block";
}
function sprintNextType2() {
  disableMiniButton();
  document.getElementById("sprintNext").style.display = "block";
}

function disableAllButtons() {
  var numero = preguntaActual;
  for (var i = 10 * numero - 3; i <= 10 * numero; i++) {
    document.getElementById(i).disabled = true;
  }
}
function disableMiniButton() {
  var numero = preguntaActual;
  var j = 10 * numero - 4;
  document.getElementById(j).disabled = true;
}

function siguientePregunta() {
  popUpLevantado = false;
  //enableAllButtons();
  document.getElementById("sprintNext").style.display = "none";
  restoreInputColors();
  preguntaActual = preguntaActual + 1;
  showQuestion(preguntaActual);
}

function enableAllButtons() {
  var numero = preguntaActual;
  if (document.getElementById(10 * numero - 4)) {
    document.getElementById(10 * numero - 4).disabled = false;
    console.log("mini Habilitado");
  }
  if (document.getElementById(10 * numero - 3)) {
    for (var i = 10 * numero - 3; i <= 10 * numero; i++) {
      document.getElementById(i).disabled = false;
    }
    console.log("todos Habilitados");
  }
}

function startClock() {
  // Set the date we're counting down to
  var minutos = 0;
  var segundos = 10;
  var milisegundos = segundos * 1000 + minutos * 60 * 1000;
  var countDownDate = new Date(milisegundos).getTime();
  var unSegundo = new Date(1000).getTime();
  var sumaSegundos = new Date(1000).getTime();

  // Update the count down every 1 second
  var x = setInterval(function () {
    var previous = countDownDate - sumaSegundos - unSegundo;
    var actual = countDownDate - sumaSegundos;
    var later = countDownDate - sumaSegundos + unSegundo;
    //----------------------------ACTUAL-----------------------------------
    // Time calculations for days, hours, minutes and seconds
    var minutes = Math.floor((actual % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((actual % (1000 * 60)) / 1000);
    // Output the result in an element with id="demo"
    document.getElementById("actual").innerHTML =
      minutes + "m " + seconds + "s ";

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
      clearInterval(x);
      document.getElementById("actual").innerHTML = "TIEMPO!";
      if (popUpLevantado == false) {
        sprintNext();
        popUpLevantado = true;
        //console.log(popUpLevantado);
      }
    }
    sumaSegundos = sumaSegundos + unSegundo;
  }, 1000);
}

function contarIDs() {
  for (var i = 1001; i <= 1100; i++) {
    if (document.getElementById(i)) {
      //console.log(document.getElementById(i));
      cantidadIDs = i;
    }
  }
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

function showQuestion(pregunta) {
  preguntaTexto = 1000 + pregunta;
  respuestaTexto = 2000 + pregunta;
  if (pregunta == 1) {
    document.getElementById(1001).style.display = "block";
    document.getElementById(2001).style.display = "block";
  } else {
    document.getElementById(preguntaTexto).style.display = "block";
    document.getElementById(respuestaTexto).style.display = "block";
    preguntaTexto = preguntaTexto - 1;
    respuestaTexto = respuestaTexto - 1;
    document.getElementById(preguntaTexto).style.display = "none";
    document.getElementById(respuestaTexto).style.display = "none";
  }
}

