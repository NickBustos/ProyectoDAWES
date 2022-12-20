<?php include_once "admin/templates/cabecera.php"; ?>

<?php
/**
 * Puedo poner a mayores, lo que me ha dicho mario de pedir comprobacion para cambiar la contrasñea
 * Borrar usuario tambien
 */

$idUser = $_SESSION[SESSION_ID];
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
        echo $sql . "<br/>";
        echo $conexion->prepare($sql)->execute($credencialesGuardar);
        echo "<br/>";
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
        echo $sql . "<br/>";
        echo $conexion->prepare($sql)->execute($usuarioGuardar);
        echo "<br/>";
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

if (isset($_POST["delete"])) {

    function delete($tabla, $columna, $dato)
    {
        $conexion = new PDO(DSN, USER, PASSWORD);
        $sql = "DELETE FROM {$tabla} WHERE {$columna} = ? ";
        $conexion->prepare($sql)->execute([$dato]);
    }

    delete("usuario_credencial", "nombreusuario", $nameAct);
    delete("credencial", "nombreusuario", $nameAct);
    delete("usuario", "id", $idUser);
    delete("usuario_credencial", "nombreusuario", $nameAct);
    echo "usuarioBorrad";
    exit();
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
                                        <p class="text-center h1 fw-bold  mx-1  mt-4"><?php echo "Página de {$_SESSION[SESSION_USER]}" ?></p>
                                        <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>' enctype='multipart/form-data'class = "subirBatalla">
                                            <div class="form-outline mb-4">
                                               
                                            <img src='<?php echo $fotoAct; ?>' width='200px' height='200px' style="display:block;margin:0 auto 0 auto;">
                                            <br>
                                            <!-- -------------------- Usuario ----------------------- -->
                                            Usuario: <input type="text" id="Mdatos" class="form-control" name='newName' value=<?php echo $nameAct; ?>><?php echo $errorName; ?>
                                            </div>
                                            <br />

                                            <!-- -------------------- Contraseña ----------------------- -->
                                            <div class="form-outline mb-4">
                                                Password:<input name='newPass'  type="password" id="Mdatos" class="form-control" value="**********"><?php echo $errorPass; ?>
                                            </div>
                                            <br />
                                            <!-- -------------------- Fecha Nac ----------------------- -->
                                            <div class="form-outline mb-4">
                                                FechaNac:<input type="date" name='newDate' id="Mdatos" class="form-control" value=<?php echo $dateAct; ?>><?php echo $errorDate; ?>
                                            </div>
                                            <br />
                                            <!-- -------------------- Email ----------------------- -->
                                            <div class="form-outline mb-4">
                                                Email<input type="email" name='newMail' id="Mdatos" class="form-control" value=<?php echo $mailAct; ?> min="<?= DATE_FIRST; ?>" max="<?= DATE_TODAY; ?>"><?php echo $errorMail; ?>
                                            </div>
                                            <br />
                                            <!-- -------------------- Foto ----------------------- -->
                                            <div class="LogoMdatos">
                                           
                                                <input type="file" id="mFoto"><?php echo $errorFoto; ?>
                                            </div>
                                            <br /> 
                                            <!-- -------------------- Boton ----------------------- -->
                                            <button type="submit" class='modificarDatos btn btn-primary btn-lg'>
                                            <p class="text-center h1 fw-bold">Enviar</p>
                                            </button>
                                            <br />    <br />    <br /> 
                                            <!-- -------------------- Boton ----------------------- -->
                                            <button type="submit" class='modificarDatosBorrar' name="delete">
                                            <p class="text-center h1 fw-bold">Borrar Cuenta</p>
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
<?php include_once "admin/templates/pie.php"; ?>