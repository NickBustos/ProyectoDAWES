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


//------------------------------------- PATTERNS -------------------------------------

//Patrones para validar campos
define("PATTERN_USER", "/([A-ZÁ-Ú]{1}[-a-zá-ú]+\s?)+/A");
define("PATTERN_PASS", "^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{".MIN_PASS_LENGTH.",".MAX_PASS_LENGTH."}$^");
define("PATTERN_CHARACTER_SEPARATOR", "@[".LINE_SEPARATOR."]@");//Verifica que hay ";"

//-------------------------------------- ERRORS --------------------------------------

//Etiquetas para dar formato HTML a los errores
define("ERROR_IN", "<span style='color:red'>");
define("ERROR_OUT", "</span>");

//Campo formulario vacio
define("ERROR_VACIO", ERROR_IN . "El campo no puede estar vacio" . ERROR_OUT);

//Usado caracter de separación
define("ERROR_CHARACTER_SEPARATOR", ERROR_IN . "No se acepta \"". LINE_SEPARATOR . "\"" . ERROR_OUT);

//REGISTRARSE
//Contraseña
define("ERROR_PASS_FORMAT", 
    ERROR_IN . "La contraseña debe tener mínimo:
        <ul>
            <li>" . MIN_PASS_LENGTH . " carácteres (Max " . MAX_PASS_LENGTH . ")</li>
            <li>1 minúscula</li>
            <li>1 mayúscula</li>
            <li>1 número</li>
        </ul>" . 
    ERROR_OUT);
define("ERROR_PASS_MATCH",  ERROR_IN . "Las contraseñas no coinciden" . ERROR_OUT);
//Usuario
define("ERROR_USER_PATTERN",  ERROR_IN . "Por favor, ingrese un nombre válido" . ERROR_OUT);
//Fecha
define("ERROR_DATE_YEAR", ERROR_IN . "Solo se pueden registrar mayores de edad" . ERROR_OUT);
//Mail
define("ERROR_MAIL", ERROR_IN . "Introduce un mail válido" . ERROR_OUT);
//File (imagen)
define("ERROR_FILE_SIZE", ERROR_IN . "El archivo no puede ocupar más de un mega" . ERROR_OUT);
define("ERROR_FILE_TYPE", ERROR_IN . "El archivo debe ser .png" . ERROR_OUT);

//INICIAR SESIÓN
//Usario
define("ERROR_LOGIN_USER", ERROR_IN . "El nombre no existe" . ERROR_OUT);
//Contraseña
define("ERROR_LOGIN_PASS", ERROR_IN . "La contraseña no es correcta" . ERROR_OUT);
?>