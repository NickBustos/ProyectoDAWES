<?php

$lang = array( //CABECERA

    "inicio" => "Home",
    "about" => "About",
    "contacto" => "Contact",
    "modoC" => "Light mode",
    "modoN" => "Batman mode",
    "idioma" => "Espagnolo",
    "cerrar" => "Log out"

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
    "registarse" => "Sign up"

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
    "error_character_separator" => ERROR_IN . "It is not allowed: \"" . LINE_SEPARATOR . "\"" . ERROR_OUT,
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