<p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?php echo $lang["subirBatalla"]; ?></p>
<!-- 
    El cubo que contiene la batalla
    Este cubo esta dividio en dos bandos
    Los dos div, tienen una imagen y un input text 
-->
<form method="post" class="subirBatalla" id="subirBatalla" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <header class='rowBatalla headerBatalla'>
        <img class='imagenUser' src='<?php echo selectFromUsuario(["foto"])[0]; ?>'>
        <p class='text-center fw-bold h1'><?php echo $_SESSION[SESSION_USER]; ?></p>
    </header>
    <div class='rowBatalla'>
        <div class="bando">
            <div>
                <img style="width:100%; height:200px; border-radius: 50%;" src="imagenes/javier.png">
                <label class="form-label" for="elementoExistente1">ELEMENTO1</label>
                <select class="form-control" name="elementoExistente1">
                    <?php
                    $conexion = new PDO(DSN, USER, PASSWORD);
                    $sql = "SELECT nombre, id FROM elemento";
                    $resultado = $conexion->query($sql);
                    $opciones = "<option value=''></option>";
                    while ($registro = $resultado->fetch(PDO::FETCH_NUM)) {
                        $opciones .= "<option value='{$registro[1]}'>{$registro[0]}</option>";
                    }
                    echo $opciones;
                    ?>
                </select>
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
                <img style="width:100%; height:200px; border-radius: 50%;" src="imagenes/martin.png">
                <label class="form-label" for="elementoExistente2">ELEMENTO2</label>
                <select class="form-control" name="elementoExistente2">
                    <?php
                    echo $opciones;
                    ?>
                </select>
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
    </div>
    <div class='rowBatalla'>
        <button class="submitBatalla btn btn-primary btn-lg" type="submit" name="subirBatalla"><?php echo $lang["subirBatalla"]; ?></button>
    </div>
</form>