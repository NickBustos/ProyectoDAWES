<?php
// Coger id del usuario dueño de la batalla
$sql = "SELECT id_usuario FROM usuario_batalla WHERE id_batalla='{$batalla}' AND accion='crear'";
$id_usuario = $conexion->query($sql)->fetch(PDO::FETCH_NUM)[0];

// Coger datos del usuario dueño de la batalla
$foto = $name_user = "";
$sql = "SELECT DISTINCT u.foto, c.nombreusuario FROM usuario u 
            INNER JOIN usuario_credencial c ON u.id=c.id_usuario 
            WHERE u.id='{$id_usuario}'";
$resultado = $conexion->query($sql);
$resultado->bindColumn(1, $foto);
$resultado->bindColumn(2, $name_user);
$resultado->fetch(PDO::FETCH_BOUND);

// Coger bandos de la batalla
$sql = "SELECT id, nombre, foto FROM elemento WHERE id='$elemento1' OR id='$elemento2'";
$bandos = $conexion->query($sql);

// Comenzar a cargar elementos HTML en variable $mostrar (crear formulario y cabecera)
$mostrar = "<form method='post' class='subirBatalla' id='subirBatalla' action='procesos/procesarVoto.php'>";
$mostrar .= "
    <header class='rowBatalla headerBatalla'>
        <img class='imagenUser' src='{$foto}'>
        <p class='text-center fw-bold h1'>{$name_user}</p>
    </header>
    <div class='rowBatalla'>";

// Por cada bando de la batalla se carga la imagen y el nombre del elemento que lo compone y el botón de votarlo.
while ($bando = $bandos->fetch(PDO::FETCH_NAMED)) {
    $mostrar .=
        "<div class='bando'>
            <div style='display:flex; justify-content:center;'>
                <img width='200px' height='200px' src='{$bando['foto']}'>
            </div>
            <p class='text-center h1 fw-bold mt-4'>{$bando['nombre']}</p>
            <div class='voteBatalla'>
                <button name='elementoVotado' type='submit' class='submitBatalla btn btn-primary btn-lg' value='{$bando['id']}'>
                    <img class='imagenUser' src='imagenes/thumbsUp.png'>
                </button>
            </div>
        </div>";
}

//Se añaden los botones next y denunciar y se cierra el formulario y el div iniciados
$mostrar .= "</div>
    <div class='rowBatalla'>
        <button type='submit' class='submitBatalla btn btn-primary btn-lg' name='siguiente'>
            <img class='imagenUser' src='imagenes/next.png'>
        </button>
        <button type='submit' class='submitBatalla btn btn-secondary btn-lg' name='denunciar'>
            <img class='imagenUser' src='imagenes/denunciar.png'>
        </button>
    </div>
    </form>&nbsp;"; // no le enseñen esto al de los colores que me pega un puño
echo $mostrar;
