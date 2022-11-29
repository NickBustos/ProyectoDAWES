<?php
// Constante para guardar el ID del usuario en la sesión, cuando inicia sesión, porque facilita mucho los select
define("SESSION_ID", "id");
//Para cualquier tabla, lo único que tenemos que insertar los datos como un array
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
        $conexion = new PDO(DSN, USER, PASSWORD);
        $sql = "SELECT idioma FROM usuario WHERE ID='{$_SESSION["idBBDD"]}'";
        $resultado = $conexion->query($sql);
        $resultado->bindColumn(1, $idioma);
        $resultado->fetch();
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
    // Crear conexión
    $conexion = new PDO(DSN, USER, PASSWORD);
    // Sentencia sql para crear credencial
    $sql = "INSERT INTO credencial VALUES ('{$datos[0]}', '" . md5($datos[1]) . "')";
    $conexion->exec($sql);
    // Coger modovis e idioma
    $modovis = "light";
    if (isset($_SESSION["modovis"]) && $_SESSION["modovis"] == "dark") {
        $modovis = "dark";
    }
    $idioma = "es";
    if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] == "en") {
        $idioma = "en";
    }

    // Sentencia sql para crear usuario
    // Campos: id, fecha, foto, email, modovis, idioma, rol
    $sql = "INSERT INTO usuario VALUES ('', '{$datos[2]}', '{$datos[3]}', '{$datos[4]}', '{$modovis}', '{$idioma}', 'usuario')";
    $conexion->exec($sql);

    // Coger id del anterior campo insertado
    $id = $conexion->lastInsertId(); // daría error si hiciera 2 a la vez???
    // $sql = "SELECT id FROM usuario WHERE foto = '{$datos[3]}'";
    // $resultado = $conexion->query($sql);
    // $linea = $resultado->fetch(PDO::FETCH_NUM);
    // $id = $linea[0];

    // Coger momento actual
    $momento = getMomentoActual();
    // Sentencia sql para crear usuario_credencial
    // campos: id_usuario, nombre, accion, fechatime, 
    $sql = "INSERT INTO usuario_credencial VALUES ('', '{$id}', '{$datos[0]}', 'registrar', '{$momento}')";
    $conexion->exec($sql);
    $sql = "INSERT INTO usuario_credencial VALUES ('', '{$id}', '{$datos[0]}', 'loguear', '{$momento}')";
    $conexion->exec($sql);

    return $id;
    // GUARDAR ID EN SESIÓN
    // $_SESSION["id"]=$id;

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
