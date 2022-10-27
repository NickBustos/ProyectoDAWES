<?php
include "admin/templates/cabecera.php";
include getIdioma("index.php");
?>
<section class="fondo">
  <div class="container-fluid main">
    
    <div class="row d-flex justify-content-center">
      <?php
      /**
       * Comprueba que la sesión tenga un usuario (ha iniciado sesión).
       * En ese caso te muestra la página de sesión iniciada.
       */
      if (isset($_SESSION[SESSION_USER])) {
        include "admin/templates/sesioniniciada.php";
      }
      ?>
      <div class="rounded-circle">
        <br><br><br><br><br><br>
        <div class="card-body">
          <div class="text-center main-text">
            <h3><?php echo $lang["bienvenido"]; ?></h3>
            <br><br>
            <div class="c2a-btn footer-c2a-btn">
              <div class="btn-group btn-group-lg" role="group" aria-label="Call to action">
                <a type="button" class="btn btn-default btn-lg" href="iniciosesion.php">
                  <?php echo $lang["iniciarsesion"]; ?></a>
                <span class="btn-circle btn-or">OR</span>
                <a type="button" class="btn btn-default btn-lg" href="registrarse.php">
                  <?php echo $lang["registarse"]; ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</section>

<?php include "admin/templates/pie.php" ?>