<?php
    $lineas = recorrer();
    echo sizeof($lineas);
    var_dump($lineas);
    echo "<br/>";
    echo getUser($lineas[1]);
    echo "<br/>";
    echo "mario esta en uso: " . isUsed("mario");
    echo "<br/>";
    echo "mario/123: " . login("mario", "123");
    

    function recorrer(){
        $contadorlinea=0;
        $lineas=[];
        $fichero = fopen("usuarios.txt", "r");
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
        $lineas = recorrer();
        
        for($linea = 0; $linea < sizeof($lineas); $linea++){
            if($user == getUser($lineas[$linea])){
                return true;//1
            }
        }
        return false;//0
    }

    function login($user, $password) {
        $lineas = recorrer();
        for($linea = 0; $linea < sizeof($lineas); $linea++){
            if($user == getUser($lineas[$linea])
                && $password == getPassword($lineas[$linea])){
                return true;//1
            }
        }
        return false;//0
    }



?>