<?php
    $lang += array(
        
    "registrarse" => "Sing up",
    "username" => "Your username:",
    "correo" => "Your email:",
    "password" => "Your password:",
    "passwordrepetida" => "Your repeated password:",
    "fecha" => "Your date of birth:",
    "avatar" => "Your avatar:",
    "registrado" => "¿You already have an account? Click <a href='iniciosesion.php'>here</a>",
    "error_vacio"=> ERROR_IN . "The field cannot be empty" . ERROR_OUT,
    "error_character_separator" => ERROR_IN . "It is not allowed: \"". LINE_SEPARATOR . "\"" . ERROR_OUT,
    "error_pass_pattern" => 
    ERROR_IN . "The password must have at least:
    <ul>
        <li>" . MIN_PASS_LENGTH . " characters (Max " . MAX_PASS_LENGTH . ")</li>
        <li>1 lowercase</li>
        <li>1 uppercase</li>
        <li>1 numbre</li>
    </ul>" . 
    ERROR_OUT,
    "error_pass_match" =>  ERROR_IN . "Passwords don't match" . ERROR_OUT,
    "error_user_pattern" =>  ERROR_IN . "Please, enter a correct user" . ERROR_OUT,
    "error_date_year"=> ERROR_IN . "Users need to be at least 18 years old" . ERROR_OUT,
    "error_mail"=> ERROR_IN . "Enter a valid mail" . ERROR_OUT,
    "error_file_size"=> ERROR_IN . "The file must be smaller than 1 MB" . ERROR_OUT,
    "error_file_type"=> ERROR_IN . "The file must be .png" . ERROR_OUT
    )
?>