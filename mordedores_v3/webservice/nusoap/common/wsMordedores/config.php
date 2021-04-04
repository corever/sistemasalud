<?php
	
	// Configuración del servidor SOAP
	define("SOAP_SERVER_NAME", "mordedoresapi");
	define("SOAP_SERVER_NAMESPACE",'urn:mordedoresapi');
	define("SOAP_SERVER_DEBUG_MODE", false);
	define("SOAP_SERVER_ENCODING", "UTF-8"); 
	define("FUNCTION_FOLDER", "functions/wsMordedores");	
	define("VERSION_WS", "1.0");	
	define("VERSION_APP", "1.0");	
	define("VERSION_MAYOR_APP", "1");
	define("LAST_VERSION_APP", "1.0"); //ultima versión aceptada
	define("NEXT_RELEASE", ""); //Fecha proxima publicacion (deprecar versiones antiguas)
	define("WS_UPDATE_DESRATIZACION", "https://asdigitaltest.minsal.cl/asdigital/jsonp/updateDesratizacionesTablet.php");
	define("WS_GET_DESRATIZACIONES", "http://asdigitaltest.minsal.cl/asdigital/jsonp/cargaDesratizacionesTablet_.php");