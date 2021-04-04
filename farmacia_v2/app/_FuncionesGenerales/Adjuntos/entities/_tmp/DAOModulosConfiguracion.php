<?php

namespace App\General\Entity;

class DAOModulosConfiguracion extends \pan\Kore\Entity{

 	protected $table = 'mfis_modulos_configuracion';

	protected $primary_key = 'id_modulo';


	const ALIMENTOS = 1;
	const SALUD_OCUPACIONAL = 2;
	const MINSATEP = 3;
	const TRAMITES = 4;
	const MORDEDORES = 5;

}