var cantidadIDs = 1;
window.onload = function() {
    contarIDs();
    entrada();
}


function opacity(shID) {
    document.getElementById(shID).style.opacity=1.0;
}

function entrada(){
    function doSetTimeout(i) {
      var sesion = "seccion";
      sesion = sesion.concat(i);
      console.log("Cambiando opacidad a ", sesion);
      setTimeout(function() { opacity(sesion); }, i*200);
    }
    for (var i = 1; i <= cantidadIDs; ++i){
      doSetTimeout(i);
    }
}

function contarIDs() {
    for (var i = 1; i <= 100; i++) {
        var sesion = "seccion";
        sesion = sesion.concat(i);
      if (document.getElementById(sesion)) {
        console.log(sesion);
        //console.log(document.getElementById(i));
        cantidadIDs = i;
      }
    }
  }