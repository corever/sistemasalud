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


class DAOAnyo extends \pan\Kore\Entity
{

	// protected $table = TABLA_ACCESO_ANYO;
	// protected $primary_key = "anyo_id";

	function __construct()
	{
		parent::__construct();
	}

	public function all()
	{
		$arrReturn = array();

		$nrAnyoActual = date("Y");
		$nrCantidadAnyos = 10;

		for ($nrAux = 0, $nrCantidadAnyos = 10; $nrAux < $nrCantidadAnyos; $nrAux++) {
			$anyo = new stdClass();
			$anyo->id = $nrAnyoActual;
			$anyo->value = $nrAnyoActual;
			array_push($arrReturn, $anyo);
			$nrAnyoActual--;
		}

		return $arrReturn;
	}
}
