<?php

/**
 ******************************************************************************
 * Sistema           : Mis Fiscalizaciones
 *
 * Descripción       : Controller para trabajar con Regiones
 *
 * Plataforma        : PHP
 *
 * Creación          : 25/02/2017
 *
 * @name             Regiones.php
 *
 * @version          1.0.0
 *
 * @author           Sebastian Carroza <sebastian.Carroza@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha		Descripción
 * ----------------------------------------------------------------------------
 *
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

namespace App\_FuncionesGenerales\General;

class Regiones extends \pan\Kore\Controller
{

	protected $_DAOComuna;
	protected $_DAOTerritorio;
	protected $_DAOBodega;
	protected $_DAOFarmacia;
	protected $_DAOCodigoRegion;
	protected $_DAOLocalidad;
	protected $_DAOLocal;


	public function __construct()
	{
		parent::__construct();

		$this->session->isValidate();
		$this->_DAOComuna			=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOTerritorio		=	new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOBodega			=	new \App\_FuncionesGenerales\General\Entity\DAOBodega;
		$this->_DAOFarmacia			=	new \App\Farmacias\Farmacia\Entities\DAOFarmacia;
		$this->_DAOCodigoRegion		=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;
		$this->_DAOLocalidad		=	new \App\_FuncionesGenerales\General\Entity\DAODireccionLocalidad;
		$this->_DAOLocal			=	new \App\Farmacias\Farmacia\Entities\DAOLocal;
	}

	/**
	 * Descripción	: Carga comunas por región
	 * @author		: <david.guzman@cosof.cl>      - 14/02/2017
	 */
	public function cargarComunasPorRegion()
	{
		//$hoy = \Fechas::fechaHoy();
		$parametros = $this->request->getParametros();
		$region     = $parametros['region'];
		$comunas	= ($region > 0) ? $this->_DAOComuna->getByRegion($region) : $this->_DAOComuna->getLista();
		$json		= array();
		$i			= 0;

		foreach ($comunas as $comuna) {
			$json[$i]['id_comuna']		=	$comuna->id_comuna_midas;
			$json[$i]['nombre_comuna']	=	$comuna->comuna_nombre;
			$json[$i]['id_region']		=	$comuna->fk_region_midas;
			$json[$i]['gl_latitud']		=	$comuna->gl_latitud;
			$json[$i]['gl_longitud']	=	$comuna->gl_longitud;
			$i++;
		}

		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga territorio por región
	 * @author		: <david.guzman@cosof.cl>      - 14/02/2017
	 */
	public function cargarTerritorioPorRegion()
	{
		//$hoy = \Fechas::fechaHoy();
		$parametros = $this->request->getParametros();
		$region     = $parametros['region'];
		$territorios	= ($region > 0) ? $this->_DAOTerritorio->getByRegion($region) : $this->_DAOTerritorio->getLista();
		$json		= array();
		$i			= 0;

		foreach ($territorios as $territorio) {
			$json[$i]['id_territorio']		= $territorio->territorio_id;
			$json[$i]['nombre_territorio']	= $territorio->nombre_territorio;
			$json[$i]['id_region']			= $territorio->fk_region_midas;
			$i++;
		}

		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga bodega por territorio
	 * @author		: <david.guzman@cosof.cl>      - 14/02/2017
	 */
	public function cargarBodegaPorTerritorio()
	{
		//$hoy = \Fechas::fechaHoy();
		$parametros 	= $this->request->getParametros();
		$territorio		= $parametros['territorio'];
		$region			= $parametros['region'];
		$bodegas		= ($territorio > 0) ? $this->_DAOBodega->getByTerritorio($territorio) : (($region > 0) ? $this->_DAOBodega->getByRegion($region) : $this->_DAOBodega->getLista());
		$json			= array();
		$i				= 0;

		foreach ($bodegas as $bodega) {
			$json[$i]['id_bodega']		= $bodega->bodega_id;
			$json[$i]['nombre_bodega']	= $bodega->bodega_nombre;
			$json[$i]['id_territorio']	= $bodega->fk_territorio;
			$i++;
		}

		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga oficinas por región
	 * @author		: <david.guzman@cosof.cl>      - 10/05/2018
	 * @author		: <sebastian.Carroza@cosof.cl> - 24/07/2019
	 */

	public function cargarOficinasPorRegion()
	{

		$parametros = $this->request->getParametros();
		$region     = $parametros['region'];
		$oficinas	= $this->_DAOOficina->getByIdRegion($region);
		$json		= array();
		$i			= 0;
		if (isset($oficinas)) {
			foreach ($oficinas as $oficina) {
				$json[$i]['id_oficina']			= $oficina->id_oficina;
				$json[$i]['nombre_oficina']		= $oficina->gl_nombre_oficina;
				$i++;
			}
		}
		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga comunas por oficina
	 * @author		: <david.guzman@cosof.cl>      - 10/05/2018
	 * @author		: <sebastian.Carroza@cosof.cl> - 29/07/2019
	 */
	public function cargarComunaporOficina()
	{

		$parametros = $this->request->getParametros();
		$oficina     = $parametros['oficina'];
		$comunas	= $this->_DAOComuna->getByIdOficina($oficina);

		//$oficina    = $_POST['oficina'];
		//$comunas	= $this->_DAOComuna->getByIdOficina($oficina);
		$json		= array();
		$i			= 0;
		if (isset($oficina)) {
			foreach ($comunas as $comuna) {
				$json[$i]['id_comuna']			= $comuna->id_comuna;
				$json[$i]['nombre_comuna']		= $comuna->gl_nombre_comuna;
				$json[$i]['gl_latitud_comuna']	= $comuna->gl_latitud_comuna;
				$json[$i]['gl_longitud_comuna']	= $comuna->gl_longitud_comuna;
				$i++;
			}
		}

		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga farmacias por región
	 * @author		: <david.guzman@cosof.cl>      - 19/08/2020
	 */
	public function cargarFarmaciasPorRegion()
	{

		$parametros = $this->request->getParametros();
		$region     = $parametros['region'];
		$farmacias	= ($region > 0) ? $this->_DAOFarmacia->getByRegion($region) : $this->_DAOFarmacia->getListaOrdenadaBy();
		$json		= array();
		$i			= 0;

		foreach ($farmacias as $farmacia) {
			$json[$i]['id_farmacia']		= $farmacia->farmacia_id;
			$json[$i]['nombre_farmacia']	= $farmacia->farmacia_rut . " - " . $farmacia->farmacia_razon_social;
			$json[$i]['id_region']			= $farmacia->id_region_midas;
			$i++;
		}

		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga códigos Fono por Región
	 * @author		: <gabriel.diaz@cosof.cl>      - 27/08/2020
	 */
	public function cargarCodigosFonoPorRegion()
	{
		$parametros		=	$this->request->getParametros();
		$region			=	$parametros['region'];
		$arrCodfono		=	NULL;

		if ($region > 0) {
			$arrCodfono	=	$this->_DAOCodigoRegion->getByParams(array("id_region" => $region));
		} else {
			$arrCodfono	=	$this->_DAOCodigoRegion->getByParams();
		}
		$json			=	$arrCodfono;

		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga localidades por Comuna
	 * @author		: <gabriel.diaz@cosof.cl>      - 01/09/2020
	 */
	public function cargarLocalidadPorComuna()
	{
		$parametros			=	$this->request->getParametros();
		$comuna				=	$parametros['comuna'];
		$arr_localidad		=	NULL;

		if ($comuna > 0) {
			$arr_localidad	=	$this->_DAOLocalidad->getByComuna($comuna);
		} else {
			$arr_localidad	=	$this->_DAOLocalidad->getByParams();
		}
		$json				=	$arr_localidad;

		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga Comuna por Territorio
	 * @author		: <ricardo.munoz@cosof.cl>      - 02/09/2020
	 */
	public function cargarComunasPorTerritorio()
	{
		$parametros	= $this->request->getParametros();
		$territorio	= (int)$parametros['territorio'];
		$arr_comuna	= NULL;

		if ($territorio > 0) {
			$arr_comuna	=	$this->_DAOComuna->where(array("fk_territorio" => $territorio), "")->runQuery()->getRows();;
		} else {
			$arr_comuna	=	$this->_DAOComuna->all();
		}
		$json				=	$arr_comuna;

		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga comunas por región
	 * @author		: <ricardo.munoz@cosof.cl>      - 27/09/2020
	 */
	public function cargarComunasConEstablecimientoUrgenciaPorRegion()
	{
		$parametros = $this->request->getParametros();
		$region     = $parametros['region'];
		$comunas	= ($region > 0) ? $this->_DAOComuna->getWithEstablecimientoUrgenciaByRegion($region) : $this->_DAOComuna->getLista();
		$json		= array();
		$i			= 0;

		// var_dump($comunas);

		if (!is_null($comunas)) {

			foreach ($comunas as $comuna) {
				$json[$i]['id_comuna']		=	$comuna->id_comuna_midas;
				$json[$i]['nombre_comuna']	=	$comuna->comuna_nombre;
				$json[$i]['id_region']		=	$comuna->fk_region_midas;
				$json[$i]['gl_latitud']		=	$comuna->gl_latitud;
				$json[$i]['gl_longitud']	=	$comuna->gl_longitud;
				$i++;
			}
		}

		echo json_encode($json);
	}

	/**
	 * Descripción	: Carga establecimiento urgencia activos por comuna
	 * @author		: <ricardo.munoz@cosof.cl>      - 27/09/2020
	 */
	public function cargarListaEstablecimientoUrgenciaByComunaActivo()
	{
		$parametros = $this->request->getParametros();
		$comuna     = $parametros['comuna'];
		$establecimientos = ($comuna > 0) ? $this->_DAOLocal->getListaEstablecimientoUrgenciaByComunaActivo($comuna) : $this->_DAOLocal->all();
		$json		= array();
		$i			= 0;

		foreach ($establecimientos as $establecimiento) {
			$json[$i]['local_id'] = $establecimiento->local_id;
			$json[$i]['local_nombre'] = $establecimiento->local_nombre;
			$json[$i]['local_direccion'] = $establecimiento->local_direccion;
			$json[$i]['local_telefono'] = $establecimiento->local_telefono;
			$json[$i]['gl_token'] = $establecimiento->gl_token;
			$i++;
		}

		echo json_encode($json);
	}
}
