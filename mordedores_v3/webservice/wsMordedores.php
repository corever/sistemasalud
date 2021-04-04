<?php
	//error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
	error_reporting(0);
	ini_set('display_errors', 0);
	ini_set('post_max_size', '256M');
	ini_set('upload_max_filesize', '256M');
	ini_set('execution_time', 3600);
	ini_set('max_execution_time', 3600);
	ini_set('memory_limit', '2048M');

//	error_log(print_r($_SERVER['CLIENT'],1));		
	//error_log(print_r($_REQUEST,1));	
	//error_log(print_r($_SERVER,1));	
	
	//error_log(":::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::");	
	//error_log(print_r(file_get_contents("php://input"),1));	
	
	include_once('nusoap/common/wsMordedores/config.php');
	include_once('nusoap/lib/nusoap.php');
	include_once('MySqli.php');
	include_once('include.php');

	include_once("DAO/DAOAdjunto.php");
	include_once("DAO/DAOAdjuntoTipo.php");
	include_once("DAO/DAOAnimalEspecie.php");
	include_once("DAO/DAOAnimalEstado.php");
	include_once("DAO/DAOAnimalEstadoProductivo.php");
	include_once("DAO/DAOAnimalMordedor.php");
	include_once("DAO/DAOAnimalTamano.php");
	include_once("DAO/DAOAnimalRaza.php");
	include_once("DAO/DAOAnimalSexo.php");
	include_once("DAO/DAOAnimalVacuna.php");
	include_once("DAO/DAOAnimalVacunaLaboratorio.php");
	include_once("DAO/DAODireccionComuna.php");
	include_once("DAO/DAODireccionNacionalidad.php");
	include_once("DAO/DAODireccionPais.php");
	include_once("DAO/DAODireccionProvincia.php");
	include_once("DAO/DAODireccionRegion.php");
	include_once("DAO/DAODueno.php");
	include_once("DAO/DAOErrorLog.php");
	include_once("DAO/DAOExpediente.php");
	include_once("DAO/DAOExpedienteEstado.php");
	include_once("DAO/DAOExpedienteMordedor.php");
	include_once("DAO/DAOExpedientePaciente.php");
	include_once("DAO/DAOHistorialEvento.php");
	include_once("DAO/DAOMensajeUsuario.php");
	include_once("DAO/DAOMensajeWebservice.php");
	include_once("DAO/DAOPaciente.php");
	include_once("DAO/DAOPacienteAlarma.php");
	include_once("DAO/DAOPacienteContactoTipo.php");
	include_once("DAO/DAOPacienteDatos.php");
	include_once("DAO/DAOPacienteEstado.php");
	include_once("DAO/DAOPacienteRabia.php");
	include_once("DAO/DAOPacienteRegistro.php");
	include_once("DAO/DAOSoap.php");
	include_once("DAO/DAOTipoContacto.php");
	include_once("DAO/DAOTipoDuracionInmunidad.php");
	include_once("DAO/DAOTipoLaboratorio.php");
	include_once("DAO/DAOTipoVacuna.php");
	include_once("DAO/DAOUsuario.php");
	include_once("DAO/DAOVisita.php");
	include_once("DAO/DAOVisitaAnimalMordedor.php");
	include_once("DAO/DAOVisitaAnimalSintomaTipo.php");
	include_once("DAO/DAOVisitaAnimalVacuna.php");
	include_once("DAO/DAOVisitaEstado.php");
	include_once("DAO/DAOVisitaPerdidaTipo.php");

	include_once("DAO/DAODesratizacion.php");

	session_start();
	// Configura el WSDL
	$server									= new soap_server();
	
	header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: SOAPAction, Content-Type, Authorization");

	$server->debug_flag						= SOAP_SERVER_DEBUG_MODE;

	$server->configureWSDL(SOAP_SERVER_NAME, SOAP_SERVER_NAMESPACE);
	$server->wsdl->schemaTargetNamespace	= SOAP_SERVER_NAMESPACE;
	$server->soap_defencoding				= SOAP_SERVER_ENCODING; 

	//Cargar archivos de funciones
	$directorio = opendir(FUNCTION_FOLDER);

	while ($archivo = readdir($directorio)){
		$ruta = FUNCTION_FOLDER."/".$archivo;
		
		if (is_file($ruta) and $archivo != "index.php"){
			include_once($ruta);
		}
	}

	// Código para invocar el servicio.
	//$HTTP_RAW_POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';	
	//$server->service($HTTP_RAW_POST_DATA);
	$server->service(file_get_contents("php://input"));
	

