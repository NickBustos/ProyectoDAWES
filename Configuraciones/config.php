<?php
define("PATRON_USER", "/([A-ZÁ-Ú]{1}[-a-zá-ú]+\s?)+/A");
define("PATRON_PASS", "/(^[A-Za-z\d$@$!%*?&_]{8,15}$)/A");//Culquiera de esos caracteres minimo 8 maximo 15
define("PATH_TO_IMAGENES", 'multimedia/imagenes/');
define("PATH_TO_BD", "multimedia/bbdd.txt");

define("DATE_TODAY", date("Y-m-d"));
define("DATE_FIRST", date("1900-01-01"));

//FORMATO ERRORES
define("ERROR_IN", "<span style='color:red'>");
define("ERROR_OUT", "</span>");

//VACIO
define("ERROR_VACIO", ERROR_IN . "El campo no puede estar vacio" . ERROR_OUT);
//PASSWORD
define("PATRON_PASS_MINUS", '@[a-z]@');
define("PATRON_PASS_MAYUS", '@[A-Z]@');
define("PATRON_PASS_NUMBER", '@[0-9]@');
define("MIN_PASS_LENGTH", 8);
define("MAX_PASS_LENGTH", 16);
define("ERROR_PASS_MIN",  ERROR_IN . "La contraseña no puede tener menos de " . MIN_PASS_LENGTH . " caracteres" . ERROR_OUT);
define("ERROR_PASS_MAX",  ERROR_IN . "La contraseña no puede tener mas de " . MAX_PASS_LENGTH . " caracteres" . ERROR_OUT);
define("ERROR_PASS_MINUS",  ERROR_IN . "La contraseña debe contener al menos una letra minúscula" . ERROR_OUT);
define("ERROR_PASS_MAYUS",  ERROR_IN . "La contraseña debe contener al menos una letra mayúscula" . ERROR_OUT);
define("ERROR_PASS_NUMBER",  ERROR_IN . "La contraseña debe contener al menos un número" . ERROR_OUT);
define("ERROR_PASS_MATCH",  ERROR_IN . "Las contraseñas no coinciden" . ERROR_OUT);
//USER
define("ERROR_USER_PATRON",  ERROR_IN . "Por favor, ingrese un nombre válido" . ERROR_OUT);
//DATE
define("ERROR_DATE_YEAR", ERROR_IN . "Solo se pueden registrar mayores de edad" . ERROR_OUT);
//MAIL
define("ERROR_MAIL", ERROR_IN . "Introduce un mail válido" . ERROR_OUT);
//FILE
define("ERROR_FILE_SIZE", ERROR_IN . "El archivo no puede ocupar más de un mega" . ERROR_OUT);
//LOGIN
define("ERROR_LOGIN_USER", ERROR_IN . "El nombre no existe" . ERROR_OUT);
define("ERROR_LOGIN_PASS", ERROR_IN . "La contraseña no es correcta" . ERROR_OUT); 


?>