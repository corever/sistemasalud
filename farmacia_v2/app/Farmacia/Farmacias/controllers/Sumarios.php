<?php

namespace App\Farmacia\Farmacias;


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
 * @name             Sumarios.php
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
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

class Sumarios extends \pan\Kore\Controller{

	/*Inicializando Variables*/
	protected $_DAOUsuario;

	public function __construct(){

		parent::__construct();
        
        $this->_DAOUsuario  = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario();
        
	}

	public function index(){

		$this->view->addJS('sumarios.js');
        $this->view->set('contenido', $this->view->fetchIt('index'));
        $this->view->render();
        
	}

}
