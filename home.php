<?php
include "admin/templates/cabecera.php";
?>
<section class="fondo">
  <div class="container-fluid main">

    <div class="row d-flex justify-content-center">
      <?php
      /**
       * Comprueba que la sesión tenga un usuario (ha iniciado sesión).
       * En ese caso te muestra la página de sesión iniciada (una batalla).
       */
      if ($usuario != null) {
        include "admin/templates/batallaPOO.php";
      } else {
        echo "
          <div class='rounded-circle'>
            <br><br><br><br><br><br>
            <div class='card-body'>
                <div class='text-center main-text'>
                    <h3> {$lang['bienvenido']} </h3>
                    <br><br>
                    <div class='c2a-btn footer-c2a-btn'>
                        <div class='btn-group btn-group-lg' role='group' aria-label='Call to action'>
                            <a type='button' class='btn btn-default btn-lg' href='iniciosesion.php'>
                                {$lang['iniciarsesion']}</a>
                            <span class='btn-circle btn-or'>OR</span>
                            <a type='button' class='btn btn-default btn-lg' href='registrarse.php'>
                                {$lang['registarse']}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
      }
      ?>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</section>

<?php include "admin/templates/pie.php" ?>