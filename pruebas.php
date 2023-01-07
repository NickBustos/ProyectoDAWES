<?php
include_once "admin/templates/cabecera.php";
$idUsuario = -1;
if (isset($_SESSION[SESSION_ID])) {
    $idUsuario = $_SESSION[SESSION_ID];
}
if (isset($_GET) && !empty($_GET) && isset($_GET["usuario"])) {
    $_idUsuario = htmlspecialchars($_GET["usuario"]);
    if (preg_match('/^\d+$/', $_idUsuario) == 1 && count(select(["id"], "usuario", ["id", $_idUsuario])) > 0) {
        $idUsuario = $_idUsuario;
    }
}
$datosUsuario = [];
if ($idUsuario > -1) {
    $datosUsuario = select(["nombreusuario"], "usuario_credencial", ["id_usuario", $idUsuario])[0];
    $datosUsuario += select(["*"], "usuario", ["id", $idUsuario])[0];
}
var_dump($datosUsuario);

echo "<br/> <br/>";
$batallas = buscarBatalla($_SESSION[SESSION_ID]);
var_dump($batallas);
echo "<br/>";
echo '<img class="imagenUser" src="' . infoBatalla($batallas[0]["id_elemento1"], "foto")[0] . '">';
echo '<img class="imagenUser" src="' . infoBatalla($batallas[0]["id_elemento2"], "foto")[0] . '">';
echo "<br/>";

$totalBatallas =(selectFromUsuario(["num_batallas_creadas"]))[0];
$totalBatallas = $datosUsuario[PERFIL_BATALLAS_CREADAS];
echo "<h1>{$totalBatallas}</h1><br/>";

echo "<h1>".count($batallas)."</h1>";

$acum = 0;
for ($i = 0; $i < $totalBatallas; $i++) {
    $imagenBatallaU = '<div class="filaBatallas" style="margin-left:25px; margin-right:25px">
                            <div class="row-center">
                                <div class="card-group">
                                    <div class="card">
                                        <img class="imagenUser" src="'
        . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento1"], "foto")[0] . '">
                                        <span class="btn-circle btn-or">OR</span> 
                                        <img class="imagenUser" src="'
        . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento2"], "foto")[0] . '">
                                        <div class="card-body">
                                            <h4 class="card-title">Batalla #' . $i + 1 . '</h4>
                                            <p class="card-text">'
        . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento1"], "nombre")[0] .
        ' vs '
        . infoBatalla(buscarBatalla($idUsuario)[$acum]["id_elemento2"], "nombre")[0] .
        '</p>
                                        </div>
                                    </div>';
    $acum = $acum + 1;
    echo $imagenBatallaU;
}
echo "</div>
                        </div>";
