<?php
    //echo getNumberOfLogo();
    // $lineas = recorrer("bbdd.txt");
    // echo sizeof($lineas);
    // echo "<br/>";
    // var_dump(getPassword($lineas[0]));
    // echo "<br/>";
    // var_dump($lineas);
    // echo "<br/>";
    // echo getUser($lineas[1]);
    // echo "<br/>";
    // echo "mario esta en uso: " . isUsed("mario");
    // echo "<br/>";
    // echo "mario/123: " . login("mario", "123");

    define("PATH_TO_IMAGES", '../files/');
    
    function getImage($file){
        if(empty($file) == false){
            return "data:" . $file["type"] . ";base64," . 
            base64_encode(file_get_contents($file["tmp_name"]));
        }
    }

    function getNumberOfLogo(){
        return count(glob(PATH_TO_IMAGES . '{*.png}', GLOB_BRACE));
    }

    function saveImage($file){
        if(empty($file) == false){
            if(is_uploaded_file($file["tmp_name"])){
                //CREAR CAMINO
                $finalpath= PATH_TO_IMAGES . getNumberOfLogo() . ".png";//se puede cambiar y sitio
                return (move_uploaded_file($file["tmp_name"], $finalpath));
                //GUARDAR
            }
        }
    }

    function recorrer($txt){
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

    function getUser($linea){
        return explode(';', $linea)[0];
    }

    function getPassword($linea){
        return explode(';', $linea)[1];
    }

    function isUsed($user){
        $lineas = recorrer("bbdd.txt");
        
        for($linea = 0; $linea < sizeof($lineas); $linea++){
            if($user == getUser($lineas[$linea])){
                return true;//1
            }
        }
        return false;//0
    }

    function login($user, $password) {
        $lineas = recorrer("bbdd.txt");
        for($linea = 0; $linea < sizeof($lineas); $linea++){
            if($user == getUser($lineas[$linea])
                && $password == getPassword($lineas[$linea])){
                return true;//1
                //se puede cambiar
            }
        }
        return false;//0
    }



?>