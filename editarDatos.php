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
    include_once "funcionesDB.php";

    $datosUsuario = selectFromUsuario('id','fechanacimiento','foto','email');
    $id = explode(",",$datosUsuario[0]); 
    $fecha = explode(",",$datosUsuario[1]);
    $foto = explode(",",$datosUsuario[2]);
    $email = explode(",",$datosUsuario[3]);
    
    $contraseña =getPassword();
    $nombre = $_SESSION[SESSION_USER];

?>

<form action="">
    Nombre Usuario:
    <input type = "text" value="<?php $nombre ?>"/>
    Contraseña:
    <input type = "text" value="<?php $contraseña ?>"/>
    Fecha Nacimiento:
    <input type = "text" value="<?php $fecha ?>"/>
    Email:
    <input type = "text" value="<?php $email ?>"/>
    Foto:
    <img src = "<?php $foto ?>"/>
    
</form>
</body>
</html>