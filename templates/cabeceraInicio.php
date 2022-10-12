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
                <a class="nav-link" href="registrarse.php">Inicio</a>
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

    $user = $password = $linea = "";

    $errorUser = $errorPassword = "";

    $registrado = false;


    if (!empty($_POST)) {
        //---------------------------- USER --------------------------------
        $_user = htmlspecialchars($_POST["user"]);
        
//CAmbiar
        if (!empty($_user)) {
            $linea = isUsed($_user);
            if ($linea == -1) {
                $errorUser = "<span style='color:red'>El nombre no existe</span>";
            } else {
                $nombreUser = $_user;
                //---------------------------- PASS --------------------------------
                $_password = htmlspecialchars($_POST["password"]);
                if (!empty($_password)) {
                    if (strcmp($_password, getPassword(recorrer(PATH_TO_BD)[$linea])) == 0){
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