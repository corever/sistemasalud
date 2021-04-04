<?php

namespace App\Farmacia\Turnos\Entities;

/**
 * <ricardo.munoz at cosof> 29/09/2020
 * DAOTurnoCodResolucion
 */
class DAOTurnoCodResolucion extends \pan\Kore\Entity
{

	protected $table		=	TABLA_TURNO_COD_RESOLUCION;
	protected $primary_key	=	"tcr_id";

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * <ricardo.munoz at cosof> 04/10/2020
	 * 
	 * Se genera el ID (correlativo por región) al hacer el Insert.
	 * Luego se debe utilizar una función para hacer el Folio (ya existe, ya que se está generando otro tipo de folio)
	 * Folio= YY+Región+Correlativo que da el insert
	 */
	function getTurnoCodResolucionByRegionAndAnyo($id_region, $nr_anyo)
	{
		// var_dump($id_region, $nr_anyo);
		// echo date("Y", mktime(0, 0, 0, 1, 1, $nr_anyo));
		// die(__METHOD__);

		$nrCorrelativo = $this->getCorrelativoByRegionAndAnyo($id_region, $nr_anyo);
		$glFolio = date("Y", mktime(0, 0, 0, 1, 1, $nr_anyo)) . $id_region . $nrCorrelativo;

		return $this->create(
			array(
				"fk_region" => $id_region,
				"tcr_correlativo" => $nrCorrelativo,
				"año" => $nr_anyo,
				"tcr_cod_resolucion" => $glFolio,
				"tcr_usado" => 0,
				"tcr_fc_creacion" => \Fechas::fechaHoy(),
				"id_usuario_creacion" => (isset($_SESSION[\Constantes::SESSION_BASE]['id'])) ? $_SESSION[\Constantes::SESSION_BASE]['id'] : 0
			)
		);
	}

	/**
	 * <ricardo.munoz at cosof> 04/10/2020
	 * obtiene el codigo correlativo + 1 por region
	 * @return Int tcr_correlativo
	 */
	function getCorrelativoByRegionAndAnyo($id_region, $anyo)
	{
		if (empty($id_region)) {
			return false;
		}

		$oCorrelativo = $this->where(array("fk_region" => $id_region, "año" => $anyo), " ifnull(max(tcr_correlativo),'0') + 1 as tcr_correlativo ")->runQuery()->getRows()[0];

		return (int)$oCorrelativo->tcr_correlativo;
	}
}
