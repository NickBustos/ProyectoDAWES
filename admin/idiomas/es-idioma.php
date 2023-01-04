<?php

$lang = array( //CABECERA

    "inicio" => "Inicio",
    "about" => "Acerca de",
    "contacto" => "Contacto",
    "modoC" => "Modo claro",
    "modoN" => "Modo noche",
    "idioma" => "Cambiar a inglés",
    "cerrar" => "Cerrar sesión",
    "paginaPersonal" => "Mi página"

);
$lang += array( //ACERCADE

    "registrate" => "Registrate",
    "paravotar" => "Registrate en nuestra página para poder votar",
    "registrarse" => "Registrarse",
    "navega" => "Navega",
    "encuestas" => "Navega por nuestra web, encuentra diferentes encuestas",
    "vota" => "¡Vota!",
    "votarencuestas" => "Vota difrentes encuestas ¡Diviertete!",
    "votar" => "Vota"

);
$lang += array( //CONTACTO

    "ponteencontacto" => "¡Ponte en contacto!",
    "nombre" => "Nombre",
    "mail" => "Email",
    "cc" => "CC",
    "mensaje" => "Escríbenos tu mensaje...",
    "enviar" => "¡Enviar!"

);
$lang += array( //INDEX

    "bienvenido" => "Bienvenido a Mum OR Dad",
    "iniciarsesion" => "Iniciar sesión",
    "registarse" => "Registrarse",
    "modificarDatos" => "Modificar datos"
);
$lang += array( //INICIOSESIÓN

    "iniciosesion" => "Iniciar sesión",
    "username" => "Nombre:",
    "password" => "Contraseña:",
    "noregistrado" => "¿No tienes cuenta? Haz clíck <a href='registrarse.php'>aquí</a>",
    "error_vacio" => ERROR_IN . "El campo no puede estar vacío" . ERROR_OUT,
    "error_login_user" => ERROR_IN . "El nombre no existe" . ERROR_OUT,
    "error_login_pass" => ERROR_IN . "La contraseña no es correcta" . ERROR_OUT

);
$lang += array( //REGISTRARSE

    "registrarse" => "Registrarse",
    "username" => "Tu nombre:",
    "correo" => "Tu correo electronico:",
    "password" => "Tu contraseña:",
    "passwordrepetida" => "Repite tu contraseña:",
    "fecha" => "Tu fecha de nacimiento:",
    "avatar" => "Introduce tu avatar:",
    "registrado" => "¿Ya tienes una cuenta? Haz clíck <a href='iniciosesion.php'>aquí</a>",
    "error_vacio" => ERROR_IN . "El campo no puede estar vacío" . ERROR_OUT,
    "error_character_separator" => ERROR_IN . "No se acepta \"" . LINE_SEPARATOR . "\"" . ERROR_OUT,
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
    "error_user_used" =>  ERROR_IN . "Ya hay un usuario con este nombre" . ERROR_OUT,
    "error_user_pattern" =>  ERROR_IN . "Por favor, ingrese un nombre válido" . ERROR_OUT,
    "error_date_year" => ERROR_IN . "Solo se pueden registrar mayores de edad" . ERROR_OUT,
    "error_mail" => ERROR_IN . "Introduce un mail válido" . ERROR_OUT,
    "error_file_size" => ERROR_IN . "El archivo no puede ocupar más de un mega" . ERROR_OUT,
    "error_file_type" => ERROR_IN . "El archivo debe ser .png" . ERROR_OUT
);
$lang += array( //SESIÓNINICIADA

    "hola1" => "Hola, ",
    "hola2" => ". ¿Qué quieres hacer?",
    "entrar" => "Entrar",
    "salir" => "Salir"

);
$lang += array( //SUBIRBATALLA

    "noBatallasDisponibles" => "NO QUEDAN BATALLAS DISPLONIBLES EN ESTE MOMENTO",
    "subirBatalla" => "Crear batalla",
    "nombre" => "Nombre:",
    "imagen" => "Imagen:",
    "volver" => "Volver",
    "upload" => "SI QUIERES SUBIR LA BATALLA, ¡VOTA!",
    "elemento1" => "Elemento 1",
    "elemento2" => "Elemento 2",
    "error_batallaExiste"=> ERROR_IN . "La batalla ya existe" . ERROR_OUT,
    "error_elementosIguales"=> ERROR_IN . "Los elementos son iguales" . ERROR_OUT

);

$lang += array( //PERFIL
    "unete" => "ÚNETE A NUETRA COMUNIDAD",
    "tituloDescripcion" => "Descripción del usuario",
    "esteUsuario" => "Este usuario ha creado ",
    "batalla" => " batalla",
    "batallas" => " batallas",
    "sinBatallas" => "¡Vaya, parece que este usuario no ha creado batallas aún!",
    "registrateYCrea" => "¡Registrate y crea batallas épicas!",
    "bat_creadas_1"=>"Comprometido",
    "bat_creadas_2"=>"Adicto",
    "bat_creadas_3"=>"Vicioso",
    "bat_votadas_1"=>"Votante",
    "bat_votadas_2"=>"Sindicalista",
    "bat_votadas_3"=>"Greta Thunberg",
    "bat_denunciadas_1"=>"Madero",
    "bat_denunciadas_2"=>"Moderador",
    "bat_denunciadas_3"=>"Vigilante"
);
