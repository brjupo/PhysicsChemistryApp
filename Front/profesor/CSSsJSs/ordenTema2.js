var allIds = [];
var allIdsTemp = [];
var contadorOrden = 1;

/*
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
*/

document.addEventListener("click", function (evt) {
  var guardarEnBBDD = document.getElementById("guardarEnBBDD");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == guardarEnBBDD) {
      //allIdsTemp = [...allIds];
      prepareToSaveInDB();
      //saveInDB();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function prepareToSaveInDB() {
  var children = document.getElementById("sortable").children;
  for (var i = 0; i < children.length; i++) {
    allIds.push(children[i].id);
  }
  allIdsTemp = [...allIds];
  saveInDB();
}

//Se hace de manera recursiva. Se debe esperar a que el servicio conteste.

function saveInDB() {
  if (allIdsTemp.length == 0) {
    alert("Información actualizada en base de datos");
    return;
  }
  $.ajax({
    type: "POST",
    url: "../servicios/ordenTema.php",
    dataType: "json",
    data: {
      id_tema: allIdsTemp[0],
      orden: contadorOrden,
      //orden: document.getElementById(allIdsTemp[0]).value.trim(),
    },
    success: function (data) {
      if (data.response == "exito") {
        console.log(data.response);
        console.log(allIdsTemp[0]);
        //console.log(document.getElementById(allIdsTemp[0]).value.trim());
        console.log(contadorOrden);
        allIdsTemp.shift();
        contadorOrden = contadorOrden + 1;
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
