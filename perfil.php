<?php
include 'admin/templates/cabecera.php';
// Iniciamos el id a -1 para el caso de que el usuario no haya iniciado sesión y no esté mirando ningún perfil
$idUsuario = -1;
// Si a iniciado sesión se coge su id
if (isset($_SESSION[SESSION_ID]) && isset($_SESSION[SESSION_USER])) {
    $idUsuario = $_SESSION[SESSION_ID];
    $nombreUsuario = $_SESSION[SESSION_USER];
}
// Si hay get (ha entrado a enlace de batalla) se coge el id del usuario creador de la batalla
if (isset($_GET) && !empty($_GET) && isset($_GET["usuario"])) {
    $_idUsuario = htmlspecialchars($_GET["usuario"]);
    if (preg_match('/^\d+$/', $_idUsuario) == 1 && count(BD::select(["id"], "usuario", ["id", $_idUsuario])) > 0) {
        $idUsuario = $_idUsuario;
        $nombreUsuario = BD::select(["nombreusuario"], "usuario_credencial", ["id_usuario", $idUsuario])[0][0];
    }
}


// Si hay id_usuario > -1 crea una instancia de clase de $usuario
$usuario = null;
if ($idUsuario > -1) {
    $usuario = new Usuario($idUsuario, $nombreUsuario);
}

?>

<section>
    <div>
        <div class="text-center main-text">
            <h4><?php
                if ($usuario != null) {
                    echo $usuario->nombreusuario;
                } else {
                    echo $lang["unete"];
                }
                ?>
            </h4>
            <br>
            <div class="medallas">
                <?php
                if ($usuario != null) {
                    // MEDALLAS
                    $nivelCreador = "";
                    if ($usuario->num_batallas_creadas >= 1000) {
                        //vicioso
                        $nivelCreador = $lang["bat_creadas_3"];
                    } else if ($usuario->num_batallas_creadas >= 100) {
                        //adicto
                        $nivelCreador =  $lang["bat_creadas_2"];
                    } else if ($usuario->num_batallas_creadas >= 10) {
                        //comprometido
                        $nivelCreador = $lang["bat_creadas_1"];
                    }

                    if (!empty($nivelCreador)) echo "<table class='medallaTabla'><tr><td>{$nivelCreador}</td></tr><tr><td><img src='https://cdn-icons-png.flaticon.com/512/3176/3176294.png' alt=''></td></tr></table>";

                    $nivelVotos = "";
                    if ($usuario->num_batallas_votadas >= 1000) {
                        //actvista
                        $nivelVotos = $lang["bat_votadas_3"];
                    } else if ($usuario->num_batallas_votadas >= 100) {
                        //sindicalista
                        $nivelVotos = $lang["bat_votadas_2"];
                    } else if ($usuario->num_batallas_votadas >= 10) {
                        //votante
                        $nivelVotos = $lang["bat_votadas_1"];
                    }

                    if (!empty($nivelVotos)) echo "<table class='medallaTabla'><tr><td>{$nivelVotos}</td></tr><tr><td><img src='https://cdn-icons-png.flaticon.com/512/5551/5551284.png' alt=''></td></tr></table>";

                    $nivelDenuncias = "";
                    if ($usuario->num_batallas_denunciadas >= 1000) {
                        //policia
                        $nivelDenuncias = $lang["bat_denunciadas_3"];
                    } else if ($usuario->num_batallas_denunciadas >= 100) {
                        //moderador
                        $nivelDenuncias = $lang["bat_denunciadas_2"];
                    } else if ($usuario->num_batallas_denunciadas >= 10) {
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
                <?php if ($usuario != null) {
                    echo $usuario->foto;
                } else {
                    echo "imagenes/nouser.png";
                } ?>" alt="">
            <div class="text-center"><br>
                <p> <?= $lang["tituloDescripcion"] ?></p>
                <?php
                if ($usuario != null) {
                    $totalBatallas = $usuario->num_batallas_creadas;
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
                if ($usuario != null) {
                    $totalBatallas = $usuario->num_batallas_creadas;
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

                            $sql =
                                "SELECT id_batalla FROM usuario_batalla 
                                WHERE id_usuario = '{$idUsuario}' AND accion LIKE ('crear')
                                ORDER BY id_batalla LIMIT {$offset}, " . ELEMENTS_PAGE;
                            $batallas = BD::realizarSql(BD::crearConexion(), $sql, []);

                            foreach ($batallas as $batalla) {
                                $idsElementos = BD::select(["id_elemento1", "id_elemento2"], "batalla_elemento", ["id_batalla", $batalla[0]])[0];
                                $infoElemento1 = BD::select(["nombre, foto"], "elemento", ["id", $idsElementos[0]])[0];
                                $infoElemento2 = BD::select(["nombre, foto"], "elemento", ["id", $idsElementos[1]])[0];
                                echo
                                "<div>
                                    <img class='imagenUser' src='{$infoElemento1[1]}'>
                                    <span class='btn-circle btn-or'>OR</span>
                                    <img class='imagenUser' src='{$infoElemento2[1]}'>
                                    <div class='card-body'>
                                        <p class='card-text'>{$infoElemento1[0]} vs {$infoElemento2[0]}</p>
                                    </div>
                                </div>";
                            }

                ?>

                <?php
                            // PAGINACION
                            if ($paginas > 1) {

                                $origen = htmlspecialchars($_SERVER["PHP_SELF"]) . "?";
                                if (!empty($_GET)) {
                                    $origen .= "usuario={$idUsuario}&";
                                }
                                $enlaces = "
                                <div class='rowBatalla text-center fw-bold h1'>
                                <div class='bando' style='display:inline-block; border:0'>";
                                if ($paginaActual > 1) {
                                    $anterior = $paginaActual - 1;
                                    $enlaces .= "<a href='{$origen}pagina={$anterior}'><</a>";
                                }
                                for ($i = 1; $i <= $paginas; $i++) {
                                    $enlaces .= "<a href='{$origen}pagina={$i}'> {$i} </a>";
                                }
                                if ($paginaActual < $paginas) {
                                    $siguiente = $paginaActual + 1;
                                    $enlaces .= "<a href='{$origen}pagina={$siguiente}'>></a>";
                                }
                                $enlaces .=
                                    "</div></div>";
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
        </div><br><br>

    </div>
</section>
<?php
include "admin/templates/pie.php"
?>