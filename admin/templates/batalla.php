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
                                // $conexion = new PDO(DSN, USER, PASSWORD); YA LA HE CREADO EN CABECERA

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
                                    $sql = "SELECT be.id_elemento1, be.id_elemento2, be.id_batalla
                                    FROM batalla_elemento be 
                                    WHERE be.id_batalla NOT IN (
                                            SELECT ub.id_batalla
                                            FROM usuario_batalla ub
                                            WHERE ub.id_usuario = {$_SESSION[SESSION_ID]}
                                        )
                                        AND be.id_batalla NOT IN (
                                            SELECT vt.id_batalla
                                            FROM voto vt
                                            WHERE vt.id_usuario = {$_SESSION[SESSION_ID]}
                                        )
                                        AND be.id_batalla NOT IN (
                                            SELECT ub.id_batalla
                                            FROM usuario_batalla ub
                                            WHERE ub.accion='denunciar'
                                            GROUP BY ub.id_batalla
                                            HAVING count(ub.accion) >= 10
                                        )
                                        AND be.id_batalla NOT IN (
                                            SELECT ub.id_batalla
                                            FROM usuario_batalla ub
                                            WHERE ub.accion='eliminar'
                                        )
                                    ORDER BY RAND() 
                                    LIMIT 1";
                                    $registroBatalla = $conexion->query($sql);

                                    $registroBatalla->bindColumn(1, $elemento1);
                                    $registroBatalla->bindColumn(2, $elemento2);
                                    $registroBatalla->bindColumn(3, $batalla);
                                    $registroBatalla->fetch(PDO::FETCH_BOUND);
                                }
                                if ($batalla == "") { // No hay batalla disponible
                                    echo "<p class='text-center fw-bold h1'>NO QUEDAN BATALLAS DISPLONIBLES</p>";
                                    echo "<a type='button' class='submitBatalla btn btn-primary btn-lg' href='crear.php'>Crear batalla</a>";
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
                                    $rol = selectFromUsuario(["rol"])[0];
                                    $classAdmin = $imagenAdmin = "";
                                    if($rol == "admin"){
                                        $classAdmin ="style='justify-content: space-between;'";
                                        $imagenAdmin = "
                                        <div class='desplegable' style='margin-right:0'>
                                            <img class='imagenUser' src='imagenes/options.png'>
                                            <div class='contenido-desplegable' style='margin-left:0'>
                                                <button type='submit' name='deleteBattle' style='background: none; color: white; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;'>
                                                    BORRAR
                                                </button>
                                            </div>
                                        </div>";
                                    }
                                    $mostrar .= "
                                            <header class='rowBatalla headerBatalla' {$classAdmin}>
                                                <img class='imagenUser' src='{$foto}'>
                                                <p class='text-center fw-bold h1'>{$name_user}</p>
                                                {$imagenAdmin}
                                            </header>
                                            <div class='rowBatalla'>";

                                    // Por cada bando de la batalla se carga la imagen y el nombre del elemento que lo compone y el botón o el nº de votos.
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
                                        if (isset($_SESSION[SESSION_BATTLE_VOTED])) { // Si ha votado se muestran votos en vez de botones
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
                                        $mostrar .= $infoBando;
                                    }

                                    //Se añaden los botones next y denunciar y se cierra el formulario y el div iniciados
                                    $mostrar .= "</div>
                                            <div class='rowBatalla'>
                                                <button type='submit' class='submitBatalla btn btn-primary btn-lg' name='{$nameDeBoton}'>
                                                    <img class='imagenUser' src='imagenes/next.png'>
                                                </button>"; // no le enseñen esto al de los colores que me pega un puño
                                    if (!isset($_SESSION[SESSION_BATTLE_VOTED])) {
                                        $mostrar .= "
                                            <button type='submit' class='submitBatalla btn btn-secondary btn-lg' name='denunciar'>
                                                <img class='imagenUser' src='imagenes/denunciar.png'>
                                            </button>";
                                    }
                                    $mostrar .= "</div>
                                        </form>&nbsp";
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