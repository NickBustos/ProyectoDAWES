<?php
include_once "admin/templates/cabecera.php";

$nombre1 = $nombre2 = $img1 = $img2 = "";
$_nombre1 = $_nombre2 = "";
$errorNombre1 = $errorNombre2 = $errorImg1 = $errorImg2 = "";
if (!empty($_POST)) {
    $bandos = [
        ["nombre1", &$_nombre1, &$nombre1, &$errorNombre1, "img1", &$img1, &$errorImg1],
        ["nombre2", &$_nombre2, &$nombre2, &$errorNombre2, "img2", &$img2, &$errorImg2]
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
    if ($nombre1 != "" && $img1 != "" && $nombre2 != "" && $img2 != "") {
        echo "<img src='{$img1}'>{$nombre1}
                <br/>
                <img src='{$img2}'>{$nombre2}";
    }
}
?>
<br><br>
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="card text-black" style="border-radius: 25px;">
                            <div class="card-body p-md-5">
                                <div class="row justify-content-center">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?php echo $lang["subirBatalla"]; ?></p>
                                    <form method="post" class="subirBatalla" id="subirBatalla" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                        <div class="bando">
                                            <div>
                                                <img style="width:100%; height:200px" src="imagenes/dad.png">
                                            </div>
                                            <div>
                                                <label class="form-label" for="nombre1"><?php echo $lang["nombre"]; ?></label>
                                                <input class="form-control" name="nombre1" type="text" value='<?php echo $nombre1 ?>'>
                                                <?php echo $errorNombre1 ?>
                                                <br />
                                                <label class="form-label" for="img1"><?php echo $lang["imagen"]; ?></label>
                                                <input class="form-control" name="img1" type="file" accept="image/png">
                                                <?php echo $errorImg1 ?>
                                            </div>
                                        </div>
                                        <div class="bando">
                                            <div class="imagen">
                                                <img  style="width:100%; height:200px" src="imagenes/mum.png">
                                            </div>
                                            <div>
                                                <label class="form-label" for="nombre2"><?php echo $lang["nombre"]; ?></label>
                                                <input class="form-control" name="nombre2" type="text" value='<?php echo $nombre2 ?>'>
                                                <?php echo $errorNombre2 ?>
                                                <br />
                                                <label class="form-label" for="img2"><?php echo $lang["imagen"]; ?></label>
                                                <input class="form-control" name="img2" type="file" accept="image/png">
                                                <?php echo $errorImg2 ?>
                                            </div>
                                        </div>
                                        <br />
                                    </form>
                                    <div>
                                        <input form="subirBatalla" class="submitBatalla btn btn-primary btn-lg" type="submit" value="<?php echo $lang["subirBatalla"]; ?>">
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

<?php include "admin/templates/pie.php" ?>