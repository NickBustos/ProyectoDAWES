<p class='text-center h4 fw-bold mb-5 mx-1 mx-md-4 mt-4'>
    Bienvenid@ <?php echo $_SESSION[SESSION_USER] ?>
</p>
<div class='container text-center main-text'>
    <form action='index.php' method='get'>
        <input type='submit' class='col-md-3 btn btn-primary btn-lg' value='Entrar'>
    </form>

    <form action='index.php' method='get'>
        <input type='submit' class='col-md-3 btn btn-secondary btn-lg' value='Salir'>
    </form>
</div>
<br /><br /><br /><br /><br /><br />
<div class='col-md-6 card text-black' style='border-radius: 25px;'>
    <img class='contact1-pic' style='margin-left: auto; margin-right: auto;'
    src=<?php echo $_SESSION[SESSION_FILE] ?>>
</div>
<?php
    exit();
?>