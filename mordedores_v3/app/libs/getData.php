<?php
	function get_data($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}	
	
	function get_data_encrypt($url,$arr) {
		$ch = curl_init();
		$timeout = 5;
		
		$parametros = urlencode(encrypt(json_encode($arr),sha1(date("Y-m-d"))));

		//echo $url."?".$parametros;
		
		curl_setopt($ch, CURLOPT_URL, $url."?".$parametros);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		
		
		return json_decode(decrypt($data,sha1(date("Y-m-d"))));
	}		
	
	function get_data_no_encrypt($url,$arr) {
		$ch = curl_init();
		$timeout = 5;
		
		$parametros = urlencode(encrypt(json_encode($arr),sha1(date("Y-m-d"))));
		
		curl_setopt($ch, CURLOPT_URL, $url."?".$parametros);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		
		
		return json_decode(decrypt($data,sha1(date("Y-m-d"))));
	}			
	
?>	