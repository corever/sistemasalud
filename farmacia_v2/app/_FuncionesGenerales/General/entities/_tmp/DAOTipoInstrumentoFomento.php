<?php

/**
 ******************************************************************************
 * Sistema			: MIS FISCALIZACIONES
 *
 * Descripcion		: Modelo para Tabla mfis_tipo_instrumento_fomento
 *
 * Plataforma		: !PHP
 *
 * Creacion			: 09/10/2019
 *
 * @name			DAOTipoInstrumentoFomento.php
 *
 * @version			1.0
 *
 * @author			Gabriel Díaz <gabriel.diaz@cosof.cl>
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


class DAOTipoInstrumentoFomento extends \pan\Kore\Entity
{
	protected $table			= TABLA_TIPO_INSTRUMENTO_FOMENTO;
	protected $primary_key		= "id_instrumento";

	function __construct()
	{
		parent::__construct();
	}

    public function getLista(){
        $query		= "SELECT *
                       FROM ".$this->table;

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return  $result->getRows();
        }else{
            return NULL;
        }
    }

	public function getListaActivas(){
		$query	=
		"	SELECT	*
			FROM	".	$this->table	."
			WHERE	bo_activo			=	1
		";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return  $result->getRows();
        }else{
            return NULL;
        }
    }
}
