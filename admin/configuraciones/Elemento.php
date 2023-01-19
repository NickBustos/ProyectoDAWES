<?php
require "BD.php";// quitar?
class Elemento
{
    private int $id;
    private $foto;
    private $nombre;
    private BD $bd;

    public function __construct($id, $bd)
    {
        $this->id = $id;
        $this->bd = $bd;
        return $this->bd->select(["nombre"], "elemento", ["id_elemento", $this->id])[0];
        return $this->bd->select(["foto"], "elemento", ["id_elemento", $this->id])[0];
    }

    public function getNombre(){
        return $this->nombre;
    }
    

    

    public function getFoto(){
        return $this->foto;
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
