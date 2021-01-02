window.onload = function () {
  //var specialChars = "!@#$%^&*()-_=+[{]}\\|;:'\",<.>/?`~";
  var myInput = document.getElementById("psw");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var length = document.getElementById("length");
  var symbol = document.getElementById("symbol");

  // When the user clicks on the password field, show the message box
  myInput.onfocus = function () {
    document.getElementById("message").style.display = "block";
  };

  // When the user clicks outside of the password field, hide the message box
  myInput.onblur = function () {
    document.getElementById("message").style.display = "none";
  };

  // When the user starts to type something inside the password field
  myInput.onkeyup = function () {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if (myInput.value.match(lowerCaseLetters)) {
      letter.classList.remove("invalid");
      letter.classList.add("valid");
    } else {
      letter.classList.remove("valid");
      letter.classList.add("invalid");
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if (myInput.value.match(upperCaseLetters)) {
      capital.classList.remove("invalid");
      capital.classList.add("valid");
    } else {
      capital.classList.remove("valid");
      capital.classList.add("invalid");
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if (myInput.value.match(numbers)) {
      number.classList.remove("invalid");
      number.classList.add("valid");
    } else {
      number.classList.remove("valid");
      number.classList.add("invalid");
    }
    // Validate symbols
    //var specialChars = "!@#$%^&*()-_=+[{]}\\|;:'\",<.>/?`~";
    var specialChars = "@#$%^&+=";
    var password = myInput.value;
    var seEncuentra = false;
    var i;
    var j;

    for (j = 0; j < password.length; j++) {
      letra = password.charAt(j);
      for (i = 0; i < specialChars.length; i++) {
        if (specialChars.charAt(i) === letra) {
          seEncuentra = true;
        }
      }
    }

    if (seEncuentra) {
      symbol.classList.remove("invalid");
      symbol.classList.add("valid");
    } else {
      symbol.classList.remove("valid");
      symbol.classList.add("invalid");
    }

    // Validate length
    if (myInput.value.length >= 8) {
      length.classList.remove("invalid");
      length.classList.add("valid");
    } else {
      length.classList.remove("valid");
      length.classList.add("invalid");
    }
  };
};

document.addEventListener("click", function (evt) {
  var mandarInfoAlServicio = document.getElementById("submit");
  var titulo = document.getElementById("titulo");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == mandarInfoAlServicio) {
      sentInfoToService();
      return;
    }
    if (targetElement == titulo) {
      index();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function index() {
  window.location.href = "https://kaanbal.net";
}

function sentInfoToService() {
  var token = document.getElementById("token").value.trim();
  var correo_e = document.getElementById("correo_e").value.trim();
  var contrasenia = document.getElementById("psw").value.trim();
  var contrasenia2 = document.getElementById("psw2").value.trim();
  if (contrasenia != contrasenia2) {
    alert("Por favor revisa los campos");
  } else {
    console.log(
      "Correo: ",
      correo_e,
      " Contras: ",
      contrasenia,
      " token: ",
      token
    );
    $.ajax({
      type: "POST",
      url: "../../servicios/registro.php",
      dataType: "json",
      data: { correo: correo_e, password: contrasenia, tokenA: token },
      success: function (data) {
        console.log(data.response);
        if (data.response == "true") {
          alert("Contraseña registrada");
          //window.location.href = "https://kaanbal.net";
          console.log("Registro exitoso");
        } else {
          alert("Algo fallo :/ ");
          console.log("Registro no exitoso");
        }
      },
    });
  }
}
