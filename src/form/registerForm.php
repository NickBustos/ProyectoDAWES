<?php

require("validaciones.php");

if(isset($_POST['email'])) {
    $email = validacion($_POST['email'], "email");
}


