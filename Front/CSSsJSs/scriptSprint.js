window.onload = function () {
  //startClock();
  contarIDs();
};
var preguntaActual = 1;
var popUpLevantado = false;
var cantidadIDs = 0;

document.addEventListener("click", function (evt) {
  var cruzCerrar = document.getElementById("cruzCerrar");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == cruzCerrar) {
      seguroRegresar();
      return;
    }
    if (parseInt(targetElement.id) >= 4*preguntaActual-3 &&
        parseInt(targetElement.id) <= 4*preguntaActual &&
        popUpLevantado == false) {
      console.log(parseInt(targetElement.id));
      whiteButtons(targetElement.id);
      sprintNext();
      popUpLevantado = true;
      console.log(popUpLevantado);
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
    window.location.href = "https://kaanbal.net";
  }
}

function whiteButtons(seleccionada) {
  var numero = preguntaActual;
  var numeroCorrecta=300+numero;
  respuestaCorrecta = document.getElementById(numeroCorrecta).innerHTML;
  console.log(respuestaCorrecta);
  var IDrespuestaCorrecta;
  for (var i = 4 * numero - 3; i <= 4 * numero; i++) {
    //Convertir todos a blanco de la pregunta en curso
    document.getElementById(i).className = "OpcionBlanco";
    //Buscar el id que contiene lo mismo que la respuesta correcta
    if(document.getElementById(i).innerHTML == respuestaCorrecta){
      IDrespuestaCorrecta=i;
    }
  }
  //Marcar en rojo la respuesta seleccionada
  document.getElementById(seleccionada).className = "OpcionIncorrecta";
  
  //Buscar la respuesta correcta
  
  
  //Marcar en Verde la respuest correcta
  //WE DEBES BUSCAR CUAL DE LAS 4 OPCIONES EMPATA CON LA CORRECTA,
  // YA TIENES LA RESPUESTA CORRECTA[TEXTO], AHORA VE ¿CUÁL DE LAS 4 ES!
  document.getElementById(IDrespuestaCorrecta).className = "OpcionCorrecta";
}

function sprintNext() {
  disableAllButtons();
  document.getElementById("sprintNext").style.display = "block";
}

function disableAllButtons() {
  var numero = preguntaActual;
  for (var i = 4 * numero - 3; i <= 4 * numero; i++) {
    document.getElementById(i).disabled = true;
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
        console.log(popUpLevantado);
      }
    }
    sumaSegundos = sumaSegundos + unSegundo;
  }, 1000);
}

function contarIDs() {
  for (var i = 1; i <= 100; i++) {
    if (document.getElementById(i)) {
      console.log(document.getElementById(i));
      cantidadIDs = i;
    }
  }
}
