<?php
require "BD.php";// quitar?

class batallas
{
    private int $idBatalla;
    private Elemento $elemento;
    private int $idUsuario;
    private BD $bd;
    private int $voto;


public function __construct($idBatalla, $bd)
{
    $this->idBatalla = $idBatalla;
    $this->bd = $bd;
}

public function getUsuarioCreador()
{
    return $this -> idUsuario;
}
public function getVotos($elemento)// revisar
    {
        $sql = "SELECT COUNT(*) FROM voto 
                WHERE id_batalla='{$this->idBatalla}'
                AND id_elemento = '{$elemento}'";
        return $this->bd->getConexion()->query($sql)->fetch(PDO::FETCH_NUM)[0];
    }

    public function pintarBatallas($idBatalla > 0)
{

}

}

?>