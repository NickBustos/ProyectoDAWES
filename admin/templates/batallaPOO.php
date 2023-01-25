<div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <?php
                                /**
                                 * Coge una batalla aleatorio o en caso de que estes viendo o haciendo operaciones con una esa
                                 * Te muestra sus datos si no has votado con las opciones de votar (votar elemento1, votar elemento2, ignorar y denunciar)
                                 * Si has votado te muestra los resultados y el boton de siguiente
                                 */
                                $batalla = Batalla::getBatalla();
                                if ($batalla == null) { // No hay batalla disponible
                                    echo "<p class='text-center fw-bold h1'>" . $lang["noBatallasDisponibles"] . "</p>";
                                    echo "<a type='button' class='submitBatalla btn btn-primary btn-lg' href='crear.php'>" . $lang["subirBatalla"] . "</a>";
                                } else {
                                    // Guardar datos de batalla en sesión para poder hacer operaciones con ellos y volver luego a la misma batalla
                                    $_SESSION[SESSION_CURRENT_BATTLE] = $batalla->id;
                                    echo $batalla->printComplex($usuario);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>