<?php
include "templates/cabecera.php";
include 'Configuraciones\funciones.php';
//ESTRUCTURA HTML DE UN MENSAJE DE CONFIRMACIÓN. *****************
$confirmacionCorreo = CONFIRMACION_CORREO;
//ESTRUCTURA HTML DE UN MENSAJE DE CONFIRMACIÓN POR CORREO. *****************
$confirmacionCorreo = wordwrap($confirmacionCorreo, 70, "\r\n");

$user = $avatar = $fechaNac = $mail = $pass = "";
$_user = $_fechaNac = $_mail = $_pass1 = $_pass2 = "";
$errorUser = $errorAvatar = $errorFecha = $errorMail = $errorPass1 = $errorPass2 = "";
$registrado = false;

if (!empty($_POST)) {
    //---------------------------- USER --------------------------------
    $_user = htmlspecialchars($_POST["user"]);
    if (validarUser($_user, $errorUser)) {
        $user = $_user;
    }
    //---------------------------- PASS --------------------------------
    $_pass1 = htmlspecialchars($_POST["password1"]);
    $_pass2 = htmlspecialchars($_POST["password2"]);
    if (validarBothPasswords($_pass1, $_pass2, $errorPass1, $errorPass2)) {
        $pass = $_pass1;
    }
    //---------------------------- DATE --------------------------------
    $_fechaNac = htmlspecialchars($_POST["fechaNac"]);
    if (validarFechaNac($_fechaNac, $errorFecha)) {
        $fechaNac = $_fechaNac;
    }
    //---------------------------- MAIL --------------------------------
    $_mail = htmlspecialchars($_POST["correoUsuario"]);
    if (validarMail($_mail, $errorMail)) {
        $mail = $_mail;
    }
    //---------------------------- FILE --------------------------------
    if (validarAvatar($_FILES, $errorAvatar)) {
        $avatar = getImage($_FILES["avatar"]);
        //GUARDAR
    }
    //---------------------------- RGST --------------------------------
    if (!empty($user) && !empty($pass) && !empty($fechaNac) && !empty($mail) && !empty($avatar)) {
        //REGISTRAR (GUARDAR DATOS)
        $registrado = true;
        //mail($mail, 'Confirmar cuenta',$confirmacionCorreo);
    }
}
?>

<div class="container">

    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

                    <section>
                        <div class="container h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="card text-black" style="border-radius: 25px;">
                                    <div class="card-body p-md-5">
                                        <div class="row justify-content-center">
                                            <?php
                                            if ($registrado) {
                                                bienvenido($user, $avatar);
                                            }
                                            ?>
                                            <div>
                                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Registrarse</p>

                                                <form class="mx-1 mx-md-4" method="post" enctype="multipart/form-data">

                                                    <!-- INICIO DE FORMULARIO -->

                                                    <form class="mx-1 mx-md-4" action='<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>' method="post">
                                                        <div class="d-flex flex-row align-items-center mb-4">


                                                            <!-- Nombre del usuario -->

                                                            <div class="form-outline flex-fill mb-0">
                                                                <?php echo $errorUser ?>
                                                                <input type="text" name="user" id="form3Example1c" class="form-control" value="<?php echo $user; ?>" />
                                                                <label class="form-label" for="form3Example1c">Tu nombre</label>
                                                            </div>
                                                        </div>


                                                        <!-- Correo electronico -->

                                                        <div class="d-flex flex-row align-items-center mb-4">
                                                            <div class="form-outline flex-fill mb-0">
                                                                <?php echo $errorMail ?>
                                                                <input type="email" name="correoUsuario" id="form3Example3c" class="form-control" value="<?php echo $mail; ?>" />
                                                                <label class="form-label" for="form3Example3c">Tu correo electronico</label>
                                                            </div>
                                                        </div>


                                                        <!-- Contraseña -->

                                                        <div class="d-flex flex-row align-items-center mb-4">
                                                            <div class="form-outline flex-fill mb-0">
                                                                <?php echo $errorPass1 ?>
                                                                <input type="password" name="password1" id="form3Example4c" class="form-control" />
                                                                <label class="form-label" for="form3Example4c">Contraseña</label>
                                                            </div>
                                                        </div>


                                                        <!-- Repetir contraseña -->

                                                        <div class="d-flex flex-row align-items-center mb-4">

                                                            <div class="form-outline flex-fill mb-0">
                                                                <?php echo $errorPass2 ?>
                                                                <input type="password" name="password2" id="form3Example4cd" class="form-control" />
                                                                <label class="form-label" for="form3Example4cd">Repite la contraseña</label>
                                                            </div>
                                                        </div>


                                                        <!-- Fecha de nacimiento -->


                                                        <div class="form-outline flex-fill mb-4">
                                                            <?php echo $errorFecha ?>
                                                            <input type="date" id="form3Example1c" class="form-control" name="fechaNac" min="<?= DATE_FIRST; ?>" max="<?= DATE_TODAY; ?>" value="<?php echo $fechaNac; ?>">
                                                            <label class="form-label" for="form3Example1c">Tu fecha de nacimiento</label>
                                                        </div>
                                            </div>
                                            <?php echo $errorAvatar ?>
                                            <div class="d-flex flex-row align-items-center mb-1">
                                                <input class="form-control" name="avatar" type="file" id="formFile" multiple accept="image/png">
                                            </div>
                                            <label for="formFile" class="form-label">Ingresa tu Avatar</label>
                                            <br>

                                            <!-- <div class="form-check d-flex justify-content-center mb-5">
                                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                                                <label class="form-check-label" for="form2Example3">
                                                    Acepto los <a href="#!">términos y condiciones</a>
                                                </label>
                                            </div> -->


                                            <!-- Botón registrarse -->

                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                <input type="submit" class="btn btn-primary btn-lg">
                                            </div>


                                            <!-- Inicio de sesión -->

                                            <div class="d-flex justify-content-center">
                                                <p class="form-text text-muted">
                                                    ¿Ya tienes una cuenta? Haz clíck <a href="iniciosesion.php">aquí</a>
                                                </p>
                                            </div>
                                            </form>

                                        </div>
                                        <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </section>

            </div>
        </div>
    </div>
</div>
</div>
<br>
<br>
<?php include "templates/pie.php" ?>