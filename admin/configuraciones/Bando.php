<?php
require "BD.php";// quitar?
class Bando
{
    private int $id;
    private BD $bd;

    public function __construct($id, $bd)
    {
        $this->id = $id;
        $this->bd = $bd;
    }

    public function getNombre(){
        return $this->bd->select(["nombre"], "elemento", ["id_elemento", $this->id])[0];// Es nombre?
    }

    public function getFoto(){
        return $this->bd->select(["foto"], "elemento", ["id_elemento", $this->id])[0];
    }

    public function getVotos($batalla)// revisar
    {
        $sql = "SELECT COUNT(*) FROM voto 
                WHERE id_elemento='{$this->id}'
                    AND id_batalla='{$batalla}'";
        return $this->bd->getConexion()->query($sql)->fetch(PDO::FETCH_NUM)[0];
    }

    public function printComplex($voted, $batalla = -1)
    {
        if($voted){ // Si ha votado se muestran votos en vez de botones
            $infoDiv = 
                "<p class='text-center h1 fw-bold'>{$this->getVotos($batalla)}</p>";
        }else{
            $infoDiv = 
                "<button name='elementoVotado' type='submit' class='submitBatalla btn btn-primary btn-lg' value='{$this->id}'>
                    <img class='imagenUser' src='imagenes/thumbsUp.png'>
                </button>";
        }
        $infoBando =
            "<div class='bando'>
                <div style='display:flex; justify-content:center;'>
                    <img width='200px' height='200px' src='{$this->getFoto()}'>
                </div>
                <p class='text-center h1 fw-bold mt-4'>{$this->getNombre()}</p>
                <div class='voteBatalla'>{$infoDiv}</div>
            </div>";
        return $infoBando;
    }
}
