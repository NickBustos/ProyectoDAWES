<?php
include 'config.php';

//--------------------------------- OPERACIONES BBDD --------------------------------

/**
 * Coger valor de una línea de registrados.txt
 * usar constantes LYNE_TYPE
 */
function getDato($type, $linea)
{
    $separatedLine = explode(LINE_SEPARATOR, $linea);
    $dato = $separatedLine[$type];
    if ($type === LINE_FILE) {
        $dato = $separatedLine[$type] . ";" . $separatedLine[$type + 1];
    }
    return $dato;
}

/**
 * Averigua si un usuario se encuentra en registrados.txt
 * @return línea completa en la que se encuentra o comillas vacías si no lo encuentra
 * transmitiendo el mensaje de error correspondiente.
 */
function getLineaFrom($user)
{
    $fp = fopen("admin/datos/registrados.txt", "r");
    while (!feof($fp)) {
        $linea = fgets($fp);
        if (strcmp($user, getDato(LINE_USER, $linea)) == 0) {
            break;
        }
        $linea = "";
    }
    fclose($fp);
    return $linea;
}

/**
 * Guardar usuario en registrados.txt
 * @param [user, md5(pass), mail, fecha, file]
 */
function registerUser($userData)
{
    $fp = fopen("admin/datos/registrados.txt", "a");
    fwrite($fp, "\n");
    fwrite($fp, implode(LINE_SEPARATOR, $userData));
    fclose($fp);
}

//-------------------------------------- OTROS --------------------------------------

/**
 * Recoge imagen de un file
 * @param $_FILES["nombreFile"]
 * @return imagen
 */
function getImage($file)
{
    if (empty($file) == false) {
        return "data:" . $file["type"] . ";base64," .
            base64_encode(file_get_contents($file["tmp_name"]));
    }
}

function getIdioma($nombrePagina)
{
    $pathIdioma = "";
    if (!isset($_COOKIE["lang"])) {
        setcookie("lang", "es", time() + 60 );
        $pathIdioma = "admin/idiomas/es-" . $nombrePagina;
    } else {
        $pathIdioma = "admin/idiomas/" . $_COOKIE["lang"] . "-" . $nombrePagina;
    }
    return $pathIdioma;
}

/**
 * Introduce datos del usuario en sesion
 */
function iniciarSesion($linea)
{
    $_SESSION[SESSION_USER] = getDato(LINE_USER, $linea);
    $_SESSION[SESSION_PASS] = getDato(LINE_PASS, $linea);
    $_SESSION[SESSION_MAIL] = getDato(LINE_MAIL, $linea);
    $_SESSION[SESSION_DATE] = getDato(LINE_DATE, $linea);
    $_SESSION[SESSION_FILE] = getDato(LINE_FILE, $linea);
}

function finalizarSesion($linea)
{
    session_destroy();
}

/** NO HACE FALTA SI SE PONE TEMPLATE
 * Mensaje mostrado al entrar o registrarse
 */
function bienvenido($user, $file)
{
    echo
    "<p class='text-center h4 fw-bold mb-5 mx-1 mx-md-4 mt-4'>
        Bienvenid@ $user
    </p>" .
        "<div class='container text-center main-text'>
        <form action='index.php' method='get'>
            <input type='submit' class='col-md-3 btn btn-primary btn-lg' value='Entrar'>
        </form>
        
        <form action='index.php' method='get'>
            <input type='submit' class='col-md-3 btn btn-secondary btn-lg' value='Salir'>
        </form>
    </div>
    <br/><br/><br/><br/><br/><br/><br/>"
        .
        "
    <div class='col-md-6 card text-black' style='border-radius: 25px;'>
        <img class='contact1-pic' style='margin-left: auto; margin-right: auto;' src='$file'>
    </div>
    ";
    exit();
}
