<?php
include_once "admin/templates/cabecera.php";
?>
<br><br>
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="card text-black" style="border-radius: 25px;">
                            <div class="card-body p-md-5">
                                <div class="row justify-content-center">
                                    <?php
                                    /**
                                     * Realizamos un select, para recoger todas las batallas
                                     * Por cada batalla el id del elemento 1 es batalla[0] y el id del elemento 2 es batalla [1].
                                     * Cada elemento esta formado, por el nombre y la foto.
                                     * A continuación mostramos los elementos, haciendo un echo $mostrar.
                                     * Por cada batalla encontrado, se realiza un while
                                     */
                                    $conexion = new PDO(DSN, USER, PASSWORD);
                                    $sql = "SELECT id_elemento1, id_elemento2, id_batalla FROM batalla_elemento ORDER BY id_batalla";
                                    $batallas = $conexion->query($sql);

                                    $id_usuario = $name_user = $foto_usuario = "";
                                    while ($batalla = $batallas->fetch(PDO::FETCH_NUM)) {
                                        $sql = "SELECT id_usuario FROM usuario_batalla WHERE id_batalla='{$batalla[2]}' AND accion='crear'";
                                        $id = $conexion->query($sql)->fetch(PDO::FETCH_NUM)[0];
                                        if ($id !== $id_usuario) {
                                            $id_usuario = $id;
                                            $sql = "SELECT DISTINCT u.foto, c.nombreusuario FROM usuario u 
                                                INNER JOIN usuario_credencial c ON u.id=c.id_usuario 
                                                WHERE u.id='{$id_usuario}'";
                                            $registro = $conexion->query($sql)->fetch(PDO::FETCH_NUM);
                                            $foto = $registro[0];
                                            $name_user = $registro[1];
                                        }

                                        $mostrar = "<form method='post' class='subirBatalla' id='subirBatalla' action='" . $_SERVER["PHP_SELF"] . "'>";
                                        $mostrar .= "
                                            <header class='rowBatalla headerBatalla'>
                                                <img class='imagenUser' src='{$foto}'>
                                                <p class='text-center fw-bold h1'>{$name_user}</p>
                                            </header>
                                            <div class='rowBatalla'>";
                                        $sql = "SELECT nombre, foto FROM elemento WHERE id='$batalla[0]' OR id='$batalla[1]'";
                                        $bandos = $conexion->query($sql);
                                        while ($bando = $bandos->fetch(PDO::FETCH_NUM)) {
                                            $mostrar .=
                                            "<div class='bando'>
                                                <div style='display:flex; justify-content:center;'>
                                                    <img width='200px' height='200px' src='{$bando[1]}'>
                                                </div>
                                                <p class='text-center h1 fw-bold mt-4'>{$bando[0]}</p>
                                                <div class='voteBatalla'>
                                                    <input type='submit' class='submitBatalla btn btn-primary btn-lg' value='VOTAR'>
                                                </div>
                                            </div>";
                                        }
                                        $mostrar .= "</div></form>&nbsp;"; // no le enseñen esto al de los colores que me pega un puño
                                        echo $mostrar;
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "admin/templates/pie.php" ?>