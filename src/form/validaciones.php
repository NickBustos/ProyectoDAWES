<?php

namespace Nickbustos\Proyectodawes\form;

class Validaciones {

    static function validacion($textoValidar, $dato) {
    
        if($dato = "email") {
            if (filter_var($textoValidar, FILTER_VALIDATE_EMAIL)){
                return $textoValidar;
            } else {
                return false;
            }
        }
    
    }

}
