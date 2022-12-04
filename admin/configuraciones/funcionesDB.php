<?php

function insertar($tabla, $datos)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "INSERT INTO {$tabla} VALUES (";
    $campos = "";
    for ($i = 0; $i < count($datos); $i++) {
        $sql .= ":{$i}";
        if ($i < count($datos) - 1) {
            $sql .= ", ";
        } else {
            $sql .= ")";
        }
    }
    $preparedSttm = $conexion->prepare($sql);
    foreach ($datos as $key => &$val) {
        $preparedSttm->bindParam(":{$key}", $val);
    }
    $preparedSttm->execute();
    return $conexion->lastInsertId();
}
/**
 * Function existe
 * Le pasamos un usuario, en caso de que lo encuentre, nos devuelve la contraseña
 * En caso de error nos devuelve false.
 * Esta función es llamada en la funcion iniciarSesion y registrarse.
 */
function existe($user)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT password FROM credencial WHERE nombreusuario = '{$user}'";
    $resultado = $conexion->query($sql);
    // return count($resultado->fetchAll(PDO::FETCH_NUM));
    if ($linea = $resultado->fetch(PDO::FETCH_NUM)) {
        return $linea[0];
    }
    return false;
}
/**
 * 1º Si tenemos guardado el ID, los busca en la base de datos.
 * 2º En caso de que no haya iniciado sesion creamos la cookie.
 * 3º Nos devuelve el path, para directamente poner include.getIdioma.
 */
function getIdioma()
{
    $idioma = "es";
    if (isset($_SESSION[SESSION_ID])) {
        $idioma = selectFromUsuario(["idioma"])[0];
    } else if (!isset($_COOKIE["lang"])) {
        setcookie("lang", "es", time() + 60, '/');
    } else if ($_COOKIE["lang"] == "en") {
        $idioma = "en";
    }
    $pathIdioma = "admin/idiomas/" . $idioma . "-idioma.php";
    return $pathIdioma;
}
/**
 * 1º Hemos creado esta funcion para facilitarnos la vida
 * Cada operacion que requiera saber el dateTime llamamos a esta funcion
 * Nos devuelve, Año-mes-dia ; Hora:minutos:segundos:milisegundos.
 */
function getMomentoActual()
{
    $momento = new DateTimeImmutable();
    return $momento->format("Y-m-d H:i:s.u");
}

// [NAME, PASSWORD, FECHA, FOTO(getImage()), EMAIL]
/**
 * Coge los datos que hemos metido en la pagina registro, 
 * Aparte en la sesion o cookie, nos coge el modo vision y el idioma seleccionado.
 * Una vez recogidos todos los datos, primero lo inserta en credencial, 
 * a continuacion lo inserta en la tabla Usuario.
 * Nos devuelve el ID.
 * Una vez recogido, nos inserta un usuario credencial y otro de loguearse.
 */
function subirUsuario($datos)
{

    insertar("credencial", [$datos[0], base64_encode ($datos[1])]);

    // Coger modovis e idioma
    $modovis = "light";
    if (isset($_SESSION["modovis"]) && $_SESSION["modovis"] == "dark") {
        $modovis = "dark";
    }
    $idioma = "es";
    if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] == "en") {
        $idioma = "en";
    }

    // Campos: id, fecha, foto, email, modovis, idioma, rol
    $id = insertar("usuario", ['', $datos[2], $datos[3], $datos[4], $modovis, $idioma, 'usuario']);

    // Coger momento actual
    $momento = getMomentoActual();
    // campos: id_usuario, nombre, accion, fechatime, 
    insertar("usuario_credencial", ['', $id, $datos[0], 'registrar', $momento]);
    insertar("usuario_credencial", ['', $id, $datos[0], 'loguear', $momento]);

    return $id;
}

/**
 * Función para facilitar datos del usuario,
 * como por ejemplo la foto de la cabecera.
 */
function selectFromUsuario($campos)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT ";
    for($i = 0; $i < count($campos); $i++){
        $sql.="{$campos[$i]}";
        if($i < count($campos) -1){
            $sql.=",";
        }
        $sql.=" ";
    }
    $sql.=" FROM usuario WHERE id='" . $_SESSION[SESSION_ID] . "'";
    $resultado = $conexion->query($sql);
    $registro = $resultado->fetch(PDO::FETCH_NUM);
    return $registro;

}


//$where [tabla, igualacion]
/**
 * Función para facilitar datos del campo que sea requerido
 * $campos --> Es una array de las columnas que queremos
 * $tabla --> Nombre de la tabla de la que queremos extraer los datos
 * $where --> Es un array al que le pasamos [nombre de tabla,valor al que se iguala]
 */
function select($campos, $tabla, $where){
    include_once "configDB.php";
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT ";
    for($i = 0; $i < count($campos); $i++){
        $sql.="{$campos[$i]}";
        if($i < count($campos) -1){
            $sql.=",";
        }
        $sql.=" ";
    }
    $sql.=" FROM {$tabla} ";
    if(isset($where)){
        $sql.="WHERE {$where[0]}='{$where[1]}'";
    }
    echo $sql;
    echo "<br/>";
    $resultado = $conexion->query($sql);
    $registros = $resultado->fetchAll(PDO::FETCH_NUM);
    return $registros;
    
}
// include_once "configDB.php";
// subirUsuario(["pepepe", "aaa", "1998-07-01", "aaaa", "aaa@"]);

