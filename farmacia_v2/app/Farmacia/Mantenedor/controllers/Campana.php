<?php

/**
 ******************************************************************************
 * Sistema           : Mis Fiscalizaciones
 *
 * Descripción       : Controlador de Mantenedor:Menu
 *
 * Plataforma        : PHP
 *
 * Creación          : 13/08/2019
 *
 * @name             Menu.php
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

namespace App\Mantenedor;



use Pan\Utils\JsonPan;

class Campana extends \pan\Kore\Controller
{

	protected $_DAOCampana;
	protected $_DAORegiones;
	protected $_DAOAmbito;
	protected $_DAOCampoEspecifico;
	protected $_DAOTipoCampo;

	/**
	 * Undocumented variable
	 *
	 * @var \App\Mantenedor\Entity\DAOCampanaOficinas
	 */
	protected $_DAOCampanaOficinas;

	public function __construct()
	{
		parent::__construct();
		$this->session->isValidate();

		$this->_DAORegiones			=	new \App\General\Entity\DAODireccionRegion;
		$this->_DAOTipoCampo 		=	new \App\General\Entity\DAOTipoCampo;
		$this->_DAOAmbito			=	new \App\Fiscalizaciones\Entity\DAOAmbito;
		$this->_DAOCampana			=	new \App\Fiscalizaciones\Entity\DAOCampana;
		$this->_DAOCampoEspecifico 	=	new \App\Mantenedor\Entity\DAOCampoEspecifico;

		$this->_DAOCampanaOficinas = new \App\Mantenedor\Entity\DAOCampanaOficinas;
	}

	public function index()
	{
		
		$this->view->set('tipo', \App\Fiscalizaciones\Entity\DAOCampana::TIPO_CAMPANA);
		$this->view->set('contenido',		$this->view->fetchIt('campana/index'));

		// $this->view->addCSS('jquery.datetimepicker.css','pub/css/');
		// $this->view->addJS('jquery.datetimepicker.js','pub/js/');
		// $this->view->addJS('calendario.js', 'pub/js/helpers');
		$this->view->addJS('regiones.js',		"app/General/assets/js/");
		$this->view->addJS('selectChosen.js',	"pub/js/helpers/");
		$this->view->addJS('dTables.js',	"pub/js/helpers/");
		$this->view->addJS('mantenedorCampana.js');
		$this->view->addJS('MantenedorCampana.init(' . \App\Fiscalizaciones\Entity\DAOCampana::TIPO_CAMPANA. ');');
		$this->view->render();
	}



	public function indexPrograma()
	{
		
		$this->view->set('tipo', \App\Fiscalizaciones\Entity\DAOCampana::TIPO_PROGRAMA);
		$this->view->set('contenido',		$this->view->fetchIt('campana/index'));

		// $this->view->addCSS('jquery.datetimepicker.css','pub/css/');
		// $this->view->addJS('jquery.datetimepicker.js','pub/js/');
		// $this->view->addJS('calendario.js', 'pub/js/helpers');
		$this->view->addJS('regiones.js',		"app/General/assets/js/");
		$this->view->addJS('selectChosen.js',	"pub/js/helpers/");
		$this->view->addJS('dTables.js',	"pub/js/helpers/");
		$this->view->addJS('mantenedorCampana.js');
		$this->view->addJS('MantenedorCampana.init(' . \App\Fiscalizaciones\Entity\DAOCampana::TIPO_PROGRAMA. ');');
		$this->view->render();
	}


	public function cargarGrillaCampanas()
	{

		$tipo = $this->request->getParametros('tipo');
		$arrCampana		=	$this->_DAOCampana->_getLista(array('bo_programa' => $tipo));
		$arrAmbito		=	$this->_DAOAmbito->getLista(array('id_estado' => 1));
		$arr_ambitos = array();
		foreach ($arrAmbito as $ambito) {
			$arr_ambitos[$ambito->id_ambito] = $ambito->gl_nombre;
		}

		$this->view->set('arrCampana',		$arrCampana);
		$this->view->set('arrAmbito',		$arr_ambitos);
		$template = $this->view->fetchIt('campana/grilla');

		echo $template;

	}


	public function agregarCampana($id_campana = null)
	{
		// --- Filtrar Restricciones de usuario --- //
		$filtros 				=	\App\General\Filtros::getFiltros();
		$arrFiltros				=	\App\General\Filtros::getArrayFiltros($filtros);
		$arrAmbito				=	$this->_DAOAmbito->getLista(array('id_estado' => 1));
		$arrTipoCampo			=	$this->_DAOTipoCampo->getListaActivos();

		$this->view->set('arrTipoCampo',	$arrTipoCampo);

		$cantCaracteres			=	10000;

		$this->view->set('id_campana', $id_campana);
		$this->view->set('tipo', \App\Fiscalizaciones\Entity\DAOCampana::TIPO_CAMPANA);
		$this->view->set('arrFiltros',		$arrFiltros);
		$this->view->set('arrAmbito',		$arrAmbito);
		$this->view->set('cantCaracteres',	$cantCaracteres);

		$this->view->addJS('mantenedorCampana.js');
		// $this->view->addJS('Calendario.init("fechaInicia");');
		// $this->view->addJS('Calendario.init("fechaFinaliza");');
		$this->view->render('campana/agregar_campana');
	}


	public function agregarPrograma($id_campana = null)
	{
		// --- Filtrar Restricciones de usuario --- //
		$filtros 				=	\App\General\Filtros::getFiltros();
		$arrFiltros				=	\App\General\Filtros::getArrayFiltros($filtros);
		$arrAmbito				=	$this->_DAOAmbito->getLista(array('id_estado' => 1));
		$arrTipoCampo			=	$this->_DAOTipoCampo->getListaActivos();

		$this->view->set('arrTipoCampo',	$arrTipoCampo);

		$cantCaracteres			=	10000;

		$this->view->set('id_campana', $id_campana);
		$this->view->set('tipo', \App\Fiscalizaciones\Entity\DAOCampana::TIPO_PROGRAMA);
		$this->view->set('arrFiltros',		$arrFiltros);
		$this->view->set('arrAmbito',		$arrAmbito);
		$this->view->set('cantCaracteres',	$cantCaracteres);

		$this->view->addJS('mantenedorCampana.js');
		// $this->view->addJS('Calendario.init("fechaInicia");');
		// $this->view->addJS('Calendario.init("fechaFinaliza");');
		$this->view->render('campana/agregar_campana');
	}

	public function agregarCampanaDB()
	{
		$this->session->isValidate();
		$salida       		= array("correcto" => false, "mensaje" => "Error: Error en sistema. Intente nuevamente o comuníquese con Soporte.");
		$params				= $this->request->getParametros();
		
		$gl_nombre_campana 	= (!empty($params['gl_nombre_campana'])) ? $params['gl_nombre_campana'] : null;
		$gl_nr_orden        = (isset($params['gl_nr_orden']) && !empty($params['gl_nr_orden'])) ? $params['gl_nr_orden'] : null;
		$ambitos          	= (!empty($params['ambitos'])) ? json_encode($params['ambitos']) : null;
		// $id_ambito         	= (!empty($params['id_ambito'])) ? $params['id_ambito'] : null;
		$fechaInicia	   	= (!empty($params['fechaInicia'])) ? \Fechas::formatearBaseDatosSinComilla($params['fechaInicia']) : null;
		$fechaFinaliza	   	= (!empty($params['fechaFinaliza'])) ? \Fechas::formatearBaseDatosSinComilla($params['fechaFinaliza']) : null;
		$bo_programa        = $params['tipo'];
		$bo_nacional        = (isset($params['campana_nacional'])) ? 1 : 0;
		//$arrEspecifico 		= $this->session->getSession('arrEspecifico') != null ? $this->session->getSession('arrEspecifico') : array();

		if (!is_null($gl_nombre_campana) && !is_null($ambitos) && !is_null($fechaInicia) && !is_null($fechaFinaliza)) {
			$parametros = array(
				"gl_nombre" 	=> $gl_nombre_campana,
				"nr_orden" 			=> $gl_nr_orden,
				"json_ambito" 			=> $ambitos,
				// "id_ambito" 			=> $id_ambito,
				"id_region" 	=> 0,
				"id_oficina" 	=> 0,
				"id_comuna" 	=> 0,
				"fc_inicia" 			=> $fechaInicia,
				"fc_finaliza" 		=> $fechaFinaliza,
				"gl_comentario" 		=> $params['gl_comentario'],
				"bo_programa" 			=> $bo_programa,
				"bo_nacional"			=> $bo_nacional
			);

			/* if (isset($params['id_region_campana'])) {
			    $parametros['id_region'] = $params['id_region_campana'];
            }
            if (isset($params['id_oficina_campana'])) {
                $parametros['id_oficina'] = $params['id_oficina_campana'];
            }
            if (isset($params['id_comuna_campana'])) {
                $parametros['id_comuna'] = $params['id_comuna_campana'];
            } */
			
			//$id_campana = $this->_DAOCampana->insertNuevo($parametros);
			if (isset($params['id']) and $params['id'] > 0) {
				if ($this->_DAOCampana->update($parametros, $params['id'])) {
					$id_campana = $params['id'];
				} else {
					$id_campana = false;
				}
				
			} else {
				$id_campana = $this->_DAOCampana->create($parametros);
			}
			
			
			if ($id_campana) {

				// registrar oficinas si vienen marcadas
				if (isset($params['id_oficina_campana']) and is_array($params['id_oficina_campana']) and count($params['id_oficina_campana']) > 0) {
					//$update_old = $this->_DAOCampanaOficinas->update(array('bo_activo' => 0), null, array('id_campana' => $id_campana));
					$delete_old = $this->_DAOCampanaOficinas->delete(array('id_campana' => $id_campana));
					$arr_oficinas = $params['id_oficina_campana'];
					foreach ($arr_oficinas as $oficina) {
						$insert_ofi = $this->_DAOCampanaOficinas->create(array('id_campana' => $id_campana, 'id_oficina' => $oficina ));
					}
				}
				

				// --- Crear Folio Campaña/Programa para nuevo registro --- //
				if ($params['id'] == "") {
					if (isset($params['id_region_campana'])) {
						if (is_array($params['id_region_campana'])) {
							$folio = $this->_DAOCampana->crearFolio(99, $id_campana); // 99: multiregion pero no nacional
						} elseif ($params['id_region_campana'] > 0) {
							$folio = $this->_DAOCampana->crearFolio($params['id_region_campana'], $id_campana);
						}
						
					} else {
						$folio = $this->_DAOCampana->crearFolio(00, $id_campana);
					}

					if ($this->_DAOCampana->update(['gl_folio_campana' => $folio], $id_campana)) {
						$mensaje = "Datos guardados";
						if ($params['tipo'] == \App\Fiscalizaciones\Entity\DAOCampana::TIPO_CAMPANA) {
							$mensaje = "Campaña guardada con éxito con folio " . $folio;
						} elseif ($params['tipo'] == \App\Fiscalizaciones\Entity\DAOCampana::TIPO_PROGRAMA) {
							$mensaje = "Programa guardado con éxito con folio " . $folio;
						}	
						$salida       	= array("correcto" => true, "mensaje" => $mensaje);
					}
				} else {
					$salida       	= array("correcto" => true, "mensaje" => "Datos guardados");
				}
                
				// --- Agregar/Actualizar Campos Específicos --- //
				$upd_campos_especificos = $this->_DAOCampoEspecifico->update(array('bo_estado' => 0), null, array('id_campana' => $id_campana));

				if (isset($params['tipo_campo_adicional']) and count($params['tipo_campo_adicional']) > 0) {
					$total_campos = count($params['tipo_campo_adicional']);
					for ($i = 0; $i < $total_campos; $i++) {
						$value = array(
							'nombre_campo_adicional' => $params['nombre_campo_adicional'][$i],
							'descripcion_campo_adicional' => $params['descripcion_campo_adicional'][$i],
							'tipo_campo_adicional' => $params['tipo_campo_adicional'][$i],
							'nombre_tipo_campo_adicional' => $params['nombre_tipo_campo_adicional'][$i],
							'opciones_campo_adicional' => $params['opciones_campo_adicional'][$i]
						);
						$data = [
							'id_campana' 		=> $id_campana,
							'nr_orden'			=> $i + 1,
							'json_code'			=> json_encode($value, JSON_UNESCAPED_UNICODE),
							'bo_estado'			=> 1,
							'id_usuario_crea'	=> $this->session->getSession('id')
						];
						$id_especifico = $this->_DAOCampoEspecifico->create($data);
					}
					
				}
			}
		}
		echo json_encode($salida, JSON_UNESCAPED_UNICODE);
	}

	public function editarCampana($id_campana)
	{

		// TODO: Agregar edicion de comentario
		$campana 	= $this->_DAOCampana->getById($id_campana);
		if (is_null($campana)) {
			die('No se encuentra registro');
		}

		$filtros 				=	\App\General\Filtros::getFiltros();
		$arrFiltros				=	\App\General\Filtros::getArrayFiltros($filtros);
		$this->view->set('arrFiltros',		$arrFiltros);
		$arrRegion 	= $this->_DAORegiones->getLista();
		$arrAmbito	= $this->_DAOAmbito->getLista(array('id_estado' => 1));
		
		$this->view->set('tipo', $campana->bo_programa);
		$this->view->set('ambitos', json_decode($campana->json_ambito, true));
		$this->view->set('es_nacional', $campana->bo_nacional);
		
		$js = '';
		if (!$campana->bo_nacional) {
			$arr_regiones_oficinas = array();
			$arr_oficinas = array();
			$oficinas = $this->_DAOCampanaOficinas->getInfo(array('campana' => $id_campana, 'estado' => 1));
			if ($oficinas) {
				foreach ($oficinas as $ofi) {
					if (!in_array($ofi->id_oficina, $arr_oficinas)) {
						$arr_oficinas[] = $ofi->id_oficina;
					}
					
					if (!in_array($ofi->id_region, $arr_regiones_oficinas)) {
						$arr_regiones_oficinas[] = $ofi->id_region;
					}
				}
			}
			
			$this->view->set('arr_regiones_oficinas', $arr_regiones_oficinas);
			$this->view->set('arr_oficinas', $arr_oficinas);

			if (count($arr_regiones_oficinas) > 0) {
				foreach ($arr_regiones_oficinas as $reg) {
					$js .= 'MantenedorCampana.cargarOficinaPorRegion(' . $reg .',"contenedor-oficinas-region-' . $reg . '");';
				}
			}

			if (count($arr_oficinas) > 0) {
				foreach ($arr_oficinas as $oficina) {
					$js .= 'setTimeout(function(){$("#id_oficina_campana_' . $oficina . '").prop("checked", true);}, 500);';
				}
			}

		}

		$arr_campos_especificos = array();
		$campos_especificos = $this->_DAOCampoEspecifico->where(array('id_campana' => $id_campana, 'bo_estado' => 1))->runQuery()->getRows();
		if ($campos_especificos) {
			foreach ($campos_especificos as $campos) {
				$campo = json_decode($campos->json_code,true);
				$arr_campos_especificos[] = $campo;
			}
		}

		$this->view->set('arr_campos_especificos', $arr_campos_especificos);
		$cantCaracteres			=	10000;
		$this->view->set('cantCaracteres',	$cantCaracteres);

		$arrTipoCampo			=	$this->_DAOTipoCampo->getListaActivos();

		$this->view->set('arrTipoCampo',	$arrTipoCampo);

		$this->view->set('id_campana', $id_campana);
		$this->view->set('campana', $campana);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrAmbito', $arrAmbito);
		//$this->view->set('arrCamposEspecificos', $campos_especificos);


		//file_put_contents('php://stderr', PHP_EOL . print_r($campana, TRUE). PHP_EOL, FILE_APPEND);
		$this->view->addJS('mantenedorCampana.js');
		$this->view->addJS('Calendario.init("fechaInicia");');
		$this->view->addJS('Calendario.init("fechaFinaliza");');
		$this->view->addJS('Calendario.init("fechaFinaliza");');
		$this->view->addJS($js);
		//$this->view->addJS("$('#id_region_campana').trigger('change');");
		//$this->view->addJS("setTimeout(function(){ $('#id_oficina_campana').trigger('change');}, 500 ) ");
		$this->view->render('campana/agregar_campana');
		//$this->view->render('campana/editar_campana');
	}

	public function editarCampanaDB()
	{
		$this->session->isValidate();
		$salida       	= array("correcto" => false, "mensaje" => "Error: Error en sistema. Intente nuevamente o comuníquese con Soporte.");
		$params			= $this->request->getParametros();


		$gl_nombre_campana 	= (!empty($params['gl_nombre_campana'])) ? $params['gl_nombre_campana'] : null;
		$gl_nr_orden        = (isset($params['gl_nr_orden']) && !empty($params['gl_nr_orden'])) ? $params['gl_nr_orden'] : null;
		$ambitos       	= (!empty($params['ambitos'])) ? $params['ambitos'] : null;
		$fechaInicia 		= (!empty($params['fechaInicia'])) ? \Fechas::formatearBaseDatosSinComilla($params['fechaInicia']) : null;
		$fechaFinaliza 		= (!empty($params['fechaFinaliza'])) ? \Fechas::formatearBaseDatosSinComilla($params['fechaFinaliza']) : null;

		if (!is_null($gl_nombre_campana) && !is_null($ambitos) && !is_null($fechaInicia) && !is_null($fechaFinaliza)) {
			$parametros = array(
				"id_campana"         => $params['id_campana'],
				"gl_nombre_campana"  => $gl_nombre_campana,
				"gl_nr_orden"        => $gl_nr_orden,
                "json_ambito" 			=> $ambitos,
				//"id_ambito"        	 => $id_ambito,
				"id_region_campana"  => 0,
				"id_oficina_campana" => 0,
				"id_comuna_campana"  => 0,
				"fechaInicia"  	  	 => $fechaInicia,
				"fechaFinaliza"      => $fechaFinaliza,
				"gl_comentario"  	 => $params['gl_comentario'],
				"bo_estado"          => $params['id_campana_estado']
			);

            if (isset($params['id_region_campana'])) {
                $parametros['id_region_campana'] = $params['id_region_campana'];
            }
            if (isset($params['id_oficina_campana'])) {
                $parametros['id_oficina_campana'] = $params['id_oficina_campana'];
            }
            if (isset($params['id_comuna_campana'])) {
                $parametros['id_comuna_campana'] = $params['id_comuna_campana'];
            }

			//file_put_contents('php://stderr', PHP_EOL . print_r($parametros, TRUE). PHP_EOL, FILE_APPEND);
			$id_campana = $this->_DAOCampana->editarCampana($parametros);
			if ($id_campana) {
				$salida       	= array("correcto" => true, "mensaje" => "Campaña/Programa agregada con éxito");
			}
		}
		echo json_encode($salida, JSON_UNESCAPED_UNICODE);
	}

	public function agregarCampoEspecifico($id_campana = null)
	{
		$arrEspecifico			=	$this->session->getSession('arrEspecifico') != null ? $this->session->getSession('arrEspecifico') : array();
		$arrTipoCampo			=	$this->_DAOTipoCampo->getListaActivos();

		$this->view->set('id_campana', $id_campana);
		$this->view->set('arrTipoCampo',	$arrTipoCampo);
		$this->view->set('arrEspecifico',	$arrEspecifico);

		$grillaEspecifico		=	$this->view->fetchIt('campana/grilla_campo_especifico');

		$this->view->set('grillaEspecifico', $grillaEspecifico);
		$this->view->addJS('campoEspecifico.js');
		$this->view->render('campana/campo_especifico');
	}

	/**
	 * Vista para añadir opciones a un criterio especifico
	 */
	public function agregarOpcionesaCriterio($opcion = NULL){
		
		if(!is_null($opcion)){
			$arrEspecifico = $this->session->getSession('arrEspecifico');
			$this->view->set('opcion',	$opcion);
			$this->view->set('opciones', $arrEspecifico[$opcion]);
			$this->view->render('campana/agregar_opcion_criterio');
		}else{
			echo 'Ha ocurrido un Error. Si este error persiste, favor contactar con Mesa de Ayuda.';
		}
	}

	/**
	 * Añadir opciones al criterio especifico
	 */
	public function agregarOpciones(){
		$params					=	$this->request->getParametros();
		$opcion					=	isset($params['opcion'])		?	$params['opcion']		:	NULL;
		$gl_opciones			=	isset($params['gl_opciones'])	?	$params['gl_opciones']	:	NULL;
		$json					=	array(
			'correcto'	=>	FALSE,
		);

		if(!is_null($opcion) && !empty($gl_opciones)){
			$arr_opciones		=	array_map('trim',explode(',',$gl_opciones));
			$total_arr_opciones = count($arr_opciones);
			$tmp_arr_opciones = array_unique($arr_opciones);
			if ($total_arr_opciones > count($tmp_arr_opciones)) {
			    $json['correcto'] = false;
			    $json['mensaje'] = 'Existen opciones repetidas';
			    echo JsonPan::enc_json($json);
			    die;
            }

			$arrEspecifico		=	$this->session->getSession('arrEspecifico');
			if(isset($arrEspecifico[$opcion])){
				$arrEspecifico[$opcion]['opciones_select']	=	$arr_opciones;
				$this->session->setSession('arrEspecifico',		$arrEspecifico);
			}
			$json['correcto'] = true;
		}
		//file_put_contents('php://stderr', PHP_EOL . print_r($this->session->getSession('arrEspecifico'), TRUE). PHP_EOL, FILE_APPEND);
		
        $this->view->set('arrEspecifico',	$arrEspecifico[$opcion]);

        $grillaEspecifico		=	$this->view->fetchIt('campana/grilla_opciones_criterio');
        $json['grilla'] = $grillaEspecifico;

        echo JsonPan::enc_json($json);

	}

	public function crearCampoTemporal(){
		$params					=	$this->request->getParametros();
		$json					=	array(
			'correcto'	=>	FALSE,
		);
		
		if(!empty($params)){
			$arrEspecifico		=	$this->session->getSession('arrEspecifico') != NULL ? $this->session->getSession('arrEspecifico') : array();

			/* revisar si ya existe un campo con el mismo nombre */
            foreach ($arrEspecifico as $arr) {
                if ($params['gl_nombre_campo'] == $arr['gl_nombre_campo']) {
                    $json['correcto'] = false;
                    $json['mensaje'] = 'Ya existe un campo con el nombre ingresado';
                    echo \Pan\Utils\JsonPan::enc_json($json);
                    die;
                }
            }
			array_push($arrEspecifico, $params);

			$this->session->setSession('arrEspecifico',	$arrEspecifico);
			$this->view->set('arrEspecifico',			$arrEspecifico);
			
			$grillaEspecifico	=	$this->view->fetchIt('campana/grilla_campo_especifico');
			$json['correcto']	=	TRUE;
			$json['grilla']		=	$grillaEspecifico;
			$json['mensaje'] = 'Dato Adicional Registrado Exitosamente';
		}
		
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
	}

	public function borrarCampoTemporal()
	{
		$param				= $this->request->getParametros();
		$arrEspecifico 		= $this->session->getSession('arrEspecifico') != null ? $this->session->getSession('arrEspecifico') : array();
		unset($arrEspecifico[$param['data']]);
		$arrEspecifico = array_values($arrEspecifico);
		$this->session->setSession('arrEspecifico', $arrEspecifico);
		$this->view->set('arrEspecifico', $arrEspecifico);
		$grillaEspecifico 	= $this->view->fetchIt('campana/grilla_campo_especifico');
		$salida				= array("correcto"	=> true, "array" => $grillaEspecifico);
		echo json_encode($salida, JSON_UNESCAPED_UNICODE);
	}


	public function deshabilitar()
	{

		$response = array();
		$item = $this->request->getParametros('item');

		$data = array('bo_estado' => 0);
		
		if ($this->_DAOCampana->update($data, $item)) {
			$response['correcto'] = true;
			$response['mensaje'] = 'El item ha sido deshabilitado correctamente';
		} else {
			$response['correcto'] = false;
			$response['mensaje'] = 'Hubo un problema al deshabilitar el item. Intente nuevamente';
		}

		echo \Pan\Utils\JsonPan::enc_json($response);
	}

	public function habilitar()
	{

		$response = array();
		$item = $this->request->getParametros('item');

		$data = array('bo_estado' => 1);
		
		if ($this->_DAOCampana->update($data, $item)) {
			$response['correcto'] = true;
			$response['mensaje'] = 'El item ha sido habilitado correctamente';
		} else {
			$response['correcto'] = false;
			$response['mensaje'] = 'Hubo un problema al habilitar el item. Intente nuevamente';
		}

		echo \Pan\Utils\JsonPan::enc_json($response);
	}


	public function getPorAmbito()
	{
		$response = array();
		$ambito = (int) $this->request->getParametros('ambito');
		$tipo = (int) $this->request->getParametros('item');

		if ($tipo == \App\Fiscalizaciones\Entity\DAOOrigen::CAMPANA) {
			$bo_programa = 0;
		} else {
			$bo_programa = 1;
		}

		$campanas = $this->_DAOCampana->where('bo_estado = 1 and bo_programa = ' . $bo_programa . ' and json_ambito like \'%"'.$ambito.'"%\'')->runQuery()->getRows();
		
		if ($campanas) {
			foreach ($campanas as $campana) {
				$response[] = array(
					'id' => $campana->id_campana,
					'nombre' => $campana->gl_nombre,
					'comentario' => $campana->gl_comentario
				);
			}
		}

		echo \Pan\Utils\JsonPan::enc_json($response);

	}


	public function verInfoDatosAdicionales()
	{
		$this->view->render('campana/info_campana');
	}

}
