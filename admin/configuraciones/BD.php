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

    // ----------------------------------------- GENERALES ----------------------------------------

    public static function crearConexion(){
        return new PDO(BD::DSN, BD::USER, BD::PASSWORD);
    }

    public static function select($campos, $tabla, $where=[], $fetch=PDO::FETCH_NUM)
    {
        $conexion = BD::crearConexion();
        $sql = "SELECT " . implode(", ", $campos) . " FROM {$tabla} ";
        if (count($where) > 0) {
            $sql .= "WHERE {$where[0]}='{$where[1]}'";
        }
        return BD::realizarSql($conexion, $sql, [], $fetch);
    }

    public static function insertar($tabla, $datos)
    {
        $conexion = BD::crearConexion();
        $sql = "INSERT INTO {$tabla} VALUES (";
        for ($i = 0; $i < count($datos); $i++) {
            $sql .= ":{$i}";
            if ($i < count($datos) - 1) {
                $sql .= ", ";
            } else {
                $sql .= ")";
            }
        }
        $preparedSttm = $conexion->prepare($sql);
        foreach ($datos as $key => &$val) {
            $preparedSttm->bindParam(":{$key}", $val);
        }
        $preparedSttm->execute();
        return $conexion->lastInsertId();
    }

    public static function update($tabla, $setTablas, $setValores, $whereColumna, $whereValor)
    {
        $conexion = BD::crearConexion();
        $sql = "UPDATE {$tabla} SET";
        for ($i = 0; $i < count($setTablas); $i++) {
            $sql .= " {$setTablas[$i]}=?";
            if ($i < count($setTablas) - 1) {
                $sql .= ",";
            }
            $sql .= " WHERE {$whereColumna}='{$whereValor}'";
        }
        BD::realizarSql($conexion, $sql, $setValores);
    }

    public static function delete($tabla, $columna, $dato)
    {
        $conexion = BD::crearConexion();
        $sql = "DELETE FROM {$tabla} WHERE {$columna} = ? ";
        BD::realizarSql($conexion, $sql, [$dato]);
    }

    public static function realizarSql($conexion, $sql, $datos, $fetch=PDO::FETCH_NUM)
    {
        $preparedSttm = $conexion->prepare($sql);
        $preparedSttm->execute($datos);
        if(startsWith($sql, "SELECT")){
            return $preparedSttm->fetchAll($fetch);
        }
    }

    // ------------------------------------------ USUARIO -----------------------------------------
    // REVISARRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR

    public static function selectFromUsuario($campos)
    {
        $conexion = BD::crearConexion();
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

    public static function existe($user)
    {
        $conexion = BD::crearConexion();
        $sql = "SELECT password FROM credencial WHERE nombreusuario = '{$user}'";
        $resultado = $conexion->query($sql);
        if ($linea = $resultado->fetch(PDO::FETCH_NUM)) {
            return $linea[0];
        }
        return false;
    }

    public static function subirUsuario($datos)
    {

        BD::insertar("credencial", [$datos[0], md5($datos[1])]);
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
        $id = BD::insertar("usuario", ['', $datos[2], $datos[3], $datos[4], $modovis, $idioma, 'usuario', '0', '0', '0', '0', '0', '0']);
        $momento = getMomentoActual();
        // campos: id_usuario, nombre, accion, fechatime, 
        BD::insertar("usuario_credencial", ['', $id, $datos[0], 'registrar', $momento]);
        BD::insertar("usuario_credencial", ['', $id, $datos[0], 'loguear', $momento]);
        return $id;
    }

    public static function actualizarUsuario($campo, $actualizacion, $id)
    {
        BD::update("usuario", [$campo], [$actualizacion], "id", $id);
    }
}

// $bd = new BD(true);
// $bd->select(["*"], "usuario");
// BD::insertar("usuario", ["","","","","","","","","","","","",""]);
// BD::update("usuario", ["email"], ["pepe"], "id", 9);
// BD::delete("usuario", "id", 9);

// var_dump(BD::realizarSql(BD::crearConexion(), "SELECT * FROM usuario", []));
// var_dump(BD::select(["*"], "usuario", []));

