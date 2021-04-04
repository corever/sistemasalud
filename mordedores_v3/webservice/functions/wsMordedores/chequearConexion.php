<?php

	//Entrada
	$server->wsdl->addComplexType(
		'chequearConexionInput',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rut' 		=> array( 'rut'			, 'type' => 'xsd:string'),
			'password' 	=> array( 'password'	, 'type' => 'xsd:string'),
			'token' 	=> array( 'token'		, 'type' => 'xsd:string')
		)
	);


	// Salida
	$server->wsdl->addComplexType(
	    'chequearConexionOutput',
        'complexType',
		'struct',
		'sequence',
		'',
		array(
		    'estado'				=> array('estado'			, 'type' => 'xsd:boolean'),
		    'appVersion'			=> array('appVersion'		, 'type' => 'xsd:string'),
		    'lastAppVersion'		=> array('lastAppVersion'	, 'type' => 'xsd:string'),
		    'proxRelease'			=> array('proxRelease'		, 'type' => 'xsd:string'),
	    )
	);

	$server->register(  'chequearConexion',
						array('data'	=> 'tns:chequearConexionInput'),
						array('return'	=> 'tns:chequearConexionOutput'),
						SOAP_SERVER_NAMESPACE,
						SOAP_SERVER_NAMESPACE.'#chequearConexion',
						"rpc", 
						"encoded", 
						''
	);


	function chequearConexion($arrWs){

		$respuesta =   array(
		            		'estado'		=> true,
		            		'appVersion'	=> VERSION_APP,
		            		'lastAppVersion'=> LAST_VERSION_APP,
		            		'proxRelease' 	=> NEXT_RELEASE
		            	);

		return $respuesta;
    }
