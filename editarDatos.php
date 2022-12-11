<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include_once "admin/configuraciones/funcionesDB.php";
    include_once "admin/configuraciones/funciones.php";
    session_start();
    $datosUsuario = selectFromUsuario(['id','fechanacimiento','foto','email']);
    $fecha = explode("-",$datosUsuario[1]);
    $nombre = $_SESSION[SESSION_USER];
    $contraseña = existe($nombre);
    $contraseñaMostrar = base64_decode($contraseña);
    
    // if(si damos al boton hacer el update){}
    // Para encriptar la contraseña --> base64_encode ($constraseñaMostrar)
/**
 * Funcion Actualizar
 */




function actualizar($tabla, $datos)
{
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "UPDATE {$tabla} SET (";
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

function actualizarDatos($datos)
{

    actualizar("credencial", [$datos[0], base64_encode ($datos[1])]);

    // Campos: id, fecha, foto, email, modovis, idioma, rol
    $id = actualizar("usuario", ['', $datos[2], $datos[3], $datos[4], $modovis, $idioma, 'usuario']);

    // Coger momento actual
    $momento = getMomentoActual();
    // campos: id_usuario, nombre, accion, fechatime, 
    actualizar("usuario_credencial", ['', $id, $datos[0], 'actualizar', $momento]);

    return $id;
}
?>

<form action="">
    Nombre Usuario:
    <input type = "text" value="<?php echo $nombre ?> "/><br>
    Contraseña:
    <input type = "text" value="<?php echo $contraseñaMostrar ?> "/><br>
    Fecha Nacimiento:
    <input type = "text" value="<?php echo $datosUsuario[1] ?> "/><br>
    Email:
    <input type = "text" value="<?php echo $datosUsuario[3] ?>  "/><br>
    Foto:
    <img src = "<?php echo $datosUsuario[2] ?> "/><br> 
    <br><br>
    
    <?php echo "<button id = 'desbloquear'>Editar Campos</button>" ?>
</form>
</body>
</html>
