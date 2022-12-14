<?php
include_once "admin/templates/cabecera.php";

//Si no ha iniciado sesión no muestra nada
if (!isset($_SESSION[SESSION_ID])) {
    echo "<h1 style='text-align:center;'>¿Qué haces?</h1><br/>";
    echo "<img src='imagenes/luigi.png'><br/>";
    exit();
}

/**
 * 1º Creamos un array bandos:
 *  - Creamos, una variable para el usuario meta los datos, si estan mal paso a la de error en caso de que este bien pasa a la variable con nombre(imagen / nombre)
 *  - Estos datos, les guardamos en un array $bandos
 *  - Lo recorremos un forEach, donde separamos el array bandos en bando y hacemos la validacion de los datos recogidos anteriormente.
 */
$nombre1 = $nombre2 = $img1 = $img2 = "";
$_nombre1 = $_nombre2 = $_img = "";
$errorNombre1 = $errorNombre2 = $errorImg1 = $errorImg2 = $errorElementoExistente = "&nbsp;";
$elementoExistente1 = $elementoExistente2 = "";
$id1 = $id2 = $elementoExistente = -1;
$preview = false;

if (!empty($_POST)) {
    //Ver datos de selects
    if ($_POST["elementoExistente1"] != "") {
        $id1 = $_POST["elementoExistente1"];
        $elementoExistente = select(["nombre", "foto"], "elemento", ["id", $id1])[0];
        $nombre1 = $elementoExistente[0];
        $img1 = $elementoExistente[1];
    } else {
        $_nombre1 = htmlspecialchars($_POST["nombre1"]);
        if (!empty($_nombre1)) {
            $nombre1 = $_nombre1;
        } else {
            $errorNombre1 = $lang["error_vacio"];
        }
        if (
            !empty($_FILES) && !empty($_FILES["img1"]) &&
            !empty($_FILES["img1"]["tmp_name"])
        ) {
            $_img = $_FILES["img1"];
            if ($_img["type"] === "image/png") { //Comprueba que el archivo es una imagen png
                if ($_img['size'] <= 750000) { //Comprueba que el archivo pesa menos de un 500 kilobytes
                    $img1 = getImage($_img);
                } else {
                    $errorImg1 = $lang["error_file_size"];
                }
            } else {
                $errorImg1 = $lang["error_file_type"];
            }
        } else {
            $errorImg1 = $lang["error_vacio"];
        }
    }

    if ($_POST["elementoExistente2"] != "") {
        $id2 = $_POST["elementoExistente2"];
        $elementoExistente = select(["nombre", "foto"], "elemento", ["id", $id2])[0];
        if ($id1 != -1) {
            if ($id1 != $id2) {
                $sql = "SELECT id_elemento2 AS ID FROM batalla_elemento WHERE id_elemento1=?
                        UNION
                        SELECT id_elemento1 AS ID FROM batalla_elemento WHERE id_elemento2=?";
                $preparedSttm = $conexion->prepare($sql);
                $preparedSttm->execute([$id1, $id1]);
                $idses = $preparedSttm->fetchAll(PDO::FETCH_COLUMN, 0); //coge todas las 1ª columnas (no importa porque solo hay 1) en 1 array
                $encontrado = array_search($id2, $idses);
                if ($encontrado === false) {
                    $nombre2 = $elementoExistente[0];
                    $img2 = $elementoExistente[1];
                } else {
                    $errorElementoExistente = $lang["error_batallaExiste"];
                }
            } else {
                $errorElementoExistente = $lang["error_elementosIguales"];
            }
        } else {
            $nombre2 = $elementoExistente[0];
            $img2 = $elementoExistente[1];
        }
    } else {
        $_nombre2 = htmlspecialchars($_POST["nombre2"]);
        if (!empty($_nombre2)) {
            $nombre2 = $_nombre2;
        } else {
            $errorNombre2 = $lang["error_vacio"];
        }
        if (
            !empty($_FILES) && !empty($_FILES["img2"]) &&
            !empty($_FILES["img2"]["tmp_name"])
        ) {
            $_img = $_FILES["img2"];
            if ($_img["type"] === "image/png") { //Comprueba que el archivo es una imagen png
                if ($_img['size'] <= 750000) { //Comprueba que el archivo pesa menos de un 750 kilobytes
                    $img2 = getImage($_img);
                } else {
                    $errorImg2 = $lang["error_file_size"];
                }
            } else {
                $errorImg2 = $lang["error_file_type"];
            }
        } else {
            $errorImg2 = $lang["error_vacio"];
        }
    }
    if (!empty($nombre1) && !empty($nombre2) && !empty($img1) && !empty($img2)) {
        $preview = true;
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
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?php echo ($preview) ? $lang["upload"] : $lang["subirBatalla"]; ?></p>
                                    <form method='post' class='subirBatalla' id='subirBatalla' enctype="multipart/form-data" action='<?php echo ($preview) ? "procesos/procesarVoto.php" : $_SERVER["PHP_SELF"]; ?>'>
                                        <!--Si estas en creacion te hace el post a esta misma página, sino te lleva a procesarVoto-->
                                        <header class='rowBatalla headerBatalla'>
                                            <img class='imagenUser' src='<?php echo selectFromUsuario(["foto"])[0]; ?>'>
                                            <p class='text-center fw-bold h1'><?php echo $_SESSION[SESSION_USER]; ?></p>
                                        </header>
                                        <div class='rowBatalla'>
                                            <div class='bando'>
                                                <div style='display:flex; justify-content:center;'>
                                                    <img width='200px' height='200px' src='<?php echo ($preview) ? $img1 : "imagenes/javier.png"; ?>'>
                                                </div>
                                                <p class='text-center h1 fw-bold mt-4'><?php echo ($preview) ? $nombre1 : $lang["elemento1"]; ?></p>
                                                <div class='voteBatalla'>
                                                    <?php
                                                    if ($preview) {
                                                        echo
                                                        "<input type='hidden' name='nombre1' value='{$nombre1}'>
                                                        <input type='hidden' name='img1' value='{$img1}'>
                                                        <input type='hidden' name='id1' value='{$id1}'>
                                                        <button name='elementoVotado' type='submit' class='submitBatalla btn btn-primary btn-lg' value='1'>
                                                            <img class='imagenUser' src='imagenes/thumbsUp.png'>
                                                        </button>";
                                                    } else {
                                                        echo
                                                        "<select class='form-control' name='elementoExistente1'>";
                                                        $conexion = new PDO(DSN, USER, PASSWORD);
                                                        $sql = "SELECT id, nombre FROM elemento";
                                                        $resultado = $conexion->query($sql);
                                                        $opciones = "<option value=''></option>";
                                                        $listaElementos = select(["id", "nombre"], "elemento", []);
                                                        foreach ($listaElementos as $elementoExistente) {
                                                            if ($elementoExistente[0] == $id1) {
                                                                $opciones .= "<option value='{$elementoExistente[0]}' selected>{$elementoExistente[1]}</option>";
                                                            } else {
                                                                $opciones .= "<option value='{$elementoExistente[0]}'>{$elementoExistente[1]}</option>";
                                                            }
                                                        }
                                                        echo $opciones . "</select><br/>";
                                                        echo
                                                        "<label class='form-label' for='nombre1'>{$lang['nombre']}</label>
                                                        <input class='form-control' name='nombre1' type='text' value='{$nombre1}'>
                                                        {$errorNombre1}
                                                        <br />
                                                        <label class='form-label' for='img1'>{$lang['imagen']}</label>
                                                        <input class='form-control' name='img1' type='file' accept='image/png'>
                                                        {$errorImg1}";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class='bando'>
                                                <div style='display:flex; justify-content:center;'>
                                                    <img width='200px' height='200px' src='<?php echo ($preview) ? $img2 : "imagenes/martin.png"; ?>'>
                                                </div>
                                                <p class='text-center h1 fw-bold mt-4'><?php echo ($preview) ? $nombre2 : $lang["elemento2"]; ?></p>
                                                <div class='voteBatalla'>
                                                    <?php
                                                    if ($preview) {
                                                        echo "<input type='hidden' name='nombre2' value='{$nombre2}'>
                                                        <input type='hidden' name='img2' value='{$img2}'>
                                                        <input type='hidden' name='id2' value='{$id2}'>
                                                        <button name='elementoVotado' type='submit' class='submitBatalla btn btn-primary btn-lg' value='2'>
                                                            <img class='imagenUser' src='imagenes/thumbsUp.png'>
                                                        </button>";
                                                    }else{
                                                        echo "<select class='form-control' name='elementoExistente2'>";
                                                        $opciones = "<option value=''></option>";
                                                        foreach ($listaElementos as $elementoExistente) {
                                                            if ($elementoExistente[0] == $id2) {
                                                                $opciones .= "<option value='{$elementoExistente[0]}' selected>{$elementoExistente[1]}</option>";
                                                            } else {
                                                                $opciones .= "<option value='{$elementoExistente[0]}'>{$elementoExistente[1]}</option>";
                                                            }
                                                        }
                                                        echo $opciones . "</select>{$errorElementoExistente}<br/>
                                                        <label class='form-label' for='nombre2'>{$lang['nombre']}</label>
                                                        <input class='form-control' name='nombre2' type='text' value='{$nombre2}'>
                                                        {$errorNombre2}
                                                        <br />
                                                        <label class='form-label' for='img2'>{$lang['imagen']}</label>
                                                        <input class='form-control' name='img2' type='file' accept='image/png'>
                                                        {$errorImg2}";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='rowBatalla'>
                                            <button type='submit' class='submitBatalla btn btn-primary btn-lg' name='<?php echo ($preview) ? "return" : "subirBatalla"; ?>'>
                                                <p class='text-center h1 fw-bold'>
                                                    <?php echo ($preview) ? $lang['volver'] : $lang['subirBatalla']; ?>
                                                </p>
                                            </button>

                                        </div>
                                    </form>&nbsp;
                                    <!--holi-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "admin/templates/pie.php" ?>