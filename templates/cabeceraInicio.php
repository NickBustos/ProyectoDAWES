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
            <li class="nav-item active " style="margin: auto;">
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


    </div>


    <?php
    include 'Configuraciones\funciones.php';

    $nombreUser = $password = $linea = "";

    $errorNombre = $errorPassword = "";

    $registrado = false;


    if (!empty($_POST)) {
        $_nombreDeUsuario = htmlspecialchars($_POST["nombreDeUsuario"]);
        //---------------------------- USER --------------------------------
        if (!empty($_nombreDeUsuario)) {
            $linea = isUsed($_nombreDeUsuario);
            if ($linea == -1) {
                $errorNombre = "<span style='color:red'>El nombre no existe</span>";
            } else {
                $nombreUser = $_nombreDeUsuario;
                //---------------------------- PASS --------------------------------
                $_password = htmlspecialchars($_POST["password"]);
                if (!empty($_password)) {
                    if (strcmp($_password, getPassword(recorrer(PATH_TO_BD)[$linea])) == 0) {
                        $registrado = true;
                    } else {
                        $errorPassword = "<span style='color:red'>La contraseña no es correcta</span>";
                    }
                } else {
                    $errorPassword = ERROR_VACIO;
                }
            }
        } else {
            $errorNombre = ERROR_VACIO;
        }
    }


    ?>