<?php
include "templates/cabeceraInicio.php";
include 'Configuraciones\funciones.php';

$user = $password = $linea = "";
$errorUser = $errorPassword = "";
$registrado = false;


if (!empty($_POST)) {
    $_user = htmlspecialchars($_POST["user"]);
    $_password = htmlspecialchars($_POST["password"]);
    puedoEntrar($_user, $_password, $errorUser, $errorPassword);
    if (empty($errorUser)) {
        $user = $_user;
        if (empty($errorPassword)) {
            $registrado = true;
        }
    }
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
                                    <?php
                                    if ($registrado) {
                                        bienvenido($user, 'multimedia/imagenes/' . $user . '.png');
                                    }
                                    ?>

                                    <div>
                                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Iniciar Sesion</p>
                                        <form method="post">
                                            <!-- User -->
                                            <div class="form-outline mb-4">
                                                <?php echo $errorUser ?>
                                                <input type="text" id="form2Example1" class="form-control" name="user" value="<?php echo $user; ?>" />
                                                <label class="form-label" for="form2Example1">Nombre usuario</label>
                                            </div>

                                            <!-- Contraseña -->
                                            <div class="form-outline mb-4">
                                                <?php echo $errorPassword ?>
                                                <input type="password" id="form2Example2" class="form-control" name="password" />
                                                <label class="form-label" for="form2Example2">Contraseña</label>
                                            </div>

                                            <!-- <div class="row mb-4">
                                                <div class="col d-flex justify-content-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                                        <label class="form-check-label" for="form2Example31"> Recuerdame </label>
                                                    </div>
                                                </div> -->


                                            <!-- <div class="col">
                                                    <a href="#!">Olvidé la contraseña</a>
                                                </div> -->
                                            <br>

                                            <!-- Submit button -->
                                            <div class="d-flex justify-content-center">
                                                <input type="submit" class="btn btn-primary btn-lg">
                                            </div>
                                            <br>
                                            <br>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <p class="form-text text-muted">
                                            ¿No tienes cuenta? Haz clíck <a href="registrarse.php">aquí</a>
                                        </p>
                                    </div>
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

<br>
<br>
<br>
<br>
<?php include "templates/pie.php" ?>