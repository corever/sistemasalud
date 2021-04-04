<?php

namespace App\Farmacia\Turnos;


/**
 ******************************************************************************
 * Sistema           : HOPE
 *
 * Descripción       : Controlador Login
 *
 * Plataforma        : PHP
 *
 * Creación          : 24/08/2020
 *
 * @name             AdminTurnos.php - Ejemplo para copiar y pegar
 *
 * @version          1.0.0
 *
 * @author			<david.guzman@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha			Descripción
 * ----------------------------------------------------------------------------
 * ricardo.munoz			25-09-2020		administrador de turnos
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

class AdminTurnos extends \pan\Kore\Controller
{

	/*Inicializando Variables*/
	protected $_DAOUsuario;
	private $_DAODireccionRegion;
	private $_DAODireccionComuna;
	private $_DAOTerritorio;
	private $_DAOAnyo;
	private $_DAOTurnoTipoPeriodo;
	private $_DAOLocal;
	private $_DAOTurno;
	private $_DAOTurnoResolucionDoc;
	private $_DAOTurnoCodResolucion;
	private $_DAOTurnoResolucion;
	private $_DAOTurnoDetalle;
	const BASE_TOKEN_SEGURIDAD = "admin_turnos_";

	public function __construct()
	{

		parent::__construct();

		$this->_DAOUsuario = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;
		$this->_DAODireccionRegion = new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAODireccionComuna = new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOTerritorio = new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOAnyo = new \App\_FuncionesGenerales\General\Entity\DAOAnyo;
		$this->_DAOTurnoTipoPeriodo = new \App\Farmacia\Turnos\Entities\DAOTurnoTipoPeriodo;
		$this->_DAOLocal = new \App\Farmacias\Farmacia\Entities\DAOLocal;
		$this->_DAOTurno = new \App\Farmacia\Turnos\Entities\DAOTurno;
		$this->_DAOTurnoResolucionDoc = new \App\Farmacia\Turnos\Entities\DAOTurnoResolucionDoc;
		$this->_DAOTurnoCodResolucion = new \App\Farmacia\Turnos\Entities\DAOTurnoCodResolucion;
		$this->_DAOTurnoResolucion = new \App\Farmacia\Turnos\Entities\DAOTurnoResolucion;
		$this->_DAOTurnoDetalle = new \App\Farmacia\Turnos\Entities\DAOTurnoDetalle;
	}

	public function index()
	{

		$this->view->addJS('adminTurnos.js');
		$this->view->set('contenido', $this->view->fetchIt('index'));
		$this->view->render();
	}

	/**
	 * @author <ricardo.munoz@cosof.cl> 25-09-2020
	 */
	public function administrarTurnos()
	{

		// var_dump("hola");
		$this->view->addJS('adminTurnos.js');
		$this->view->set('filtros', $this->view->fetchIt('administrar_turnos/filtros'));
		$this->view->set('grilla', $this->view->fetchIt('administrar_turnos/grilla'));
		$this->view->set('contenido', $this->view->fetchIt('administrar_turnos/index'));
		$this->view->render();
	}

	/**
	 * @author <ricardo.munoz@cosof.cl> 25-09-2020
	 */
	public function grillaTurnos()
	{
		$params     = $this->request->getParametros();

		// var_dump($params);
		//Guardo Filtros en SESSION
		// $_SESSION[\Constantes::SESSION_BASE]['mantenedor_bodegas']['filtros']   = $params;

		// $arrRol = $this->_DAOUsuario($_SESSION[\Constantes::SESSION_BASE]['arrRoles']); 

		$arrTurnosDetalle = $this->_DAOTurnoDetalle->all();

		// var_dump($arrTurnosDetalle);

		$arrGrilla  = array('data' => array());

		if (!empty($arrTurnosDetalle)) {
			foreach ($arrTurnosDetalle as $item) {

				$arr    = array();

				$oLocal = $this->_DAOLocal->getByPK($item->fk_local);
				$oTurno = $this->_DAOTurno->getByPK($item->fk_turno);


				$arr['gl_token'] = \Seguridad::hashBaseClave(self::BASE_TOKEN_SEGURIDAD, $item->turno_detalle_id);
				$arr['turno_detalle_id'] = $item->turno_detalle_id;
				$arr['id_turno'] = $item->fk_turno;
				$arr['fk_local'] = $item->fk_local;
				$arr['local_nombre'] =  $oLocal->local_nombre;
				$arr['local_direccion'] =  $oLocal->local_direccion;
				$arr['local_telefono'] =  $oLocal->local_telefono;
				$arr['region_nombre'] =  $this->_DAODireccionRegion->getByPK($oTurno->fk_region)->region_nombre;
				$arr['fk_region'] = $oTurno->fk_region;
				$arr['comuna_nombre'] = $this->_DAODireccionComuna->getByPK($oTurno->fk_comuna)->comuna_nombre;
				$arr['fk_comuna'] = $oTurno->fk_comuna;
				$arr['hora_inicio'] = $item->detalle_hora_inicio;
				$arr['hora_termino'] = $item->detalle_hora_termino;
				$arr['opciones']    = '
                
                                        <button type="button" class="btn btn-xs descargarExcel "
											data-toggle="tooltip" title="' . \Traduce::texto("Descargar Excel") . '">
											<i class="fa fa-download"></i>
                                        </button>  
                                        <button type="button" class="btn btn-xs verResolucion "
											data-toggle="tooltip" title="' . \Traduce::texto("Ver Resolución") . '">
											<i class="fa fa-eye"></i>
                                        </button>  
                                        <button type="button" class="btn btn-xs visarResolucion"
											data-toggle="tooltip" title="' . \Traduce::texto("Visar Resolución") . '">
											<i class="fa fa-user-check"></i>
										</button>
                                        <button type="button" class="btn btn-xs editarResolucion"
											data-toggle="tooltip" title="' . \Traduce::texto("Editar Resolución") . '">
											<i class="fa fa-edit"></i>
										</button>';

				$arrGrilla['data'][] = $arr;
			}
		}

		echo json_encode($arrGrilla);
	}

	/**
	 * @author <ricardo.munoz@cosof.cl> 25-09-2020
	 */
	public function descargarExcel()
	{
		$this->view->render('administrar_turnos/descargar_excel');
	}

	/**
	 * @author <ricardo.munoz@cosof.cl> 25-09-2020
	 */
	public function verResolucion()
	{
		$this->view->render('administrar_turnos/ver_resolucion');
	}

	/**
	 * @author <ricardo.munoz@cosof.cl> 25-09-2020
	 */
	public function visarResolucion()
	{
		$this->view->render('administrar_turnos/visar_resolucion');
	}

	/**
	 * @author <ricardo.munoz@cosof.cl> 25-09-2020
	 */
	public function editarResolucion()
	{
		$this->index();
	}
}
