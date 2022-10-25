<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MumORDad</title>
    <link rel="stylesheet" href="./css/archivo.css" />
    <?php
    include "admin/configuraciones/funciones.php";
    include getIdioma("cabecera.php");
    ?>
</head>

<body>
    <?php
    if (!isset($_SESSION)) {
        session_start();
        $_SESSION['id'] = array(
            'tema' => 'claro'
        );
        if ($_SESSION['id']['tema'] == 'noche') {
            echo '<link rel="stylesheet" type="text/css" href="./css/archivo-oscuro.css">';
        }
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <ul class="nav navbar-nav">
            <li>
                <a href="#" class="navbar-brand">
                    <img src="imagenes/logo.png" alt="Logo">
                </a>
            </li>
            <li class="nav-item active " style="margin: auto;">
                <a class="nav-link" href="index.php"><?php echo $lang["inicio"]; ?></a>
            </li>

            <li class="nav-item" style="margin: auto;">
                <a class="nav-link" href="acercade.php"><?php echo $lang["about"]; ?></a>
            </li>

            <li class="nav-item" style="margin: auto;">
                <a class="nav-link" href="contacto.php"><?php echo $lang["contacto"]; ?></a>
            </li>
        </ul>
        <div class="desplegable">
            <img class="imagenUser" src="
                <?php
                $imagen = "imagenes/nouser.png";
                if (isset($_SESSION) && isset($_SESSION[SESSION_USER])) {
                    $imagen = $_SESSION[SESSION_FILE];
                }
                echo $imagen;
                ?>">
            <div class="contenido-desplegable">
                <a href="index.html"><?php echo $lang["inicio"]; ?></a>
                <a href=""><?php echo $lang["modo"]; ?></a>
                <a href="cambiaridioma.php"><?php echo $lang["idioma"]; ?></a>
                <a href="cerrarsesion.php"><?php echo $lang["cerrar"]; ?></a>
            </div>
        </div>
    </nav>