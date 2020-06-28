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
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == guardarEnBBDD) {
      allIdsTemp = allIds;
      saveInDB();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

//NO SE PUEDE HACER ESTO, DEPENDES DEL TIEMPO QUE SE TARDE EL SERVICIO EN RESPONDER
/*
function saveAllInDB(){
    for(j = 0; j<allIds.length; j++){
        console.log(allIds[j]);
        console.log(document.getElementById(allIds[j]).value.trim());
        saveInDB(allIds[j], document.getElementById(allIds[j]).value.trim());
    }
}
*/


function saveInDB() {
    if(allIdsTemp.length==0){
        alert("Información actualizada en base de datos");
        return;
    }
    $.ajax({
        type: "POST",
        url: "../SERVICIOS/nombreTema.php",
        dataType: "json",
        data: {
          id_tema: allIds[0],
          nombre: document.getElementById(allIds[0]).value.trim()
        },
        success: function (data) {
          if (data.response == "exito") {
            console.log(data.response);
            console.log(allIds[0]);
            console.log(document.getElementById(allIds[0]).value.trim());
            allIds.shift();
            saveInDB();
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
