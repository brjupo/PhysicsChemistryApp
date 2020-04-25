var Correctaudio = new Audio("Correct.mp3");

document.addEventListener("click", function (evt) {
  var cruzCerrar = document.getElementById("play");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == cruzCerrar) {
      Correctaudio.play();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});
