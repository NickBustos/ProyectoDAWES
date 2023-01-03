<?php
include 'admin/templates/cabecera.php';
?>

<section>
    <div>
        <div class="text-center main-text">
            <h4><?php
                if ((isset($_SESSION[SESSION_ID]))) {
                    echo $_SESSION[SESSION_USER];
                } else {
                    echo $lang["unete"];
                }
                ?>
            </h4>
            <br>
            <div class="medallas">
                <img src="https://cdn-icons-png.flaticon.com/512/3176/3176294.png" alt=""><img src="https://cdn-icons-png.flaticon.com/512/5551/5551284.png" alt="">
            </div><br>
        </div>
        <div class="row d-flex justify-content-center">
            <img class="rounded-circle" src="
                <?php if (isset($_SESSION[SESSION_ID])) {
                    echo selectFromUsuario(["foto"])[0];
                } else {
                    echo "imagenes/nouser.png";
                } ?>" alt="">
            <div class="text-center"><br>
                <p> <?= $lang["tituloDescripcion"] ?></p>
                <?php
                if (isset($_SESSION[SESSION_ID])) {
                    $totalBatallas = selectFromUsuario(["num_batallas_creadas"])[0];
                    if ($totalBatallas == "1") {
                        echo  '<h6>' .
                            $lang["esteUsuario"] . $totalBatallas . $lang["batalla"] .
                            '</h6>';
                    } else {
                        echo  '<h6>' .
                            $lang["esteUsuario"] . $totalBatallas . $lang["batallas"] .
                            '</h6>';
                    }
                }
                ?>
            </div>
        </div><br><br>
        <div class="filaBatallas" style="margin-left:25px; margin-right:25px    ">
            <div class="row-center">
                <?php
                if (isset($_SESSION[SESSION_ID])) {
                    $totalBatallas = selectFromUsuario(["num_batallas_creadas"])[0];
                    echo "<br>";
                    if ($totalBatallas == "0") {
                        echo  '<h4>' .
                            $lang["sinBatallas"] .
                            '</h4>';
                    } else {
                        $acum = 0;
                        for ($i = 0; $i < $totalBatallas; $i++) {
                            $imagenBatallaU = '<div class="filaBatallas" style="margin-left:25px; margin-right:25px">
                            <div class="row-center">
                                <div class="card-group">
                                    <div class="card">
                                        <img class="imagenUser" src="' . infoBatalla(buscarBatalla($_SESSION[SESSION_ID])[$acum], "foto")[0] . '">
                                        <span class="btn-circle btn-or">OR</span> 
                                        <img class="imagenUser" src="' . infoBatalla(buscarBatalla($_SESSION[SESSION_ID])[$acum + 1], "foto")[0] . '">
                                        <div class="card-body">
                                            <h4 class="card-title">Batalla #' . $i + 1 . '</h4>
                                            <p class="card-text">' . infoBatalla(buscarBatalla($_SESSION[SESSION_ID])[$acum], "nombre")[0] . ' vs ' . infoBatalla(buscarBatalla($_SESSION[SESSION_ID])[$acum + 1], "nombre")[0] . '</p>
                                        </div>
                                    </div>';
                            $acum = $acum + $i + 1;

                            echo $imagenBatallaU;
                        }
                        echo "</div>
                        </div>";
                    }
                } else {
                    echo  '<h4>'
                        . $lang["registrateYCrea"] .
                        '</h4>';
                }

                ?>


            </div>
        </div><br><br>'








        <!--  '<div class="filaBatallas">
            <div class="row-center">
                <div class="card-group">
                    <div class="card">
                        <img class="card-img-top" data-src="#" alt="mario" style="height: 15px;">
                        <span class="btn-circle btn-or">OR</span>
                        <img class="card-img-top" data-src="#" alt="luigi" style="height: 15px;">
                        <div class="card-body">
                            <h4 class="card-title">Batalla #1</h4>
                            <p class="card-text">Mario vs Luigi</p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" data-src="holder.js/100x180/" alt="Nesquick" style="height: 15px;">
                        <span class="btn-circle btn-or">OR</span>
                        <img class="card-img-top" data-src="holder.js/100x180/" alt="Colacao" style="height: 15px;">
                        <div class="card-body">
                            <h4 class="card-title">Batalla #2</h4>
                            <p class="card-text">Colacao vs Nesquick</p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" data-src="holder.js/100x180/" alt="Foto1" style="height: 15px;">
                        <span class="btn-circle btn-or">OR</span>
                        <img class="card-img-top" data-src="holder.js/100x180/" alt="Foto2" style="height: 15px;">
                        <div class="card-body">
                            <h4 class="card-title">Batalla #3</h4>
                            <p class="card-text">Algo vs Cosa</p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" data-src="holder.js/100x180/" alt="Foto1" style="height: 15px;">
                        <span class="btn-circle btn-or">OR</span>
                        <img class="card-img-top" data-src="holder.js/100x180/" alt="Foto2" style="height: 15px;">
                        <div class="card-body">
                            <h4 class="card-title">Batalla #4</h4>
                            <p class="card-text">Pelado vs Hippie</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>'-->

    </div>
</section>
<?php
include "admin/templates/pie.php"
?>