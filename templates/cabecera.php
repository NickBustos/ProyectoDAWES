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

    $_nombreUsuario = $_fechaNac = "";
    $fechamax = date("Y-m-d");
    $fechamin = date("1900-01-01");

    $errorNombre = $errorFile = $errorFecha = "";

    if (!empty($_POST)) {
        $nombreUserPass = $avatar = $fechaNac = "";
        $_nombreUsuario = htmlspecialchars($_POST["nombreDeUsuario"]);
        //---------------------------- USER --------------------------------
        if (!empty($nombreDeUsuario)) {
            if (!validar($nombreDeUsuario, VALIDA_NOMBREUSUARIO)) {
                $errorNombre = "Por favor, ingrese un nombre válido";
            } else {
                $nombreUserPass = $_nombreUsuario;
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
                $errorFecha = "Solo se pueden registrar mayores de edad";
            }
        }else{
            $errorFecha = ERROR_VACIO;
        }
        //---------------------------- FILE --------------------------------
        if (empty($_FILES) == false && empty($_FILES["avatar"]) == false 
            && $_FILES["avatar"]["tmp_name"] != "") {
            $avatar = getImage($_FILES["avatar"]);
            //saveImage($_FILES["avatar"]);
        } else {
            $errorFile = ERROR_VACIO;
        }
    }


    ?>