<?php

namespace src\controller\form;

use src\controller\Mailer;



if(isset($_POST['email'])) {
    $email = Validaciones::validacion($_POST['email'], "email");

    
    

}


