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

/**
 * Funcion para calcular la edad
 * Actualmente esta para que si es menor de edad devuelva false
 * Edad minima 01/01/1900
 * Edad maxima dia actual
 * @param El usuario solamente debe seleccionar una fecha
 */

function calculaedad($fechanacimiento){
    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
      $ano_diferencia--;
    if($ano_diferencia >= 18){
        return true;
    }else{
        return false;
    }
  }


?>