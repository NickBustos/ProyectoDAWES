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
                <a class="nav-link" href="">Inicio</a>
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

    $nombreUser = $avatar = $fechaNac = "";
    $_nombreDeUsuario = $_fechaNac = "";
    $fechamax = date("Y-m-d");
    $fechamin = date("1900-01-01");

    $errorNombre = $errorFile = $errorFecha = "";

    $registrado = false;

    if (!empty($_POST)) {
        $_nombreDeUsuario = htmlspecialchars($_POST["nombreDeUsuario"]);
        //---------------------------- USER --------------------------------
        if (!empty($_nombreDeUsuario)) {
            if (!validar($_nombreDeUsuario, VALIDA_NOMBREUSUARIO)) {
                $errorNombre = "<span style='color:red'>Por favor, ingrese un nombre válido</span>";
            } else {
                $nombreUser = $_nombreDeUsuario;
            }
        } else {
            $errorNombre = ERROR_VACIO;
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
        if (!empty($nombreUser) && !empty($fechaNac) && !empty($avatar)) {
            //REGISTRAR (GUARDAR DATOS)
            $registrado = true;
        }
    }


    ?>