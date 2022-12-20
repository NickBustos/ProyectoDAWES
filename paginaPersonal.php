<?php include_once "admin/templates/cabecera.php"; ?>
<?php
    if(!isset($_SESSION[SESSION_ID])){
        header("Location: index.php");
    }
    $idUsuario = $_SESSION[SESSION_ID];
    if(isset($_GET["usuario"])){
        $idUsuario = $_GET["usuario"];
    }
    $datosUsuario = select(["*"], "usuario", ["id", $idUsuario])[0];
    foreach($datosUsuario as $dato){
        echo $dato . "<br/>";
    }
?>
<?php include_once "admin/templates/pie.php"; ?>