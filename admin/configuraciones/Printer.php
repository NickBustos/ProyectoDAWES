<?php
require "Elemento.php";
class Printer{
    public static function imprimir(){
        
    }

    public static function print($objeto){
        switch(get_class($objeto)){
            case "Elemento":
                
                break;
        }
    }

    public function __get($var) {
		if (property_exists(__CLASS__, $var)) { 
			 return $this->$var; 
		}
	} 
}
$e = new Elemento(3, new BD(true));
Printer::print($e);

