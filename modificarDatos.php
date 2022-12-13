<?php include_once "admin/templates/cabecera.php"; ?>

<?php

// var_dump($_SESSION);
// echo "<br/>";

$nameAct = $_SESSION[SESSION_USER];
$datosActuales = selectFromUsuario(["fechanacimiento", "foto", "email"]);
$dateAct = $datosActuales[0];
$fotoAct = $datosActuales[1];
$mailAct = $datosActuales[2];
$passAct = select(["password"], "credencial", ["nombreusuario", $_SESSION[SESSION_USER]])[0][0];

$newName = $newPass = $newDate = $newMail = $newFoto = "";
$errorName = $errorFoto = $errorDate = $errorMail = $errorPass = "";
$credencialesGuardar = [];
$tablasCredenciales = [];
$usuarioGuardar = [];
$tablasUsuario = [];

if (!empty($_POST)) {
    $newName = $_POST["newName"];
    $newPass = $_POST["newPass"];
    $dateNew = $_POST["newDate"];
    $mailNew = $_POST["newMail"];
    if ($newName != $nameAct) {
        if (preg_match(PATTERN_USER, $newName)) {
            if (existe($newName) == false) {
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
        }
    }
    if (count($credencialesGuardar) > 0) {
        update("credencial", $tablasCredenciales, $credencialesGuardar, "nombreusuario", $nameAct);

        if (in_array("nombreusuario", $tablasCredenciales)) {
            $_SESSION[SESSION_USER] = $newName;
            $nameAct = $newName;
            $errorName = "Nombre Cambiado";
        }
        if (in_array("password", $tablasCredenciales)) {
            $errorPass = "Password Cambiado";
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

    if (count($usuarioGuardar) > 0) {
        update("usuario", $tablasUsuario, $usuarioGuardar, "id", $_SESSION[SESSION_ID]);

        if (in_array("fechanacimiento", $tablasUsuario)) {
            $dateAct = $dateNew;
            $errorDate = "Fecha Cambiada";
        }
        if (in_array("email", $tablasUsuario)) {
            $mailAct = $mailNew;
            $errorMail = "Mail Cambiado";
        }
        if (in_array("foto", $tablasUsuario)) {
            $fotoAct = $fotoNew;
            $errorFoto = "Foto Cambiada";
        }
    }
}
?>
<div style="text-align:center">
    <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>' class="mx-1 mx-md-4" style="display:inline-block;" enctype='multipart/form-data'>
        <img src='<?php echo $fotoAct; ?>' width='300px' height='300px'>
        <br />
        Nombre:<input type="text" name='newName' value=<?php echo $nameAct; ?>
            class="form-control"><?php echo $errorName; ?>
        <br />
        Password:<input name='newPass' type="password" class="form-control"><?php echo $errorPass; ?>
        <br />
        FechaNac:<input type="date" name='newDate' value=<?php echo $dateAct; ?> class="form-control"><?php echo $errorDate; ?>
        <br />
        Email:<input type="email" name='newMail' value=<?php echo $mailAct; ?> min="<?= DATE_FIRST; ?>" max="<?= DATE_TODAY; ?>" class="form-control"><?php echo $errorMail; ?>
        <br />
        Imagen:<input type="file" name='newFoto' class="form-control"><?php echo $errorFoto; ?>
        <br />
        <input type="submit" class="btn btn-primary btn-lg">
    </form>
</div>
<?php include_once "admin/templates/pie.php"; ?>