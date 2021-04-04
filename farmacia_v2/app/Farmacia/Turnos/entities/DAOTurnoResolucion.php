<?php

namespace App\Farmacia\Turnos\Entities;

/**
 * <ricardo.munoz at cosof> 29/09/2020
 * DAOTurnoResolucion
 */
class DAOTurnoResolucion extends \pan\Kore\Entity
{

	protected $table		=	TABLA_TURNO_RESOLUCION;
	protected $primary_key	=	"tr_id";

	function __construct()
	{
		parent::__construct();
	}
}
