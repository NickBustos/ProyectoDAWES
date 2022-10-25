<?php
include 'admin/templates/cabecera.php';
include getIdioma("acercade.php");
?>
<div class="row-center">
    <div class="col-md-3">
        <div class="card">
            <img class="card-img-top" src="https://cdn-icons-png.flaticon.com/512/2422/2422601.png" alt="">
            <div class="card-body">
                <h4 class="card-title"><?php echo $lang["registrate"]; ?></h4>
                <p class="card-text"><?php echo $lang["paravotar"]; ?></p>
                <a name="" id="" class="btn btn-primary" href="registrarse.php" role="button">
                <?php echo $lang["registrarse"]; ?>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <img class="card-img-top" src="https://cdn-icons-png.flaticon.com/512/977/977597.png" alt="">
            <div class="card-body">
                <h4 class="card-title"><?php echo $lang["navega"]; ?></h4>
                <p class="card-text"><?php echo $lang["encuestas"]; ?></p>
                <a name="" id="" class="btn btn-primary" href="iniciosesion.php" role="button">
                    <?php echo $lang["navega"]; ?></a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <img class="card-img-top" src="https://cdn-icons-png.flaticon.com/512/2633/2633926.png" alt="">
            <div class="card-body">
                <h4 class="card-title"><?php echo $lang["vota"]; ?></h4>
                <p class="card-text"><?php echo $lang["votarencuestas"]; ?></p>
                <a name="" id="" class="btn btn-primary" href="#" role="button"><?php echo $lang["votar"]; ?></a>
            </div>
        </div>
    </div>
</div>
<br><br><br><br><br><br><br>
<?php include 'admin/templates/pie.php' ?>