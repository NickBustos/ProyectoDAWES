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
                        if ($totalBatallas > 0) { // PAGINACIÓN
                            $paginas = ceil($totalBatallas / ELEMENTS_PAGE);

                            $paginaActual = 1;
                            if (isset($_GET["pagina"])) {
                                $destino = htmlspecialchars($_GET["pagina"]);
                                if (is_numeric($destino)) {
                                    $destino = floor($destino);
                                    if ($destino >= 1 && $destino <= $paginas) {
                                        $paginaActual = $destino;
                                    }
                                }
                            }
                            $offset = ($paginaActual - 1) * ELEMENTS_PAGE;
                            //$sql = "SELECT id FROM usuario_batalla WHERE id = '" . $idUsuario . "  LIMIT BY " . ELEMENTS_PAGE . "'";
                            $id = "id1";
                            $sql = "SELECT id FROM usuario_batalla ";
                            if (isset($_SESSION[SESSION_ID])) {
                                $sql .= "WHERE id_usuario = '" . $_SESSION[SESSION_ID] . "' AND accion LIKE ('crear')";
                                $id = "id2";
                            }
                            $sql .= " ORDER BY id_batalla LIMIT {$offset}, " . ELEMENTS_PAGE;
                            $elementos = $conexion->query($sql)->fetchAll(PDO::FETCH_NUM);

                            echo "
                            </form>
                            <div>
                            <div>
                            <div>";
                            // Por cada elemento crea un formulario con un boton de submit que es la imagen del elemento
                            if ($paginaActual == 1) {
                                $acum = 0;
                            } else{
                                $acum = $paginaActual + 2;
                            }


                            foreach ($elementos as $elemento) {
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
                                                <h4 class="card-title">Batalla #' . $acum + 1 . '</h4>
                                                <p class="card-text">'
                                    . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento1"], "nombre")[0] .
                                    ' vs '
                                    . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento2"], "nombre")[0] .
                                    '</p>
                                            </div>
                                        </div>';
                                $acum = $acum + 1;
                                echo $imagenBatallaU;
                ?>

                <?php
                                // PAGINACION
                            }
                            echo "</div></div><br/>";
                            if ($paginas > 1) {

                                $enlaces = "<div class='rowBatalla text-center fw-bold h1'>
                                <div class='bando' style='display:inline-block; border:0'>";
                                if ($paginaActual > 1) {
                                    $anterior = $paginaActual - 1;
                                    $enlaces .= "<a href='{$_SERVER["PHP_SELF"]}?pagina={$anterior}'><</a>";
                                }
                                for ($i = 1; $i <= $paginas; $i++) {
                                    $enlaces .= "<a href='{$_SERVER["PHP_SELF"]}?pagina={$i}'> {$i} </a>";
                                }
                                if ($paginaActual < $paginas) {
                                    $siguiente = $paginaActual + 1;
                                    $enlaces .= "<a href='{$_SERVER["PHP_SELF"]}?pagina={$siguiente}'>></a>";
                                }
                                $enlaces .= "</div></div></div>";
                                echo $enlaces;
                            }
                        }
                    }
                } else {
                    echo  '<h4>'
                        . $lang["registrateYCrea"] .
                        '</h4>';
                }

                ?>


            </div>
        </div><br><br>'

    </div>
</section>
<?php
include "admin/templates/pie.php"
?>