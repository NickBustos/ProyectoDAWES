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
        $_user = htmlspecialchars($_POST["user"]);
        $_password = htmlspecialchars($_POST["password"]);
        login($_user, $_password, $errorUser, $errorPassword);
        if(empty($errorUser)){
            $user = $_user;
            if(empty($errorPassword)){
                $registrado = true;
            }
        }
            
            
    }


    ?>