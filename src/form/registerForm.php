<?php

namespace Nickbustos\Proyectodawes\form;

require("../../vendor/autoload.php");
use Nickbustos\Proyectodawes\controller\Mailer;



if(isset($_POST['email'])) {
    $email = Validaciones::validacion($_POST['email'], "email");

    if($email != false) {
        
        Mailer::sendMail($email);
        echo "Correo <b>" . $email . "</b> validado correctamente";

    } else {
        echo "Error al crear la cuenta";
    }
    


}


