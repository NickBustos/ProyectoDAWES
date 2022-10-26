<?php
include "admin/templates/cabecera.php";
include getIdioma("registrarse.php");

$user = $avatar = $fechaNac = $mail = $pass = "";
$_user = $_fechaNac = $_mail = $_pass1 = $_pass2 = "";
$errorUser = $errorAvatar = $errorFecha = $errorMail = $errorPass = "";

if (!empty($_POST)) {
    //---------------------------- USER --------------------------------
    $_user = htmlspecialchars($_POST["user"]);
    if (!empty($_user)) {
        if (preg_match(PATTERN_USER, $_user)) {
            if (!preg_match(PATTERN_CHARACTER_SEPARATOR, $_user)) {
                $user = $_user;
            } else {
                $errorUser = $lang["error_character_separator"];
            }
        } else {
            $errorUser = $lang["error_user_pattern"];
        }
    } else {
        $errorUser = $lang["error_vacio"];
    }
    //---------------------------- PASS --------------------------------
    $_pass1 = htmlspecialchars($_POST["password1"]);
    $_pass2 = htmlspecialchars($_POST["password2"]);
    if (!empty($_pass1)) {
        if (
            preg_match(PATTERN_PASS_MINUS, $_pass1) && preg_match(PATTERN_PASS_MAYUS, $_pass1)
            && preg_match(PATTERN_PASS_NUMBER, $_pass1) && strlen($_pass1) <= MAX_PASS_LENGTH
            && strlen($_pass1) >= MIN_PASS_LENGTH
        ) {
            if (!empty($_pass2) && $_pass1 === $_pass2) {
                $pass = $_pass1;
            } else {
                $errorPass = $lang["error_pass_match"];
            }
        } else {
            $errorPass = $lang["error_pass_pattern"];
        }
    } else {
        $errorPass = $lang["error_vacio"];
    }
    //---------------------------- DATE --------------------------------
    $_fechaNac = htmlspecialchars($_POST["fechaNac"]);
    if (!empty($_fechaNac)) {
        if (validarMayorEdad($_fechaNac)) {
            $fechaNac = $_fechaNac;
        } else {
            $errorFecha = $lang["error_date_year"];
        }
    } else {
        $errorFecha = $lang["error_vacio"];
    }
    //---------------------------- MAIL --------------------------------
    $_mail = htmlspecialchars($_POST["correoUsuario"]);
    if (!empty($_mail)) {
        if (filter_var($_mail, FILTER_VALIDATE_EMAIL)) {
            if (!preg_match(PATTERN_CHARACTER_SEPARATOR, $_mail)) {
                $mail = $_mail;
            } else {
                $errorMail = $lang["error_character_separator"];
            }
        } else {
            $errorMail = $lang["error_mail"];
        }
    } else {
        $errorMail = $lang["error_vacio"];
    }
    //---------------------------- FILE --------------------------------

    if (
        !empty($_FILES) && !empty($_FILES["avatar"])
        && !empty($_FILES["avatar"]["tmp_name"])
    ) {
        if ($_FILES["avatar"]["type"] === "image/png") {
            if ($_FILES['avatar']['size'] <= 1000000) { //1 mega
                $avatar = getImage($_FILES["avatar"]);
            } else {
                $errorAvatar = $lang["error_file_size"];
            }
        } else {
            $errorAvatar = $lang["error_file_type"];
        }
    } else {
        $errorAvatar = $lang["error_vacio"];
    }
    //---------------------------- RGST --------------------------------
    if (!empty($user) && !empty($pass) && !empty($fechaNac) && !empty($mail) && !empty($avatar)) {
        $userData = [$user, md5($pass), $mail, $fechaNac, $avatar];
        registerUser($userData);
        iniciarSesion(join(LINE_SEPARATOR, $userData));
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
                                            if (isset($_SESSION[SESSION_USER])) {
                                                include "admin/templates/sesioniniciada.php";
                                            }
                                            ?>
                                            <div>
                                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?php echo $lang["registrarse"]; ?></p>

                                                <form class="mx-1 mx-md-4" method="post" enctype="multipart/form-data">

                                                    <!-- INICIO DE FORMULARIO -->

                                                    <form class="mx-1 mx-md-4" action='<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>' method="post">
                                                        <div class="d-flex flex-row align-items-center mb-4">


                                                            <!-- Nombre del usuario -->

                                                            <div class="form-outline flex-fill mb-0">
                                                                <?php echo $errorUser ?>
                                                                <input type="text" name="user" id="form3Example1c" class="form-control" value="<?php echo $user; ?>" />
                                                                <label class="form-label" for="form3Example1c"><?php echo $lang["username"]; ?></label>
                                                            </div>
                                                        </div>


                                                        <!-- Correo electronico -->

                                                        <div class="d-flex flex-row align-items-center mb-4">
                                                            <div class="form-outline flex-fill mb-0">
                                                                <?php echo $errorMail ?>
                                                                <input type="email" name="correoUsuario" id="form3Example3c" class="form-control" value="<?php echo $mail; ?>" />
                                                                <label class="form-label" for="form3Example3c"><?php echo $lang["correo"]; ?></label>
                                                            </div>
                                                        </div>


                                                        <!-- Contraseña -->

                                                        <div class="d-flex flex-row align-items-center mb-4">
                                                            <div class="form-outline flex-fill mb-0">
                                                                <?php echo $errorPass ?>
                                                                <input type="password" name="password1" id="form3Example4c" class="form-control" />
                                                                <label class="form-label" for="form3Example4c"><?php echo $lang["password"]; ?></label>
                                                            </div>
                                                        </div>


                                                        <!-- Repetir contraseña -->

                                                        <div class="d-flex flex-row align-items-center mb-4">

                                                            <div class="form-outline flex-fill mb-0">
                                                                <input type="password" name="password2" id="form3Example4cd" class="form-control" />
                                                                <label class="form-label" for="form3Example4cd"><?php echo $lang["passwordrepetida"]; ?></label>
                                                            </div>
                                                        </div>


                                                        <!-- Fecha de nacimiento -->


                                                        <div class="form-outline flex-fill mb-4">
                                                            <?php echo $errorFecha ?>
                                                            <input type="date" id="form3Example1c" class="form-control" name="fechaNac" min="<?= DATE_FIRST; ?>" max="<?= DATE_TODAY; ?>" value="<?php echo $fechaNac; ?>">
                                                            <label class="form-label" for="form3Example1c"><?php echo $lang["fecha"]; ?></label>
                                                        </div>
                                            </div>
                                            <?php echo $errorAvatar ?>
                                            <div class="d-flex flex-row align-items-center mb-1">
                                                <input class="form-control" name="avatar" type="file" id="formFile" multiple accept="image/png">
                                            </div>
                                            <label for="formFile" class="form-label"><?php echo $lang["avatar"]; ?></label>
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
                                                    <?php echo $lang["registrado"]; ?>
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
<?php include "admin/templates/pie.php" ?>