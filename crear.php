<?php
include_once "admin/templates/cabecera.php";
define("ELEMENTS_PAGE", 2);

var_dump($_SESSION);
echo "<br/>";
var_dump($_POST);
echo "<br/>";

if (isset($_POST["id1"])) {
    $_SESSION["crearElem1"] = $_POST["id1"];
} else if (isset($_POST["nombre1"])) {
    $nombre1 = htmlspecialchars($_POST["nombre1"]);
    $img1 = getImage($_FILES["img1"]);
    $_SESSION["crearElem1"] = insertar("elemento", ["", $nombre1, $img1, 0]);
    insertar("usuario_elemento", ["", $_SESSION[SESSION_ID], $_SESSION["crearElem1"], "crear", getMomentoActual()]);

    $elementosCreados = selectFromUsuario(["num_elementos_creados"])[0];
    $elementosCreados++;
    actualizarUsuario("num_elementos_creados", $elementosCreados, $_SESSION[SESSION_ID]);
} else if (isset($_POST["id2"])) {
    $_SESSION["crearElem2"] = $_POST["id2"];
} else if (isset($_POST["nombre2"])) {
    $nombre2 = htmlspecialchars($_POST["nombre2"]);
    $img2 = getImage($_FILES["img2"]);
    $_SESSION["crearElem2"] = insertar("elemento", ["", $nombre2, $img2, 0]);
    insertar("usuario_elemento", ["", $_SESSION[SESSION_ID], $_SESSION["crearElem2"], "crear", getMomentoActual()]);

    $elementosCreados = selectFromUsuario(["num_elementos_creados"])[0];
    $elementosCreados++;
    actualizarUsuario("num_elementos_creados", $elementosCreados, $_SESSION[SESSION_ID]);
}

if (isset($_SESSION["crearElem2"])) {
    $sql = "SELECT nombre, foto FROM elemento WHERE id=?";
    $preparedSttm = $conexion->prepare($sql);
    $preparedSttm->execute([$_SESSION['crearElem1']]);
    $elemento1 = $preparedSttm->fetch(PDO::FETCH_NUM);
    $nombre1 = $elemento1[0];
    $img1 = $elemento1[1];

    $sql = "SELECT nombre, foto FROM elemento WHERE id=?";
    $preparedSttm = $conexion->prepare($sql);
    $preparedSttm->execute([$_SESSION['crearElem2']]);
    $elemento2 = $preparedSttm->fetch(PDO::FETCH_NUM);
    $nombre2 = $elemento2[0];
    $img2 = $elemento2[1];
?>
    <h1>Batalla</h1>
    <form method='post' class='subirBatalla' id='subirBatalla' enctype="multipart/form-data" action='procesos/procesarVoto2.php'>
        <header class='rowBatalla headerBatalla'>
            <img class='imagenUser' src='<?= selectFromUsuario(["foto"])[0]; ?>'>
            <p class='text-center fw-bold h1'><?= $_SESSION[SESSION_USER]; ?></p>
        </header>
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
    </form>&nbsp;

<?php } else { ?>
    <form method="post" enctype="multipart/form-data">
        <h1><?= (isset($_SESSION["crearElem1"])) ? "Elemento 2" : "Elemento 1"; ?></h1>
        Nombre:<input type="text" name="<?= (isset($_SESSION["crearElem1"])) ? "nombre2" : "nombre1"; ?>" value="">
        <br />
        Foto:<input type="file" name="<?= (isset($_SESSION["crearElem1"])) ? "img2" : "img1"; ?>" value="">
        <input type="submit">
    </form>
<?php
    $sql = "SELECT COUNT(*) FROM elemento";
    $numElementos = $conexion->query($sql)->fetch(PDO::FETCH_NUM)[0];

    if (isset($_SESSION["crearElem1"])) {
        $numElementos--;
    }

    if ($numElementos > 0) {// PAGINACIÓN
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
        if (isset($_SESSION["crearElem1"])) {
            $sql .= "WHERE id!={$_SESSION["crearElem1"]} ";
            $id = "id2";
        }
        $sql .= "ORDER BY nombre LIMIT {$offset}, " . ELEMENTS_PAGE;
        $elementos = $conexion->query($sql)->fetchAll(PDO::FETCH_NUM);
        foreach ($elementos as $elemento) {
            echo "
    <form method='post' style='display:inline-block'>
        <input type='hidden' name='{$id}' value='{$elemento[0]}'>
        <button type='submit'>
            <img src='{$elemento[2]}' width='100px' height='100px'>
        </button>
    </form>
    ";
        }
        echo "<br/>";

        if ($paginas > 1) {
            $enlaces = "";
            if ($paginaActual > 1) {
                $anterior = $paginaActual - 1;
                $enlaces .= "<a href='{$_SERVER["PHP_SELF"]}?pagina={$anterior}'>Anterior</a>";
            }
            for ($i = 1; $i <= $paginas; $i++) {
                $enlaces .= "<a href='{$_SERVER["PHP_SELF"]}?pagina={$i}'> {$i} </a>";
            }
            if ($paginaActual < $paginas) {
                $siguiente = $paginaActual + 1;
                $enlaces .= "<a href='{$_SERVER["PHP_SELF"]}?pagina={$siguiente}'>Siguiente</a>";
            }
            echo $enlaces;
        }
    }
}
?>

<?php
include_once "admin/templates/pie.php";
?>