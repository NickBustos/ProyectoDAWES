<?php

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