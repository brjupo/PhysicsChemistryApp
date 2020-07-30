var lastQuestion = 0;
var questionNumberArray = [];
var puntos = 0;
var buenas0_malas1_alHilo = [0, 0];
var firstTimeToSaveGrade = 0;
var idioma = "e";
var CorrectAudio = new Audio("../../CSSsJSs/sounds/Incorrect.mp3");
var IncorrectAudio = new Audio("../../CSSsJSs/sounds/Correct.mp3");
var acumulador = 0;

//RECUERDA, ANTES DE MOSTRAR, DEBERÁS LIMPIAR LO QUE EL ALUMNO ESCRIBIÓ ANTES

window.onload = function () {
  createArrayWithQuestions();
  contarTiempo();
  idioma = document.getElementById("idioma").innerHTML.trim();
  registrarInactividad();
};

function contarTiempo() {
window.setInterval(function(){
  acumulador++;
},1000);
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
      if (buenas0_malas1_alHilo[0] == 5) {
        motivationGoodMessage(lastQuestion);
        buenas0_malas1_alHilo[0] = 0;
      } else if (buenas0_malas1_alHilo[1] == 5) {
        motivationBadMessage(lastQuestion);
        buenas0_malas1_alHilo[1] = 0;
      } else {
        nextQuestion(lastQuestion);
      }
      return;
    }
    if (
      parseInt(targetElement.id) >= 10 * questionNumberArray[0] - 3 &&
      parseInt(targetElement.id) <= 10 * questionNumberArray[0]
    ) {
      disableAllButtons(questionNumberArray[0]);
      colorAllButtonsToWhite(questionNumberArray[0]);
      verifyIfCorrectOption(targetElement.id, questionNumberArray[0]);
      showContinueButton();
      return;
    }
    if (parseInt(targetElement.id) == 10 * questionNumberArray[0] - 4) {
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
  if (idioma == "e"){
    var texto = "¿Seguro que quieres regresar?\nPerderás todo tu progreso de esta lección.";
  }else{
    var texto = "Are you sure to return?\nIf you return you will lose all your progress of this lesson.";
  }
  if (
    confirm(texto)
  ) {
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
    puntos = puntos + 1;
    buenas0_malas1_alHilo[0] += 1;
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
    CorrectAudio.play();
  } else {
    lastQuestion = questionNumber;
    questionNumberArray.push(questionNumber);
    questionNumberArray.shift();
    buenas0_malas1_alHilo[1] += 1;
    IncorrectAudio.play();
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
    buenas0_malas1_alHilo[0] += 1;
    document.getElementById(10 * questionNumber - 5).style.color = "green";
    document.getElementById(
      10 * questionNumber - 5
    ).value = document
      .getElementById(10 * questionNumber - 5)
      .value.toLowerCase();
    puntos = puntos + 1;
    document.getElementById("puntosBuenos").innerHTML = puntos;
    barWidth(puntos);
    CorrectAudio.play();
  } else {
    lastQuestion = questionNumber;
    questionNumberArray.push(questionNumber);
    questionNumberArray.shift();
    buenas0_malas1_alHilo[1] += 1;
    document.getElementById(10 * questionNumber - 5).style.color = "red";
    document.getElementById(
      10 * questionNumber - 5
    ).value = document
      .getElementById(10 * questionNumber - 5)
      .value.toLowerCase();
    IncorrectAudio.play();
  }
}

