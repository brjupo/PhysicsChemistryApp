//--------------------------------------------------------------
//---------------------------ON CLIC----------------------------
//--------------------------------------------------------------
document.addEventListener("click", function (evt) {
    var botonContrasenaOlvidada = document.getElementById("contraOlvidada");
    var spanish = document.getElementById("spanish");
    var english = document.getElementById("english");
    var signIn = document.getElementById("signIn");
    var signUp = document.getElementById("signUp");
    var imStudent = document.getElementById("studentTable");
    var imTeacher = document.getElementById("teacherTable");
    var registerTeacherButton = document.getElementById("registrarProfesor");
    var registerStudentButton = document.getElementById("registrarAlumno");
    targetElement = evt.target; // clicked element
  
    do {
      if (targetElement == botonContrasenaOlvidada) {
        showContraOlvidada();
        return;
      }
      if (targetElement == spanish) {
        cambiarEspanol();
        escribirEspanol();
        return;
      }
      if (targetElement == english) {
        cambiarIngles();
        escribirIngles();
        return;
      }
      if (targetElement == signIn) {
        ocultarForms();
        mostrarSignIn();
        return;
      }
      if (targetElement == signUp) {
        ocultarForms();
        mostrarSignUp();
        return;
      }
      if (targetElement == imStudent) {
        ocultarForms();
        mostrarImStudent();
        return;
      }
      if (targetElement == imTeacher) {
        ocultarForms();
        mostrarImTeacher();
        return;
      }
      if (targetElement == registerTeacherButton) {
        registrarProfesor();
        return;
      }
      if (targetElement == registerStudentButton) {
        registrarAlumno();
        return;
      }
      // Go up the DOM
      targetElement = targetElement.parentNode;
    } while (targetElement);
  });
  function ocultarForms() {
    document.getElementById("signUpData").style.display = "none";
    document.getElementById("signInData").style.display = "none";
    document.getElementById("contraOlvidada").style.display = "none";
    document.getElementById("ingresar").style.display = "none";
    document.getElementById("correoProfesor").style.display = "none";
    document.getElementById("validarCorreoProfesor").style.display = "none";
    document.getElementById("correoAlumno").style.display = "none";
    document.getElementById("validarCorreoAlumno").style.display = "none";
    document.getElementById("codigoAlumno").style.display = "none";
    document.getElementById("validarCodigoAlumno").style.display = "none";
    document.getElementById("registrarAlumno").style.display = "none";
    document.getElementById("registrarProfesor").style.display = "none";
    signIn.classList.remove("signIn_off");
    signIn.classList.remove("signIn_on");
    signUp.classList.remove("signUp_on");
    signUp.classList.remove("signUp_off");
  }
  function mostrarSignIn() {
    document.getElementById("signInData").style.display = "block";
    signIn.classList.add("signIn_on");
    signUp.classList.add("signUp_off");
    document.getElementById("contraOlvidada").style.display = "block";
    document.getElementById("ingresar").style.display = "block";
  }
  function mostrarSignUp() {
    document.getElementById("signUpData").style.display = "block";
    signIn.classList.add("signIn_off");
    signUp.classList.add("signUp_on");
  }
  function mostrarImStudent() {
    mostrarSignUp();
    document.getElementById("correoAlumno").style.display = "block";
    document.getElementById("validarCorreoAlumno").style.display = "block";
    document.getElementById("codigoAlumno").style.display = "block";
    document.getElementById("validarCodigoAlumno").style.display = "block";
    document.getElementById("registrarAlumno").style.display = "block";
  }
  function mostrarImTeacher() {
    mostrarSignUp();
    document.getElementById("correoProfesor").style.display = "block";
    document.getElementById("validarCorreoProfesor").style.display = "block";
    document.getElementById("registrarProfesor").style.display = "block";
  }
  function cambiarEspanol() {
    var idioma = document.getElementById("idiomas");
    idioma.innerHTML = "Idioma";
    var slogan = document.getElementById("slogan");
    slogan.innerHTML = "!Diviértete Aprendiendo!";
    document.getElementById("signIn").innerHTML = "Ingresar";
    document.getElementById("signUp").innerHTML = "Registrarse";
    var usuario = document.getElementById("usuario");
    usuario.innerHTML = "Usuario";
    var contrasena = document.getElementById("contrasena");
    contrasena.innerHTML = "Contraseña";
    var olvidada = document.getElementById("contraOlvidada");
    olvidada.innerHTML = "Olvide mi contraseña";
    var contacto = document.getElementById("contacto");
    contacto.innerHTML = "Contáctanos";
    document.getElementById("TyC").innerHTML =
      "Al hacer clic en Ingresar/Registrarse aceptas nuestros " +
      "<a href='terminosCondiciones.html'>" +
      "<strong>términos y condiciones</strong></a>";
    document.getElementById("ingresar").value = "Ingresar";
    document.getElementById("registrarAlumno").innerHTML = "Registrar";
    document.getElementById("registrarProfesor").innerHTML = "Resgistrar";
    document.getElementById("soyProfesor").innerHTML = "Soy profesor";
    document.getElementById("correoProfesor").innerHTML = "Correo";
    document.getElementById("soyAlumno").innerHTML = "Soy Alumno";
    document.getElementById("correoAlumno").innerHTML = "Correo";
    document.getElementById("codigoAlumno").innerHTML = "Código de grupo";
  }
  
  function cambiarIngles() {
    var idioma = document.getElementById("idiomas");
    idioma.innerHTML = "Language";
    var slogan = document.getElementById("slogan");
    slogan.innerHTML = "Have fun learning!";
    document.getElementById("signIn").innerHTML = "Sign In";
    document.getElementById("signUp").innerHTML = "Sign Up";
    var usuario = document.getElementById("usuario");
    usuario.innerHTML = "User";
    var contrasena = document.getElementById("contrasena");
    contrasena.innerHTML = "Password";
    var olvidada = document.getElementById("contraOlvidada");
    olvidada.innerHTML = "Forgot password?";
    var contacto = document.getElementById("contacto");
    contacto.innerHTML = "Contact us";
    document.getElementById("TyC").innerHTML =
      "By clicking Log In/Sign Up, you agree to our " +
      "<a href='terminosCondiciones.html'>" +
      "<strong>terms and conditions</strong></a>";
    document.getElementById("ingresar").value = "Log In";
    document.getElementById("registrarAlumno").innerHTML = "Sign Up";
    document.getElementById("registrarProfesor").innerHTML = "Sign Up";
    document.getElementById("soyProfesor").innerHTML = "I am a teacher";
    document.getElementById("correoProfesor").innerHTML = "e-mail";
    document.getElementById("soyAlumno").innerHTML = "I am a student";
    document.getElementById("correoAlumno").innerHTML = "e-mail";
    document.getElementById("codigoAlumno").innerHTML = "Group code";
  }
  
  function escribirEspanol() {
    document.getElementById("idioma").value = "e";
    document.getElementById("spanish").style.webkitFilter = "brightness(3)";
    document.getElementById("english").style.webkitFilter = "brightness(1)";
  }
  function escribirIngles() {
    document.getElementById("idioma").value = "i";
    document.getElementById("spanish").style.webkitFilter = "brightness(1)";
    document.getElementById("english").style.webkitFilter = "brightness(3)";
  }
  function showContraOlvidada() {
    var matricula = $("#validarUsuario").val();
    console.log("Matricula: ", matricula);
    $.ajax({
      type: "POST",
      url: "dev/servicios/contraOlvidada.php",
      dataType: "json",
      data: { correo_e: matricula },
      success: function (data) {
        console.log(data.response);
        if (data.response == "true") {
          //alert("Etcito");
          document.getElementById("emailMessage").innerHTML =
            "Te hemos enviado un mensaje a tu correo para recuperar tu contraseña.";
          console.log("Correo enviado");
        } else {
          //alert(data.response);
          document.getElementById("emailMessage").innerHTML = data.response;
        }
      },
    });
    //document.getElementById("forma").style.display = "none";
    document.getElementById("emailMessage").style.display = "block";
  }

  function registrarAlumno() {
    var correo_alumno = document.getElementById("validarCorreoAlumno").value;
    var codigo = document.getElementById("validarCodigoAlumno").value;

    console.log("Correo profesor: ", correo_alumno);
    $.ajax({
      type: "POST",
      url: "dev/servicios/registerStudent.php",
      dataType: "json",
      data: { studentMail: correo_alumno, studentCode: codigo},
      error: function () {
        document.getElementById("emailMessage").innerHTML =
          "Te hemos enviado un correo desde <strong>licencias@kaanbal.net</strong> el cual indica el proceso a seguir. Por favor revisa tu carpeta de junk mail, spam o correo no deseado.";
      },
      success: function (data) {
        console.log(data.response);
        document.getElementById("emailMessage").innerHTML = data.response;
      },
    });
    document.getElementById("emailMessage").style.display = "block";
  }