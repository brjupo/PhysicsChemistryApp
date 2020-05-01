document.addEventListener("click", function (evt) {
    var goButton = document.getElementById("goButton");
    targetElement = evt.target; // clicked element
  
    do {
      if (targetElement == goButton) {
        getQuestionMatrix();
        return;
      }
      // Go up the DOM
      targetElement = targetElement.parentNode;
    } while (targetElement);
  });

function getQuestionMatrix() {    
    var leccionID = document.getElementById("leccionID").value.trim();
    var Usuario = document.getElementById("Usuario").value.trim();
    var Password = document.getElementById("Password").value.trim();
    alert(Usuario+ " "+ Password+ " "+ leccionID);
  
    $.ajax({
      type: "POST",
      url: "../../Servicios/preguntasGral.php",
      dataType: "json",
      //data: {leccion: leccionID, userID: Usuario, pass:Password},
      data: {idLeccion: leccionID},
      success: function (data) {
        
            console.log(data);
            document.getElementById("ID_pregunta").innerHTML=data[0]["id_pregunta"];
            document.getElementById("Tipo").innerHTML=data[0]["tipo"];
            document.getElementById("PreguntaParte1").innerHTML=data[0]["PreguntaParte1"];
            document.getElementById("PreguntaParte2").innerHTML=data[0]["PreguntaParte2"];
            document.getElementById("R1").innerHTML=data[0]["respuesta_correcta"];
            document.getElementById("R2").innerHTML=data[0]["respuesta2"];
            document.getElementById("R3").innerHTML=data[0]["respuesta3"];
            document.getElementById("R4").innerHTML=data[0]["respuesta2"];
            document.getElementById("RC_Num").innerHTML=data[0]["patrona"];

            document.getElementById("1ID_pregunta").innerHTML=1;
            document.getElementById("1Tipo").innerHTML=1;
            document.getElementById("1PreguntaParte1").innerHTML=1;
            document.getElementById("1PreguntaParte2").innerHTML=1;
            document.getElementById("1R1").innerHTML=1;
            document.getElementById("1R2").innerHTML=1;
            document.getElementById("1R3").innerHTML=1;
            document.getElementById("1R4").innerHTML=1;
            document.getElementById("1RC_Num").innerHTML=1;


            document.getElementById("2ID_pregunta").innerHTML=1;
            document.getElementById("2Tipo").innerHTML=1;
            document.getElementById("2PreguntaParte1").innerHTML=1;
            document.getElementById("2PreguntaParte2").innerHTML=1;
            document.getElementById("2R1").innerHTML=1;
            document.getElementById("2R2").innerHTML=1;
            document.getElementById("2R3").innerHTML=1;
            document.getElementById("2R4").innerHTML=1;
            document.getElementById("2RC_Num").innerHTML=1;

            //document.getElementById("").innerHTML=1;
      },
    });
  }


  /*
  document.getElementById("leccionID").innerHTML
  <p id="ID_pregunta"></p>
<p id="Tipo"></p>
<p id="PreguntaParte1"></p>
<p id="PreguntaParte2"></p>
<p id="R1"></p>
<p id="R2"></p>
<p id="R3"></p>
<p id="R4"></p>
<p id="RC_Num"></p>
  */