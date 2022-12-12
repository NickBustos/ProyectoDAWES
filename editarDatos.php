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
    
?>

<form class="mx-1 mx-md-4" action='<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>' method="post">
    Nombre Usuario:
    <input type = "text" name = "user" value="<?php echo $nombre ?> "/><br>
    Contraseña:
    <input type = "text" name = "password1" value="<?php echo $contraseña1 ?> "/><br>
    Fecha Nacimiento:
    <input type = "text" name = "fechaNac" value="<?php echo $datosUsuario[1] ?> "/><br>
    Email:
    <input type = "text" value="<?php echo $datosUsuario[3] ?>  "name = "email" /><br>
    Foto:
    <img src = "<?php echo $datosUsuario[2] ?> " name = "img"/><br> 
    <br><br>
    
    <?php echo "<button id = 'desbloquear'>Editar Campos</button>" ?>

    <?php
    if (!empty($_POST)) {
        //---------------------------- USER --------------------------------
        $_user = htmlspecialchars($_POST["user"]);
        if (!empty($_user)) {
            if($_user != $nombre){
                $nombre = $_user;
            if (preg_match(PATTERN_USER, $_user)) {
                if (!preg_match(PATTERN_CHARACTER_SEPARATOR, $_user)) {
                    if (existe($_user) === false) {
                        $user = $_user;
                    } else {
                        $errorUser = $lang["error_user_used"];
                    }
                } else {
                    $errorUser = $lang["error_character_separator"];
                }
            } else {
                $errorUser = $lang["error_user_pattern"];
            }
        } else {
           $nombre; // Si el nombre no ha cambiado
        }
        } else {
            $errorUser = $lang["error_vacio"];
        }

            //---------------------------- PASS --------------------------------
        $_pass1 = htmlspecialchars($_POST["password1"]);
        // $_pass2 = htmlspecialchars($_POST["password2"]);
        if (!empty($_pass1)) {
            if($_pass1 != $contraseña1){
            if (
                preg_match(PATTERN_PASS_MINUS, $_pass1) && preg_match(PATTERN_PASS_MAYUS, $_pass1)
                && preg_match(PATTERN_PASS_NUMBER, $_pass1) && strlen($_pass1) <= MAX_PASS_LENGTH
                && strlen($_pass1) >= MIN_PASS_LENGTH
            ) {
            } else {
                $errorPass = $lang["error_pass_pattern"];
            }
    } else {
        $contraseña1 = $_pass1;
    }
        } else {
            $errorPass = $lang["error_vacio"];
        }


        $_fechaNac = htmlspecialchars($_POST["fechaNac"]);
        if (!empty($_fechaNac)) {
            if($datosUsuario[1]!=$_fechaNac){
            if (validarMayorEdad($_fechaNac)) {
                $fechaNac = $_fechaNac;
            } else {
                $errorFecha = $lang["error_date_year"];
            }
        }else{
            $datosUsuario[1] = $fechaNac;
        }
        } else {
            $errorFecha = $lang["error_vacio"];
        }
        

    ?>
        </form>
</body>
</html>
