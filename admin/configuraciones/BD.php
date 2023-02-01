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

    /**
     * Devuelve una conexión PDO
     */
    public static function crearConexion(){
        return new PDO(BD::DSN, BD::USER, BD::PASSWORD);
    }

    /**
     * @param campos array con el nombre de las caolumnas o las operaciones sobre las que trabajar 
     * @param tabla string con el nombre de la tabla
     * @param where array de 2 de longitud donde el primer valor es el nombre de la columna y el segundo el valor que toma
     * @param fetch constante de PDO para el tipo de extracción de datos
     */
    public static function select($campos, $tabla, $where=[], $fetch=PDO::FETCH_NUM)
    {
        $conexion = BD::crearConexion();
        $sql = "SELECT " . implode(", ", $campos) . " FROM {$tabla} ";
        if (count($where) > 0) {
            $sql .= "WHERE {$where[0]}='{$where[1]}'";
        }
        return BD::realizarSql($conexion, $sql, [], $fetch);
    }

    /**
     * @param tabla string con el nombre de la tabla
     * @param datos array con el conjunto de valores de todas las columnas
     */
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

    /**
     * @param tabla string con el nombre de la tabla
     * @param setTablas array de strings con el nombre de las columnas a modificar
     * @param setValores array de valores que toman las columnas anteriores
     * @param wherecolumna string nombre de la columna
     * @param wherevalor valor que toma la columna anterior
     */
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

    /**
     * @param tabla string con el nombre de la tabla
     * @param columna string con el nombre de la columna que permite identificar al elemento/s
     * @param dato valor que toma la columna anterior
     */
    public static function delete($tabla, $columna, $dato)
    {
        $conexion = BD::crearConexion();
        $sql = "DELETE FROM {$tabla} WHERE {$columna} = ? ";
        BD::realizarSql($conexion, $sql, [$dato]);
    }

    /**
     * Realiza una consulta sql preparada pasada por parámetro rellenando sus datos con el array datos
     */
    public static function realizarSql($conexion, $sql, $datos, $fetch=PDO::FETCH_NUM)
    {
        $preparedSttm = $conexion->prepare($sql);
        $preparedSttm->execute($datos);
        if(startsWith($sql, "SELECT")){
            return $preparedSttm->fetchAll($fetch);
        }
    }

}


