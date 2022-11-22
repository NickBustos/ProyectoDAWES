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
    include "admin/configuraciones/funcionesDB.php";
    include getIdioma("cabecera.php");

    /**
     * Inicia sesión.
     * Si no hay un tema definido en $_SESSION lo crea con el valor "claro".
     * Si el valor del tema es "noche" carga el css correspondiente.
     * 
     */
    session_start();
    if (!isset($_SESSION['tema'])) {
        $_SESSION[SESSION_TEMA] = 'claro';
    }
    if ($_SESSION[SESSION_TEMA] == 'noche') {
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
                /**
                 * Por defecto muestra la imagen nouser.png
                 * Si esta iniciada la sesión coge la imagen del avatar del usuario.
                 */
                if (isset($_SESSION) && isset($_SESSION[SESSION_USER])) {
                    echo $_SESSION[SESSION_FILE];
                } else {
                    echo "imagenes/nouser.png";
                }
                ?>">
            <div class="contenido-desplegable">
                <?php
                /**
                 * Muestra el mensaje correspondiente para cambiar el tema y el idioma.
                 */
                    if(isset($_SESSION) && isset($_SESSION[SESSION_TEMA]) && $_SESSION[SESSION_TEMA]==="noche"){
                        echo "<a href='cambiarTema.php'>" . $lang["modoC"] . "</a>";
                    }else{
                        echo "<a href='cambiarTema.php'>" . $lang["modoN"] . "</a>";
                    }
                ?>
                <a href="cambiarIdioma.php"><?php echo $lang["idioma"]; ?></a>
                
                <?php
                /**
                 * Si el usuario ha iniciado sesión muestra la opción de cerrar sesión.
                 */
                if (isset($_SESSION) && isset($_SESSION[SESSION_USER])) {
                    echo "<a href='cerrarsesion.php'> " . $lang['cerrar'] . "</a>";
                }
                ?>

            </div>
        </div>

    </nav>