function barWidth(puntos) {
  anchoBarra = 100 * puntos;
  anchoBarra =
    anchoBarra /
    parseInt(document.getElementById("totalPreguntas").innerHTML.trim());
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

function hiddeMotivationMessage() {
  document.getElementById("motivationMessage").style.display = "none";
}

function nextQuestion(lastQuestion) {
  hiddePreviousQuestion(lastQuestion);
  hiddePreviousAnswers(lastQuestion);
  hiddeMotivationMessage();
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
    //enviarCalificacion();
    //function enviarCalificacion() {
    var userID = document.getElementById("userID").innerHTML.trim();
    var leccionID = document.getElementById("leccionID").innerHTML.trim();
    //alert(userID+ " "+ puntos+ " "+ leccionID);

    $.ajax({
      type: "POST",
      url: "../../../Servicios/subirPuntosType.php",
      dataType: "json",
      data: { id: userID, leccion: leccionID, puntos: puntos, flagTipo: "PP" },
      success: function (data) {
        console.log(data.response);
        if (data.response == "exito") {
          //alert("Etcito");
          console.log("Valores enviados correctamente");
        } else {
          //alert(data.response);
          console.log("Algo salio mal");
        }
      },
    });
    //}
    firstTimeToSaveGrade = 1;
    enviarAcumulador(userID);
  }
  if (questionNumberArray.length == 0) {
    var userID = document.getElementById("userID").innerHTML.trim();
    var leccionID = document.getElementById("leccionID").innerHTML.trim();
    //alert(userID+ " "+ puntos+ " "+ leccionID);

    $.ajax({
      type: "POST",
      url: "../../../Servicios/subirPuntosType.php",
      dataType: "json",
      data: { id: userID, leccion: leccionID, puntos: puntos, flagTipo: "PP" },
      success: function (data) {
        console.log(data.response);
        if (data.response == "exito") {
          //alert("Etcito");
          console.log("Valores enviados correctamente");
          var stringLiga = "nivelCompletado.php?subtema=";
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
    enviarAcumulador(userID);
  } else {
    loadNewQuestion(questionNumberArray[0]);
  }
}

function motivationGoodMessage(lastQuestion) {
  //Ocultamos esta seccion
  document.getElementById("botonSiguientePregunta").style.display = "none";
  document.getElementById("motivationMessage").style.display = "block";
  if (idioma == "e") {
    goodJobMessages = [
      "Excelente, sigue así",
      "¡Eres increible!",
      "¡Eres el mejor!",
      "Sabía que podías con esto y más",
      "¡Vas muy bien!",
      "¡Bien hecho!",
      "¡Sigue así!",
      "¡Sigue adelante, vas muy bien!",
      "¡Dá siempre tu 100%!",
      "¡Perseverar rinde frutos!",
      "Observa, escucha y aprende.",
      "¡Lo lograste!",
      "¡Muy bien!",
      "Ten paciencia, obtendrás lo que deseas.",
      "Un viaje de mil millas comienza con un simple paso.",
      "Con autodisciplina casi todo es posible.",
      "¡Eres joven y talentoso!",
      "¡Lo lograste otra vez!",
      "El secreto del éxito es el entusiasmo, ¡sigue adelante!",
      "No hay ascensor al éxito, tienes que tomar las escaleras.",
      "Con esfuerzo y perseverancia podrás alcanzar tus metas.",
      " El precio del éxito es el trabajo, dedicación y determinación.",
      "Siempre puedes ser mejor.",
      "La suerte y el esfuerzo van de la mano.",
      "Cuanto más trabajas, más suerte pareces tener.",
      "¡Estás aprendiendo mucho! ",
      "¡Sigue aprendiendo!",
      "Cuando aprendes algo, nadie puede arrebatártelo.",
      "Todo es práctica.",
      "¡La fortuna te favorece!",
      "Tu disciplina es el ingrediente más importante del éxito.",
      "¡Das lo mejor que tienes!",
      "Si eres constante, ¡serás éxitoso!",
      "Nada es difícil si lo divides en pequeños trabajos.",
      "La motivación te hizo iniciar y el hábito te permite continuar",
      "Tu éxito es la suma de pequeños esfuerzos repetidos varias veces.",
      "Perseverancia. No hay otro secreto para tu éxito",
      "¡Busca la excelencia!",
      "Esfuerzo continuo, ¡es la clave para alcanzar el éxito!",
      "Tu actitud, no tu aptitud, determinará tu altitud.",
      "Comienza a pensar en ti, como la persona que quieres ser.",
      "Sé el cambio que quieres ver en el mundo.",
      "No hay atajos para llegar a cualquier lugar al que merezca la pena llegar.",
      "Si haces primero las cosas que son más fáciles, haces mucho progreso.",
      "Siempre parece imposible hasta que se hace.",
      "La motivación es lo que te pone en marcha, el hábito es lo que hace que sigas",
      "Tus talentos y habilidades van mejorando con el tiempo.",
      "Tu paciencia conseguirá más cosas que tu fuerza.",
      "Los campeones siguen jugando hasta que lo hacen bien.",
      "El éxito depende del esfuerzo",
    ];
  } else {
    goodJobMessages = [
      "Your're on fire!",
      "You are  doing amazing!",
      "Excellent!",
      "Follow your dreams!",
      "“Success is the sum of small efforts, repeated.” - R. Collier",
      "“Motivation is what gets you started. Habit is what keeps you going.” – Jim Ryun",
      "“What the mind can conceive and believe, and the heart desire, you can achieve.” – Norman Vincent Peale",
      "The sky is the limit!",
      "Look at what you can accomplish!",
      "You are amazing!",
      "Everything you need to accomplish your goals is already in you.",
      "Consistent hard work leads to success.",
      "Patience will take you farther than strength.",
      "“There are no traffic jams on the extra mile.” -Zig Ziglar",
      "Success isn't always about greatness. It's about consistency.- Dwayne “The Rock” Johnson",
      "It always seems impossible until it's done. -Nelson Mandela",
      "Perseverance is not a long race; it is many short races one after the other. -Walter Elliot",
      "Let me tell you the secret that has led to my goal. My strength lies solely in my tenacity. -Louis Pasteur",
      "I was taught the way of progress is neither swift nor easy. -Marie Curie",
      "Success is not final, failure is not fatal: It is the courage to continue that counts. -Winston Churchill",
      "Aim for success!",
      "Your getting so much better!",
      "“If you are working on something that you really care about, you don’t have to be pushed. The vision pulls you.” - Steve Jobs",
      "“We may encounter, many defeats but we must not be defeated.” - Maya Angelou",
      "“Success comes from having dreams that are bigger than your fears.” -Bobby Unser",
    ];
  }

  //Numero random del 0 al goodJobMessages.length
  rand = Math.floor(Math.random() * goodJobMessages.length);
  hiddePreviousQuestion(lastQuestion);
  hiddePreviousAnswers(lastQuestion);
  document.getElementById("dialogo").innerHTML = goodJobMessages[rand];
  //Mostramos esta seccion
  document.getElementById("botonSiguientePregunta").style.display = "block";
}

function motivationBadMessage(lastQuestion) {
  //Ocultamos esta seccion
  document.getElementById("botonSiguientePregunta").style.display = "none";
  document.getElementById("motivationMessage").style.display = "block";
  if (idioma == "e") {
    badJobMessages = [
      "Aunque falles, sigues aprendiendo",
      "Todo esfuerzo valdrá la pena",
      "Yo confió en tí, sigue adelante",
      "Has podido con más, solo concentrate",
      "Todo se logra con un poco de esfuerzo",
      "¡Mantén tu entusiasmo!",
      "¡Tú puedes!",
      "¡Sigue intentando!",
      "¡Cree en ti mismo!",
      "¡No te rindas!",
      " ¡Tú decides seguir!",
      "Sal de tu zona de confort",
      "¡Nunca te conformes!",
      "No bajes tus metas, aumenta tus esfuerzos.",
      " La paciencia y la constancia son los mejores compañeros.",
      "El 80% del éxito se basa simplemente en insistir.",
      "La confianza en ti mismo es el primer secreto del éxito.",
      "Sé constante y lo lograrás.",
      "El éxito es la suma de pequeños esfuerzos repetidos todos los días.",
      "Aprende de tus errores y sigue adelante.",
      "Si crees que puedes, ya estás a medio camino.",
      "a actitud es una pequeña cosa que marca una gran diferencia.",
      "¡Busca la oportunidad!",
      "Si te caes siete veces, levántate ocho.",
      "¡Tú puedes!, sigue intentando.",
      "¡Insiste y lo lograrás!",
      "Las limitaciones viven solo en tu mente.",
      "El mayor riesgo es no arriesgarse nada.",
      "Los errores, son lecciones que te harán mejorar.",
      "Todo comienza con nada.",
    ];
  } else {
    badJobMessages = [
      "You can do it!",
      "Keep trying!",
      "Go for it!",
      "Don´t give up!",
      "It’s worth a shot!",
      "“The expert in anything was once a beginner” — Helen Hayes",
      "What do you have to lose?",
      "Never give up!",
      "Believe in yourself!",
      "Hang in there!",
      "Don’t give up!",
      "Keep pushing!",
      "Keep fighting!",
      "Stay strong!",
      "Never give up!",
      "“There are no shortcuts to any place worth going.” - Beverly Stills",
      "Come on! You can do it!",
      "Just breathe and have faith that everything will work out for the best.",
      "Don’t worry, be happy!",
      "Stay positive",
      "Be the smart person that you are!",
      "Just relax, and keep trying!",
      "It doesn’t matter how slow you go as long as you never stop.",
      "“Never let the fear of striking out stop you from playing the game.” - Babe Ruth",
      "“A person who never made a mistake never tried anything new”. - Albert Einstein",
      "“Learning is never done without errors and defeat.” – Vladimir Lenin",
    ];
  }
  //Numero random del 0 al goodJobMessages.length
  rand = Math.floor(Math.random() * badJobMessages.length);
  hiddePreviousQuestion(lastQuestion);
  hiddePreviousAnswers(lastQuestion);
  document.getElementById("dialogo").innerHTML = badJobMessages[rand];
  //Mostramos esta seccion
  document.getElementById("botonSiguientePregunta").style.display = "block";
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

function enviarAcumulador(userID) {
$.ajax({
  type: "POST",
  url: "../../../Servicios/enviarAcumulador.php",
  dataType: "json",
  data: { id: userID, acmldr: acumulador, flagTipo: "acmlrPP" },
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

var registrarInactividad = function () {
  var t;
  reiniciarTiempo();
  window.onload = reiniciarTiempo;
  // Eventos del DOM
  document.onmousemove = reiniciarTiempo;
  document.onkeypress = reiniciarTiempo;
  document.onload = reiniciarTiempo;
  document.onmousemove = reiniciarTiempo;
  document.onmousedown = reiniciarTiempo; // aplica para una pantalla touch
  document.ontouchstart = reiniciarTiempo;
  document.onclick = reiniciarTiempo;     // aplica para un clic del touchpad
  document.onscroll = reiniciarTiempo;    // navegando con flechas del teclado
  document.onkeypress = reiniciarTiempo;

  function tiempoExcedido() {
      alert("Estuvo inactivo durante mucho tiempo.")
  }

  function reiniciarTiempo() {
      acumulador = 600000;
      clearTimeout(t);
      t = setTimeout(tiempoExcedido, 600000)
      // 1000 milisegundos = 1 segundo
  }
};