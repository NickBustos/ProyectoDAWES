<?php
//contendrá tanto el formulario de registro como la lógica 
//de negocio asociada a la validación del formulario.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registro</title>
    <style>
 .error { 
            color: #FF0000;
        }
    </style>
</head>
<body>
<?php
//Variables de error
$_nombreApellidoError = $_passError = $_mailError = $_fechaNacError= $_avatarError = "";

//variables para el html
$nombreApellido = $pass = $email = $fechaNac = "";


//patrones
$patronNombre ="/[A-Z a-z 0-9]{5,10}/A"; //El nombre de usuaruio es comprendido entre 5 y 10 caracteres y puede ser mayusculas, minusculas y numeros (orden indiferente)
$patronPass = "/(^[A-Za-z\d$@$!%*?&]{8,15}$)/A";//Culquiera de esos caracteres minimo 8 maximo 15
$patronmail = "/([a-z0-9 A-Z _\.-]+)@([gmail | hotmail]{1})\.([a-z]{3})/A";//uno o mas caracteres, entre m,M,numeros y simbolos, luego el @ y luego gmail o hotmail y una extesnion . de tres


if(!empty($_POST)){

    //Variables para las funciones
require "funciones.php";
$_nombreApellido = htmlspecialchars($_POST["usuario"]);
$_pass = htmlspecialchars($_POST["pass"]);
$_mail = htmlspecialchars($_POST["email"]);
$_fechaNac = htmlspecialchars($_POST["fechaNac"]);


if(!empty($_nombreApellido)){
    if(validarRegistro($nombreApellido, $patronNombre) == false){
        $_nombreApellidoError ="No has introducido un nombre válido";
    }else{
        $nombreApellido = $_nombreApellido;
    }
}
if(!empty($_pass)){
    if(validarRegistro($_pass,$patronPass) == false){
        $_passError = "No has puesto una contraseña valida";
    }else{
        $pass = $_pass;
    }
}
if(!empty($_email)){
    if(validarRegistro($_mail,$patronmail) == false){
        $_mailError = "No has introducido un email valido";
    }else{
        $email = $_mail;
    }
}
if(!empty($_fechaNac)){
    if(validarEdad($_fechaNac) == false){
        $_fechaNacError ="no has introducido una fecha de nacimiento valida";
    }else{
        $fechaNac = $_fechaNac;
    }
}
if($nombreApellido!= "" && $pass != "" && $email != ""){
    echo "registrado el usuario $_nombreApellido, con contraseña $_pass, con email $_mail";
    exit();
}
}

?>
    <p><span class = "error">* = campo obligatorio</span></p>
    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>' method="post">

    Nombre de Usuario:
    <input type = "text" name ="usuario" value = "<?php $nombreApellido; ?>">
    <span class = "error">*<?php echo $_nombreApellidoError; ?></span><br>
    Conraseña:
    <input type = "password" name = "pass" value = "<?php $pass; ?>">
    <span class = "error">*<?php echo $_passError; ?></span><br>
    Email:
    <input type = "text" name = "email" value = "<?php $email; ?>">
    <span class = "error">*<?php echo $_mailError; ?></span><br>
    Fecha Nacimiento:
    <input type = "date" name = "fechaNac" value = "<?php $fechaNac; ?>">
    <span class = "error">*<?php echo $_fechaNacError; ?></span><br>
    <form action="procesarFicheros.php" method="post" enctype="multipart/form-data">
    Seleccionar fichero: <br>
    <input type = "file" multiple accept="image/.jpg image/.png" id="avatar" name ="imagenAvatar"><br>
    </form>
    <br>
    <br>

    <input type ="submit" value="enviar formulario">

</form>
</body>
</html>
