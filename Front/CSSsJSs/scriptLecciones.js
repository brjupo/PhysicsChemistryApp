var cantidadIDs = 0;
window.onload = function() {
    contarIDs();
    entrada();
}


function opacity(shID) {
    document.getElementById(shID).style.opacity = 1.0;
}

function entrada(){
    //transition: opacity 2s ease-in-out;
    //setTimeout(function(){opacity("seccion0");},100);
    //setTimeout(function(){opacity("seccion1");},500);
    //setTimeout(function(){opacity("seccion2");},900);
    //setTimeout(function(){opacity("seccion3");},1300);
    
    var tiempoMaxMilis = 1000;
    var desfase = parseInt(tiempoMaxMilis/cantidadIDs);
    for (var i = 0; i <= cantidadIDs; i++) {
        var sesion = "seccion";
        sesion = sesion.concat(i);
        setTimeout(function(){opacity(sesion);},desfase*i);
    }
}

function contarIDs() {
    for (var i = 0; i <= 100; i++) {
        var sesion = "seccion";
        sesion = sesion.concat(i);
      if (document.getElementById(sesion)) {
        console.log(sesion);
        //console.log(document.getElementById(i));
        cantidadIDs = i;
      }
    }
  }