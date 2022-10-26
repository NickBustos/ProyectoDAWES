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


    session_start();

    if (!isset($_SESSION['tema'])) {
        $_SESSION["tema"] = 'claro';
    }

    if ($_SESSION['tema'] == 'noche') {
        echo '<link rel="stylesheet" type="text/css" href="./css/archivo-oscuro.css">';
    }
    ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="#" class="navbar-brand">
            <img src="imagenes/logo.png" alt="Logo">
        </a>
        <ul class="nav navbar-nav">
            
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
                if (isset($_SESSION) && isset($_SESSION[SESSION_USER])) {
                    echo $_SESSION[SESSION_FILE];
                } else {
                    echo "imagenes/nouser.png";
                }
                //echo $imagen;
                ?>">
            <div class="contenido-desplegable">
                <a href="cambiarTema.php"><?php echo $lang["modo"]; ?></a>
                <a href="cambiarIdioma.php"><?php echo $lang["idioma"]; ?></a>
                <?php
                if (isset($_SESSION) && isset($_SESSION[SESSION_USER])) {
                    echo "<a href='cerrarsesion.php'> " . $lang['cerrar'] . "</a>";
                }
                ?>

            </div>
        </div>

    </nav>