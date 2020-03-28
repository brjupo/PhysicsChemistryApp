window.onload = function() {
  //var specialChars = "!@#$%^&*()-_=+[{]}\\|;:'\",<.>/?`~";
  var myInput = document.getElementById("psw");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var length = document.getElementById("length");
  var symbol = document.getElementById("symbol");

  // When the user clicks on the password field, show the message box
  myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
  };

  // When the user clicks outside of the password field, hide the message box
  myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
  };

  // When the user starts to type something inside the password field
  myInput.onkeyup = function() {
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
    //var specialChars = "@#$%^&+=";
    var specialChars = "!@#$%^&*()-_=+[{]}\\|;:'\",<.>/?`~";
    var password = myInput.value;
    var seEncuentra = false;
    var i;
    var j;

    for (j = 0; j < password.length; j++) {
      letra=password.charAt(j);
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
  var validation = Array.prototype.filter.call(forms, function (form) {
    form.addEventListener(
        "submit",
        function (event) {
            if (form.checkValidity() === false) {
                console.log("no entras prro");
                event.preventDefault();
                event.stopPropagation();
            }
            else{
                var nombre = "yoMero";
                var correo = $("#validarUsuario").val();
                var contrasena = $("#validarPassword").val();
                console.log("entre");
                $.ajax({
                    type: "POST",
                    url: "https://educapp-frontend.000webhostapp.com/registerEducapp.php",
                    data:  { name: nombre, username: correo, password: contrasena },
                    success: function (data) {
                        console.log("etcito  " + data.msg);
                    },
                    dataType: "json"
                  });                    
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        },
        false
    );
});
};



