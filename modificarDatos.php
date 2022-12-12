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
        $sql = "UPDATE credencial SET ";
        for ($i = 0; $i < count($credencialesGuardar); $i++) {
            $sql .= "{$tablasCredenciales[$i]}=?";
            if ($i < count($credencialesGuardar) - 1) {
                $sql .= ", ";
            }
        }
        $sql .= " WHERE nombreusuario='{$nameAct}'";
        // echo $sql . "<br/>";
        // echo $conexion->prepare($sql)->execute($credencialesGuardar);
        // echo "<br/>";
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
        $sql = "UPDATE usuario SET ";
        for ($i = 0; $i < count($usuarioGuardar); $i++) {
            $sql .= "{$tablasUsuario[$i]}=?";
            if ($i < count($usuarioGuardar) - 1) {
                $sql .= ", ";
            }
        }
        $sql .= " WHERE id='{$_SESSION[SESSION_ID]}'";
        // echo $sql . "<br/>";
        // echo $conexion->prepare($sql)->execute($usuarioGuardar);
        // echo "<br/>";
        if (in_array("fechanacimiento", $tablasUsuario)) {
            $dateAct = $dateNew;
            $errorDate = "Fecha Cambiada";
        }
        if (in_array("email", $tablasUsuario)) {
            $mailAct = $mailNew;
            $errorMail = "Mail Cambiado";
        }
        if(in_array("foto", $tablasUsuario)){
            $fotoAct = $fotoNew;
            $errorFoto = "Foto Cambiada";
        }
    }
}
?>

<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>' enctype='multipart/form-data'>
    Nombre:<input type="text" name='newName' value=<?php echo $nameAct; ?>><?php echo $errorName; ?>
    <br />
    Password:<input name='newPass' type="password"><?php echo $errorPass; ?>
    <br />
    FechaNac:<input type="date" name='newDate' value=<?php echo $dateAct; ?>><?php echo $errorDate; ?>
    <br />
    Email<input type="email" name='newMail' value=<?php echo $mailAct; ?> min="<?= DATE_FIRST; ?>" max="<?= DATE_TODAY; ?>"><?php echo $errorMail; ?>
    <br />
    <img src='<?php echo $fotoAct; ?>' width='100px' height='100px'>
    <input type="file" name='newFoto'><?php echo $errorFoto; ?>
    <br />
    <input type="submit">
</form>

<?php include_once "admin/templates/pie.php"; ?>