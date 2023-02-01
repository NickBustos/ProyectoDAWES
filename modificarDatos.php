<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MumORDad</title>
    <?php
    session_start();
    include "admin/configuraciones/funciones.php";
    $usuario = null;
    if (isset($_SESSION[SESSION_ID])) {
        $usuario = new Usuario($_SESSION[SESSION_ID], $_SESSION[SESSION_USER]);
    }
    include getIdioma($usuario);
    /**
     * Inicia sesión.
     * Si no hay un tema definido en $_SESSION lo crea con el valor "claro".
     * Si el valor del tema es "noche" carga el css correspondiente.
     */
    $css = "<link rel='stylesheet' href='./css/archivo.css' />";
    if ($usuario != null) {
        if ($usuario->modovis === "dark") {
            $css = '<link rel="stylesheet" type="text/css" href="./css/archivo-oscuro.css">';
        }
    } else if (!isset($_SESSION[TEMA])) {
        $_SESSION[TEMA] = TEMA_LIGHT;
    } else if ($_SESSION[TEMA] == TEMA_DARK) {
        $css = '<link rel="stylesheet" type="text/css" href="./css/archivo-oscuro.css">';
    }
    echo $css;
    ?>
</head>

<body>
    <?php

    if ($usuario == null) {
        echo "<h1 style='text-align:center;'>¿Qué haces?</h1><br/>";
        echo "<img src='imagenes/luigi.png'><br/>";
        exit();
    }
    // Coger información del usuario de bbdd
    $idUser = $_SESSION[SESSION_ID];
    $nameAct = $_SESSION[SESSION_USER];
    $dateAct = $usuario->fechanacimiento;
    $fotoAct = $usuario->foto;
    $mailAct = $usuario->email;
    $passAct = $usuario->password;

    $newName = $newPass = $newDate = $newMail = $newFoto = "";
    $errorName = $errorFoto = $errorDate = $errorMail = $errorPass = "";
    $credencialesGuardar = [];
    $tablasCredenciales = [];
    $usuarioGuardar = [];
    $tablasUsuario = [];

    // Si ha cambiado datos
    if (!empty($_POST)) {
        // Validaciones
        $newName = $_POST["newName"];
        $newPass = $_POST["newPass"];
        $dateNew = $_POST["newDate"];
        $mailNew = $_POST["newMail"];
        if ($newName != $nameAct) {
            if (preg_match(PATTERN_USER, $newName)) {
                if (Usuario::existe($newName) == false) {
                    array_push($credencialesGuardar, $newName);
                    array_push($tablasCredenciales, "nombreusuario");
                } else {
                    $errorName = $lang["error_user_used"];
                }
            } else {
                $errorName = $lang["error_user_pattern"];
            }
        }
        if (!empty($newPass)) {
            if (
                preg_match(PATTERN_PASS_MINUS, $newPass) && preg_match(PATTERN_PASS_MAYUS, $newPass)
                && preg_match(PATTERN_PASS_NUMBER, $newPass) && strlen($newPass) <= MAX_PASS_LENGTH
                && strlen($newPass) >= MIN_PASS_LENGTH
            ) {
                array_push($credencialesGuardar, md5($newPass));
                array_push($tablasCredenciales, "password");
            } else {
                $errorPass = $lang["error_pass_pattern"];
            }
        }
        // Los datos validados los guardamos en array junto a otro con el nombre de su columna
        // Y si hay realiza el update
        // Tabla credencial
        if (count($credencialesGuardar) > 0) { // count = length
            $sql = "UPDATE credencial SET ";
            for ($i = 0; $i < count($credencialesGuardar); $i++) {
                $sql .= "{$tablasCredenciales[$i]}=?";
                if ($i < count($credencialesGuardar) - 1) {
                    $sql .= ", ";
                }
            }
            $sql .= " WHERE nombreusuario='{$nameAct}'";
            BD::crearConexion()->prepare($sql)->execute($credencialesGuardar);
            if (in_array("nombreusuario", $tablasCredenciales)) {
                $_SESSION[SESSION_USER] = $newName;
                $nameAct = $newName;
                $errorName = $lang["usuarioCambiado"];
            }
            if (in_array("password", $tablasCredenciales)) {
                $errorPass = $lang["passwordCambiada"];
            }
        }

        if ($dateNew != $dateAct) {
            if (validarMayorEdad($dateNew)) {
                array_push($usuarioGuardar, $dateNew);
                array_push($tablasUsuario, "fechanacimiento");
            } else {
                $errorDate = $lang["error_date_year"];
            }
        }
        if ($mailNew != $mailAct) {
            if (filter_var($mailNew, FILTER_VALIDATE_EMAIL)) {
                array_push($usuarioGuardar, $mailNew);
                array_push($tablasUsuario, "email");
            } else {
                $errorMail = $lang["error_mail"];
            }
        }

        if (
            !empty($_FILES) && !empty($_FILES["newFoto"])
            && !empty($_FILES["newFoto"]["tmp_name"])
        ) {
            if ($_FILES["newFoto"]["type"] === "image/png") { //Comrpueba que el archivo es una imagen png
                if ($_FILES['newFoto']['size'] <= 750000) { //Comprueba que el archivo pesa menos de un 750 kilobytes
                    $fotoNew = getImage($_FILES["newFoto"]);
                    array_push($usuarioGuardar, $fotoNew);
                    array_push($tablasUsuario, "foto");
                } else {
                    $errorFoto = $lang["error_file_size"];
                }
            } else {
                $errorFoto = $lang["error_file_type"];
            }
        }
        // Lo mismo pero con la tabla usuario
        if (count($usuarioGuardar) > 0) {
            $sql = "UPDATE usuario SET ";
            for ($i = 0; $i < count($usuarioGuardar); $i++) {
                $sql .= "{$tablasUsuario[$i]}=?";
                if ($i < count($usuarioGuardar) - 1) {
                    $sql .= ", ";
                }
            }
            $sql .= " WHERE id='{$_SESSION[SESSION_ID]}'";
            BD::crearConexion()->prepare($sql)->execute($usuarioGuardar);
            if (in_array("fechanacimiento", $tablasUsuario)) {
                $dateAct = $dateNew;
                $errorDate =$lang["fechaCambiada"];
            }
            if (in_array("email", $tablasUsuario)) {
                $mailAct = $mailNew;
                $errorMail = $lang["emailCambiado"];
            }
            if (in_array("foto", $tablasUsuario)) {
                $fotoAct = $fotoNew;
                $errorFoto = $lang["fotoCambiada"];
            }
        }
    }
    // Si ha dado a borrar elimina todos los datos del usuario, sale de la sesión y vuelve a index
    if (isset($_POST["delete"])) {
        BD::delete("usuario_credencial", "nombreusuario", $nameAct);
        BD::delete("credencial", "nombreusuario", $nameAct);
        BD::delete("usuario", "id", $idUser);
        BD::delete("usuario_credencial", "nombreusuario", $nameAct);
        header("Location: procesos/cerrarsesion.php");
    } else if (isset($_POST["inicio"])) {
        header("Location: index.php");
    }
    ?>
    <br><br>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="container h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="card text-black" style="border-radius: 25px;">
                                <div class="card-body p-md-5">
                                    <div class="row justify-content-center">
                                        <div>
                                            <!-- Para ver como se hace con el lang     <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?php echo $lang["iniciosesion"]; ?></p> -->
                                            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?php echo "Página de {$_SESSION[SESSION_USER]}" ?></p>
                                            <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>' enctype='multipart/form-data'>
                                                <div class="form-outline mb-4">
                                                    <!-- -------------------- Usuario ----------------------- -->
                                                    Usuario:<input type="text" id="Mdatos" class="form-control" name='newName' value='<?php echo $nameAct; ?>'>
                                                    <?php echo $errorName; ?>
                                                </div>
                                                <br /> <br />

                                                <!-- -------------------- Contraseña ----------------------- -->
                                                <div class="form-outline mb-4">
                                                    Password:<input name='newPass' type="password" id="Mdatos" class="form-control" value="">
                                                    <?php echo $errorPass; ?>
                                                </div>
                                                <br /> <br />
                                                <!-- -------------------- Fecha Nac ----------------------- -->
                                                <div class="form-outline mb-4">
                                                    FechaNac:<input type="date" name='newDate' id="Mdatos" class="form-control" value='<?php echo $dateAct; ?>'>
                                                    <?php echo $errorDate; ?>
                                                </div>
                                                <br /> <br />
                                                <!-- -------------------- Email ----------------------- -->
                                                <div class="form-outline mb-4">
                                                    Email<input type="email" name='newMail' id="Mdatos" class="form-control" value=<?php echo $mailAct; ?> min="<?= DATE_FIRST; ?>" max="<?= DATE_TODAY; ?>">
                                                    <?php echo $errorMail; ?>
                                                </div>
                                                <br /> <br />
                                                <!-- -------------------- Foto ----------------------- -->
                                                <div class="LogoMdatos">
                                                    <img src='<?php echo $fotoAct; ?>' width='200px' height='200px'>
                                                    <input type="file" name="newFoto"><br /><?php echo $errorFoto; ?>
                                                </div>
                                                <br /> <br /> <br />
                                                <!-- -------------------- Boton ----------------------- -->
                                                <button type="submit" class='modificarDatos btn btn-primary btn-lg'>
                                                    <p class="text-center h1 fw-bold">Enviar</p>
                                                </button>
                                                <br /> <br /> <br />
                                                <!-- -------------------- Boton ----------------------- -->
                                                <button type="submit" class='modificarDatosBorrar' name="delete">
                                                    <p class="text-center h1 fw-bold">Borrar Cuenta</p>
                                                </button>
                                                <br /> <br /> <br />
                                                <!-- -------------------- Boton ----------------------- -->
                                                <button type="submit" class='modificarDatos btn btn-primary btn-lg' name="inicio">
                                                    <p class="text-center h1 fw-bold">Inicio</p>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>