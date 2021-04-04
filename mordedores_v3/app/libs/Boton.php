<?php

/**
*****************************************************************************
* Sistema		: PREVENCION DE FEMICIDIOS
* Descripcion	: Helper de Boton
* Plataforma	: !PHP
* Creacion		: 24/02/2017
* @name			Boton.php
* @version		1.0
* @author		Victor Retamal <victor.retamal@cosof.cl>
*=============================================================================
*!ControlCambio
*--------------
*!cProgramador				!cFecha		!cDescripcion 
*-----------------------------------------------------------------------------
*
*-----------------------------------------------------------------------------
*****************************************************************************
*/

Class Boton{

	/**
	* Genera boton Ayuda ?
	* @param string $explicacion
	* @param string $titulo
	* @param string $class_posicion 'pull-left', 'pull-right' o '' 
	* @return string html
	*/
	public static function botonAyuda($explicacion, $titulo='', $class_posicion="pull-right", $class_color="btn-primary"){
		
		return '<span class="btn btn-xs '.$class_color.' '.$class_posicion.' infoTip" data-pos="'.$class_posicion.'" data-titulo="'.$titulo.'" data-texto="'.$explicacion.'">
					<li class="fa fa-question-circle"></li>
				</span>';
	}

	public static function getBotonVer($token_expediente='',$gl_folio=''){
		return	"	<button type='button' 
                        onClick=\"xModal.open('".BASE_URI."/Paciente/ver/$token_expediente', 'Detalle Notificación $gl_folio', 85)\"
                        data-toggle='tooltip' 
                        class='btn btn-xs btn-info'
                        data-title='Ver'>
                        <i class='fa fa-search'></i>
                    </button>";
	}

	public static function getBotonBitacora($token_expediente='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Bitacora/ver/$token_expediente', 'Bitácora $gl_folio', 85)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-primary'
						data-title='Bitácora'>
						<i class='fa fa-info-circle'></i>
					</button>";
	}

	public static function getBotonNotificacionRepetida($token_expediente='',$gl_folio='',$gl_rut=''){
		return	"	<button type='button' 
						onClick=\"Paciente.notificacionRepetida(this,'".$token_expediente."','".$gl_folio."','".$gl_rut."');\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-success'
						data-title='¿Corresponde a Notificación?'>
						<i class='fa fa-check'></i>
					</button>";
	}
	
	public static function getBotonAsignarFiscalizador($token_expediente='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Agenda/asignar/$token_expediente', 'Asignar Fiscalizador $gl_folio', 80)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-success'
						data-title='Asignar'>
						<i class='fa fa-user-plus'></i>
					</button>";
	}
	
	public static function getBotonReasignarFiscalizador($token_expediente='',$token_fiscalizador='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Agenda/asignar/$token_expediente/$token_fiscalizador', 'Reasignar Fiscalizador $gl_folio', 80)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-success'
						data-title='Reasignar'>
						<i class='fa fa-refresh'></i>
					</button>";
	}
	
	public static function getBotonDevolverVisita($token_expediente='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Agenda/devolver/$token_expediente', 'Devolver Visita $gl_folio', 80)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-warning'
						data-title='Devolver Visita'>
						<i class='fa fa-undo'></i>
					</button>";
	}
	
	public static function getBotonProgramarVisita($token_expediente='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Agenda/programar/$token_expediente', 'Programar Visita $gl_folio', 80)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-success'
						data-title='Programar Visita'>
						<i class='fa fa-calendar'></i>
					</button>";
	}
	
	public static function getBotonReprogramar($token_expediente='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Agenda/programar/$token_expediente/1', 'Reprogramar Visita $gl_folio', 80)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-warning'
						data-title='Reprogramar Visita'>
						<i class='fa fa-calendar'></i>
					</button>";
	}
	
	public static function getBotonInformarVisita($token_expediente='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Agenda/informarVisita/$token_expediente/', 'Informar Visita $gl_folio', 80)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-success'
						data-title='Informar Visita'>
						<i class='fa fa-pencil'></i>
					</button>";
	}
	
	public static function getBotonAsignarMicrochip($token_expediente='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Microchip/asignar/$token_expediente/', 'Asignar Fiscalizador $gl_folio', 80)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-success'
						data-title='Asignar Fiscalizador'>
						<i class='fa fa-user-plus'></i>
					</button>";
	}
	
	public static function getBotonReasignarMicrochip($token_expediente='',$token_fiscalizador='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Microchip/asignar/$token_expediente/$token_fiscalizador', 'Reasignar Fiscalizador $gl_folio', 80)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-warning'
						data-title='Reasignar Fiscalizador'>
						<i class='fa fa-refresh'></i>
					</button>";
	}
	
	public static function getBotonEditarDireccion($token_expediente='',$gl_folio=''){
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Administrativo/editar/$token_expediente', 'Editar Dirección $gl_folio', 80)\" 
						data-toggle='tooltip' 
						class='btn btn-xs btn-warning'
						data-title='Editar Dirección'>
						<i class='fa fa-edit'></i>
					</button>";
	}
	
	public static function getBotonDescargaDocInicial($token_expediente='',$texto_btn='',$class_btn='btn-success'){
		return	"	<button type='button' 
						onClick=\"window.open('".BASE_URI."/Adjunto/verDocInicialByTokenExpediente/?token=$token_expediente')\"  
						data-toggle='tooltip' 
						class='btn btn-xs $class_btn'
						data-title='Descargar Documento Inicial'>
                        <i class='fa fa-download'></i>
                        $texto_btn
					</button>";
	}
	
	public static function getBotonDescargaActa($token_expediente=''){
		return	"	<button type='button' 
						onClick=\"window.open('".BASE_URI."/Paciente/generarPdfActa/$token_expediente')\" 
						data-toggle='tooltip'
						class='btn btn-xs btn-success'
						data-title='Descargar Acta Visita'>
						<i class='fa fa-download'></i>
					</button>";
	}
	
	public static function getBotonResultadoISP($token_expediente='',$gl_folio=''){
        
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Administrativo/resultadoISP/?token_expediente=$token_expediente', 'Resultado de Muestra ISP $gl_folio', 80)\" 
						data-toggle='tooltip'
						class='btn btn-xs btn-warning'
						data-title='Resultado ISP'>
						<i class='fa fa-flask'></i>
					</button>";
	}
    
	public static function getBotonCerrarNotificacion($token_expediente='',$gl_folio=''){
        
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Microchip/cerrarNotificacion/?token_expediente=$token_expediente', 'Cerrar Notificación $gl_folio', 60)\" 
						data-toggle='tooltip'
						class='btn btn-xs btn-danger'
						data-title='Cerrar Notificación'>
						<i class='fa fa-close'></i>
					</button>";
	}
    
	public static function getBotonLlamadoPacienteObserva($token_expediente='',$gl_folio=''){
        
		return	"	<button type='button' 
						onClick=\"xModal.open('".BASE_URI."/Paciente/llamadoPacienteObserva/?token_expediente=$token_expediente', 'Llamado Paciente Observa $gl_folio', 60)\" 
						data-toggle='tooltip'
						class='btn btn-xs btn-info'
						data-title='Llamado Paciente Observa'>
						<i class='fa fa-phone'></i>
					</button>";
	}
	
	public static function getBotonInformarWeb($token_expediente=''){
		return	"	<button type='button' 
						onClick=\"window.location.href ='".BASE_URI."/Informar/visita/$token_expediente/'\"  
						data-toggle='tooltip' 
						class='btn btn-xs btn-default'
						data-title='Informar Visita'>
						<i class='fa fa-tablet fa-2x'></i>
					</button>";
	}

	/**
	* Generar botones en Grilla
	* @param string $bandeja [de donde se llama]
	* @param int $id_paciente
	* @return string html
	*/
	public static function botonGrilla(	$bandeja                        = '',
										$token_expediente               = '',
										$token_fiscalizador             = '',
										$grupo_estado                   = '0',
										$id_animal_grupo                = '0',
										$microchip                      = '0',
										$gl_folio                       = '',
										$nr_visitas                     = '0', 
										$expediente_estado              = '0',
										$bo_domicilio_conocido          = '0',
										$id_tipo_visita                 = '0',
										$id_tipo_visita_mor             = '0',
                                        $id_resultado_isp_1             = '0',
										$id_resultado_isp_2             = '0',
										$bo_all_domicilio_conocido      = '0',
                                        $grupo_fiscalizador             = '0',
                                        $bo_paciente_observa            = '0',
                                        $boton_llamado_observa          = '0',
                                        $grupo_resultado_isp            = '0',
                                        $id_ultimo_visita_estado        = '0',
                                        $id_ultimo_tipo_visita_perdida  = '0',
                                        $bo_ultimo_volver_visitar       = '0'
										){
        
        $id_usuario             = $_SESSION[SESSION_BASE]['id'];
        $id_perfil              = $_SESSION[SESSION_BASE]['perfil'];
        $bo_informar_web        = $_SESSION[SESSION_BASE]['bo_informar_web'];
        $arr_estados            = explode(",", $grupo_estado);
        $arr_fiscalizador       = explode(",", $grupo_fiscalizador);
        $arr_resultado_isp      = explode(",", $grupo_resultado_isp);
        
		$ver					= Boton::getBotonVer($token_expediente,$gl_folio);
		$bitacora				= Boton::getBotonBitacora($token_expediente,$gl_folio);
		$asignar				= Boton::getBotonAsignarFiscalizador($token_expediente,$gl_folio);
		$programar				= Boton::getBotonProgramarVisita($token_expediente);
		$reprogramar            = Boton::getBotonReprogramar($token_expediente);
		$informar				= Boton::getBotonInformarVisita($token_expediente);
		$asignarMicrochip       = Boton::getBotonAsignarMicrochip($token_expediente,$gl_folio);
		$reasignarMicrochip     = Boton::getBotonReasignarMicrochip($token_expediente,$gl_folio);
		$descargar				= Boton::getBotonDescargaActa($token_expediente);
		$reasignar				= Boton::getBotonReasignarFiscalizador($token_expediente,$token_fiscalizador,$gl_folio);
		$editarDireccion        = Boton::getBotonEditarDireccion($token_expediente,$gl_folio);
		$descargaDocInicial     = Boton::getBotonDescargaDocInicial($token_expediente);
		$devolver               = Boton::getBotonDevolverVisita($token_expediente,$gl_folio);
		$resultadoISP           = Boton::getBotonResultadoISP($token_expediente,$gl_folio,$nr_visitas);
		$cerrarNotificacion     = Boton::getBotonCerrarNotificacion($token_expediente,$gl_folio);
		$informarWeb     		= Boton::getBotonInformarWeb($token_expediente);
		$llamadoPacienteObs 	= Boton::getBotonLlamadoPacienteObserva($token_expediente,$gl_folio);
        
       
		
		if($bandeja == 'editar_direccion'){
			$botones	.= $editarDireccion;
		}else{
			$botones                = ($nr_visitas>0 && $id_perfil != 13 && $id_perfil != 15)?$ver:"";
			$botones				.= $bitacora;
			if($bandeja == 'otro'){
				//$botones	= $ver.$bitacora;
			}else if($bandeja == 'nacional'){
				/*if(in_array("1",$arr_estados) && $id_animal_grupo == 3){
					$botones    .= $asignar;
				}elseif(in_array("9",$arr_estados) && $id_animal_grupo == 3){
					$botones    .= $reasignar;
				}*/
			}else if($bandeja == 'admin'){
				if($bo_domicilio_conocido == 1){
					if(in_array("1",$arr_estados) && $id_animal_grupo == 3){
						if($expediente_estado == "7"){
							$botones    .= ($microchip==1)?$reasignarMicrochip:$reasignar;
						}else{
							if($microchip==1){
								$botones    .= $asignarMicrochip;
							}else{
								$botones    .= ($bo_paciente_observa==1 && $boton_llamado_observa != 33 && $boton_llamado_observa != 32 && $boton_llamado_observa != 34)?$llamadoPacienteObs:$asignar;
							}
						}
					}elseif(in_array("9",$arr_estados) && $id_animal_grupo == 3){
						$botones    .= ($microchip==1)?$reasignarMicrochip:$reasignar;
					}elseif($expediente_estado == 11 && $id_ultimo_visita_estado == 1 &&
						($id_ultimo_tipo_visita_perdida == 2 || $id_ultimo_tipo_visita_perdida == 4) && $bo_ultimo_volver_visitar == 2){
						if($microchip==1){
							$botones    .= $asignarMicrochip;
						}
						else{
							$botones    .= $asignar;
						}
					}
				}
				
				if($expediente_estado != "6" && $expediente_estado != "7" && ($id_tipo_visita == "2" || $id_tipo_visita_mor == "2")){
					if($id_resultado_isp_1 != 1 && $id_resultado_isp_2 != 2){
						$botones .= $resultadoISP;
					}
				}
				/*
				if($expediente_estado == "6" || $expediente_estado == "7" || $expediente_estado == "14"){
					$botones .= $informarWeb;
				}
				*/
			}else if($bandeja == 'establecimiento'){
				$botones	.= $descargaDocInicial;
			}else if($bandeja == 'administrativo'){
				if($bo_all_domicilio_conocido == 0 && $id_animal_grupo == 3){
					$botones	.= $editarDireccion;
					$botones	.= $llamadoPacienteObs;
				}
			}else if($bandeja == 'seremi'){
				//if($id_perfil != 10){
					if($bo_domicilio_conocido == 1){
						if(in_array("1",$arr_estados) && $id_animal_grupo == 3){
							if($expediente_estado == "7"){
								$botones    .= ($microchip==1)?$reasignarMicrochip:$reasignar;
							}else{
								if($microchip==1){
									$botones    .= $asignarMicrochip;
								}else{
									$botones    .= ($bo_paciente_observa==1 && $boton_llamado_observa != 33 && $boton_llamado_observa != 32 && $boton_llamado_observa != 34)?$llamadoPacienteObs:$asignar;
								}
							}
						}elseif(in_array("9",$arr_estados) && $id_animal_grupo == 3){
							$botones    .= ($microchip==1)?$reasignarMicrochip:$reasignar;
						}elseif($expediente_estado == 11 && $id_ultimo_visita_estado == 1 &&
							($id_ultimo_tipo_visita_perdida == 2 || $id_ultimo_tipo_visita_perdida == 4) && $bo_ultimo_volver_visitar == 2){
							if($microchip==1){
								$botones    .= $asignarMicrochip;
							}
							else{
								$botones    .= $asignar;
							}
						}
					}
				//}
				if($expediente_estado != "6" && $expediente_estado != "7" && ($id_tipo_visita == "2" || $id_tipo_visita_mor == "2")){
					if($id_resultado_isp_1 != 1 && $id_resultado_isp_2 != 2){
						$botones .= $resultadoISP;
					}
				}
				
				if($microchip == 1){
					//$botones .= $informarWeb;
					//$botones .= $cerrarNotificacion;
				}
			}
			else if($bandeja == 'fiscalizador'){
				/*if((in_array("2",$arr_estados) || in_array("13",$arr_estados)) && $id_animal_grupo == 3){
					$botones    .= $programar;
				}elseif((in_array("6",$arr_estados) || in_array("14",$arr_estados)) && $id_animal_grupo == 3){
					$botones    .= $reprogramar;
				}*/
				//$botones    .= ($estado_expediente == 6)?$informar:"";
				if((in_array("6",$arr_estados) OR in_array("14",$arr_estados) OR in_array("7",$arr_estados)) && $id_animal_grupo == 3){
					$botones    .= $devolver;
				}
				$botones    .= (in_array("6",$arr_estados) OR in_array("7",$arr_estados) OR in_array("14",$arr_estados))?$descargar:"";
				
				if((in_array("6",$arr_estados) OR in_array("7",$arr_estados) OR in_array("14",$arr_estados))
					&& $id_animal_grupo == 3 && $bo_informar_web && in_array($id_usuario,$arr_fiscalizador)){
					$botones .= $informarWeb;
				}
			}
			else if($bandeja == 'buscarAdministrativo'){
				if($bo_all_domicilio_conocido == 0 && $id_animal_grupo == 3){
					$botones	.= $editarDireccion;
				}
			}
			else if($bandeja == 'buscarSeremi'){
				//Botón Resultado ISP
				if(!in_array("6",$arr_estados) && !in_array("7",$arr_estados) && ($id_tipo_visita == "2" || $id_tipo_visita_mor == "2")){
					if(in_array(0,$arr_resultado_isp) && !in_array(1,$arr_resultado_isp)){
						$botones .= $resultadoISP;
					}
				}
				if($bo_domicilio_conocido == 1){
					if(in_array("1",$arr_estados) && $id_animal_grupo == 3){
						if($expediente_estado == "7"){
							$botones    .= ($microchip==1)?$reasignarMicrochip:$reasignar;
						}else{
							if($microchip==1){
								$botones    .= $asignarMicrochip;
							}else{
								$botones    .= ($bo_paciente_observa==1 && $boton_llamado_observa != 33 && $boton_llamado_observa != 32 && $boton_llamado_observa != 34)?$llamadoPacienteObs:$asignar;
							}
						}
					}elseif(in_array("9",$arr_estados) && $id_animal_grupo == 3){
						$botones    .= ($microchip==1)?$reasignarMicrochip:$reasignar;
					}elseif($expediente_estado == 11 && $id_ultimo_visita_estado == 1 &&
						($id_ultimo_tipo_visita_perdida == 2 || $id_ultimo_tipo_visita_perdida == 4) && $bo_ultimo_volver_visitar == 2){
						if($microchip==1){
							$botones    .= $asignarMicrochip;
						}
						else{
							$botones    .= $asignar;
						}
					}
				}
			}
		}
		file_put_contents('php://stderr', PHP_EOL . "botones: ".print_r($botones,TRUE).PHP_EOL, FILE_APPEND);
		return $botones;
	}

}