//<script type="text/javascript">
  $(document).ready(function() {   
      $('#mandarInfoAlServicio').click(function(e){
        e.preventDefault();
        var nombre = "yoMero";
        var correo = $("#validarUsuario").val();
        var contrasena = $("#validarPassword").val();

        $.ajax({
            type: "POST",
            url: "https://educapp-frontend.000webhostapp.com/registerEducapp.php",
            dataType: "json",
            data: { name:nombre , username:correo, password:contrasena },
            success : function(data){
                if (data.code == "200"){
                    alert("Success: " +data.msg);
                } else {
                    alert(data.msg);
                }
            }
        });
      });
  });
//</script>

document.addEventListener("click", function (evt) {
  var botonCodigo = document.getElementById("botonCodigo");
  var botonSesion = document.getElementById("botonSesion");
  var mandarInfoAlServicio = document.getElementById("mandarInfoAlServicio");
  var botonContrasenaOlvidada = document.getElementById("contraOlvidada");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == botonCodigo) {
      console.log("Codigo");
      showCode();
      return;
    }
    if (targetElement == botonSesion) {
      console.log("Sesion");
      showSession();
      return;
    }
    if (targetElement == botonContrasenaOlvidada) {
      showContraOlvidada();
      return;
    }
    if (targetElement == mandarInfoAlServicio) {
      servicio();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function showCode() {
  hideAll();
  document.getElementById("seccionCodigo").style.display = "block";
}
function showSession() {
  hideAll();
  document.getElementById("seccionSesion").style.display = "block";
}

function hideAll() {
  document.getElementById("seccionCodigo").style.display = "none";
  document.getElementById("seccionSesion").style.display = "none";
  document.getElementById("emailSent").style.display = "none";
  document.getElementById("relleno").style.display = "none";
}

function showContraOlvidada() {
  hideAll();
  document.getElementById("emailSent").style.display = "block";
}

window.onload = function () {
  //this.hideAll();
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.getElementsByClassName("needs-validation");
  //var forms = document.getElementById('validacion');
  // Loop over them and prevent submission
  var validation = Array.prototype.filter.call(forms, function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
};
