<<<<<<< HEAD
<?php include "templates/cabecera.php";?>
    
=======
<?php include "templates/cabeceraRegistrarse.php" ?>

>>>>>>> main
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
                                                if($registrado){
                                                    echo 
                                                    "<p class='text-center h4 fw-bold mb-5 mx-1 mx-md-4 mt-4'>
                                                        Usuario registrado correctamente
                                                    </p>";
                                                    exit();
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
                                                            <?php echo $errorNombre ?>
                                                            <input type="text" name= "nombreDeUsuario"  id="form3Example1c" class="form-control" 
                                                                value="<?php echo $nombreUser;?>" />
                                                            <label class="form-label" for="form3Example1c">Tu nombre</label>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form-outline flex-fill mb-0">
                                                            <?php echo $errorMail ?>
                                                            <input type="email" name="correoUsuario" id="form3Example3c" class="form-control" />
                                                            <label class="form-label" for="form3Example3c">Tu correo electronico</label>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form-outline flex-fill mb-0">
                                                            <input type="password" name="contrasenaUsuario" id="form3Example4c" class="form-control" />
                                                            <label class="form-label" for="form3Example4c">Contraseña</label>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">

                                                        <div class="form-outline flex-fill mb-0">
                                                            <input type="password" name="reContrasenaUsuario" id="form3Example4cd" class="form-control" />
                                                            <label class="form-label" for="form3Example4cd">Repite la contraseña</label>
                                                        </div>
                                                    </div>


                                                    <!-- Fecha de nacimiento -->


                                                    <div class="form-outline flex-fill mb-4">
                                                        <?php echo $errorFecha ?>
                                                        <input type="date" id="form3Example1c" class="form-control"  
                                                            name = "fechaNac" min ="<?= $fechamin;?>"  max="<?=$fechamax;?>" 
                                                            value = "<?php echo $fechaNac; ?>">
                                                        <label class="form-label" for="form3Example1c">Tu fecha de nacimiento</label>
                                                    </div>
                                            </div>
                                            <?php echo $errorFile ?>
                                            <div class="d-flex flex-row align-items-center mb-1">
                                                <input class="form-control" name="avatar" type="file" id="formFile" multiple accept="image/png">
                                            </div>
                                            <label for="formFile" class="form-label">Ingresa tu Avatar</label>
                                            <br><br>

                                            <!-- Terminos y condiciones -->

                                            <div class="form-check d-flex justify-content-center mb-5">
                                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                                                <label class="form-check-label" for="form2Example3">
                                                    Acepto los <a href="#!">términos y condiciones</a>
                                                </label>
                                            </div>

<<<<<<< HEAD
                                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                        <button type="button" class="btn btn-primary btn-lg">Registrarse</button>
                                                    </div>
                                                    <div class="row d-flex justify-content-center">
                                                        <p class="form-text text-muted">
                                                            ¿Ya tienes una cuenta? Haz clíck <a href="iniciosesion.php">aquí</a>
                                                        </p>
                                                    </div>
                                                </form>
=======

                                            <!-- Botón registrarse -->

                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                <input type="submit" class="btn btn-primary btn-lg">
                                            </div>


                                            <!-- Inicio de sesión -->

                                            <div class="d-flex">
                                                <p class="form-text text-muted">
                                                    ¿Ya tienes una cuenta? Haz clíck <a href="iniciosesion.php">aquí</a>
                                                </p>
                                            </div>
                                            </form>
>>>>>>> main

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
<?php
    function validar_Password($password,&$error_password){
        if(strlen($password) < 8){
            $error_password = "La contraseña no puede tener menos de 8 caracteres";
            return false;
        }
        if(strlen($password) > 64){
            $error_password = "La contraseña no puede tener más de 64 caracteres";
            return false;
        }
        if(!preg_match(`[a-z]`, $password)){
            $error_password = "La contraseña debe contener al menos una letra minúscula";
            return false;
        }
        if(!preg_match(`[A-Z]`, $password)){
            $error_password = "La contraseña debe contener al menos una letra mayúscula";
            return false;
        }
        if(!preg_match(`[0-9]`, $password)){
            $error_password = "La contraseña debe contener al menos un carácter númerico";
            return false;
        }
        $error_password = "";
        return true;
    }
    
?>
<?php include "templates/pie.php";?>

    