<link rel="stylesheet" href="../../css/archivo.css">
<?php
session_start();
require_once "Elemento.php";
class Batalla
{
    private $id;
    private $id_creator;
    private $elements;

    public static function getBatalla()
    {
        $batalla = null;
        if (isset($_SESSION[SESSION_CURRENT_BATTLE])) {
            $batalla = new Batalla($_SESSION[SESSION_CURRENT_BATTLE]);
        } else {
            /**
             * Coger una batalla aleatoriamente
             * que no ha creado el usuario
             * que no ha votado
             * que no tiene 10 o más denuncias
             * que no ha sido eliminada
             */
            $sql =
                "SELECT be.id_batalla
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
            $registroBatalla = BD::realizarSql(BD::crearConexion(), $sql, []);
            if (count($registroBatalla) > 0) {
                $batalla = new Batalla($registroBatalla[0][0]);
                $_SESSION[SESSION_CURRENT_BATTLE] = $batalla->id;
            }
        }
        return $batalla;
    }

    public function __construct($batalla)
    {
        $this->id = $batalla;
        $sql = "SELECT id_usuario FROM usuario_batalla WHERE id_batalla = ? AND accion LIKE (?)";
        $id_creator = BD::realizarSql(BD::crearConexion(), $sql, [$this->id, 'crear']);
        if (count($id_creator) == 0) { // Usuario borrado
            $this->id_creator = null;
        } else {
            $this->id_creator = $id_creator[0][0];
        }
        $id_elementos = BD::select(["id_elemento1, id_elemento2"], "batalla_elemento", ["id_batalla", $this->id])[0];
        $this->elements = [];
        array_push($this->elements, new Elemento($id_elementos[0]));
        array_push($this->elements, new Elemento($id_elementos[1]));
    }

    public function printComplex() // RETOCAR
    {
        $voted = $_SESSION[SESSION_BATTLE_VOTED];
        // $voted = false;
        $nameDeBoton = "ignorar";
        if ($voted) $nameDeBoton = "siguiente";

        $foto = "../../imagenes/nouser.png"; // CONSTANTES???
        $name_user = "Usuario borrado";

        if ($this->id_creator != null) {
            $foto = BD::select(["foto"], "usuario", ["id", $this->id_creator])[0][0];
            $name_user = BD::select(["nombreusuario"], "usuario_credencial", ["id_usuario", $this->id_creator])[0][0];
        }

        $mostrar =
            "<form method='post' class='subirBatalla' id='subirBatalla' action='procesos/procesarVoto.php'>";
        // $rol = selectFromUsuario(["rol"])[0];
        $rol = "admin";
        $classAdmin = $opcionesAdmin = "";
        if ($rol == "admin") {
            $classAdmin = "style='justify-content: space-between;'";
            $opcionesAdmin = "
                <div class='desplegable' style='margin-right:0'>
                    <img class='imagenUser' src='../../imagenes/options.png'>
                    <div class='contenido-desplegable' style='margin-left:0'>
                        <button type='submit' name='deleteBattle' style='background: none; color: white; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;'>
                            DELETE
                        </button>
                    </div>
                </div>";
        }
        $mostrar = "";
        if ($this->id_creator == null) {
            $mostrar .=
                "<header class='rowBatalla headerBatalla' {$classAdmin}>
                    <img class='imagenUser' src='{$foto}'>
                    <p class='text-center fw-bold h1'>
                        {$name_user}
                    </p>
                    {$opcionesAdmin}
                </header>";
        } else {
            $mostrar .=
                "<header class='rowBatalla headerBatalla' {$classAdmin}>
                    <a href='perfil.php?usuario={$this->id_creator}'>
                        <img class='imagenUser' src='{$foto}'>
                    </a>
                    <p class='text-center fw-bold h1'>
                        <a href='perfil.php?usuario={$this->id_creator}' style='color:white;'>
                            {$name_user}
                        </a>
                    </p>
                    {$opcionesAdmin}
                </header>";
        }
        $mostrar .=
            "<div class='rowBatalla'>";
        foreach ($this->elements as $element) {
            $mostrar .= $element->printComplex($voted, $this->id);
        }
        $mostrar .=
            "</div>
            <div class='rowBatalla'>
                <button type='submit' class='submitBatalla btn btn-primary btn-lg' name='{$nameDeBoton}'>
                    <img class='imagenUser' src='../../imagenes/next.png'>
                </button>";
        if (!$voted) {
            $mostrar .=
                "<button type='submit' class='submitBatalla btn btn-secondary btn-lg' name='denunciar'>
                    <img class='imagenUser' src='../../imagenes/denunciar.png'>
                </button>";
        }
        $mostrar .=
            "</div>
            </form>&nbsp";
        return $mostrar;
    }
}

// $b = new Batalla(9);
// echo $b->printComplex(false);
// echo Batalla::getBatalla()->printComplex();
