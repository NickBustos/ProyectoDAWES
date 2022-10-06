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
 $_fechaNacError= "";

//variables para el html
$fechamax = date("Y-m-d");
$fechamin = date("1900-01-01");
$fechaNac = "";



if(!empty($_POST)){
    //Variables para las funciones

$_fechaNac = htmlspecialchars($_POST["fechaNac"]);

if(!empty($_fechaNac)){
    
    include "funciones.php";
    if(calculaedad($_fechaNac)== false){
        echo "Solo se pueden registrar mayores de edad";

    }else{
        echo "fecha valida" ;      
        $fechaNac = $_fechaNac;
        
    } 
       
    }
}



?>
<p><span class = "error">* = campo obligatorio</span></p>
<form action='<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>' method="post">

   <input type = "date" name = "fechaNac" min ="<?= $fechamin;?>"  max="<?=$fechamax;?>" value = "<?php $fechaNac; ?>">
   <br> 
   <input type ="submit" value="enviar formulario">

</form>
</body>
</html>

