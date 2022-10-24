<?php
include "admin/templates/cabecera.php";
include getIdioma("iniciosesion.php");

$user = $password = $linea = "";
$errorUser = $errorPassword = "";

if (!empty($_POST)) {
    $_user = htmlspecialchars($_POST["user"]);
    $_password = htmlspecialchars($_POST["password"]);
    $linea;

    if(!empty($_user)){
        $linea = getLineaFrom($_user);
        if($linea !== ""){
            $user = $_user;
            if(!empty($_password)){
                $_password = md5($_password);
                if($_password === getDato(LINE_PASS, $linea)){
                    iniciarSesion($linea);
                }else{
                    $errorPassword = $lang["error_login_pass"];
                }
            }else{
                $errorPassword = $lang["error_vacio"];
            }
        }else{
            $errorUser = $lang["error_login_user"];
        }
    }else{
        $errorUser = $lang["error_vacio"];
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
                                    if (isset($_SESSION[SESSION_USER])) {
                                        include "admin/templates/sesionIniciada.php";
                                    }
                                    ?>

                                    <div>
                                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?php echo $lang["iniciosesion"]; ?></p>
                                        <form method="post">
                                            <!-- User -->
                                            <div class="form-outline mb-4">
                                                <?php echo $errorUser ?>
                                                <input type="text" id="form2Example1" class="form-control" name="user" value="<?php echo $user; ?>" />
                                                <label class="form-label" for="form2Example1"><?php echo $lang["username"]; ?></label>
                                            </div>

                                            <!-- Contraseña -->
                                            <div class="form-outline mb-4">
                                                <?php echo $errorPassword ?>
                                                <input type="password" id="form2Example2" class="form-control" name="password" />
                                                <label class="form-label" for="form2Example2"><?php echo $lang["password"]; ?></label>
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
                                        <?php echo $lang["noregistrado"]; ?>
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
<?php include "admin/templates/pie.php" ?>