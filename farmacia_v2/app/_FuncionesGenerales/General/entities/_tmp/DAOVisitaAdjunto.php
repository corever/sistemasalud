<?php

namespace App\General\Entity;

class DAOVisitaAdjunto extends \pan\Kore\Entity{

 	protected $table		=	TABLA_VISITA_ADJUNTO;
	protected $primary_key	=	'id_adjunto';

	const	TIPO_FICHA	=	1;
	const	TIPO_ACTA	=	2;

	function __construct()
	{
		parent::__construct();
	}
}