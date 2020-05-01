var questionMatrix = []; //En realidad es un array con objetos, por ser JSON
var questionIDs = []; //NO ES EL ID DE BBDD es la posición en el arreglo
var puntos = 0;

var CorrectAudio = new Audio("../CSSsJSs/sounds/Incorrect.mp3");
var IncorrectAudio = new Audio("../CSSsJSs/sounds/Correct.mp3");

function borrarParaLoBueno() {
  questionMatrix = [
    {
      estatus: "1",
      id_autor: "1",
      id_leccion: "2",
      id_pregunta: "10",
      orden: "1",
      patrona: "2",
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
      id_pregunta: "15",
      orden: "6",
      patrona: "3",
      pregunta:
        "En la siguiente fotografía se observa un pato parado sobre la arena a punto de ser alcanzado por el agua de mar. Estos son ejemplos de:",
      preguntaParte1:
        "En la siguiente fotografía se observa un pato parado sobre la arena a punto de ser alcanzado por el agua de mar. Estos son ejemplos de:",
      preguntaParte2: "",
      respuesta2: "Factores bióticos y abióticos",
      respuesta3: "Factores abióticos",
      respuesta4: "Fenómenos físicos",
      respuesta_correcta: "Factores bióticos",
      tipo: "1",
      tiene_imagen: "true",
    },
    
    {
      estatus: "1",
      id_autor: "1",
      id_leccion: "2",
      id_pregunta: "13",
      orden: "4",
      patrona: "ABIOTICOS",
      pregunta:
        "El mar, las rocas y el aire que se observan en la siguiente fotografía, son ejemplos de factores:",
      preguntaParte1:
        "El mar, las rocas y el aire que se observan en la siguiente fotografía, son ejemplos de factores:",
      preguntaParte2: "",
      respuesta2: null,
      respuesta3: null,
      respuesta4: "ABIOTICOS",
      respuesta_correcta: null,
      tipo: "2",
      tiene_imagen: "true",
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
    //questionIDs.push(questionMatrix[i]["id_pregunta"]);
    questionIDs.push(i);
  }
}

function loadNewQuestion(questionID) {
  enableAllButtons();
  colorAllButtons();
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
function colorAllButtons() {
  document.getElementById("Opcion1SinImagen").className = "Opcion1";
  document.getElementById("Opcion2SinImagen").className = "Opcion2";
  document.getElementById("Opcion3SinImagen").className = "Opcion3";
  document.getElementById("Opcion4SinImagen").className = "Opcion4";
  document.getElementById("Opcion1ConImagen").className = "Opcion1";
  document.getElementById("Opcion2ConImagen").className = "Opcion2";
  document.getElementById("Opcion3ConImagen").className = "Opcion3";
  document.getElementById("Opcion4ConImagen").className = "Opcion4";
  document.getElementById("acceptConImagen").className = "miniBoton";
  document.getElementById("acceptSinImagen").className = "miniBoton";
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
    console.log(questionMatrix[questionID]["preguntaParte1"]);

    if (questionMatrix[questionID]["tiene_imagen"] == "true") {
      document.getElementById("imagenPreguntaTipo1").src =
        "../imagenes/" + questionMatrix[questionID]["id_pregunta"] + ".jpg";
      document.getElementById("Opcion1ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta_correcta"];
      document.getElementById("Opcion2ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta2"];
      document.getElementById("Opcion3ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta3"];
      document.getElementById("Opcion4ConImagen").innerHTML =
        questionMatrix[questionID]["respuesta4"];
      console.log(questionMatrix[questionID]["respuesta4"]);
    } else {
      document.getElementById("Opcion1SinImagen").innerHTML =
        questionMatrix[questionID]["respuesta_correcta"];
      document.getElementById("Opcion2SinImagen").innerHTML =
        questionMatrix[questionID]["respuesta2"];
      document.getElementById("Opcion3SinImagen").innerHTML =
        questionMatrix[questionID]["respuesta3"];
      document.getElementById("Opcion4SinImagen").innerHTML =
        questionMatrix[questionID]["respuesta4"];
      console.log(questionMatrix[questionID]["respuesta4"]);
    }
  } else if (questionMatrix[questionID]["tipo"] == "2") {
    document.getElementById("textoPreguntaTipo2").innerHTML =
      questionMatrix[questionID]["preguntaParte1"] +
      '<input type="text" id="idTextoEscrito">' +
      questionMatrix[questionID]["preguntaParte2"];
    if (questionMatrix[questionID]["tiene_imagen"] == "true") {
      document.getElementById("imagenPreguntaTipo2").src =
        "../imagenes/" + questionMatrix[questionID]["id_pregunta"] + ".jpg";
    }
  }
}

document.addEventListener("click", function (evt) {
  cruzCerrar = document.getElementById("cruzCerrar");
  botonSiguientePregunta = document.getElementById("botonSiguientePregunta");
  Opcion1SinImagen = document.getElementById("Opcion1SinImagen");
  Opcion2SinImagen = document.getElementById("Opcion2SinImagen");
  Opcion3SinImagen = document.getElementById("Opcion3SinImagen");
  Opcion4SinImagen = document.getElementById("Opcion4SinImagen");
  Opcion1ConImagen = document.getElementById("Opcion1ConImagen");
  Opcion2ConImagen = document.getElementById("Opcion2ConImagen");
  Opcion3ConImagen = document.getElementById("Opcion3ConImagen");
  Opcion4ConImagen = document.getElementById("Opcion4ConImagen");
  acceptConImagen = document.getElementById("acceptConImagen");
  acceptSinImagen = document.getElementById("acceptSinImagen");
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
  document.getElementById(
    "Opcion" +
      questionMatrix[questionIDs[0]]["patrona"] +
      res[7] +
      res[8] +
      "nImagen"
  ).className = "OpcionCorrecta";
  //AUN NO DESPLAZAMOS EL ARREGLO questionIDs[], por lo que podemos seguir leyendo de la posicion [0]
  if (res[6] == questionMatrix[questionIDs[0]]["patrona"]) {
    questionIDs.shift();
    puntos = puntos + 1;
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
    CorrectAudio.play();
  } else {
    questionIDs.push(questionIDs[0]);
    questionIDs.shift();
    IncorrectAudio.play();
  }
}

function verifyIfTextIsCorrect() {
  if (questionMatrix[questionIDs[0]]["patrona"] == 1) {
  }
  //NORMALIZAR la respuesta CORRECTA
  var respuestaCorrectaNormalizada = 
    questionMatrix[questionIDs[0]]["patrona"]
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
  document.getElementById("acceptConImagen").innerHTML = questionMatrix[questionIDs[0]]["patrona"];
  document.getElementById("acceptSinImagen").innerHTML = questionMatrix[questionIDs[0]]["patrona"];
  if (respuestaEscritaUpper == respuestaCorrectaUpper) {
    questionIDs.shift();
    document.getElementById("idTextoEscrito").style.color = "green";
    document.getElementById("idTextoEscrito").value = document
      .getElementById("idTextoEscrito")
      .value.toLowerCase();
    puntos = puntos + 1;
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
    CorrectAudio.play();
  } else {
    questionIDs.push(questionIDs[0]);
    questionIDs.shift();
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
  if (questionIDs.length == 0) {
    enviarCalificacion();
  } else {
    loadNewQuestion(questionIDs[0]);
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
