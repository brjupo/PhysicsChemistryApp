
window.onload = function () {
var fruits = [];

fruits.push("3");
fruits.push("5");
fruits.push("7");
fruits.push("12");
document.getElementById("demo1").innerHTML = fruits[0];
fruits.shift();
document.getElementById("demo2").innerHTML = fruits;
fruits.shift();
document.getElementById("demo3").innerHTML = fruits;
fruits.shift();
document.getElementById("demo4").innerHTML = fruits;
document.getElementById("length4").innerHTML = fruits.length;
fruits.shift();
document.getElementById("demo5").innerHTML = fruits;
document.getElementById("length5").innerHTML = fruits.length;
fruits.shift();
document.getElementById("demo6").innerHTML = fruits;
document.getElementById("length6").innerHTML = fruits.length;
}
