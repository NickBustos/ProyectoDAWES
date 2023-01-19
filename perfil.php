<?php
include 'admin/templates/cabecera.php';
// Iniciamos el id a -1 para el caso de que el usuario no haya iniciado sesión y no esté mirando ningún perfil
$idUsuario = -1;
// Si a iniciado sesión se coge su id
if (isset($_SESSION[SESSION_ID])) {
    $idUsuario = $_SESSION[SESSION_ID];
}
// Si hay get (ha entrado a enlace de batalla) se coge el id del usuario creador de la batalla
if (isset($_GET) && !empty($_GET) && isset($_GET["usuario"])) {
    $_idUsuario = htmlspecialchars($_GET["usuario"]);
    if (preg_match('/^\d+$/', $_idUsuario) == 1 && count(select(["id"], "usuario", ["id", $_idUsuario])) > 0) {
        $idUsuario = $_idUsuario;
    }
}
// Si hay usuario guarda todos sus datos en el array $datosusuario
$datosUsuario = [];
if ($idUsuario > -1) {
    $datosUsuario = select(["nombreusuario"], "usuario_credencial", ["id_usuario", $idUsuario])[0];
    $datosUsuario += select(["*"], "usuario", ["id", $idUsuario])[0];
}
//var_dump($datosUsuario);

/* 
Orden de datos:
[nombreusuario, fechaNacimiento, foto, mail, modovis, idioma, rol,
num_elementos_creados, num_batallas_creadas, num_batallas_votadas, 
num_batallas_ignoradas, num_batallas_denunciadas, puntos_troll]
*/
?>

<section>
    <div>
        <div class="text-center main-text">
            <h4><?php
                if ($idUsuario !== -1) {
                    echo $datosUsuario[PERFIL_USUARIO]; // NOMBREUSUARIO
                } else {
                    echo $lang["unete"];
                }
                ?>
            </h4>
            <br>
            <div class="medallas">
                <?php
                if ($idUsuario !== -1) {
                    // MEDALLAS
                    $nivelCreador = "";
                    if ($datosUsuario[PERFIL_BATALLAS_CREADAS] >= 1000) {
                        //vicioso
                        $nivelCreador = $lang["bat_creadas_3"];
                    } else if ($datosUsuario[PERFIL_BATALLAS_CREADAS] >= 100) {
                        //adicto
                        $nivelCreador =  $lang["bat_creadas_2"];
                    } else if ($datosUsuario[PERFIL_BATALLAS_CREADAS] >= 10) {
                        //comprometido
                        $nivelCreador = $lang["bat_creadas_1"];
                    }

                    if (!empty($nivelCreador)) echo "<table class='medallaTabla'><tr><td>{$nivelCreador}</td></tr><tr><td><img src='https://cdn-icons-png.flaticon.com/512/3176/3176294.png' alt=''></td></tr></table>";

                    $nivelVotos = "";
                    if ($datosUsuario[PERFIL_BATALLAS_VOTADAS] >= 1000) {
                        //actvista
                        $nivelVotos = $lang["bat_votadas_3"];
                    } else if ($datosUsuario[PERFIL_BATALLAS_VOTADAS] >= 100) {
                        //sindicalista
                        $nivelVotos = $lang["bat_votadas_2"];
                    } else if ($datosUsuario[PERFIL_BATALLAS_VOTADAS] >= 10) {
                        //votante
                        $nivelVotos = $lang["bat_votadas_1"];
                    }

                    if (!empty($nivelVotos)) echo "<table class='medallaTabla'><tr><td>{$nivelVotos}</td></tr><tr><td><img src='https://cdn-icons-png.flaticon.com/512/5551/5551284.png' alt=''></td></tr></table>";

                    $nivelDenuncias = "";
                    if ($datosUsuario[PERFIL_BATALLAS_DENUNCIADAS] >= 1000) {
                        //policia
                        $nivelDenuncias = $lang["bat_denunciadas_3"];
                    } else if ($datosUsuario[PERFIL_BATALLAS_DENUNCIADAS] >= 100) {
                        //moderador
                        $nivelDenuncias = $lang["bat_denunciadas_2"];
                    } else if ($datosUsuario[PERFIL_BATALLAS_DENUNCIADAS] >= 10) {
                        //vigilante
                        $nivelDenuncias = $lang["bat_denunciadas_1"];
                    }

                    if (!empty($nivelDenuncias)) echo "<table class='medallaTabla'><tr><td>{$nivelDenuncias}</td></tr><tr><td><img src='https://cdn-icons-png.flaticon.com/512/3176/3176294.png' alt=''></td></tr></table>";
                }
                ?>
            </div><br>
        </div>
        <div class="row d-flex justify-content-center">
            <img class="rounded-circle" src="
                <?php if ($idUsuario !== -1) {
                    echo $datosUsuario[PERFIL_FOTO];
                } else {
                    echo "imagenes/nouser.png";
                } ?>" alt="">
            <div class="text-center"><br>
                <p> <?= $lang["tituloDescripcion"] ?></p>
                <?php
                if ($idUsuario !== -1) {
                    $totalBatallas = $datosUsuario[PERFIL_BATALLAS_CREADAS];
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
                if ($idUsuario !== -1) {
                    $totalBatallas = $datosUsuario[PERFIL_BATALLAS_CREADAS];
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
                                        <img class="imagenUser" src="' 
                                        . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento1"], "foto")[0] . '">
                                        <span class="btn-circle btn-or">OR</span> 
                                        <img class="imagenUser" src="' 
                                        . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento2"], "foto")[0] . '">
                                        <div class="card-body">
                                            <h4 class="card-title">Batalla #' . $i + 1 . '</h4>
                                            <p class="card-text">' 
                                            . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento1"], "nombre")[0] . 
                                            ' vs '
                                            . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento2"], "nombre")[0] . 
                                            '</p>
                                        </div>
                                    </div>';
                            $acum = $acum + 1;
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