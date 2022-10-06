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
      echo $ano_diferencia;
    if($ano_diferencia >= 18){
        return true;
    }else{
        return false;
    }
  }


/**
 * Recoge imagen de un file
 * @param $_FILES["nombreFile"]
 * @return imagen
 */
function getImage($file){
    if(empty($file) == false){
        return "data:" . $file["type"] . ";base64," . 
        base64_encode(file_get_contents($file["tmp_name"]));
    }
}

/**
 * Cuenta numero de imagenes.png en carpeta files
 */
function getNumberOfLogo(){
    return count(glob(PATH_TO_IMAGENES . '{*.png}', GLOB_BRACE));
}

/**
 * Guardar imagen en carpeta files
 */
function saveImage($file){
    if(empty($file) == false){
        if(is_uploaded_file($file["tmp_name"])){
            //CREAR CAMINO
            $finalpath= PATH_TO_IMAGENES . getNumberOfLogo() . ".png";//se puede cambiar y sitio
            return (move_uploaded_file($file["tmp_name"], $finalpath));
            //GUARDAR
        }
    }
}

/**
 * Recorrer un file un txt
 * @param path con nombre del archivo
 */
function recorrer($txt=PATH_TO_BD){
    $contadorlinea=0;
    $lineas=[];
    $fichero = fopen($txt, "r");
    while(!feof($fichero)){
        $linea = "";
        $linea = fgets($fichero);
        $lineas[$contadorlinea++]=$linea;   
    }
    return $lineas;
}

/**
 * Coger usuario de una línea de recorrer
 */
function getUser($linea){
    return explode(';', $linea)[0];
}

/**
 * Coger password de una línea de recorrer
 */
function getPassword($linea){
    return explode(';', $linea)[1];
}

/**
 * Averigua si un nombre de usuario esta usado en file bbdd
 */
function isUsed($user){
    $lineas = recorrer(PATH_TO_BD);
    
    for($linea = 0; $linea < sizeof($lineas); $linea++){
        if($user == getUser($lineas[$linea])){
            return true;//1
        }
    }
    return false;//0
}

/**
 * Verifica que un usuario y contraseña se encuentran en file bbdd
 */
function login($user, $password) {
    $lineas = recorrer(PATH_TO_BD);
    for($linea = 0; $linea < sizeof($lineas); $linea++){
        if($user == getUser($lineas[$linea])
            && $password == getPassword($lineas[$linea])){
            return true;//1
            //se puede cambiar
        }
    }
    return false;//0
}

function validacion($textoValidar, $dato) {
    
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

?>