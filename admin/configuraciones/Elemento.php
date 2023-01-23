<?php
class Elemento
{
    private int $id;
    private $foto;
    private $nombre;

    public function __construct($id)
    {
        $this->id = $id;
        $this->nombre = BD::select(["nombre"], "elemento", ["id", $this->id])[0][0];
        $this->foto = BD::select(["foto"], "elemento", ["id", $this->id])[0][0];
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getFoto(){
        return $this->foto;
    }

    public function getVotos($batalla)// revisar
    {
        $sql = "SELECT COUNT(*) FROM voto 
                WHERE id_elemento=?
                    AND id_batalla=?";
        return BD::realizarSql(BD::crearConexion(), $sql, [$this->id, $batalla])[0][0];
    }

    public function printComplex($voted, $batalla = -1)
    {
        if($voted){ // Si ha votado se muestran votos en vez de botones
            $infoDiv = 
                "<p class='text-center h1 fw-bold'>{$this->getVotos($batalla)}</p>";
        }else{
            $infoDiv = 
                "<button name='elementoVotado' type='submit' class='submitBatalla btn btn-primary btn-lg' value='{$this->id}'>
                    <img class='imagenUser' src='../../imagenes/thumbsUp.png'>
                </button>";
        }
        $infoBando =
            "<div class='bando'>
                <div style='display:flex; justify-content:center;'>
                    <img width='200px' height='200px' src='{$this->foto}'>
                </div>
                <p class='text-center h1 fw-bold mt-4'>{$this->nombre}</p>
                <div class='voteBatalla'>{$infoDiv}</div>
            </div>";
        return $infoBando;
    }
}
// $e = new Elemento(9, new BD(true));
// echo $e->printComplex(true, 3);
