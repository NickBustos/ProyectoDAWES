<?php
include getIdioma("sesioniniciada.php");
?>
<p class='text-center h4 fw-bold mb-5 mx-1 mx-md-4 mt-4'>
    <!-- Muestra un mensaje personalizado para los usuarios con nombre y su avatar -->
    <?php echo $lang["hola1"]; ?><?php echo $_SESSION[SESSION_USER] ?>
    <?php echo $lang["hola2"]; ?>
</p>
<div class='container text-center main-text'>
    <form action='index.php' method='post'>
        <input type='submit' class='col-md-3 btn btn-primary btn-lg' value='<?php echo $lang["entrar"]; ?>' name="Entrar a sesión">
    </form>

    <form action='cerrarsesion.php' method='post'>
        <input type='submit' class='col-md-3 btn btn-secondary btn-lg' value='<?php echo $lang["salir"]; ?>' name="Cerrar sesión">
    </form>
</div>
<br /><br /><br /><br /><br /><br />
<div class='col-md-6 card text-black' style='border-radius: 25px;'>
    <img class='card-img-bottom' style='margin-left: auto; margin-right: auto;'
    src=<?php echo $_SESSION[SESSION_FILE] ?>>
</div>
<?php
    include "admin/templates/pie.php";
    exit();
?>