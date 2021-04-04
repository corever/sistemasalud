<?php

/**
 ******************************************************************************
 * Sistema           : MIS FISCALIZACIONES
 *
 * Descripcion       : Modelo para Tabla mfis_correlativo_fiscalizacion
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 04/10/2019
 *
 * @name             DAOCorrelativoFiscalizacion.php
 *
 * @version          1.0
 *
 * @author           Francisco Valdés <francisco.valdes@cosof.cl>
 *
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				!cFecha		!cDescripcion
 * ----------------------------------------------------------------------------
 *
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */


namespace App\General\Entity;

class DAOCorrelativoFiscalizacion extends \pan\Kore\Entity
{

    protected $table        = TABLA_CORRELATIVO_FISCALIZACION;
    protected $primary_key    = "id_correlativo";

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Descripcion  :   Genera el folio para fiscalizacion
     * @author          Francisco Valdés <francisco.valdes@cosof.cl>
     * @param           int $id_fiscalizacion
     * @param           int $id_region
     * @return          string $gl_folio         
     */
    public function crearFolio($id_fiscalizacion, $id_region = 0)
    {
        $params['year']             = date('Y');
        $params['region']           = $id_region > 9 ? $id_region : '0' . $id_region;;
        $params['fiscalizacion']    = $id_fiscalizacion;
        $params['user']             = \pan\utils\SessionPan::getSession('id');
        $query                      = " INSERT INTO " . $this->table . "(nr_year,id_region,id_fiscalizacion,id_usuario_crea)
                                        VALUES(?,?,?,?)";


        $response   = $this->db->execQuery($query, array_values($params));
        if ($response) {
            $folio = '' . date('y') . $params['region'] . $this->db->getLastId();
            file_put_contents('php://stderr', PHP_EOL . "QUERY: " . print_r($folio, TRUE) . PHP_EOL, FILE_APPEND);
            return $folio;
        } else {
            return NULL;
        }
    }
}
