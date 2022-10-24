<?php
include "admin/templates/cabecera.php";
session_destroy();
header('Location: index.php');
exit();
?>