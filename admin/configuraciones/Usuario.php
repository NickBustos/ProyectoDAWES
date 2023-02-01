<?php
class Usuario
{
    private string $nombreusuario;
    private string $password;
    private string $id;
    private string $fechanacimiento;
    private string $foto;
    private string $email;
    private string $modovis;
    private string $idioma;
    private string $rol;
    private string $num_elementos_creados;
    private int $num_batallas_creadas;
    private int $num_batallas_votadas;
    private int $num_batallas_ignoradas;
    private int $num_batallas_denunciadas;
    private int $puntos_troll;

    public function __construct($id, $nombreusuario)
    {
        $this->id = $id;
        $this->nombreusuario = $nombreusuario;
        $datos = [
            ...BD::select(["*"], "credencial", ["nombreusuario", $this->nombreusuario], PDO::FETCH_NAMED)[0],
            ...BD::select(["*"], "usuario", ["id", $this->id], PDO::FETCH_NAMED)[0]
        ];
        $this->password = $datos["password"];
        $this->fechanacimiento = $datos["fechanacimiento"];
        $this->foto = $datos["foto"];
        $this->email = $datos["email"];
        $this->modovis = $datos["modovis"];
        $this->idioma = $datos["idioma"];
        $this->rol = $datos["rol"];
        $this->num_elementos_creados = $datos["num_elementos_creados"];
        $this->num_batallas_creadas = $datos["num_batallas_creadas"];
        $this->num_batallas_votadas = $datos["num_batallas_votadas"];
        $this->num_batallas_ignoradas = $datos["num_batallas_ignoradas"];
        $this->num_batallas_denunciadas = $datos["num_batallas_denunciadas"];
        $this->puntos_troll = $datos["puntos_troll"];
    }

    public static function login($nombreusuario)
    {
        $_SESSION[SESSION_USER] = $nombreusuario;
        $_SESSION[SESSION_ID] = BD::select(["id_usuario"], "usuario_credencial", ["nombreusuario", $nombreusuario])[0][0];
        BD::insertar("usuario_credencial", ["", $_SESSION[SESSION_ID], $nombreusuario, "loguear", getMomentoActual()]);
    }
    /**
     * Sube unos datos pasados como parámetro como un nuevo usuario a la base de datos
     * @return id del usuario
     */
    public static function registrarUsuario($datos)
    {
        //[$user, $pass, $fechaNac, $avatar, $mail]
        BD::insertar("credencial", [$datos[0], md5($datos[1])]);
        // Coger modovis e idioma
        $modovis = "light";
        if (isset($_SESSION["modovis"]) && $_SESSION["modovis"] == "dark") {
            $modovis = "dark";
        }
        $idioma = "es";
        if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] == "en") {
            $idioma = "en";
        }
        // Campos: id, fecha, foto, email, modovis, idioma, rol, elementos_creados, batallas_creadas, votadas, ignoradas, denunciadas, puntos_troll
        $id = BD::insertar("usuario", ['', $datos[2], $datos[3], $datos[4], $modovis, $idioma, 'usuario', '0', '0', '0', '0', '0', '0']);
        $momento = getMomentoActual();
        // campos: id_usuario, nombre, accion, fechatime, 
        BD::insertar("usuario_credencial", ['', $id, $datos[0], 'registrar', $momento]);
        BD::insertar("usuario_credencial", ['', $id, $datos[0], 'loguear', $momento]);
        return $id;
    }

    
    /**
     * Actualiza uno de los datos de un usuario con un id concreto
     */
    public static function actualizarUsuario($campo, $actualizacion, $id)
    {
        BD::update("usuario", [$campo], [$actualizacion], "id", $id);
    }

    /**
     * Verifica si un nombre de usuario existe
     * @return contraseña del usuario en cuestión o false si no lo encuentra
     */
    static function existe($user)
    {
        $conexion = BD::crearConexion();
        $sql = "SELECT password FROM credencial WHERE nombreusuario = '{$user}'";
        $resultado = $conexion->query($sql);
        if ($linea = $resultado->fetch(PDO::FETCH_NUM)) {
            return $linea[0];
        }
        return false;
    }

    public function __get($var)
    {
        if (property_exists(__CLASS__, $var)) {
            return $this->$var;
        }
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
            Usuario::actualizarUsuario("num_batallas_ignoradas", $this->num_batallas_ignoradas, $this->id);
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
            Usuario::actualizarUsuario("num_batallas_denunciadas", $this->num_batallas_denunciadas, $this->id);
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
                    Usuario::actualizarUsuario("puntos_troll", $puntos_troll, $batalla->id_creator);
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
        Usuario::actualizarUsuario("num_batallas_creadas", $this->num_batallas_creadas, $this->id);
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
        BD::realizarSql(BD::crearConexion(), $sql, $datos);
        $this->num_batallas_votadas++;
        Usuario::actualizarUsuario("num_batallas_votadas",  $this->num_batallas_votadas, $this->id);
    }

    public function limpiarSesion($datossesion)
    {
        foreach ($datossesion as $dato) {
            if (isset($_SESSION[$dato])) {
                unset($_SESSION[$dato]);
            }
        }
    }
}
