<?php include "templates/cabecera.php" ?>
 <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="container h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="card text-black" style="border-radius: 25px;">
                                <div class="card-body p-md-5">
                                    <div class="row justify-content-center">
                                        <div>
                                            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Iniciar Sesion</p>
                                            <form>
                                                <!-- Email -->
                                                <div class="form-outline mb-4">
                                                    <input type="email" id="form2Example1" class="form-control" />
                                                    <label class="form-label" for="form2Example1">Correo eléctronico</label>
                                                </div>

                                                <!-- Contraseña -->
                                                <div class="form-outline mb-4">
                                                    <input type="password" id="form2Example2" class="form-control" />
                                                    <label class="form-label" for="form2Example2">Contraseña</label>
                                                </div>

                                                <!-- Recordar contraseña -->
                                                <div class="row mb-4">
                                                    <div class="col d-flex justify-content-center">
                                                        <!-- Checkbox -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                                            <label class="form-check-label" for="form2Example31"> Recuerdame </label>
                                                        </div>
                                                    </div>


                                                    <div class="col">
                                                        <!-- Simple link -->
                                                        <a href="#!">Olvidé la contraseña</a>
                                                    </div>
                                                    <br><br>
                                                    <!-- Submit button -->
                                                    <div class="d-flex justify-content-center">
                                                        <button type="button" class="btn btn-primary btn-lg">Iniciar Sesion</button>
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
        </div>



        <?php include "templates/pie.php" ?>