<?php

/**
 ******************************************************************************
 * Sistema			: MIS FISCALIZACIONES
 *
 * Descripcion		: Modelo para Tabla mfis_tipo_campo
 *
 * Plataforma		: !PHP
 *
 * Creacion			: 09/10/2019
 *
 * @name			DAOTipoCampo.php
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


class DAOTipoCampo extends \pan\Kore\Entity
{
	protected $table			= TABLA_TIPO_CAMPO;
	protected $primary_key		= "id_tipo";

	const TIPO_LISTA_UNICA = 1;
	const TIPO_TEXTO = 2;
	const TIPO_LISTA_MULTIPLE = 3;

	function __construct()
	{
		parent::__construct();
	}

	public function getListaActivos(){
		$query		= "	SELECT	*
						FROM	".	$this->table	."
						WHERE	bo_activo				=	1
		";

		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return  $result->getRows();
		}else{
			return NULL;
		}
	}
}
