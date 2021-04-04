<?php
/**
******************************************************************************
* Sistema           : MANTENEDOR ESTABLECIMIENTOS DE SALUD
*
* Descripcion       : Modelo para Tabla noti_auditoria
*
* Plataforma        : !PHP
*
* Creacion          : 25/01/2019
*
* @name             DAOAdjuntoTipo.php
*
* @version          1.0
*
* @author           Victor Retamal <victor.retamal@cosof.cl>
*
******************************************************************************
* !ControlCambio
* --------------
* !cProgramador             !cFecha     !cDescripcion
* ----------------------------------------------------------------------------
*
* ----------------------------------------------------------------------------
* ****************************************************************************
*/
namespace App\_FuncionesGenerales\Adjuntos\Entity;

class DAOAdjuntoTipo extends \pan\Kore\Entity{
    protected $table            = TABLA_ADJUNTO_TIPO;
    protected $primary_key      = "id_adjunto_tipo";
    protected $_transaccional   = false;

    function __construct()
    {
        parent::__construct();
    }

    public function getById($id){
        $query  = " SELECT * FROM ".$this->table."
            WHERE ".$this->primary_key." = ?";

        $param  = array(intval($id));
        $result = $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows(0);
        }else{
            return NULL;
        }
    }

     public function getLista($filtros = []){
        $this->db->select(" *
                          ")
                ->from($this->table, "adj")
                ->whereAND("adj.bo_estado", 1)
                ->whereAND("adj.bo_mostrar", 1)
                ->orderBy("adj.gl_nombre");

        if(!empty($filtros)){
            if(!empty($filtros["id_modulo"])){
                $this->db->whereAND("adj.id_modulo", $filtros["id_modulo"]);
            }
        }

        file_put_contents('php://stderr', PHP_EOL . print_r($this->db->showQuery(), TRUE). PHP_EOL, FILE_APPEND);
        
        $result = $this->db->runQuery();

        if ($result->getNumRows() > 0) {
            return $result->getRows();
        } else {
            return NULL;
        }
    }
}

?>
