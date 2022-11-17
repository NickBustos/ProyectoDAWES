<?php
define("HOST", "localhost");// o 127.0.0.1
define("USER", "root");
define("PASSWORD", "");
define("DB","dbempresa");//CAMBIAR
define("DRIVER", "mysql"); //PARA PDO
define("DSN", (DRIVER . ":host=" . HOST . ";dbname=" . DB));
?>