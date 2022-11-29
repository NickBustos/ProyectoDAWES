<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MumORDad</title>
    <?php
    include "admin/configuraciones/funciones.php";
    include "admin/configuraciones/funcionesDB.php";
    include getIdioma();

    /**
     * Inicia sesión.
     * Si no hay un tema definido en $_SESSION lo crea con el valor "claro".
     * Si el valor del tema es "noche" carga el css correspondiente.
     * 
     */
    session_start();
    $css = "<link rel='stylesheet' href='./css/archivo.css' />";
    if (!isset($_SESSION["modovis"])) {
        $_SESSION["modovis"] = 'light';
    }
    if ($_SESSION["modovis"] == 'dark') {
        $css = '<link rel="stylesheet" type="text/css" href="./css/archivo-oscuro.css">';
    }
    echo $css;
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
                if (isset($_SESSION[SESSION_ID])) {
                    echo selectFromUsuario(["foto"])[0];
                } else {
                    echo "imagenes/nouser.png";
                }
                ?>">
            <div class="contenido-desplegable">
                <?php
                /**
                 * Muestra el mensaje correspondiente para cambiar el tema y el idioma.
                 */
                    if(isset($_SESSION["modovis"]) && $_SESSION["modovis"]==="dark"){
                        echo "<a href='procesos/cambiarTema.php'>" . $lang["modoC"] . "</a>";
                    }else{
                        echo "<a href='procesos/cambiarTema.php'>" . $lang["modoN"] . "</a>";
                    }
                ?>
                <a href="procesos/cambiarIdioma.php"><?php echo $lang["idioma"]; ?></a>
                
                <?php
                /**
                 * Si el usuario ha iniciado sesión muestra la opción de cerrar sesión.
                 */
                if (isset($_SESSION[SESSION_ID])) {
                    echo "<a href='procesos/cerrarsesion.php'> " . $lang['cerrar'] . "</a>";
                }
                ?>

            </div>
        </div>

    </nav>