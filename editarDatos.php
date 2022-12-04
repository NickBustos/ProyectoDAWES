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
    
?>

<form action="">
    Nombre Usuario:
    <input type = "text" value="<?php echo $nombre ?> "disabled/><br>
    Contraseña:
    <input type = "text" value="<?php echo $contraseñaMostrar ?> "disabled/><br>
    Fecha Nacimiento:
    <input type = "text" value="<?php echo $datosUsuario[1] ?> "disabled/><br>
    Email:
    <input type = "text" value="<?php echo $datosUsuario[3] ?>  "disabled/><br>
    Foto:
    <img src = "<?php echo $datosUsuario[2] ?> "disabled/><br> 
    <br><br>
    
    <?php echo "<button id = 'desbloquear'>Editar Campos</button>" ?>
</form>
</body>
</html>
