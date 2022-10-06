<?php

namespace Nickbustos\Proyectodawes\form;

require("../../vendor/autoload.php");
use Nickbustos\Proyectodawes\controller\Mailer;


if(isset($_POST['email'])) {
    $email = Validaciones::validacion($_POST['email'], "email");

    if($email != false) {
        echo "Correo <b>" . $email . "</b> validado correctamente";
        $prueba = Mailer::sendMail($email);
        echo "</br><pre>";
        print_r($prueba);
        echo "</pre></br>";
    }else {
        echo "Error al crear la cuenta";
    }
    


}


