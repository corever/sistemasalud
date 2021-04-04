<?php

namespace App\Farmacia\Turnos\Entities;

/**
 * <ricardo.munoz at cosof> 29/09/2020
 * DAOTurnoResolucionDoc
 */
class DAOTurnoResolucionDoc extends \pan\Kore\Entity
{

	protected $table		=	TABLA_TURNO_RESOLUCION_DOC;
	protected $primary_key	=	"tr_doc_id";

	function __construct()
	{
		parent::__construct();
	}


	/**
	 * cosof-ricardo-munoz
	 * 29-09-2020
	 */
	public function getContenidoDocumento($id_region, $nrTurnoUrgencia)
	{
		$arrWhere = array();
		$arrParams = "tr_doc_contenido";

		$arrWhere["fk_region"] = $id_region;
		$arrWhere["fk_turno_documento_tipo"] = $nrTurnoUrgencia;

		$oTurnoResolucionDoc = $this->where($arrWhere, $arrParams)->runQuery()->getRows()[0];

		// si no encuentra un registro por la region especifica, busca el "nacional" region = 0
		if (is_null($oTurnoResolucionDoc)) {
			$arrWhere["fk_region"] = 0;
			$arrWhere["fk_turno_documento_tipo"] = $nrTurnoUrgencia;

			$oTurnoResolucionDoc = $this->where($arrWhere, $arrParams)->runQuery()->getRows()[0];
		}

		return $oTurnoResolucionDoc->tr_doc_contenido;
	}

	/**
	 * cosof-ricardo-munoz
	 * 29-09-2020
	 */
	public function patchContenidoDocumentoUrgencia($params)
	{
		$arrDataPdf = array();
		
		$arrDataPdf["Numero_Res"] = "" ;
		$arrDataPdf["Region_Nombre_Corto"] = "" ;
		$arrDataPdf["Fecha_Res"] = "" ;
		$arrDataPdf["Region_Nombre"] = "" ;
		$arrDataPdf["Comuna_Nombre"] = "" ;
		$arrDataPdf["Numero_Decreto"] = "" ;
		$arrDataPdf["Fecha_Decreto"] = "" ;
		$arrDataPdf["N1"] = "" ;
		$arrDataPdf["Periodo_Inicio"] = "" ;
		$arrDataPdf["Periodo_Termino"] = "" ;
		$arrDataPdf["Calendario_Turno"] = "" ;
		$arrDataPdf["N2"] = "" ;
		$arrDataPdf["N3"] = "" ;
		$arrDataPdf["Fono_Contacto"] = "" ;
		$arrDataPdf["Email_Contacto"] = "" ;
		$arrDataPdf["N4"] = "" ;
		$arrDataPdf["N5"] = "" ;
		$arrDataPdf["N6"] = "" ;
		$arrDataPdf["N7"] = "" ;
		$arrDataPdf["Direccion"] = "" ; 
		$arrDataPdf["Sin_Efecto"] = "" ;
		$arrDataPdf["N9"] = "" ;
		$arrDataPdf["N10"] = "" ;
		$arrDataPdf["Turno_Extra"] = "" ;
		$arrDataPdf["Nombre_Firmante"] = "" ;
		$arrDataPdf["Cargo_Firmante"] = "" ;
 
		return $arrDataPdf;
	}
}
