<?php

/**
*****************************************************************************
* Sistema		: ANIMALES MORDEDORES
* Descripcion	: Helper de Eventos
* Plataforma	: !PHP
* Creacion		: 10/05/2018
* @name			Evento.php
* @version		1.0
* @author		David Guzmán <david.guzman@cosof.cl>
*=============================================================================
*!ControlCambio
*--------------
*!cProgramador				!cFecha		!cDescripcion 
*-----------------------------------------------------------------------------
*
*-----------------------------------------------------------------------------
*****************************************************************************
*/

include_once (APP_PATH . 'models/DAOHistorialEvento.php');

Class Evento{

    protected $_DAOEvento;

    public function __construct() {
        $this->_DAOEvento = New DAOHistorialEvento();
    }
    
	 /**
     * Guarda un Nuevo Evento
     * @param int $id_evento_tipo
	 * @param int $id_expediente
	 * @param int $id_paciente
	 * @param int $id_mordedor
	 * @param string $gl_descripcion
	 * @param array $mostrar_in
     */
    public function guardar($id_evento_tipo, $id_expediente, $id_paciente, $id_mordedor, $gl_descripcion, $id_tipo_comentario=NULL, $mostrar_in="1",$gl_otro_tipo_comentario=""){
        
        $datos_evento   = array(    $id_evento_tipo,
                                    $id_expediente,
                                    $id_paciente,
                                    $id_mordedor,
                                    $id_tipo_comentario,
                                    $gl_otro_tipo_comentario,
                                    $gl_descripcion,
                                    $mostrar_in
						        );
		$resp           = $this->_DAOEvento->insertarEvento($datos_evento);
        
		return $resp;
    }

	public function guardarMostrarUltimo($tipo_evento,$id_empa, $id_paciente, $gl_descripcion, $bo_estado,$bo_mostrar, $id_usuario_crea){
        
        $datos_evento['eventos_tipo']		= $tipo_evento;
		$datos_evento['id_empa']			= $id_empa;
		$datos_evento['id_paciente']		= $id_paciente;
		$datos_evento['gl_descripcion']		= $gl_descripcion;
		$datos_evento['bo_estado']			= $bo_estado;
		$datos_evento['bo_mostrar']			= $bo_mostrar;
		$datos_evento['id_usuario_crea']	= $id_usuario_crea;
		$ocultar							= $this->_DAOEvento->ocultarEventos($tipo_evento);
		$resp								= FALSE;

		if ($ocultar){
			$resp							= $this->_DAOEvento->insEvento($datos_evento);
		}
		return $resp;
    }
   
}