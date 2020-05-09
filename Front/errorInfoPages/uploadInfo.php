<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../CSSsJSs/styleUploadOne.css" />
    <script src="../CSSsJSs/scriptUploadOne.js"></script>
    <script src="../CSSsJSs/minAJAX.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                <p class="titulo" id="titulo">Kaanbal</p>
            </div>
            <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>



    <div class="container">
        <div class="row">
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="textCenter col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                <label for="correoNuevo">Matrícula a dar de alta. Ejemplo.- A01169493</label>
                <input type="text" id="matricula" name="matricula" maxlength="9" pattern="(A)(0)(?=.*\d).{7}" placeholder="A01169493" required />

                <label for="psw">Por favor, confirme contraseña de super usuario de hoy <?php echo date("Y-m-d") ?></label>
                <input type="password" id="psw" name="psw" required />

            </div>
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-2 col-sm-2 col-md-5 col-lg-5 col-xl-5"></div>
            <div class="textCenter col-8 col-sm-8 col-md-2 col-lg-2 col-xl-2">
                <button class="boton2" id="submit">
                    Subir matrícula
                </button>
            </div>
            <div class="textCenter col-2 col-sm-2 col-md-5 col-lg-5 col-xl-5"></div>
        </div>
    </div>





    <h2>Import CSV file into Mysql using PHP</h2>

    <div id="response" class="<?php if (!empty($type)) {
                                    echo $type . " display-block";
                                } ?>">
        <?php if (!empty($message)) {
            echo $message;
        } ?>
    </div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-horizontal" action="" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file" id="file" accept=".csv">
                    <button type="submit" id="submit" name="import" class="btn-submit">Import</button>
                    <br />

                </div>

            </form>

        </div>
        <?php
        $sqlSelect = "SELECT * FROM users";
        $result = $db->select($sqlSelect);
        if (!empty($result)) {
        ?>
            <table id='userTable'>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>First Name</th>
                        <th>Last Name</th>

                    </tr>
                </thead>
                <?php

                foreach ($result as $row) {
                ?>

                    <tbody>
                        <tr>
                            <td><?php echo $row['userId']; ?></td>
                            <td><?php echo $row['userName']; ?></td>
                            <td><?php echo $row['firstName']; ?></td>
                            <td><?php echo $row['lastName']; ?></td>
                        </tr>
                    <?php
                }
                    ?>
                    </tbody>
            </table>
        <?php } ?>
    </div>







    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:rgba(0,0,0,0)">.</p>
            </div>
        </div>
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:rgba(0,0,0,0)">.</p>
            </div>
        </div>
    </div>
    <div class="foot">
        <div class="container">
            <div class="row">
                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 ">
                    <p class="footSubject">Nosotros</p>
                </div>
                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 ">
                    <p class="footSubject">Ayuda</p>
                </div>
                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 ">
                    <p class="footSubject">Términos</p>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#frmCSVImport").on("submit", function() {

                $("#response").attr("class", "");
                $("#response").html("");
                var fileType = ".csv";
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
                if (!regex.test($("#file").val().toLowerCase())) {
                    $("#response").addClass("error");
                    $("#response").addClass("display-block");
                    $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
                    return false;
                }
                return true;
            });
        });
    </script>
</body>

</html>