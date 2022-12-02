<?php
include "admin/templates/cabecera.php";
?>
<section class="fondo">
  <div class="container-fluid main">

    <div class="row d-flex justify-content-center">
      <?php
      /**
       * Comprueba que la sesión tenga un usuario (ha iniciado sesión).
       * En ese caso te muestra la página de sesión iniciada.
       */
      if (isset($_SESSION[SESSION_ID])) {
        include "admin/templates/batalla.php";
      }else{
        include "admin/templates/circuloInicio.php";
      }
      ?>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</section>

<?php include "admin/templates/pie.php" ?>