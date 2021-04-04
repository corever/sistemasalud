<?php

/**
*****************************************************************************
* Sistema		: PREVENCION DE FEMICIDIOS
* Descripcion	: Helper de Fechas
* Plataforma	: !PHP
* Creacion		: 24/02/2017
* @name			Fechas.php
* @version		1.0
* @author		David Gusmán <david.guzman@cosof.cl>
*=============================================================================
*!ControlCambio
*--------------
*!cProgramador				!cFecha		!cDescripcion 
*-----------------------------------------------------------------------------
*
*-----------------------------------------------------------------------------
*****************************************************************************
*/

class Fechas{

	public static function formatearBaseDatos($fecha,$separador="-"){
		if(empty($fecha) || is_null($fecha) || $fecha == "NULL"){
			return 'NULL';
		}
		if (strpos($fecha, " ") !== false){
			$time	= explode(" ",$fecha);
			return self::formatearBaseDatos($time[0]) . " " . $time[1];
		}else{
			$fecha	= explode("/",$fecha);
			if(strlen($fecha[0]) < 4){
				return "'".$fecha[2] . $separador . $fecha[1] . $separador . $fecha[0]."'";
			}
			else{
				return "'".$fecha[0] . $separador . $fecha[1] . $separador . $fecha[1]."'";
			}
		}
	}
	
	public static function formatearBaseDatosSinComilla($fecha,$separador="-"){
		if(empty($fecha) || is_null($fecha) || $fecha == "NULL"){
			return 'NULL';
		}
		if (strpos($fecha, " ") !== false){
			$time	= explode(" ",$fecha);
			return self::formatearBaseDatos($time[0]) . " " . $time[1];
		}else{
			$fecha	= (strpos($fecha, "/") !== false) ? explode("/",$fecha): explode("-",$fecha);
			//verifico si la fecha ya está en el orden correcto
			if(strlen($fecha[0]) < 4){
				return $fecha[2] . $separador . $fecha[1] . $separador . $fecha[0];
			}else{
				return $fecha[0] . $separador . $fecha[1] . $separador . $fecha[2];
			}
		}
	}

	public static function formatearHtml($fecha,$separador="/"){
		if(empty($fecha)){
			return '';
		}
		if (strpos($fecha, " ") !== false){
			$time = explode(" ",$fecha);
			return self::formatearHtml($time[0]) . " " . $time[1];
		}else{
			$fecha = explode("-",$fecha);
			return $fecha[2] . $separador . $fecha[1] . $separador . $fecha[0];
		}
	}

	public static function traducirFecha($fecha){
		return str_replace('day','día',str_replace('mon','mes',str_replace('mons','meses',str_replace('year','año',$fecha))));
	}

	public static function fechaLiteral($fecha){
		$fecha = strftime("%e de %B de %Y",strtotime($fecha));
		$fecha = explode(" ",trim($fecha));

		return $fecha[0]." de ".ucfirst($fecha[2])." de ".$fecha[4]; 
	}

	public static function diffDias($fecha_i,$fecha_f,$solo_dias=false){
		if($solo_dias){
			$fecha_i	= explode(" ",$fecha_i);
			$fecha_f	= explode(" ",$fecha_f);
			$dias		= (strtotime($fecha_i[0])-strtotime($fecha_f[0]))/86400;
			$dias		= abs($dias); $dias = floor($dias);		
			return $dias;
		}

		$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
		$dias 	= abs($dias); $dias = floor($dias);		
		return $dias;
	}

	public static function diffDiasTickets($fecha_creacion,$fecha_entrega){
        $creacion	= date_create($fecha_creacion);
        $entrega	= date_create($fecha_entrega);
        $diferencia	= date_diff($creacion, $entrega);
        
		if($diferencia->invert == 1){
            $diferencia_dias	= ($diferencia->days * -1); 
        }else{
            $diferencia_dias	= $diferencia->days;
        }       
		return $diferencia_dias;
	}

	public static function diffDiasAlerta($fecha_creacion,$fecha_entrega){
		$creacion			= date_create($fecha_creacion);
        $entrega			= date_create($fecha_entrega);
        $diferencia			= date_diff($creacion, $entrega);
        $diferencia_dias	= $diferencia->days;

		if($diferencia_dias >= 30){
        	$alerta	= "verde.png";
        }
        if($diferencia_dias < 30 && $diferencia_dias >7){
        	$alerta	= "amarillo.png";
        }
        if($diferencia_dias <=7){
        	$alerta	= "rojo.png";
        }
		return $alerta;
	}

	/**
	 * calcula la edad de una persona segun su fecha de nacimiento en formato DD-MM-AAAA
	 * @param  [type] $fecha_nacimiento [description]
	 * @return [type]                   [description]
	 */
	public static function calcularEdadInv($fecha_nacimiento){
		if(!empty($fecha_nacimiento)){
			list($dia,$mes,$ano)	= explode("-",$fecha_nacimiento);
			$ano_diferencia			= date("Y") - $ano;
			$mes_diferencia			= date("m") - $mes;
			$dia_diferencia			= date("d") - $dia;

			if ($dia_diferencia < 0 || $mes_diferencia < 0){
				$ano_diferencia--;
			}
			return $ano_diferencia;
			
		} else {
			return null;
		}
	}
        
	public static function calcularEdad($fecha_nacimiento){
		list($ano,$mes,$dia)	= explode("-",$fecha_nacimiento);
	    $ano_diferencia			= date("Y") - $ano;
	    $mes_diferencia			= date("m") - $mes;
	    $dia_diferencia			= date("d") - $dia;

		if ($dia_diferencia < 0 || $mes_diferencia < 0){
			$ano_diferencia--;
		}
	    return $ano_diferencia;
	}

	public static function fechaHoy(){
		$fechaHoy	= date("Y-m-d");
		return $fechaHoy;
	}
	
	public static function fechaHoyVista(){
		$fechaHoy	= date("d-m-Y");
		return $fechaHoy;
	}
}
