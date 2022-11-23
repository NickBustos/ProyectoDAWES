<?php
/**
 * Inicia sessión y la destruye, 
 * borrando todo el contenido de $_SESSION.
 * Luego te lleva de vuelta a "index.php".
 */
session_start();
session_destroy();
header('Location: index.php');
exit();
?>