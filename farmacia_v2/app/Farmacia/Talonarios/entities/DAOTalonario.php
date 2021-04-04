<?php

namespace App\Farmacia\Talonarios\Entity;

class DAOTalonario extends \pan\Kore\Entity
{

    protected $table       = TABLA_TALONARIO;
    protected $primary_key = "talonario_id";

    function __construct()
    {
        parent::__construct();
    }

    public function getLista()
    {
        $query    = "SELECT * FROM " . $this->table;
        $result    = $this->db->getQuery($query)->runQuery();

        if ($result->getNumRows() > 0) {
            return $result->getRows();
        } else {
            return NULL;
        }
    }

    /**
     * valida si los números de folio ingresados existen en el sistema para la serie
     */
    public function getValidarFolioExiste($nr_folio_inicial, $nr_folio_final, $gl_serie)
    {
        $query = "SELECT count(1) as existeFolio FROM " . $this->table
            . " WHERE talonario_folio_inicial < $nr_folio_final"
            . " AND talonario_folio_final > $nr_folio_inicial"
            . " AND talonario_serie = '" . $gl_serie . "'";

        $result = $this->db->getQuery($query)->runQuery();
 
        $rows = $result->getRows();
        $res = $rows[0]; 
        if (0 === (int)$res->existeFolio) {
            return TRUE;
        }
        return FALSE;
    }
}
