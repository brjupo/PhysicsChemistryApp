window.onload = function () {
    countDiamonts();
};

function countDiamonts() {
    var totalDiamantes = parseInt(document.getElementById("numeroDiamantes").innerHTML.trim());
    var diamantes = 0;
    // Update the count down every 1 second
    var x = setInterval(function () {
        document.getElementById("numeroDiamantes").innerHTML = diamantes;
        diamantes = diamantes + 1;
        if (diamantes > totalDiamantes) {
            clearInterval(x);
        }
    }, 20);
}

