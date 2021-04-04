<?php
/**
 ******************************************************************************
 * Sistema			: Mis Fiscalizaciones
 *
 * Descripcion		: Modelo para Tabla ws_acceso_sistemas
 *
 * Plataforma		: !PHP
 *
 * Creacion			: 17/07/2019
 *
 * @name			DAOSistema.php
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

class DAOSistema extends \pan\Kore\Entity{

	protected	$table				=	TABLA_ACCESO_SISTEMAS;
	protected	$primary_key		=	"id_sistema";

	const	ASDIGITAL				=	1;
	const	SUMANET					=	2;
	const	RECAUDACION				=	3;
	const	FARMANET				=	4;
	const	PROGRAMACION			=	5;
	const	EMERGENCIA				=	6;
	const	MIDAS					=	7;
	const	SOPORTES				=	8;
	const	RAPSINET				=	9;
	const	COMPARADOR				=	10;
	const	WS_COMPARADOR			=	11;
	const	VIGILANCIA				=	12;
	const	EXTERNO					=	13;
	const	SIRAM					=	14;
	const	VIRTUALCICOM			=	15;
	const	REQUERIMIENTOS			=	16;
	const	PREVENCION_FEMICIDIOS	=	17;
	const	SALUD_OCUPACIONAL		=	18;
	const	MONITOREO_CONTINENTAL	=	19;
	const	MONITOREO_INSULAR		=	20;
	const	PROMOCION				=	21;
	const	VECTORES_CHAGAS			=	22;
	const	OBSERVATORIO_PRECIOS	=	23;
	const	SINAISO					=	24;
	const	CALL_CENTER				=	25;
	const	MIS_FISCALIZACIONES		=	26;
	const	EESS					=	27;
	const	MORDEDORES				=	28;


	function __construct(){
		parent::__construct();
	}

	public function getById($id_sistema){
		$query	= "	SELECT * FROM ".$this->table."
					WHERE ".$this->primary_key." = ?";

		$param	= array($id_sistema);
		$result	= $this->db->getQuery($query,$param)->runQuery();

		if($result->getNumRows()>0){
			return $result->getRows(0);
		}else{
			return NULL;
		}
	}
}
