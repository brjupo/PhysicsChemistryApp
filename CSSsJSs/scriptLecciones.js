window.onload = function() {
    this.entrada();
}


function opacity(shID) {
    document.getElementById(shID).style.opacity = 1.0;
}

function entrada(){
    //transition: opacity 2s ease-in-out;
    setTimeout(function(){opacity("seccion0");},100);
    setTimeout(function(){opacity("seccion1");},500);
    setTimeout(function(){opacity("seccion2");},900);
    setTimeout(function(){opacity("seccion3");},1300);
    setTimeout(function(){opacity("seccion4");},1700);
}
