<?php include "templates/cabecera.php" ?>

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
                                            <div>
                                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Registrarse</p>

                                                <form class="mx-1 mx-md-4">

                                                    <div class="d-flex flex-row align-items-center mb-4">

                                                        <div class="form-outline flex-fill mb-0">
                                                            <input type="text" id="form3Example1c" class="form-control" />
                                                            <label class="form-label" for="form3Example1c">Tu nombre</label>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">

                                                        <div class="form-outline flex-fill mb-0">
                                                            <input type="email" id="form3Example3c" class="form-control" />
                                                            <label class="form-label" for="form3Example3c">Tu correo electronico</label>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">

                                                        <div class="form-outline flex-fill mb-0">
                                                            <input type="password" id="form3Example4c" class="form-control" />
                                                            <label class="form-label" for="form3Example4c">Contraseña</label>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">

                                                        <div class="form-outline flex-fill mb-0">
                                                            <input type="password" id="form3Example4cd" class="form-control" />
                                                            <label class="form-label" for="form3Example4cd">Repite la contraseña</label>
                                                        </div>
                                                    </div>

                                                    <div class="form-outline flex-fill mb-4">
                                                        <input type="text" id="form3Example1c" class="form-control" />
                                                        <label class="form-label" for="form3Example1c">Tu fecha de nacimiento</label>
                                                    </div>
                                            </div>

                                            <div class="d-flex flex-row align-items-center mb-1">
                                                <input class="form-control" type="file" id="formFile">
                                            </div>


                                            <label for="formFile" class="form-label">Ingresa tu Avatar</label>
                                            <br><br>

                                            <div class="form-check d-flex justify-content-center mb-5">
                                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                                                <label class="form-check-label" for="form2Example3">
                                                    Acepto los <a href="#!">términos y condiciones</a>
                                                </label>
                                            </div>

                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                <button type="button" class="btn btn-primary btn-lg">Registrarse</button>
                                            </div>
                                            <div class="d-flex">
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
<?php include "templates/pie.php" ?>