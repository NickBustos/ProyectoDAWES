<?php
define("SESSION_ID", "id");

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

function getIdioma()
{
    $idioma = "es";
    if (isset($_SESSION["idBBDD"])) {
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

function getMomentoActual()
{
    $momento = new DateTimeImmutable();
    return $momento->format("Y-m-d H:i:s.u");
}

// [NAME, PASSWORD, FECHA, FOTO(getImage()), EMAIL]
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

function selectFromUsuario($campo)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT {$campo} FROM usuario WHERE id='" . $_SESSION[SESSION_ID] . "'";
    return $conexion->query($sql)->fetch(PDO::FETCH_NUM)[0];
}

// subirUsuario(["Mario", "aaa", "1998-07-01", "wa.png", "mariomh@alumnos.iesgalileo.com"]);
