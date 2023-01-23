<?php
//-------------------------------------- VALUES --------------------------------------

//Imagenes:
define("IMAGE_MAX_SIZE", 750000);

//Fecha:
define("DATE_TODAY", date("Y-m-d"));//última disponible para formulario
define("DATE_FIRST", date("1900-01-01"));//primera disponible para formulario

//Contraseña:
define("MIN_PASS_LENGTH", 8);//Contraseña: tamaño minimo
define("MAX_PASS_LENGTH", 16);//Contraseña: tamaño máximo

//Datos guardados en sesion de usuario
define("SESSION_ID", "id");
define("SESSION_USER", "user");
define("SESSION_CURRENT_BATTLE", "current_battle");
define("SESSION_BATTLE_ELEM_1", "battle_elem1");
define("SESSION_BATTLE_ELEM_2", "battle_elem2");
define("SESSION_BATTLE_VOTED", "battle_voted");


//------------------------------------- PATTERNS -------------------------------------

//Patrones para validar campos
define("PATTERN_USER", "/([A-ZÁ-Ú]{1}[-a-zá-ú]+\s?)+/A");
define("PATTERN_PASS_MINUS", '/[a-z]/');//Verifica que hay una minuscula
define("PATTERN_PASS_MAYUS", '/[A-Z]/');//Verifica que hay una mayuscula
define("PATTERN_PASS_NUMBER", '/[0-9]/');//Verifica que hay un numero

//-------------------------------------- ERRORS --------------------------------------

//Etiquetas para dar formato HTML a los errores
define("ERROR_IN", "<span style='color:red'>");
define("ERROR_OUT", "</span>");

//-------------------------------------- IDIOMA ---------------------------------------
define("LANG_ENGLISH", "en");
define("LANG_SPANISH", "es");
define("LANG", "lang");

//------------------------------------- MODOVIS ---------------------------------------
define("TEMA", "modovis");
define("TEMA_LIGHT", "light");
define("TEMA_DARK", "dark");

//----------------------------------- CREAR BATTLE ------------------------------------
define("ELEMENTS_PAGE", 4);
define("SESSION_CREAR_ELEM_1", "crearElem1");
define("SESSION_CREAR_ELEM_2", "crearElem2");

//----------------------------------- PERFIL ------------------------------------
// índices de array $datosusuario de perfil => se cambiara con objetos
define("PERFIL_USUARIO", 0);
define("PERFIL_FOTO", 2);
define("PERFIL_BATALLAS_CREADAS", 8);
define("PERFIL_BATALLAS_VOTADAS", 9);
define("PERFIL_BATALLAS_DENUNCIADAS", 11);

?>