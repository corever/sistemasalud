<?php

namespace App\Farmacia\Turnos\Entities;

/**
 * <ricardo.munoz at cosof> 29/09/2020
 * TurnoTipoPeriodo
 */
class DAOTurnoTipoPeriodo extends \pan\Kore\Entity
{

	protected $table		=	TABLA_TURNO_TIPO_PERIODO;
	protected $primary_key	=	"id_turno_tipo_periodo";

	function __construct()
	{
		parent::__construct();
	}
}
