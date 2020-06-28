var allIds = [];

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
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == guardarEnBBDD) {
      saveAllInDB();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function saveAllInDB(){
    for(j = 0; j<allIds.length; j++){
        console.log(j);
        console.log(document.getElementById(j).value.trim());
    }
    //saveInDB();
}


function saveInDB(id_tema, nombre) {
    $.ajax({
        type: "POST",
        url: "../SERVICIOS/nombreTema.php",
        dataType: "json",
        data: {
          id_tema: id_tema,
          nombre: nombre
        },
        success: function (data) {
          if (data.response == "exito") {
            console.log(data.response);
            //alert("Nombre actualizado en Base de datos");
          } else {
            console.log(data.response);
            //alert("Error: " + data.response);
          }
        },
        error: function () {
          alert("ERROR Desconocido, Actualice la página y reintente");
        },
      });
}
