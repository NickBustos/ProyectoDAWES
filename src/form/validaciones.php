<?php

function validacion($textoValidar, $dato) {
    
    if ($dato == "nombre") {
        $regex = "/([A-ZÁ-Ú]{1}[-a-zá-ú]+\s?)+/A";
    } elseif ($dato == "curso") {
        $regex = "/([1-2]{1}\º){1}/A";
    } elseif ($dato = "titulo") {
        $regex = "/(DAM|DAW|ASIR)/A";
    } elseif ($dato = "email") {
        $regex = "/(DAM|DAW|ASIR)/A";
    }

    if (empty($textoValidar)) {
        echo "El campo $dato no puede estar vacio\n";
        exit();
    } elseif ( !preg_match($regex, $textoValidar) ) {
        echo "El $dato no tiene un formato correcto\n";
        exit();
    } else {
        return $textoValidar;
    }

}