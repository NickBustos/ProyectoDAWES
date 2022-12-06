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
$_nombre1 = $_nombre2 = $_img1 = $_img2 = "";
$errorNombre1 = $errorNombre2 = $errorImg1 = $errorImg2 = "&nbsp;";
$elementoExistente1 = $elementoExistente2 = "";
if (!empty($_POST)) {
    if (isset($_POST["subirBatalla"])) { //Estaba en creación -> validaciones
        $bandos = [
            ["nombre1", &$_nombre1, &$nombre1, &$errorNombre1, "img1", &$img1, &$errorImg1, "elementoExistente1", &$elementoExistente1],
            ["nombre2", &$_nombre2, &$nombre2, &$errorNombre2, "img2", &$img2, &$errorImg2, "elementoExistente2", &$elementoExistente2]
        ];
        foreach ($bandos as $bando) {
                $bando[1] = htmlspecialchars($_POST[$bando[0]]);
            if (!empty($bando[1])) {
                $bando[2] = $bando[1];
            } else {
                $bando[3] = $lang["error_vacio"];
            }
            if (
                !empty($_FILES) && !empty($_FILES[$bando[4]])
                && !empty($_FILES[$bando[4]]["tmp_name"])
            ) { //Se asegura de que el usuario ha introducido un archivo
                if ($_FILES[$bando[4]]["type"] === "image/png") { //Comprueba que el archivo es una imagen png
                    if ($_FILES[$bando[4]]['size'] <= 1000000) { //Comprueba que el archivo pesa menos de un 1 mega
                        $bando[5] = getImage($_FILES[$bando[4]]);
                    } else {
                        $bando[6] = $lang["error_file_size"];
                    }
                } else {
                    $bando[6] = $lang["error_file_type"];
                }
            } else {
                $bando[6] = $lang["error_vacio"];
            }
        }
    } else if (isset($_POST["nombre1"])) { //Se estaba en preview -> voto/volver
        if (isset($_POST["elementoVotado"])) { //voto (subir y votar)
            $_nombre1 = htmlspecialchars($_POST["nombre1"]);
            $_img1 = htmlspecialchars($_POST["img1"]);
            $_nombre2 = htmlspecialchars($_POST["nombre2"]);
            $_img2 = htmlspecialchars($_POST["img2"]);
            $idElem1 = insertar("elemento", ["", $_nombre1, $_img1, 0]);
            $idElem2 = insertar("elemento", ["", $_nombre2, $_img2, 0]);
            $idBatalla = insertar("batalla_elemento", ["", $idElem1, $idElem2]);
            insertar("usuario_batalla", ["", $_SESSION[SESSION_ID], $idBatalla, "crear", getMomentoActual()]);

            $conexion = new PDO(DSN, USER, PASSWORD);
            $elementoVotado = $idElem1;
            if ($_POST["elementoVotado"] === "2") {
                $elementoVotado = $idElem2;
            }
            $sql = "INSERT INTO voto VALUES (
                :id_u, :id_b, :id_e, :mom
            )";
            $datos = [
                "id_u" => $_SESSION[SESSION_ID],
                "id_b" => $idBatalla,
                "id_e" => $elementoVotado,
                "mom" => getMomentoActual()
            ];
            $preparedSttm = $conexion->prepare($sql)->execute($datos);
            echo "<p class='text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4'>BATALLA SUBIDA CON ÉXITO</p>";
            $nombre1 = $nombre2 = $img1 = $img2 = "";
        }
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
                                    <?php
                                    if ($nombre1 != "" && $img1 != "" && $nombre2 != "" && $img2 != "") {
                                        include "admin/templates/batallaPreview.php";
                                    } else {
                                        include "admin/templates/creacionBatalla.php";
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

<?php include "admin/templates/pie.php" ?>