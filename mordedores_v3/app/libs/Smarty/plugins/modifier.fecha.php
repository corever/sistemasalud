<?php

function smarty_modifier_fecha($fecha){
	
	$fecha = str_replace("  "," ",$fecha);
	$arr = explode(" ",trim($fecha));
	$arr = explode("-",$arr[0]);
	/*
	if(strlen($arr[1]) == 1){
		$arr[1]	= "0".$arr[1];
	}
	
	$hora = trim($arr[3]);
	
	if($hora[0] != "1"){
		$arr[3]	= "0".$arr[3];		
	}
	
	
	$meses = array(	"Jan" => "01",
					"Feb" => "02",
					"Mar" => "03",
					"Abr" => "04",
					"May" => "05",
					"Jun" => "06",
					"Jul" => "07",
					"Aug" => "08",
					"Sep" => "09",
					"Oct" => "10",
					"Nov" => "11",
					"Dec" => "12");
	
	
	
	*/
    return $arr[2]."/".$arr[1]."/".$arr[0];
}

?>
