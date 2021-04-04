<?php

namespace App\Farmacia\Turnos\Entities;

/**
 * <ricardo.munoz at cosof> 29/09/2020
 * DAOTurno
 */
class DAOTurno extends \pan\Kore\Entity
{

	protected $table		=	TABLA_TURNO;
	protected $primary_key	=	"turno_id";

	function __construct()
	{
		parent::__construct();
	}
}
