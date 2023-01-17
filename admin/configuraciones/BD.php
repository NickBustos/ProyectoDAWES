<?php

class BD
{
    const HOST = "localhost"; // o 127.0.0.1
    const USER = "root";
    const PASSWORD = "";
    const NAME = "dbbatallas";
    const DRIVER = "mysql"; //PARA PDO
    const DSN = BD::DRIVER . ":host=" . BD::HOST . ";dbname=" . BD::NAME;

    // const HOST = "sql307.byethost22.com";// o 127.0.0.1
    // const USER = "b22_32770819";
    // const PASSWORD = "grupoDAWES";
    // const BD = "b22_32770819_dbbatallas";
    // const DRIVER = "mysql"; //PARA PDO
    // const DSN = DRIVER . ":host=" . HOST . ";dbname=" . BD;

    private $conexion;

    public function __construct($conect)
    {
        if ($conect) {
            $this->startConexion();
        }
    }

    public function startConexion()
    {
        $this->conexion = new PDO(BD::DSN, BD::USER, BD::PASSWORD);
    }

    public function isConnected()
    {
        return (isset($this->conexion));
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    // ----------------------------------------- GENERALES ----------------------------------------

    public function select($campos, $tabla, $where=[])
    {
        $sql = "SELECT " . implode(", ", $campos) . " FROM {$tabla} ";
        if (count($where) > 0) {
            $sql .= "WHERE {$where[0]}='{$where[1]}'";
        }
        $resultado = $this->conexion->query($sql);
        $registros = $resultado->fetchAll(PDO::FETCH_NUM);
        return $registros;
    }

    public function insertar($tabla, $datos)
    {
        $sql = "INSERT INTO {$tabla} VALUES (";
        for ($i = 0; $i < count($datos); $i++) {
            $sql .= ":{$i}";
            if ($i < count($datos) - 1) {
                $sql .= ", ";
            } else {
                $sql .= ")";
            }
        }
        $preparedSttm = $this->conexion->prepare($sql);
        foreach ($datos as $key => &$val) {
            $preparedSttm->bindParam(":{$key}", $val);
        }
        $preparedSttm->execute();
        return $this->conexion->lastInsertId();
    }

    public function update($tabla, $setTablas, $setValores, $whereColumna, $whereValor)
    {
        $sql = "UPDATE {$tabla} SET";
        for ($i = 0; $i < count($setTablas); $i++) {
            $sql .= " {$setTablas[$i]}=?";
            if ($i < count($setTablas) - 1) {
                $sql .= ",";
            }
            $sql .= " WHERE {$whereColumna}='{$whereValor}'";
        }
        $this->conexion->prepare($sql)->execute($setValores);
    }

    public function delete($tabla, $columna, $dato)
    {
        $sql = "DELETE FROM {$tabla} WHERE {$columna} = ? ";
        $this->conexion->prepare($sql)->execute([$dato]);
    }

    public function realizarSql($sql, $datos)
    {
        $preparedSttm = $this->conexion->prepare($sql);
        $preparedSttm->execute($datos);
    }

    // ------------------------------------------ USUARIO -----------------------------------------

    public function selectFromUsuario($campos)
    {
        $conexion = new PDO(DSN, USER, PASSWORD);
        $sql = "SELECT ";
        for ($i = 0; $i < count($campos); $i++) {
            $sql .= "{$campos[$i]}";
            if ($i < count($campos) - 1) {
                $sql .= ",";
            }
            $sql .= " ";
        }
        $sql .= " FROM usuario WHERE id='" . $_SESSION[SESSION_ID] . "'";
        $resultado = $conexion->query($sql);
        $registro = $resultado->fetch(PDO::FETCH_NUM);
        return $registro;
    }

    public function existe($user)
    {
        $sql = "SELECT password FROM credencial WHERE nombreusuario = '{$user}'";
        $resultado = $this->conexion->query($sql);
        if ($linea = $resultado->fetch(PDO::FETCH_NUM)) {
            return $linea[0];
        }
        return false;
    }

    public function subirUsuario($datos)
    {

        $this->insertar("credencial", [$datos[0], md5($datos[1])]);
        // Coger modovis e idioma



        // CLASE USUARIO ???
        $modovis = "light";
        if (isset($_SESSION["modovis"]) && $_SESSION["modovis"] == "dark") {
            $modovis = "dark";
        }
        $idioma = "es";
        if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] == "en") {
            $idioma = "en";
        }
        // Campos: id, fecha, foto, email, modovis, idioma, rol
        $id = $this->insertar("usuario", ['', $datos[2], $datos[3], $datos[4], $modovis, $idioma, 'usuario', '0', '0', '0', '0', '0', '0']);



        $momento = getMomentoActual();
        // campos: id_usuario, nombre, accion, fechatime, 
        $this->insertar("usuario_credencial", ['', $id, $datos[0], 'registrar', $momento]);
        $this->insertar("usuario_credencial", ['', $id, $datos[0], 'loguear', $momento]);
        return $id;
    }

    public function actualizarUsuario($campo, $actualizacion, $id)
    {
        $this->update("usuario", [$campo], [$actualizacion], "id", $id);
    }

    //------------------------------------------ BATALLA ------------------------------------------

    public function buscarBatalla($idUsuario)
    {
        $query =
            'SELECT id_elemento1, id_elemento2 
        FROM batalla_elemento 
        WHERE id_batalla = ANY 
            ( SELECT id_batalla FROM usuario_batalla WHERE id_usuario = ' . $idUsuario . ' AND accion LIKE ("crear"));';
        $resultado = $this->conexion->query($query);
        $arr = array();
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function infoBatalla($idElemento, $info)
    {
        $query = "SELECT " . $info . " FROM elemento WHERE id = '" . $idElemento . "'";
        $resultado = $this->conexion->query($query);
        $registro = $resultado->fetchAll(PDO::FETCH_COLUMN);
        return $registro;
    }
}

$bd = new BD(true);
$bd->select(["*"], "usuario");
