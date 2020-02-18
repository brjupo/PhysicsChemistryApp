window.onload = function() {
  startClock();
};

var popUpLevantado = false;

document.addEventListener("click", function(evt) {
  var cruzCerrar = document.getElementById("cruzCerrar");
  var Opcion1 = document.getElementById("Opcion1");
  var Opcion2 = document.getElementById("Opcion2");
  var Opcion3 = document.getElementById("Opcion3");
  var Opcion4 = document.getElementById("Opcion4");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == cruzCerrar) {
      seguroRegresar();
      return;
    }
    if (targetElement == Opcion1 && popUpLevantado == false) {
      whiteButtons();
      sprintNext();
      popUpLevantado = true;
      console.log(popUpLevantado); 
      return;
    }
    if (targetElement == Opcion2 && popUpLevantado == false) {
      whiteButtons();
      sprintNext();
      popUpLevantado = true;
      console.log(popUpLevantado); 
      return;
    }
    if (targetElement == Opcion3 && popUpLevantado == false) {
      whiteButtons();
      sprintNext();
      popUpLevantado = true;
      console.log(popUpLevantado); 
      return;
    }
    if (targetElement == Opcion4 && popUpLevantado == false) {
      whiteButtons();
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
    window.location.href = "../entExamen.html";
  }
}

function whiteButtons(){
  document.getElementById("Opcion1").className = "OpcionBlanco";
  document.getElementById("Opcion2").className = "OpcionBlanco";
  document.getElementById("Opcion3").className = "OpcionCorrecta";
  document.getElementById("Opcion4").className = "OpcionIncorrecta";
}

function sprintNext() {
  disableAllButtons();
  document.getElementById("sprintNext").style.display = "block";
}

function disableAllButtons() {
  document.getElementById("Opcion1").disabled = true;
  document.getElementById("Opcion2").disabled = true;
  document.getElementById("Opcion3").disabled = true;
  document.getElementById("Opcion4").disabled = true;
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
  var x = setInterval(function() {
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
