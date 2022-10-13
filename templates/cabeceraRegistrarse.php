<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajo</title>
    <link rel="stylesheet" href="./css/archivo.css" />
    <link rel="stylesheet" href="./css/style.css" />

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <ul class="nav navbar-nav">
            <li>
        <a href="#" class="navbar-brand">
                <img src="multimedia/imagenes/logo2.png.png" alt="Logo">
            </a>
            </li>
            <li class="nav-item active" style="margin: auto;">
                <a class="nav-link" href="index.php">Inicio</a>
            </li>

            <li class="nav-item" style="margin: auto;">
                <a class="nav-link" href="acercade.php">Acerca de</a>
            </li>

            <li class="nav-item" style="margin: auto;">
                <a class="nav-link" href="contacto.php">Contacto</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <br></br>

    </div>


    <?php
    include 'Configuraciones\funciones.php';
    //ESTRUCTURA HTML DE UN MENSAJE DE CONFIRMACIÓN. *****************
    $confirmacionCorreo = CONFIRMACION_CORREO;
    //ESTRUCTURA HTML DE UN MENSAJE DE CONFIRMACIÓN POR CORREO. *****************
    $confirmacionCorreo = wordwrap($confirmacionCorreo, 70, "\r\n");

    $user = $avatar = $fechaNac = $mail = $pass = "";
    $_user = $_fechaNac = $_mail = $_pass1 = $_pass2 = "";
    $errorUser = $errorAvatar = $errorFecha = $errorMail = $errorPass1 = $errorPass2 = "";
    $registrado = false;

    if (!empty($_POST)) {
        //---------------------------- USER --------------------------------
        $_user = htmlspecialchars($_POST["user"]);
        if(validarUser($_user, $errorUser)){
            $user = $_user;
        }
        //---------------------------- PASS --------------------------------
        $_pass1 = htmlspecialchars($_POST["password1"]);
        $_pass2 = htmlspecialchars($_POST["password2"]);
        if(validarBothPasswords($_pass1, $_pass2, $errorPass1, $errorPass2)){
            $pass = $_pass1;
        }
        //---------------------------- DATE --------------------------------
        $_fechaNac = htmlspecialchars($_POST["fechaNac"]);
        if(validarFechaNac($_fechaNac, $errorFecha)){
            $fechaNac = $_fechaNac;
        }
        //---------------------------- MAIL --------------------------------
        $_mail = htmlspecialchars($_POST["correoUsuario"]);
        if(validarMail($_mail, $errorMail)){
            $mail = $_mail;
        }
        //---------------------------- FILE --------------------------------
        if(validarAvatar($_FILES, $errorAvatar)){
            $avatar = getImage($_FILES["avatar"]);
            //GUARDAR
        }
        //---------------------------- RGST --------------------------------
        if (!empty($user) && !empty($pass) && !empty($fechaNac) && !empty($mail) && !empty($avatar)) {
            //REGISTRAR (GUARDAR DATOS)
            $registrado = true;
            //mail($mail, 'Confirmar cuenta',$confirmacionCorreo);
        }
    }

    ?>