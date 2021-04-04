<?php

namespace App\Farmacia\Farmacias;


/**
 ******************************************************************************
 * Sistema           : HOPE
 *
 * Descripción       : Controlador RegistroDT
 *
 * Plataforma        : PHP
 *
 * Creación          : 14/09/2019
 *
 * @name             RegistroDT.php
 *
 * @version          1.0.0
 *
 * @author			Camila Figueroa
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha			Descripción
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

class RegistroDT extends \pan\Kore\Controller{

	protected $_DAOAuditoriaLogin;	
	protected $_DAOPerfil;	

	public function __construct(){
		parent::__construct();
        	
		$this->_DAORol       	    = 	new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol();
		$this->_DAOAuditoriaLogin   = 	new \App\_FuncionesGenerales\General\Entity\DAOAuditoriaLogin();        
        $this->_DAOTraductor    	= 	new \App\_FuncionesGenerales\General\Entity\DAOTraductor();       
		$this->_DAORegion			=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOComuna			=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOTerritorio		=	new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOCodigoRegion		=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;
		$this->_DAOEspecialidad		=	new \App\Farmacia\Medico\Entity\DAOEspecialidad();
		$this->_DAOProfesion		=	new \App\_FuncionesGenerales\General\Entity\DAOProfesion;
        $this->_DAOSolicitudDT		= 	new \App\Farmacias\Entity\DAORegistroDT;
	}								

	public function registro(){
		//se obtienen los parámetros del formulario inicial de registro , por sesion
		$datosSolicitud = $_SESSION[\Constantes::SESSION_BASE]['registroDT']['datosSolicitud'];
		//se valida el rut , el email y el rut
		$valida_rut 			= $this->valida_rut(trim($datosSolicitud['rut']));
		$valida_email 			= $this->comprobar_email(trim($datosSolicitud['email']));
		$valida_region 			= is_int((int)trim($datosSolicitud['id_region']))? true: false;		
		if($valida_rut==true&&$valida_email==true&&$valida_region==true){
			$arrRegion      	= $this->_DAORegion->getLista();
			$arrRegion     		= $this->_DAORegion->getLista();
			$arrTerritorio      = $this->_DAOTerritorio->getLista();
			$arrCodRegion   	= $this->_DAOCodigoRegion->getLista();
			$arrComuna 			= $this->_DAOComuna->getLista();
			$arrEspecialidad	= $this->_DAOEspecialidad->getLista();
			$arrProfesion		= $this->_DAOProfesion->getLista();
			$this->view->addJS('registroDT.js');
			$this->view->addJS('validador.js', 'pub/js/');
			$this->view->addJS('utils.js', 'pub/js/');
			$this->view->addJs('regiones.js','pub/js/helpers/');	
			$this->view->addJS('adjunto.js', 'app/_FuncionesGenerales/Adjuntos/assets/js');		
			
			$this->view->addJs('$("#fc_nacimiento").datepicker({language:"es", format: "dd/mm/yyyy" ,startDate: "-99y", endDate: "-18y",  autoclose: true}).on("hide", function(e) { e.stopPropagation();});
			$("#fc_asume_desde").datepicker({language:"es", format: "dd/mm/yyyy",startDate: "-1y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});
			$("#fc_asume_hasta").datepicker({language:"es", format: "dd/mm/yyyy",startDate: "-1y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});
			$("#fc_cese_hasta").datepicker({language:"es", format: "dd/mm/yyyy",startDate: "-1y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});
			$("#fc_cese_desde").datepicker({language:"es", format: "dd/mm/yyyy",startDate: "-1y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});
			$(".labelauty").labelauty();		
			$(".date").datetimepicker({ format: "HH:mm"});');
			$this->view->set('arrRegion', $arrRegion);
			$this->view->set('arrComuna', $arrComuna);
			$this->view->set('arrTerritorio', $arrTerritorio);
			$this->view->set('arrCodRegion', $arrCodRegion);		
			$this->view->set('arrEspecialidad', $arrEspecialidad);		
			$this->view->set('arrProfesion', $arrProfesion);				
			$this->view->set('arrRegion', $arrRegion);
	
			unset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjTituloDT']);
			unset($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjDeclaracionDT']);
			// GRILLA para adjunto de TITULO DT
			$this->view->set('boComentarioAdj', 0);
			$this->view->set('cantAdjuntos', 1);
			$this->view->set('idTipoAdjunto', 4);
			$this->view->set('extensionAdjunto', 'documento');
			$this->view->set('idForm', 'adjTituloDT');
			$this->view->set('idGrillaAdjunto', 'grillaTituloDT');
			$grillaTituloDT = $this->view->fetchIt('btnAdjuntar',null,'_FuncionesGenerales/Adjuntos');
			// GRILLA para adjunto de DECLARACION DT
			$this->view->set('boComentarioAdj', 0);
			$this->view->set('cantAdjuntos', 1);
			$this->view->set('idTipoAdjunto', 4);
			$this->view->set('extensionAdjunto', 'documento');
			$this->view->set('idForm', 'adjDeclaracionDT');
			$this->view->set('idGrillaAdjunto', 'grillaDeclaracionDT');
			$grillaDeclaracionDT = $this->view->fetchIt('btnAdjuntar',null,'_FuncionesGenerales/Adjuntos');
			
			$this->view->set('grillaTituloDT', $grillaTituloDT);
			$this->view->set('grillaDeclaracionDT', $grillaDeclaracionDT);
			$this->view->render('solicitudRegistroDT/layoutRegistroDT');
		}else{											
			$this->view->render('emailRegistroDT/errorVerificacionNuevoDT');
		}
	}


	public function cargarComunasPorRegion()
	{
		$parametros = $this->request->getParametros();
		$region     = $parametros['region'];
		$comunas	= ($region > 0) ? $this->_DAOComuna->getByRegion($region) : $this->_DAOComuna->getLista();
		$json		= array();
		$i			= 0;

		foreach ($comunas as $comuna) {
			$json[$i]['id_comuna']		=	$comuna->id_comuna_midas;
			$json[$i]['nombre_comuna']	=	$comuna->comuna_nombre;
			$json[$i]['id_region']		=	$comuna->id_region_midas;
			$json[$i]['gl_latitud']		=	$comuna->gl_latitud;
			$json[$i]['gl_longitud']	=	$comuna->gl_longitud;
			$i++;
		}		
		echo json_encode($json);
	}

	/**
	 * Permite registrar la solicitud de director técnico en base de datos
	 * Se almacenan los datos personales, adjuntos, farmacia y mini formularios internos en formato JSON
	 * @author Camila Figueroa
	 */
	public function registraDTBD(){
		$parametros 			= $this->request->getParametros();
		$datos_personales   	= (array)json_decode($parametros['datos_personales']);
		$datos_farmacia			= (array)json_decode($parametros['datos_farmacia']);
		
		// En caso de dudas con respecto a cuales son los indices adecuados para cada caso, descomenta las siguientes lineas 
		// En el archivo error.log se imprimirá el contenido de datos_personales y datos_farmacia
		
		file_put_contents('php://stderr', PHP_EOL . "datos_personales ".print_r($datos_personales,TRUE).PHP_EOL, FILE_APPEND);
		file_put_contents('php://stderr', PHP_EOL . "datos_farmacia ".print_r($datos_farmacia,TRUE).PHP_EOL, FILE_APPEND);
		
		$json_cese_post			= (array)json_decode($parametros['json_cese']);
		$gl_rut_dt 				= trim($datos_personales[0]->value);
		$gl_nombre_dt  			= trim($datos_personales[1]->value);
		$gl_paterno_dt  		= trim($datos_personales[2]->value);
		$gl_materno_dt  		= trim($datos_personales[3]->value);
		$fc_nacimiento_dt  		= date('Y-m-d', strtotime(str_replace('/', '-', trim($datos_personales[4]->value))));
		$gl_email_dt  			= trim($datos_personales[5]->value);		

		$id_profesion_dt  		= trim($datos_personales[6]->value);	
		$gl_tipo_titulo_dt  	= trim($datos_personales[7]->value);
		if($gl_tipo_titulo_dt =="N"){
			$nro_titulo_dt   	= trim($datos_personales[8]->value);
			$archivo_titulo_dt  = "";
		}
		if($gl_tipo_titulo_dt =="A"){
			$archivo_titulo_dt  = $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjTituloDT'];						
			$nro_titulo_dt      = "";
		}

		$archivo_declaracion_dt 		=$_SESSION[\Constantes::SESSION_BASE]['sesion_formulario']['adjDeclaracionDT'];		
		$id_region_dt  			= trim($datos_personales[13]->value);
		$id_comuna_dt  			= trim($datos_personales[14]->value);
		$gl_direccion_dt  		= trim($datos_personales[15]->value);
		$gl_telefono_dt  		= trim($datos_personales[16]->value);
		$id_motivo_dt  			= trim($parametros['bo_motivo']); // 1 ASUME 0 CESE

		if($id_motivo_dt =="1"||$id_motivo_dt ==1){
			$json_asume_dt  	= trim($parametros['json_motivo']) ;
			$json_cese_dt  		= "";
			$bo_asume 			= 1;
			$bo_cese 			= 0;
		}else{
			$json_cese_dt 		= json_encode((array) $json_cese_post);
			$json_asume_dt      = "";
			$bo_asume 			= 0;
			$bo_cese 			= 1;
		}
		$gl_observacion 		= trim($parametros['observacion']);
		$gl_rut_farmacia	 	= trim($datos_farmacia[4]->value);
		$id_region_farmacia 	= trim($datos_farmacia[0]->value);
		$json_farmacia 			= trim($parametros['datos_farmacia']);
		$json_documentos  		=  json_encode(array("adjuntosRegistroDT" => array("adjuntoTituloDT" => $archivo_titulo_dt , "adjuntoDeclaracionDT" => $archivo_declaracion_dt)));

		$bo_solicitud 			= 0; // sin aprobar aun
		$bo_declaracion 		= 0; // 0 = pendiente , 1 = aceptada , 2 = rechazada	
				
		$datos_solicitud = array(
			$gl_rut_dt,
			$gl_nombre_dt,
			$gl_paterno_dt,
			$gl_materno_dt,
			$gl_email_dt, 
			$fc_nacimiento_dt,
			$id_profesion_dt, 
			$nro_titulo_dt,
			$id_region_dt,
			$id_comuna_dt,
			$gl_direccion_dt,
			$gl_telefono_dt,
			$id_motivo_dt,
			$gl_observacion,
			$gl_rut_farmacia,
			$id_region_farmacia,
			$json_farmacia,
			$json_documentos,
			$bo_solicitud,
			$bo_asume, 
			$bo_cese,
			$json_asume_dt,
			$json_cese_dt,
			$bo_declaracion
		);

		$insertaSolicitudBD = $this->_DAOSolicitudDT->insertarSolicitudDT($datos_solicitud);
		if($insertaSolicitudBD){
			$correcto 	= "OK";
			$error 		= false;
			//una vez que el usuario se registra se borra la sesión 
			unset($_SESSION[\Constantes::SESSION_BASE]['registroDT']['datosSolicitud']);
		}else{
			$correcto 	= null;
			$error    	= true;
		}

		$json			= array("correcto" => $correcto, "error" => $error);
        echo json_encode($json);
	}
	
	/**
	 *Permite validar el rut ingresado en el formulariod e solicitud de registro de director técnico 
	 *@author Camila Figueroa
	 */
	function valida_rut($rut){
		$rut = preg_replace('/[^k0-9]/i', '', $rut);
		$dv  = substr($rut, -1);
		$numero = substr($rut, 0, strlen($rut)-1);
		$i = 2;
		$suma = 0;
		foreach(array_reverse(str_split($numero)) as $v)
		{
			if($i==8)
				$i = 2;

			$suma += $v * $i;
			++$i;
		}

		$dvr = 11 - ($suma % 11);
		
		if($dvr == 11)
			$dvr = 0;
		if($dvr == 10)
			$dvr = 'K';

		if($dvr == strtoupper($dv))
			return true;
		else
			return false;
	}

	/**
	 * Permite validar la dirección de correo ingresada en formulario de solicitud de registro de director técnico
	 * @author Camila Figueroa
	 */
	function comprobar_email($email){
		return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
	}

	/**
	 * Muestra la vista de finalización exitoso del registro de solicitud de director técnico
	 * @author Camila Figueroa
	 */
	public function finalizaRegistro(){
		file_put_contents('php://stderr', PHP_EOL . "FinalizaRegistroDT ". PHP_EOL, FILE_APPEND);
		$this->view->render('solicitudRegistroDT/registroExitoso');
	}
	


}
