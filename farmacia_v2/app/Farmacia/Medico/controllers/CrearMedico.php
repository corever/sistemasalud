<?php

namespace App\Farmacia\Medico;
use Pan\Utils\ValidatePan as validatePan;

/**
 ******************************************************************************
 * Sistema           : HOPE
 *
 * Descripción       : Controlador Crear Medico Cirujano
 *
 * Plataforma        : PHP
 *
 * Creación          : 09/09/2020
 *
 * @name             CrearMedico.php 
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

class CrearMedico extends \pan\Kore\Controller{


	public function __construct(){

		parent::__construct();
        
		$this->_DAORegion				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOComuna				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAOTerritorio			=	new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOCodigoRegion			=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;
		$this->_DAOEspecialidad			=	new \App\Farmacia\Medico\Entity\DAOEspecialidad();
		$this->_DAOProfesion			=	new \App\_FuncionesGenerales\General\Entity\DAOProfesion;
        
	}

	public function index(){

		$this->view->addJS('adminMedico.js');
		$this->view->addJS('validador.js', 'pub/js/');
		$this->view->addJS('utils.js', 'pub/js/');
        $arrRegion     		= $this->_DAORegion->getLista();
        $arrTerritorio      = $this->_DAOTerritorio->getLista();
		$arrCodRegion   	= $this->_DAOCodigoRegion->getLista();
		$arrComuna 			= $this->_DAOComuna->getLista();
		$arrEspecialidad	= $this->_DAOEspecialidad->getLista();
		$arrProfesion		= $this->_DAOProfesion->getLista();
		
		$this->view->addJS('$("#fc_nacimiento_medico").datepicker({language:"es", format: "dd/mm/yyyy",startDate: "-99y", endDate: "-18y", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$(".labelauty").labelauty();');	
		$this->view->addJS('adminMedico.js');			
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrTerritorio', $arrTerritorio);
		$this->view->set('arrCodRegion', $arrCodRegion);		
		$this->view->set('arrEspecialidad', $arrEspecialidad);		
		$this->view->set('arrProfesion', $arrProfesion);		
		$this->view->set('registrar',    $this->view->fetchIt('crearMedico/nuevoMedico'));
		$this->view->set('contenido', $this->view->fetchIt('crearMedico/menuCrearMedico'));
        $this->view->render();
        
	}

}
