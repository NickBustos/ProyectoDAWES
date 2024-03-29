<?php
include_once "admin/templates/cabecera.php";

//Si no ha iniciado sesión no muestra nada
if ($usuario == null) {
    echo "<h1 style='text-align:center;'>¿Qué haces?</h1><br/>";
    echo "<img src='imagenes/luigi.png'><br/>";
    exit();
}

$nombre = $img = "";
$_nombre = $_img = "";
$errorNombre = $errorImg = "";
$nombre1 = $nombre2 = $img1 = $img2 = "";

// ELEMENTO 1
// Ha cogido elemento existente
if (isset($_POST["id1"])) {
    $_SESSION[SESSION_CREAR_ELEM_1] = $_POST["id1"];
    // Ha cogido elemento no existente
    // Validaciones 
    // En caso de que esté todo bien lo sube
} else if (isset($_POST["nombre1"])) { // Crear
    $_nombre = trim(htmlspecialchars($_POST["nombre1"]));
    if (!empty($_nombre)) {
        $nombre = $_nombre;
    } else {
        $errorNombre = $lang["error_vacio"];
    }

    if (
        !empty($_FILES) && !empty($_FILES["img1"]) &&
        !empty($_FILES["img1"]["tmp_name"])
    ) {
        $_img = $_FILES["img1"];
        if ($_img["type"] === "image/png") {
            if ($_img['size'] <= IMAGE_MAX_SIZE) {
                $img = getImage($_img);
            } else {
                $errorImg = $lang["error_file_size"];
            }
        } else {
            $errorImg = $lang["error_file_type"];
        }
    } else {
        $errorImg = $lang["error_vacio"];
    }

    if ($errorNombre == "" && $errorImg == "") {
        $_SESSION[SESSION_CREAR_ELEM_1] = $usuario->crearElemento($nombre, $img);
        $nombre = "";
        
    }
    // ELEMENTO 2
} else if (isset($_POST["id2"])) { // Existente
    $_SESSION[SESSION_CREAR_ELEM_2] = $_POST["id2"];
} else if (isset($_POST["nombre2"])) { // Crear
    $_nombre = trim(htmlspecialchars($_POST["nombre2"]));
    if (!empty($_nombre)) {
        $nombre = $_nombre;
    } else {
        $errorNombre = $lang["error_vacio"];
    }

    if (
        !empty($_FILES) && !empty($_FILES["img2"]) &&
        !empty($_FILES["img2"]["tmp_name"])
    ) {
        $_img = $_FILES["img2"];
        if ($_img["type"] === "image/png") {
            if ($_img['size'] <= IMAGE_MAX_SIZE) {
                $img = getImage($_img);
            } else {
                $errorImg = $lang["error_file_size"];
            }
        } else {
            $errorImg = $lang["error_file_type"];
        }
    } else {
        $errorImg = $lang["error_vacio"];
    }

    if ($errorNombre == "" && $errorImg == "") {
        $_SESSION[SESSION_CREAR_ELEM_2] = $usuario->crearElemento($nombre, $img);
    }
}
?>
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="card text-black" style="border-radius: 25px;">
                            <div class="card-body p-md-5">
                                <div class="row justify-content-center">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?= (isset($_SESSION[SESSION_CREAR_ELEM_2])) ? $lang["upload"] : $lang["subirBatalla"]; ?></p>
                                    <form method='post' class='subirBatalla' id='subirBatalla' enctype="multipart/form-data" action='<?= (isset($_SESSION[SESSION_CREAR_ELEM_2])) ? "procesos/procesarVoto.php" : $_SERVER["PHP_SELF"]; ?>' <?= (isset($_SESSION[SESSION_CREAR_ELEM_2])) ? "" : "style='border-bottom:0; border-radius:0; padding-bottom:0px;'"; ?>>
                                        <header class='rowBatalla headerBatalla'>
                                            <img class='imagenUser' src='<?= $usuario->foto; ?>'>
                                            <p class='text-center fw-bold h1'><?= $_SESSION[SESSION_USER]; ?></p>
                                        </header>
                                        <?php
                                        if (isset($_SESSION[SESSION_CREAR_ELEM_2])) {
                                            $sql = "SELECT nombre, foto FROM elemento WHERE id=?";
                                            $elemento1 = BD::realizarSql(BD::crearConexion(), $sql, [$_SESSION[SESSION_CREAR_ELEM_1]])[0];
                                            $nombre1 = $elemento1[0];
                                            $img1 = $elemento1[1];

                                            $sql = "SELECT nombre, foto FROM elemento WHERE id=?";

                                            $elemento2 = BD::realizarSql(BD::crearConexion(), $sql, [$_SESSION[SESSION_CREAR_ELEM_2]])[0];
                                            $nombre2 = $elemento2[0];
                                            $img2 = $elemento2[1];
                                        ?>
                                            <div class='rowBatalla'>
                                                <div class='bando'>
                                                    <div style='display:flex; justify-content:center;'>
                                                        <img width='200px' height='200px' src='<?= $img1 ?>'>
                                                    </div>
                                                    <p class='text-center h1 fw-bold mt-4'><?= $nombre1 ?></p>
                                                    <div class='voteBatalla'>
                                                        <button name='elementoVotado' type='submit' class='submitBatalla btn btn-primary btn-lg' value='1'>
                                                            <img class='imagenUser' src='imagenes/thumbsUp.png'>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class='bando'>
                                                    <div style='display:flex; justify-content:center;'>
                                                        <img width='200px' height='200px' src='<?= $img2 ?>'>
                                                    </div>
                                                    <p class='text-center h1 fw-bold mt-4'><?= $nombre2 ?></p>
                                                    <div class='voteBatalla'>
                                                        <button name='elementoVotado' type='submit' class='submitBatalla btn btn-primary btn-lg' value='2'>
                                                            <img class='imagenUser' src='imagenes/thumbsUp.png'>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='rowBatalla'>
                                                <button type='submit' class='submitBatalla btn btn-primary btn-lg' name='<?= "reiniciar" ?>'>
                                                    <p class='text-center h1 fw-bold'>
                                                        <?= "Reiniciar" ?>
                                                    </p>
                                                </button>
                                            </div>
                                    </form>
                                <?php } else { ?>
                                    <div class='rowBatalla'>
                                        <div class='bando' style='border:0px'>
                                            <p class='text-center h1 fw-bold mt-4'><?php echo (isset($_SESSION[SESSION_CREAR_ELEM_1])) ? $lang["elemento2"] : $lang["elemento1"]; ?></p>
                                            <div class='voteBatalla'>
                                                <label class='form-label' for='<?= (isset($_SESSION[SESSION_CREAR_ELEM_1])) ? "nombre2" : "nombre1"; ?>'>
                                                    <?= $lang["nombre"]; ?>
                                                </label>
                                                <input class='form-control' type="text" name="<?= (isset($_SESSION[SESSION_CREAR_ELEM_1])) ? "nombre2" : "nombre1"; ?>" value="<?= $nombre; ?>">
                                                <?= $errorNombre; ?>
                                                <br />

                                                <label class='form-label' for='<?= (isset($_SESSION[SESSION_CREAR_ELEM_1])) ? "img2" : "img1"; ?>'>
                                                    <?= $lang["imagen"]; ?>
                                                </label>
                                                <input class='form-control' type="file" name="<?= (isset($_SESSION[SESSION_CREAR_ELEM_1])) ? "img2" : "img1"; ?>">
                                                <?= $errorImg; ?>
                                                <br />
                                                <input type="submit" class='submitBatalla btn btn-primary btn-lg'>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                            $sql = "SELECT COUNT(*) FROM elemento ";
                                            if (isset($_SESSION[SESSION_CREAR_ELEM_1])) {
                                                $sql .= "WHERE id!='{$_SESSION[SESSION_CREAR_ELEM_1]}' AND id NOT IN 
                                                (SELECT id_elemento2 AS ID FROM batalla_elemento WHERE id_elemento1='{$_SESSION[SESSION_CREAR_ELEM_1]}'
                                                UNION
                                                SELECT id_elemento1 AS ID FROM batalla_elemento WHERE id_elemento2='{$_SESSION[SESSION_CREAR_ELEM_1]}')";
                                                $id = "id2";
                                            }
                                            
                                            $numElementos = BD::realizarSql(BD::crearConexion(), $sql, [])[0][0];

                                            if ($numElementos > 0) { // PAGINACIÓN
                                                $paginas = ceil($numElementos / ELEMENTS_PAGE);

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

                                                $id = "id1";
                                                $sql = "SELECT id, nombre, foto FROM elemento ";
                                                if (isset($_SESSION[SESSION_CREAR_ELEM_1])) {
                                                    $sql .= "WHERE id!='{$_SESSION[SESSION_CREAR_ELEM_1]}' AND id NOT IN 
                                                    (SELECT id_elemento2 AS ID FROM batalla_elemento WHERE id_elemento1='{$_SESSION[SESSION_CREAR_ELEM_1]}'
                                                                UNION
                                                                SELECT id_elemento1 AS ID FROM batalla_elemento WHERE id_elemento2='{$_SESSION[SESSION_CREAR_ELEM_1]}')";
                                                    $id = "id2";
                                                }
                                                $sql .= "ORDER BY nombre LIMIT {$offset}, " . ELEMENTS_PAGE;
                                                $elementos = BD::realizarSql(BD::crearConexion(), $sql, []);
                                                echo "
                                                </form>
                                                <div class='subirBatalla' style='border-top:0; border-radius:0; padding-top:0px;'>
                                                <div class='rowBatalla'>
                                                <div class='bando' style='display:flex; flex-direction:row; border:0'>";
                                                // Por cada elemento crea un formulario con un boton de submit que es la imagen del elemento
                                                foreach ($elementos as $elemento) {
                                    ?>
                                            <form method='post' action='<?= $_SERVER['PHP_SELF'] ?>' style='box-sizing: border-box; width:25%;'>
                                                <input type='hidden' name='<?= $id ?>' value='<?= $elemento[0] ?>'>
                                                <button type='submit'>
                                                    <img src='<?= $elemento[2] ?>' width='100px' height='100px'>
                                                </button>
                                            </form>
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
                                ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
include_once "admin/templates/pie.php";
?>