var allIds = [];
var allIdsTemp = [];

window.onload = function () {
  var allElements = document.getElementsByTagName("*");
  var el;
  var entero;
  for (var i = 0, n = allElements.length; i < n; ++i) {
    el = allElements[i];
    if (el.id) {
        entero = parseInt(el.id);
        if(!isNaN(entero)){
            allIds.push(entero);
        }
    }
  }
};

document.addEventListener("click", function (evt) {
  var guardarEnBBDD = document.getElementById("guardarEnBBDD");
  targetElement = evt.target;

  do {
    if (targetElement == guardarEnBBDD) {
      document.getElementById("imgLoadingGif").style.display = "block";
      allIdsTemp = [...allIds];
      saveInDB();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});



function saveInDB() {
    if(allIdsTemp.length==0){
        alert("Información actualizada en base de datos");
        document.getElementById("imgLoadingGif").style.display = "none";
        return;
    }
    $.ajax({
        type: "POST",
        url: "../servicios/setVideoLink.php",
        dataType: "json",
        data: {
          idLeccion: allIdsTemp[0],
          videoLink: document.getElementById(allIdsTemp[0]).value.trim()
        },
        success: function (data) {
          if (data.response == "exito") {
            console.log(data.response);
            console.log(allIdsTemp[0]);
            console.log(document.getElementById(allIdsTemp[0]).value.trim());
            allIdsTemp.shift();
            saveInDB();
            //alert("Nombre actualizado en Base de datos");
          } else {
            console.log(data.response);
            //alert("Error: " + data.response);
          }
        },
        error: function () {
          alert("ERROR Desconocido, Actualice la página y reintente");
          document.getElementById("imgLoadingGif").style.display = "none";
        },
      });
}
