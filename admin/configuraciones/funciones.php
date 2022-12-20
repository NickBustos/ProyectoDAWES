<?php
include 'config.php';
include 'configDB.php';

//------------------------------------- FECHAS --------------------------------------
/**
 * Cada operacion que requiera saber el dateTime llamamos a esta funcion
 * Nos devuelve un string con formato: Año-mes-dia ; Hora:minutos:segundos:milisegundos.
 */
function getMomentoActual()
{
    $momento = new DateTimeImmutable();
    return $momento->format("Y-m-d H:i:s.u");
}

//---------------------------------- VALIDACIONES -----------------------------------
/**
 * Verifica si han pasado 18 años desde fecha
 */
function validarMayorEdad($fechanacimiento)
{
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    if ($ano_diferencia >= 18) {
        return true;
    } else {
        return false;
    }
}

//------------------------------------- FILES --------------------------------------
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

//------------------------------ OPERACIONES SESION -------------------------------
/**
 * Elimina todos los datos de la sesión
 * excepto el id del usuario y su nombre
 */
function quitarDatosBatalla()
{
    foreach ($_SESSION as $key => $value) {
        if ($key != SESSION_ID && $key != SESSION_USER) {
            unset($_SESSION[$key]);
        }
    }
}

//------------------------------ OPERACIONES CON BBDD ------------------------------

//--------------------------------- BBDD GENERALES ---------------------------------

/**
 * Inserta una tupla en una tabla.
 * $datos = array con todos los campos de la tabla
 */
function insertar($tabla, $datos)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "INSERT INTO {$tabla} VALUES (";
    for ($i = 0; $i < count($datos); $i++) {
        $sql .= ":{$i}";
        if ($i < count($datos) - 1) {
            $sql .= ", ";
        } else {
            $sql .= ")";
        }
    }
    echo $sql;
    $preparedSttm = $conexion->prepare($sql);
    foreach ($datos as $key => &$val) {
        $preparedSttm->bindParam(":{$key}", $val);
    }
    $preparedSttm->execute();
    return $conexion->lastInsertId();
}

/**
 * Select sencillo (con un where o ninguno) a la base de datos
 * $campos = Array de las columnas que queremos
 * $tabla = Nombre de la tabla de la que queremos extraer los datos
 * $where = Array al que le pasamos [nombre de tabla, valor al que se iguala]
 * return array de registros (arrays de columnas)
 */
function select($campos, $tabla, $where)
{
    include_once "configDB.php";
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT ";
    for ($i = 0; $i < count($campos); $i++) {
        $sql .= "{$campos[$i]}";
        if ($i < count($campos) - 1) {
            $sql .= ",";
        }
        $sql .= " ";
    }
    $sql .= " FROM {$tabla} ";
    if (count($where) > 0) {
        $sql .= "WHERE {$where[0]}='{$where[1]}'";
    }
    $resultado = $conexion->query($sql);
    $registros = $resultado->fetchAll(PDO::FETCH_NUM);
    return $registros;
}

/**
 * Ejecuta como consulta preparada un sql y unos datos en array
 * (Usada en procesar voto)
 */
function realizarSql($conexion, $sql, $datos)
{
    $preparedSttm = $conexion->prepare($sql);
    $preparedSttm->execute($datos);
}

/**
 * 
 */
function update($tabla, $setTablas, $setValores, $whereColumna, $whereValor)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "UPDATE {$tabla} SET";
    for ($i = 0; $i < count($setTablas); $i++) {
        $sql .= " {$setTablas[$i]}=?";
        if ($i < count($setTablas) - 1) {
            $sql .= ",";
        }
        $sql .= " WHERE {$whereColumna}='{$whereValor}'";
    }
    // echo $sql . "<br/>";
    // $sql = "UPDATE {$tabla} SET {$setTabla}=? WHERE $whereTabla={$whereValor}";
    $conexion->prepare($sql)->execute($setValores);
}

function delete($tabla, $columna, $dato)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "DELETE FROM {$tabla} WHERE {$columna} = ? ";
    $conexion->prepare($sql)->execute([$dato]);
}

//---------------------------------- BBDD USUARIO ---------------------------------

/**
 * Función para facilitar datos del usuario,
 * como por ejemplo la foto de la cabecera.
 */
