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
            <li class="nav-item active">
                <a class="nav-link" href="iniciosesion.php">Inicio</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="">Acerca de</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="">Contacto</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <br></br>

    </div>


    <?php
    include 'Configuraciones\funciones.php';

    $nombreUser = $avatar = $fechaNac = $mail = $pass = "";
    $_nombreDeUsuario = $_fechaNac = $_mail = $_pass1 = $_pass2 = "";
    $fechamax = date("Y-m-d");
    $fechamin = date("1900-01-01");

    $errorNombre = $errorFile = $errorFecha = $errorMail = $errorPass1 = $errorPass2 = "";

    $registrado = false;

    if (!empty($_POST)) {
        //---------------------------- USER --------------------------------
        $_nombreDeUsuario = htmlspecialchars($_POST["nombreDeUsuario"]);
        if (!empty($_nombreDeUsuario)) {
            if (!validar($_nombreDeUsuario, VALIDA_NOMBREUSUARIO)) {
                $errorNombre = "<span style='color:red'>Por favor, ingrese un nombre válido</span>";
            } else {
                if(strlen($_nombreDeUsuario) >= 3 && strlen($_nombreDeUsuario) <= 32){
                    $nombreUser = $_nombreDeUsuario;
                }else{
                    $errorNombre = "<span style='color:red'>Tiene que tener entre 8-16 caracteres</span>";
                }
            }
        } else {
            $errorNombre = ERROR_VACIO;
        }
        //---------------------------- PASS --------------------------------
        $_pass1 = htmlspecialchars($_POST["password1"]);
        $_pass2 = htmlspecialchars($_POST["password2"]);
        if(!empty($_pass1)) {
            if(validarPassword($_pass1, $errorPass1)){
                if(!empty($_pass2)) {
                    if($_pass1 == $_pass2){
                        $pass = $_pass1;
                    }else{
                        $errorPass2 = "<span style='color:red'>Las contraseñas no coinciden</span>";
                    }
                }else{
                    $errorPass2 = ERROR_VACIO;
                }
            }
        }else{
            $errorPass1 = ERROR_VACIO;
        }
        //---------------------------- DATE --------------------------------
        $_fechaNac = htmlspecialchars($_POST["fechaNac"]);
        if (!empty($_fechaNac)) {
            if (calculaedad($_fechaNac)) {
                $fechaNac = $_fechaNac;
            } else {
                $errorFecha = "<span style='color:red'>Solo se pueden registrar mayores de edad</span>";
            }
        } else {
            $errorFecha = ERROR_VACIO;
        }
        //---------------------------- MAIL --------------------------------
        $_mail = htmlspecialchars($_POST["correoUsuario"]);
        if(!empty($_mail)){
            if(validarMail($_mail)){
                $mail = $_mail;
            }else{
                $errorMail = "<span style='color:red'>Introduce un Mail válido</span>";
            }
        }else{
            $errorMail = ERROR_VACIO;
        }
        //---------------------------- FILE --------------------------------
        if (
            empty($_FILES) == false && empty($_FILES["avatar"]) == false
            && $_FILES["avatar"]["tmp_name"] != ""
        ) {
            if ($_FILES['avatar']['size'] < 1000000) {//1 mega
                $avatar = getImage($_FILES["avatar"]);
            //saveImage($_FILES["avatar"]);
            }else{
                $errorFile = "<span style='color:red'>El archivo no puede ocupar más de un mega</span>";
            }
            
        } else {
            $errorFile = ERROR_VACIO;
        }
        //---------------------------- RGST --------------------------------
        if (!empty($nombreUser) && !empty($fechaNac) && !empty($avatar) && !empty($mail)) {
            //REGISTRAR (GUARDAR DATOS)
            $registrado = true;
        }
    }


    ?>