document.addEventListener("click", function (evt) {
  var generateReport = document.getElementById("generateReport");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == generateReport) {
      oneGroupOneMode();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function oneGroupOneMode() {
  string =
    "oneGroupOneMode.php?grupo=" +
    document.getElementById("grupo").value.trim() +
    "&modo=" +
    document.getElementById("modalidad").value.trim()+
    "&leccion=" +
    document.getElementById("leccion").innerHTML.trim();
  window.location.replace(tring);
}
