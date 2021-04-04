<?php

class Evento{

    public static function setEvento($id_evento_tipo, $arr_tag=null, $gl_mensaje=''){
		
		$DAOEvento     = new App\_FuncionesGenerales\General\Entity\DAOEvento();
		$DAOEventoTipo = new App\_FuncionesGenerales\General\Entity\DAOEventoTipo();
	
        if(is_array($arr_tag)){

			$mensaje_tag = $DAOEventoTipo->getEventoTipoById($id_evento_tipo);
			$flag 		 = 0;
			foreach($arr_tag as $keyTag => $valTag){
				$gl_descripcion = str_replace($keyTag, $valTag, ($flag == 0 ? $mensaje_tag->gl_descripcion : $gl_descripcion));
				$flag++;
			}
			
		}else{
			$gl_descripcion	= $gl_mensaje;
		}
		
		$datos_evento   = array(
			$id_evento_tipo,
			1,
			$gl_descripcion,
			$_SESSION[\Constantes::SESSION_BASE]['id_usuario']
		);
        
		return $DAOEvento->insertarEvento($datos_evento);
    }
    
    public static function eventoUsuario($id_historial_tipo, $id_usuario, $gl_mensaje='', $arr_tag=null, $arr_replace=null){
        $DAOUsuarioHistorial    = new App\Usuario\Entity\DAOUsuarioHistorial();
        
        if(is_array($arr_tag)){
			$mensaje_tag	= $DAOUsuarioHistorial->getHistorialTipoById($id_historial_tipo);

			$gl_descripcion = str_replace($arr_tag,$arr_replace,$mensaje_tag->gl_descripcion);
		}else{
			$gl_descripcion	= $gl_mensaje;
		}
        
        $datos_evento   = array(    $id_usuario,
                                    $id_historial_tipo,
                                    $gl_descripcion,
                                    $_SESSION[\Constantes::SESSION_BASE]['id_usuario']
						        );
        
		$resp                   = $DAOUsuarioHistorial->insertarEvento($datos_evento);
        
		return $resp;
    }
    
}