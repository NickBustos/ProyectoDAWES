<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MumORDad</title>
    <?php
    session_start();
    include "admin/configuraciones/funciones.php";
    $usuario = null;
    if(isset($_SESSION[SESSION_ID])){
        $usuario = new Usuario($_SESSION[SESSION_ID], $_SESSION[SESSION_USER]);
    }
    include getIdioma($usuario);
    /**
     * Inicia sesión.
     * Si no hay un tema definido en $_SESSION lo crea con el valor "claro".
     * Si el valor del tema es "noche" carga el css correspondiente.
     */
    $css = "<link rel='stylesheet' href='./css/archivo.css' />";
    if ($usuario != null) {
        if ($usuario->modovis === "dark") {
            $css = '<link rel="stylesheet" type="text/css" href="./css/archivo-oscuro.css">';
        }
    } else if (!isset($_SESSION[TEMA])) {
        $_SESSION[TEMA] = TEMA_LIGHT;
    } else if ($_SESSION[TEMA] == TEMA_DARK) {
        $css = '<link rel="stylesheet" type="text/css" href="./css/archivo-oscuro.css">';
    }
    echo $css;
    ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="index.php" class="navbar-brand">
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

            <?php
            if ($usuario != null) {
                echo
                "<li class='nav-item' style='margin: auto;'>
                    <a class='nav-link' href='crear.php'>{$lang['subirBatalla']}</a>
                </li>";
            }
            ?>
        </ul>
        <div class="desplegable">
            <img class="imagenUser" src="
                <?php
                /**
                 * Por defecto muestra la imagen nouser.png
                 * Si esta iniciada la sesión coge la imagen del avatar del usuario.
                 */
                if ($usuario != null) {
                    echo $usuario->foto;
                } else {
                    echo "imagenes/nouser.png";
                }
                ?>">
            <div class="contenido-desplegable">
                <?php
                /**
                 * Si el usuario ha iniciado sesión muestra la opción de entrar a su pagina personal.
                 */
                if ($usuario != null) {
                    echo "<a href='perfil.php'> " . $lang['paginaPersonal'] . "</a>";
                }
                ?>
                <?php
                /**
                 * Muestra el mensaje correspondiente para cambiar el tema y el idioma.
                 */
                $mensaje = "<a href='procesos/cambiarTema.php'>" . $lang["modoN"] . "</a>";
                if ($usuario != null) {
                    if ($usuario->modovis === TEMA_DARK) {
                        $mensaje = "<a href='procesos/cambiarTema.php'>" . $lang["modoC"] . "</a>";
                    }
                } else if (isset($_SESSION["modovis"]) && $_SESSION["modovis"] === "dark") {
                    $mensaje = "<a href='procesos/cambiarTema.php'>" . $lang["modoC"] . "</a>";
                }
                echo $mensaje;
                ?>
                <a href="procesos/cambiarIdioma.php"><?php echo $lang["idioma"]; ?></a>

                <?php
                /**
                 * Si el usuario ha iniciado sesión muestra la opción de cerrar sesión.
                 */
                if ($usuario != null) {
                    echo "<a href='modificarDatos.php'>" . $lang['modificarDatos'] . "</a>";
                    echo "<a href='procesos/cerrarsesion.php'> " . $lang['cerrar'] . "</a>";
                }
                ?>


            </div>
        </div>

    </nav>