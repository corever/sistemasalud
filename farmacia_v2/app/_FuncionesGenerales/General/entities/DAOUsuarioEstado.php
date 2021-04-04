<?php

namespace App\_FuncionesGenerales\General\Entity;

use stdClass;

/**
 ******************************************************************************
 * Sistema           : Farmacia v2
 *
 * Descripción       : DAO Usuario Estado
 *
 * Plataforma        : PHP
 *
 * Creación          : 14/09/2020
 *
 * @name             AdminUsuario.php
 *
 * @version          1.0.0
 *
 * @author			<ricardo.munoz@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha			Descripción
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */


class DAOUsuarioEstado extends \pan\Kore\Entity
{

	// protected $table			            = TABLA_ACCESO_USUARIO;
	// protected $primary_key		            = "mu_id";

	function __construct()
	{
		parent::__construct();
	}

	public function all()
	{
		// $estadoInactivo = new stdClass();
		// $estadoInactivo->usuario_estado_id = "1";
		// $estadoInactivo->usuario_estado_nombre = "Activo";

		$estadoActivo = new stdClass();
		$estadoActivo->usuario_estado_id = "1";
		$estadoActivo->usuario_estado_nombre = "Activo";

		return array(
			// $estadoInactivo, 
			$estadoActivo
		);
	}
}
