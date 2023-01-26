<?php

class Persona
{
    private $perfilId;
    private $perfilFoto;
    private $perfilBatallasCreadas;
    private $perfilVotos;
    private $perfilDenuncias;

    /*function __construct()
    {
        
    }*/

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
        $conexion = new PDO(DSN, USER, PASSWORD);
        $sql = "SELECT password FROM credencial WHERE nombreusuario = '{$user}'";
        $resultado = $conexion->query($sql);
        // return count($resultado->fetchAll(PDO::FETCH_NUM));
        if ($linea = $resultado->fetch(PDO::FETCH_NUM)) {
            return $linea[0];
        }
        return false;
    }
}
