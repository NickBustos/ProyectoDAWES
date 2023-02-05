<?php

$lang = array( //CABECERA

    "inicio" => "Home",
    "about" => "About",
    "contacto" => "Contact",
    "modoC" => "Light mode",
    "modoN" => "Batman mode",
    "idioma" => "Espagnolo",
    "cerrar" => "Log out",
    "paginaPersonal" => "My Page"

);
$lang += array( //ACERCADE

    "registrate" => "Sing up",
    "paravotar" => "Sign up on our page to be able to vote",
    "registrarse" => "Sign up",
    "navega" => "Scroll",
    "encuestas" => "Browse our website, find different surveys and have fun!",
    "vota" => "Vote!",
    "votarencuestas" => "Vote different surveys. Have fun!",
    "votar" => "Vote"

);
$lang += array( //CONTACTO

    "ponteencontacto" => "Get in touch!",
    "nombre" => "Name",
    "mail" => "Email",
    "cc" => "CC",
    "mensaje" => "Write your message...",
    "enviar" => "Send!"

);
$lang += array( //INDEX

    "bienvenido" => "Welcome to Mum OR Dad",
    "iniciarsesion" => "Sign in",
    "registarse" => "Sign up",
    "modificarDatos" => "Modify data"

);
$lang += array( //INICIOSESIÓN

    "iniciosesion" => "Sing in",
    "username" => "Username:",
    "password" => "Password:",
    "noregistrado" => "¿You doesn't have an account? Click <a href='registrarse.php'>here</a>",
    "error_vacio" => ERROR_IN . "The field can not be empty" . ERROR_OUT,
    "error_login_user" => ERROR_IN . "Unrecognized user" . ERROR_OUT,
    "error_login_pass" => ERROR_IN . "Incorrect password" . ERROR_OUT

);
$lang += array( //REGISTRARSE

    "registrarse" => "Sing up",
    "username" => "Your username:",
    "correo" => "Your email:",
    "password" => "Your password:",
    "passwordrepetida" => "Your repeated password:",
    "fecha" => "Your date of birth:",
    "avatar" => "Your avatar:",
    "registrado" => "¿You already have an account? Click <a href='iniciosesion.php'>here</a>",
    "error_vacio" => ERROR_IN . "The field cannot be empty" . ERROR_OUT,
    "error_pass_pattern" =>
    ERROR_IN . "The password must have at least:
    <ul>
        <li>" . MIN_PASS_LENGTH . " characters (Max " . MAX_PASS_LENGTH . ")</li>
        <li>1 lowercase</li>
        <li>1 uppercase</li>
        <li>1 number</li>
    </ul>" .
        ERROR_OUT,
    "error_pass_match" =>  ERROR_IN . "Passwords don't match" . ERROR_OUT,
    "error_user_used" =>  ERROR_IN . "The username is already in use" . ERROR_OUT,
    "error_user_pattern" =>  ERROR_IN . "Please, enter a correct user" . ERROR_OUT,
    "error_date_year" => ERROR_IN . "Users need to be at least 18 years old" . ERROR_OUT,
    "error_mail" => ERROR_IN . "Enter a valid mail" . ERROR_OUT,
    "error_file_size" => ERROR_IN . "The file must be smaller than 1 MB" . ERROR_OUT,
    "error_file_type" => ERROR_IN . "The file must be .png" . ERROR_OUT
);
$lang += array( //SESIÓNINICIADA

    "hola1" => "Hi, ",
    "hola2" => ". What do you want to do?",
    "entrar" => "Get in",
    "salir" => "Get out"

);
$lang += array( //SUBIRBATALLA

    "noBatallasDisponibles" => "THERE IS NO AVAILABLE BATTLES AT THE MOMENT",
    "subirBatalla" => "Create battle",
    "nombre" => "Name:",
    "imagen" => "Image:",
    "volver" => "Return",
    "upload" => "IF YOU WANT TO UPLOAD THE BATTLE, ¡VOTE!",
    "elemento1" => "Element 1",
    "elemento2" => "Element 2",
    "error_batallaExiste"=> ERROR_IN . "This battle already exists" . ERROR_OUT,
    "error_elementosIguales"=> ERROR_IN . "Elements are the same" . ERROR_OUT

);

$lang += array( //PERFIL
    "unete" => "JOIN OUR COMUNITY NOW",
    "tituloDescripcion" => "User description",
    "esteUsuario" => "This user has created ",
    "batalla" => " battle",
    "batallas" => " battles",
    "sinBatallas" => "¡Whoopsie-daisy, it looks like this user hasn't created a battle yet!",
    "registrateYCrea" => "¡Join us and create epic battles!",
    "bat_creadas_1"=>"Engaged",
    "bat_creadas_2"=>"Adict",
    "bat_creadas_3"=>"Vicious",
    "bat_votadas_1"=>"Voter",
    "bat_votadas_2"=>"Sindicalist",
    "bat_votadas_3"=>"Greta Thunberg",
    "bat_denunciadas_1"=>"Pig",
    "bat_denunciadas_2"=>"Moderator",
    "bat_denunciadas_3"=>"Daredevil",
    "usuarioBorrado"=>"Deleted user"
);

$lang += array(//MODIFICAR DATOS
    "usuarioCambiado"=>"User name changed successfully",
    "passwordCambiada"=>"Password changed successfully",
    "fechaCambiada"=>"Date birth changed successfully",
    "emailCambiado"=>"Email changed successfully",
    "fotoCambiada"=>"Photo  changed successfully",
    "change"=> "Change",
    "delete_user" => "Delete user"
);
