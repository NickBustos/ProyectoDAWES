<?php
function insertar($tabla, $datos){
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "INSERT INTO {$tabla} VALUES (";
    $campos = "";
    for($i = 0; $i < count($datos); $i++){
        $sql .= ":{$i}";
        $campos .= "s";
        if($i < count($datos) - 1){
            $sql .= ", ";
        }else{
            $sql .= ")";
        }
    }
    $preparedSttm = $conexion->prepare($sql);
    foreach ($datos as $key => &$val) {
        $preparedSttm->bindParam(":{$key}", $val);
    }
    return $preparedSttm->execute();
}

function existe($user){
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT password FROM credencial WHERE nombreusuario = '{$user}'";
    $resultado = $conexion->query($sql);
    // return count($resultado->fetchAll(PDO::FETCH_NUM));
    if($linea = $resultado->fetch(PDO::FETCH_NUM)){
        return $linea[0];
    }
    return false;
}

function getIdioma()
{
    $idioma = "es";
    if(isset($_SESSION["idBBDD"])){
        $conexion = new PDO(DSN, USER, PASSWORD);
        $sql = "SELECT idioma FROM usuario WHERE ID='{$_SESSION["idBBDD"]}'";
        $resultado = $conexion->query($sql);
        $resultado->bindColumn(1, $idioma);
        $resultado->fetch();
    }else if(!isset($_COOKIE["lang"])){
        setcookie("lang", "es", time() + 60 * 60);
    }else if($_COOKIE["lang"]=="en"){
        $idioma = "en";
    }
    $pathIdioma = "admin/idiomas/".$idioma."-idioma.php";
    return $pathIdioma;
}

function subirUsuario($datos){
    // Crear conexión
    $conexion = new PDO(DSN, USER, PASSWORD);
    // Sentencia sql para crear credencial
    $sql = "INSERT INTO credencial VALUES ('{$datos[0]}', '{$datos[1]}')";
    $conexion->exec($sql);
    // Coger modovis e idioma
    $modovis = "light";
    if(isset($_SESSION) && isset($_SESSION["tema"]) && $_SESSION["tema"]=="dark"){
        $modovis = "dark";
    }
    $idioma = "es";
    if(isset($_COOKIE) && isset($_COOKIE["lang"]) && $_COOKIE["lang"]=="en"){
        $idioma = "en";
    }

    $rutaFoto = "imagenes/{$datos[0]}.png}";

    // Sentencia sql para crear usuario
    // Campos: id, fecha, foto, email, modovis, idioma, rol
    $sql = "INSERT INTO usuario VALUES ('', '{$datos[2]}', '{$rutaFoto}', '{$datos[4]}', '{$modovis}', '{$idioma}', 'usuario')";
    $conexion->exec($sql);

    // Coger id del anterior campo insertado
    // $id = $conexion->lastInsertId(); // daría error si hiciera 2 a la vez???

    $sql = "SELECT id FROM usuario WHERE foto = '{$datos[3]}'";
    $resultado = $conexion->query($sql);
    $linea = $resultado->fetch(PDO::FETCH_NUM);
    $id = $linea[0];

    //guardar foto
    move_uploaded_file($datos[3]["tmp_name"], $rutaFoto);

    // Coger momento actual
    $momento = new DateTimeImmutable();
    $momento = $momento->format("Y-m-d H:i:s.u");
    // Sentencia sql para crear usuario_credencial
    // campos: id_usuario, nombre, accion, fechatime, 
    $sql = "INSERT INTO usuario_credencial VALUES ('', '{$id}', '{$datos[0]}', 'registrar', '{$momento}')";
    $conexion->exec($sql);
    $sql = "INSERT INTO usuario_credencial VALUES ('', '{$id}', '{$datos[0]}', 'loguear', '{$momento}')";
    $conexion->exec($sql);

    //GUARDAR ID EN SESIÓN
}
?>