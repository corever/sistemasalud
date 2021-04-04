<?php

/**
 ******************************************************************************
 * Sistema           : MIS FISCALIZACIONES
 *
 * Descripcion       : Modelo para Tabla mfis_historial_evento
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 09/10/2019
 *
 * @name             DAOEvento.php
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


class DAOEvento extends \pan\Kore\Entity
{
    protected $table            = TABLA_EVENTO;
    protected $primary_key        = "id_evento";

    function __construct()
    {
        parent::__construct();
    }

    public function getByIdFiscalizacion($id_fiscalizacion)
    {
        $query    = "	SELECT 
                            evento.*,
                            tipo.gl_nombre_evento_tipo,
                            CONCAT_WS(' ', usuario.gl_nombres, usuario.gl_apellido_paterno, usuario.gl_apellido_materno) AS gl_nombre_completo                      
                        FROM " . $this->table . " evento
                        JOIN " . TABLA_EVENTO_TIPO . " tipo ON evento.id_evento_tipo = tipo.id_evento_tipo
                        JOIN " . TABLA_ACCESO_USUARIO . " usuario ON evento.id_usuario_crea = usuario.id_usuario
                        WHERE evento.id_fiscalizacion = ?
                        AND evento.bo_estado = 1";

        $result    = $this->db->getQuery($query, $id_fiscalizacion)->runQuery();
        if ($result->getNumRows() > 0) {
            return $result->getRows();
        } else {
            return NULL;
        }
    }
}
