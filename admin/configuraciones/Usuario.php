<?php
class Usuario
{
    private $id;
    private $nombreusuario;
    private $num_batallas_ignoradas;
    private $num_batallas_denunciadas;
    private $num_batallas_creadas;
    private $num_batallas_votadas;

    public static function login($nombreusuario)
    {
        $_SESSION[SESSION_USER] = $nombreusuario;
        $_SESSION[SESSION_ID] = BD::select(["id_usuario"], "usuario_credencial", ["nombreusuario", $nombreusuario]);
        BD::insertar("usuario_credencial", [$_SESSION[SESSION_ID], $nombreusuario, "loguear", getMomentoActual()]);
    }

    public function __construct($id, $nombreusuario)
    {
        $this->id = $id;
        $this->nombreusuario = $nombreusuario;
        $datos = [
            ...BD::select(["*"], "credencial", ["nombreusuario", $this->nombreusuario], PDO::FETCH_NAMED)[0],
            ...BD::select(["*"], "usuario", ["id", $this->id], PDO::FETCH_NAMED)[0]
        ];
        $this->num_batallas_ignoradas = $datos["num_batallas_ignoradas"];
        $this->num_batallas_denunciadas = $datos["num_batallas_denunciadas"];
        $this->num_batallas_creadas = $datos["num_batallas_creadas"];
        $this->num_batallas_votadas = $datos["num_batallas_votadas"];
        var_dump($datos);
    }

    // Quita datos de batalla de la sesión para que muestre una nueva  
    public function siguienteBatalla($batalla)
    {
        $this->limpiarSesion([SESSION_CURRENT_BATTLE, SESSION_BATTLE_VOTED]);
    }

    // Insert de que ha ignorado batalla
    // Quita los datos de la batalla de la sesion para que muestre una nueva
    public function ignorarBatalla($batalla)
    {
        $sql = "INSERT INTO usuario_batalla VALUES (
                '', :id_u, :id_b, 'ignorar', :mom
            )";
        $datos = [
            "id_u" => $this->id,
            "id_b" => $batalla->id,
            "mom" => getMomentoActual()
        ];
        try {
            BD::realizarSql(BD::crearConexion(), $sql, $datos);
            $this->limpiarSesion([SESSION_CURRENT_BATTLE, SESSION_BATTLE_VOTED]);
            $this->num_batallas_ignoradas++;
            BD::actualizarUsuario("num_batallas_ignoradas", $this->num_batallas_ignoradas, $this->id);
        } catch (PDOException $e) {
        }
    }

    // Insert de que ha denunciado batalla
    // Quita los datos de la batalla de la sesion para que muestre una nueva
    public function denunciarBatalla($batalla)
    {

        $sqlInsert = "INSERT INTO usuario_batalla VALUES (
            '', :id_u, :id_b, 'denunciar', :mom
            )";
        $sqlSelect = "SELECT count(*) FROM usuario_batalla WHERE accion='denunciar' AND id_batalla=?";
        $datos = [
            "id_u" => $this->id,
            "id_b" => $batalla->id,
            "mom" => getMomentoActual()
        ];
        try {
            BD::realizarSql(BD::crearConexion(), $sqlInsert, $datos);
            $this->num_batallas_denunciadas++;
            BD::actualizarUsuario("num_batallas_denunciadas", $this->num_batallas_denunciadas, $this->id);
            $denuncias = BD::realizarSql(BD::crearConexion(), $sqlSelect, [$batalla->id])[0][0];
            if ($denuncias >= 10 && $batalla->id_creator != null) { // CAMBIAR NUMERO
                $puntos_troll = BD::select(["puntos_troll"], "usuario", ["id", $batalla->id_creator])[0][0];
                $puntos_troll++;
                if ($puntos_troll >= 10) {
                    $nombreusuario = BD::select(["nombreusuario"], "usuario_credencial", ["id_usuario", $batalla->id_creator])[0][0];
                    BD::delete("usuario_credencial", "id", $batalla->id_creator);
                    BD::delete("credencial", "nombreusuario", $nombreusuario);
                    BD::delete("usuario", "id", $batalla->id_creator);
                    $batalla->removeUser();
                } else {
                    BD::actualizarUsuario("puntos_troll", $puntos_troll, $batalla->id_creator);
                }
            }
            $this->limpiarSesion([SESSION_CURRENT_BATTLE, SESSION_BATTLE_VOTED]);
        } catch (PDOException $e) {
        } catch (Exception $e) {
        }
    }

    // Insert de batalla eliminada del administrador
    // Quita los datos de la batalla de la sesion para que muestre una nueva
    public function borrarBatalla($batalla)
    {
        BD::insertar("usuario_batalla", ["", $this->id, $batalla->id, "eliminar", getMomentoActual()]);
        $this->limpiarSesion([SESSION_CURRENT_BATTLE, SESSION_BATTLE_VOTED]);
    }

    public function crearBatalla($id_elemento1, $id_elemento2)
    {
        $id_batalla = BD::insertar("batalla_elemento", ["", $id_elemento1, $id_elemento2]);
        BD::insertar("usuario_batalla", ["", $this->id, $id_batalla, "crear", getMomentoActual()]);
        $this->num_batallas_creadas++;
        BD::actualizarUsuario("num_batallas_creadas", $this->num_batallas_creadas, $this->id);
        return $id_batalla; // Para cogerla en $_SESSION[SESSION_CURRENT_BATTLE]
    }

    public function votarBatalla($batalla, $elemento)
    {
        $sql = "INSERT INTO voto VALUES (
            :id_u, :id_b, :id_e, :mom
            )";
        $datos = [
            "id_u" => $this->id,
            "id_b" => $batalla->id,
            "id_e" => $elemento->id,
            "mom" => getMomentoActual()
        ];
        $_SESSION[SESSION_BATTLE_VOTED] = true; // Sacar???????????
        BD::realizarSql(BD::crearConexion(), $sql, $datos);
        $this->num_batallas_votadas++;
        BD::actualizarUsuario("num_batallas_votadas",  $this->num_batallas_votadas, $this->id);
    }

    private function limpiarSesion($datossesion)
    {
        foreach ($datossesion as $dato) {
            unset($_SESSION[$dato]);
        }
    }
}

// $u = new Usuario(1, "Mario");
// echo "<br/><br/><br/>";
// var_dump($u);
