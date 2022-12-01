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
                                    //Si no ha iniciado sesión no muestra nada
                                    if (!isset($_SESSION[SESSION_ID])) {
                                        echo "<h1 style='text-align:center;'>¿Qué haces?</h1><br/>";
                                        echo "<img src='imagenes/luigi.png'><br/>";
                                        exit();
                                    }
                                    /**
                                     * Realizamos un select, para recoger todas las batallas
                                     * Por cada batalla el id del elemento 1 es batalla[0] y el id del elemento 2 es batalla [1].
                                     * Cada elemento esta formado, por el nombre y la foto.
                                     * A continuación mostramos los elementos, haciendo un echo $mostrar.
                                     * Por cada batalla encontrado, se realiza un while
                                     */
                                    $conexion = new PDO(DSN, USER, PASSWORD);

                                    $batalla = $elemento1 = $elemento2 = "";
                                    $nameDeBoton = "ignorar"; // de base el boton es ignorar

                                    if (isset($_SESSION[SESSION_CURRENT_BATTLE])) {
                                        $batalla = $_SESSION[SESSION_CURRENT_BATTLE];
                                        $elemento1 = $_SESSION[SESSION_BATTLE_ELEM_1];
                                        $elemento2 = $_SESSION[SESSION_BATTLE_ELEM_2];

                                        if (isset($_SESSION[SESSION_BATTLE_VOTED])) {
                                            // HA VOTADO
                                            $nameDeBoton = "siguiente"; // si ha votado es siguiente
                                        }
                                    } else {
                                        //COMPROBAR QUE TENGA EN CUENTA LA TABLA VOTO TAMBIÉN

                                        /*
                                        SELECT be.id_elemento1, be.id_elemento2, be.id_batalla 
            FROM batalla_elemento be 
            INNER JOIN usuario_batalla ub
            	ON be.id_batalla = ub.id_batalla
            INNER JOIN voto vt
            	ON ub.id_usuario = vt.id_usuario
            WHERE ub.id_usuario <> '10'
            ORDER BY RAND() LIMIT 1

                                        */
                                        $sql = "SELECT be.id_elemento1, be.id_elemento2, be.id_batalla 
                                                    FROM batalla_elemento be 
                                                    INNER JOIN usuario_batalla ub
                                                        ON be.id_batalla = ub.id_batalla
                                                    WHERE ub.id_usuario <> '{$_SESSION[SESSION_ID]}'
                                                    ORDER BY RAND() LIMIT 1";
                                        $registroBatalla = $conexion->query($sql);

                                        $registroBatalla->bindColumn(1, $elemento1);
                                        $registroBatalla->bindColumn(2, $elemento2);
                                        $registroBatalla->bindColumn(3, $batalla);
                                        $registroBatalla->fetch(PDO::FETCH_BOUND);
                                    }
                                    if ($batalla == "") { // No hay batalla disponible
                                        echo "<p class='text-center fw-bold h1'>NO QUEDAN BATALLAS DISPLONIBLES</p>";
                                        echo "
                                        <form action='crearBatalla.php'>
                                            <input type='submit' class='submitBatalla btn btn-primary btn-lg' value='Crear batalla'>
                                        </form>";
                                    } else {
                                        // Guardar datos de batalla en sesión para poder hacer operaciones con ellos
                                        $_SESSION[SESSION_CURRENT_BATTLE] = $batalla;
                                        $_SESSION[SESSION_BATTLE_ELEM_1] = $elemento1;
                                        $_SESSION[SESSION_BATTLE_ELEM_2] = $elemento2;

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
                                            $infoBando =
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
                                            if(isset($_SESSION[SESSION_BATTLE_VOTED])){
                                                $sql = "SELECT COUNT(*) FROM voto 
                                                    WHERE id_elemento='{$bando['id']}'
                                                        AND id_batalla='{$batalla}'";
                                                $votos = $conexion->query($sql)->fetch(PDO::FETCH_NUM)[0];
                                                
                                                $infoBando =
                                                "<div class='bando'>
                                                    <div style='display:flex; justify-content:center;'>
                                                        <img width='200px' height='200px' src='{$bando['foto']}'>
                                                    </div>
                                                    <p class='text-center h1 fw-bold mt-4'>{$bando['nombre']}</p>
                                                    <div class='voteBatalla'>
                                                        <p class='text-center h1 fw-bold'>{$votos}</p>
                                                    </div>
                                                </div>";
                                            }
                                            $mostrar.=$infoBando;
                                        }

                                        //Se añaden los botones next y denunciar y se cierra el formulario y el div iniciados
                                        $mostrar .= "</div>
                                            <div class='rowBatalla'>
                                                <button type='submit' class='submitBatalla btn btn-primary btn-lg' name='{$nameDeBoton}'>
                                                    <img class='imagenUser' src='imagenes/next.png'>
                                                </button>
                                                <button type='submit' class='submitBatalla btn btn-secondary btn-lg' name='denunciar'>
                                                    <img class='imagenUser' src='imagenes/denunciar.png'>
                                                </button>
                                            </div>
                                            </form>&nbsp;"; // no le enseñen esto al de los colores que me pega un puño
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