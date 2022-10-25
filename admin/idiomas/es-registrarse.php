<?php
    $lang += array(
        
    "registrarse" => "Registrarse",
    "username" => "Tu nombre:",
    "correo" => "Tu correo electronico:",
    "password" => "Tu contraseña:",
    "passwordrepetida" => "Repite tu contraseña:",
    "fecha" => "Tu fecha de nacimiento:",
    "avatar" => "Introduce tu avatar:",
    "registrado" => "¿Ya tienes una cuenta? Haz clíck <a href='iniciosesion.php'>aquí</a>",
    "error_vacio"=> ERROR_IN . "El campo no puede estar vacío" . ERROR_OUT,
    "error_character_separator" => ERROR_IN . "No se acepta \"". LINE_SEPARATOR . "\"" . ERROR_OUT,
    "error_pass_pattern" => 
    ERROR_IN . "La contraseña debe tener mínimo:
    <ul>
        <li>" . MIN_PASS_LENGTH . " carácteres (Max " . MAX_PASS_LENGTH . ")</li>
        <li>1 minúscula</li>
        <li>1 mayúscula</li>
        <li>1 número</li>
    </ul>" . 
    ERROR_OUT,
    "error_pass_match" =>  ERROR_IN . "Las contraseñas no coinciden" . ERROR_OUT,
    "error_user_pattern" =>  ERROR_IN . "Por favor, ingrese un nombre válido" . ERROR_OUT,
    "error_date_year"=> ERROR_IN . "Solo se pueden registrar mayores de edad" . ERROR_OUT,
    "error_mail"=> ERROR_IN . "Introduce un mail válido" . ERROR_OUT,
    "error_file_size"=> ERROR_IN . "El archivo no puede ocupar más de un mega" . ERROR_OUT,
    "error_file_type"=> ERROR_IN . "El archivo debe ser .png" . ERROR_OUT
    )
?>