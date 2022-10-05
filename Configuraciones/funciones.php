<?php
include 'config.php';

//************************************************* */

//Validar Nombre del usuario
function validar($datoAValidar, $expresionRegular) {


if (preg_match($expresionRegular, $datoAValidar))   {
    $valida = true; // lo mismo que hacer "return true;"
} else {
    $valida = false;
}

return $valida;
}


//************************************************* */



function validarRegistro($campo,$patron){
    if(preg_match($campo,$patron)){
        return true;
    }
    return false;
}


function validarEdad($fecha){
    $hoy = new DateTime();
    if($hoy -> diff($fecha) > 18){
        return true;
    }else{
        return false;
    }
}

?>