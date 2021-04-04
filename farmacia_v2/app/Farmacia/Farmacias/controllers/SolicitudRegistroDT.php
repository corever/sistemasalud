<?php

namespace App\Farmacia\Farmacias;


/**
 ******************************************************************************
 * Sistema           : Farmacia V2
 *
 * Descripción       : Controlador SolicitudRegistroDT
 *
 * Plataforma        : PHP
 *
 * Creación          : 08/07/2019
 *
 * @name             SolicitudRegistroDT.php
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

class SolicitudRegistroDT extends \pan\Kore\Controller{

	protected $_DAOAuditoriaLogin;
	protected $_DAOPerfil;

	public function __construct(){
		parent::__construct();

		$this->_DAORol       	    = new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol();
		$this->_DAOAuditoriaLogin   = new \App\_FuncionesGenerales\General\Entity\DAOAuditoriaLogin();
        $this->_DAOTraductor    	= new \App\_FuncionesGenerales\General\Entity\DAOTraductor();
        $this->_DAORegion			=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
	}

	public function index(){

        $arrRegion      = $this->_DAORegion->getLista();
		$this->view->addJS('registroDT.js');
		$this->view->addJS('adjunto.js', 'app/_FuncionesGenerales/Adjuntos/assets/js');	
        $this->view->set('arrRegion', $arrRegion);
		$this->view->render('solicitudRegistroDT/formularioSolicitudRegistroDT');
	}


	public function enviarMailValidacion(){				
		$params     	= $this->request->getParametros();
		$rut 			= trim($params['rut']);
		$email 			= trim($params['email']);
		$id_region 		= trim($params['id_region']);		
		$rut_hash 		= str_pad(base64_encode($rut),20,"-",STR_PAD_LEFT);
		$email_hash     = str_pad(base64_encode($email), 100, "-", STR_PAD_LEFT);
		$region_hash 	= str_pad(base64_encode($id_region),5,"-",STR_PAD_LEFT);
		
		$arrInfo        = array(								
								"hash_data"        => base64_encode($rut_hash.$email_hash.$region_hash),
								"fecha"         => \Fechas::fechaHoyVista(),
								"rut"			=> $rut,
								"email"         => $email,
								"id_region"		=> $id_region
		);

		// Segunda validacion de datos 

		$rut_valido= $this->valida_rut(trim($params['rut']));
		$email_valido = $this->comprobar_email(trim($params['email']));
		$region_valida = is_int((int)trim($params['id_region']))? true: false;

		if($rut_valido==true&&$email_valido==true&&$region_valida==true){
			$_SESSION[\Constantes::SESSION_BASE]['registroDT']['datosSolicitud']   = $arrInfo;
			$asunto         = "Solicitud de Registro DT - HOPE OPS WEB";
			$html_email     = $this->view->fetchIt('emailRegistroDT/mailVerificacionNuevoDT', $arrInfo, 'Farmacia/Farmacias');			
			$respuestaEmail = \Email::sendEmail($email, $asunto, $html_email);
			if($respuestaEmail['correcto']){
				$correcto = "OK";
				$error = false;
			}else{
				$correcto = null;
				$error = true;
			}
			file_put_contents('php://stderr', PHP_EOL."Envio de email : ".print_r($correcto, TRUE). PHP_EOL, FILE_APPEND);
			
		}else{
			$correcto = null;
			$error = true;
		}

		$json			= array("correcto" => $correcto, "error" => $error);
        echo json_encode($json);
	}


	
	public function verCorreo(){

		$arrRegion      	= $this->_DAORegion->getLista();
		$datosSolicitud = $_SESSION[\Constantes::SESSION_BASE]['registroDT']['datosSolicitud'];
		$valida_rut 			= $this->valida_rut(trim($datosSolicitud['rut']));
		$valida_email 			= $this->comprobar_email(trim($datosSolicitud['email']));
		$valida_region 		= is_int((int)trim($datosSolicitud['id_region']))? true: false;
		if($valida_rut==true&&$valida_email==true&&$valida_region==true){
			$this->view->addJS('registroDT.js');		
			$this->view->set('datosSolicitud', $datosSolicitud);
			$this->view->set('arrRegion', $arrRegion);
			$this->view->render('emailRegistroDT/mailVerificacionNuevoDT');
		}else{											
			$this->view->render('emailRegistroDT/errorVerificacionNuevoDT');
		}
		
	}

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


	function comprobar_email($email){
		return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
	}
}