function selectFromUsuario($campos)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT ";
    for ($i = 0; $i < count($campos); $i++) {
        $sql .= "{$campos[$i]}";
        if ($i < count($campos) - 1) {
            $sql .= ",";
        }
        $sql .= " ";
    }
    $sql .= " FROM usuario WHERE id='" . $_SESSION[SESSION_ID] . "'";
    $resultado = $conexion->query($sql);
    $registro = $resultado->fetch(PDO::FETCH_NUM);
    return $registro;
}

/**
 * $user = nombre usuario que queremos ver si está usado
 * En caso de que lo encuentre, nos devuelve la contraseña
 * En caso de error nos devuelve false.
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
 * Crear un usuario en la base de datos con unos datos pasados y el modo y el idioma en uso actual cogido.
 * Inserta en credencial, en la tabla Usuario y después dos veces en usuario credencial (loguearse y entrar)
 * $datos = [NAME, PASSWORD, FECHA, FOTO(getImage()), EMAIL]
 * @return ID generado para el usuario.
 */
function subirUsuario($datos)
{

    insertar("credencial", [$datos[0], md5($datos[1])]);
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
    $id = insertar("usuario", ['', $datos[2], $datos[3], $datos[4], $modovis, $idioma, 'usuario', '0', '0', '0', '0', '0', '0']);

    $momento = getMomentoActual();
    // campos: id_usuario, nombre, accion, fechatime, 
    insertar("usuario_credencial", ['', $id, $datos[0], 'registrar', $momento]);
    insertar("usuario_credencial", ['', $id, $datos[0], 'loguear', $momento]);
    return $id;
}

/**
 * Actualizar campo de usuarios (numero_batallas_creadas, numero_denuncias...)
 * $campo = columna
 * $actualizacion = nuevo valor de columna
 * $id = id de usuario
 */
function actualizarUsuario($campo, $actualizacion, $id)
{
    update("usuario", [$campo], [$actualizacion], "id", $id);
}

//------------------------------- IDIOMA / TEMA ---------------------------------

/**
 * 1º Si tenemos guardado el ID, los busca en la base de datos.
 * 2º En caso de que no haya iniciado sesion creamos la cookie.
 * 3º Nos devuelve el path, para directamente poner include getIdioma().
 */
function getIdioma()
{
    $idioma = LANG_SPANISH;
    if (isset($_SESSION[SESSION_ID])) {
        $idioma = selectFromUsuario(["idioma"])[0];
    } else if (!isset($_COOKIE[LANG])) {
        setcookie(LANG, LANG_SPANISH, time() + 60 * 60, '/');
    } else if ($_COOKIE[LANG] == LANG_ENGLISH) {
        $idioma = LANG_ENGLISH;
    }
    $pathIdioma = "admin/idiomas/" . $idioma . "-idioma.php";
    return $pathIdioma;
}

/**
 * Funcion que devuelve el idioma contrario al introducido
 * Ingles => español y viceversa.
 */
function getIdiomaContrario($idioma)
{
    $nuevoIdioma = LANG_SPANISH;
    if ($idioma == LANG_SPANISH) {
        $nuevoIdioma = LANG_ENGLISH;
    }
    return $nuevoIdioma;
}

/**
 * Funcion que devuelve el tema contrario al introducido
 * Light => dark y viceversa.
 */
function getTemaContrario($tema)
{
    $nuevoTema = TEMA_LIGHT;
    if ($tema == TEMA_LIGHT) {
        $nuevoTema = TEMA_DARK;
    }
    return $nuevoTema;
}





//---PREGUNTAR



/**
 * Devuelve las imagenes de todos elementos creados o no, utilizados para crear batallas.
 * Para ello solo se necesita pasar un id de usuario para que la query se encargue 
 * de realizar la busqueda.
 */
function imagenBatalla($idUsuario)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $query = 'SELECT foto FROM elemento WHERE id = ANY (SELECT id_elemento1 FROM batalla_elemento WHERE id_batalla = ANY (SELECT id_batalla FROM usuario_batalla WHERE id_usuario = ' . $idUsuario . ' AND accion LIKE ("crear")) UNION ALL SELECT id_elemento2 FROM batalla_elemento WHERE id_batalla = ANY (SELECT id_batalla FROM usuario_batalla WHERE id_usuario = ' . $idUsuario . ' AND accion LIKE ("crear")));';
    $resultado = $conexion->query($query);
    $registro = $resultado->fetchAll(PDO::FETCH_COLUMN);
    return $registro;
}




