<?php
define("VALIDA_NOMBREUSUARIO", "/([A-ZÁ-Ú]{1}[-a-zá-ú]+\s?)+/A");
define("VALIDA_PASSWORD", "/(^[A-Za-z\d$@$!%*?&_]{8,15}$)/A");//Culquiera de esos caracteres minimo 8 maximo 15
define("PATH_TO_IMAGENES", 'multimedia/imagenes/');
define("PATH_TO_BD", "multimedia/bbdd.txt");
define("ERROR_VACIO", "<span style='color:red'>El campo no puede estar vacio</span>");
?>