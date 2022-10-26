<?php
//-------------------------------------- PATHS ---------------------------------------

define("PATH_TO_IMAGENES", 'multimedia/imagenes/');//ACTUALIZAR
define("PATH_TO_BD", "multimedia/bbdd.txt");//ACTUALIZAR

//-------------------------------------- VALUES --------------------------------------

//Fecha:
define("DATE_TODAY", date("Y-m-d"));
define("DATE_FIRST", date("1900-01-01"));//primera disponible para formulario

//Contraseña:
define("MIN_PASS_LENGTH", 8);//Contraseña: tamaño minimo
define("MAX_PASS_LENGTH", 16);//Contraseña: tamaño máximo

//Numeros de posiciones en arrays de línea de registrados.txt
define("LINE_USER", 0);
define("LINE_PASS", 1);
define("LINE_MAIL", 2);
define("LINE_DATE", 3);
define("LINE_FILE", 4);
define("LINE_SEPARATOR", ";");

//Datos guardados en sesion de usuario
define("SESSION_USER", "user");
define("SESSION_PASS", "pass");
define("SESSION_MAIL", "mail");
define("SESSION_DATE", "date");
define("SESSION_FILE", "avatar");
define("SESSION_THEME", "theme");


//------------------------------------- PATTERNS -------------------------------------

//Patrones para validar campos
define("PATTERN_USER", "/([A-ZÁ-Ú]{1}[-a-zá-ú]+\s?)+/A");
define("PATTERN_PASS", "^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{".MIN_PASS_LENGTH.",".MAX_PASS_LENGTH."}$^");
define("PATTERN_PASS_MINUS", '/[a-z]/');
define("PATTERN_PASS_MAYUS", '/[A-Z]/');
define("PATTERN_PASS_NUMBER", '/[0-9]/');
define("PATTERN_CHARACTER_SEPARATOR", "@[".LINE_SEPARATOR."]@");//Verifica que hay ";"

//-------------------------------------- ERRORS --------------------------------------

//Etiquetas para dar formato HTML a los errores
define("ERROR_IN", "<span style='color:red'>");
define("ERROR_OUT", "</span>");

?>