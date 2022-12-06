<p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?php echo $lang["upload"]; ?></p>
<form method='post' class='subirBatalla' id='subirBatalla' action=''>
    <header class='rowBatalla headerBatalla'>
        <img class='imagenUser' src='<?php echo selectFromUsuario(["foto"])[0]; ?>'>
        <p class='text-center fw-bold h1'><?php echo $_SESSION[SESSION_USER]; ?></p>
    </header>
    <div class='rowBatalla'>
        <div class='bando'>
            <div style='display:flex; justify-content:center;'>
                <img width='200px' height='200px' src='<?php echo $img1; ?>'>
            </div>
            <p class='text-center h1 fw-bold mt-4'><?php echo $nombre1; ?></p>
            <div class='voteBatalla'>
                <button name='elementoVotado' type='submit' class='submitBatalla btn btn-primary btn-lg' value='1'>
                    <img class='imagenUser' src='imagenes/thumbsUp.png'>
                </button>
            </div>
        </div>
        <div class='bando'>
            <div style='display:flex; justify-content:center;'>
                <img width='200px' height='200px' src='<?php echo $img2; ?>'>
            </div>
            <p class='text-center h1 fw-bold mt-4'><?php echo $nombre2; ?></p>
            <div class='voteBatalla'>
                <button name='elementoVotado' type='submit' class='submitBatalla btn btn-primary btn-lg' value='2'>
                    <img class='imagenUser' src='imagenes/thumbsUp.png'>
                </button>
            </div>
        </div>
    </div>
    <div class='rowBatalla'>
        <button type='submit' class='submitBatalla btn btn-primary btn-lg' name='return'>
            <p class='text-center h1 fw-bold'><?php echo $lang["volver"] ?></p>
        </button>
    </div>
    <input type="hidden" name="nombre1" value="<?php echo $nombre1 ?>">
    <input type="hidden" name="img1" value="<?php echo $img1 ?>">
    <input type="hidden" name="nombre2" value="<?php echo $nombre2 ?>">
    <input type="hidden" name="img2" value="<?php echo $img2 ?>">
</form>&nbsp;