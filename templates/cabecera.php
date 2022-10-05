<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajo</title>
    <link rel="stylesheet" href="./css/archivo.css"/>
    <link rel="stylesheet" href="./css/style.css"/>
    
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
    $_nombreUsuario="";

    if(!empty($_POST)){
        include 'funcioones.php';
        $_nombreUsuario = htmlspecialchars($_POST["nombreDeUsuario"]); 
    }

    ?>