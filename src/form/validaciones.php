<?php

namespace src\controller\form\Validaciones;

class Validaciones {

    static function validacion($textoValidar, $dato) {
    
        if($dato = "email") {
            if (filter_var($textoValidar, FILTER_VALIDATE_EMAIL)){
                echo $textoValidar;
                return $textoValidar;
            } else {
                echo "error";
                return false;
            }
        }
    
    }

}
