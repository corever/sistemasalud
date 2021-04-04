<?php

class HashGenerator {
    public static function generar_sha256($string){
		return hash('sha256',$string);
	}

	public static function generar_sha512($string){
		return hash('sha512',$string);
	}

	/*function getHash($base,$public_key,$private_key){
		$token	= hash('sha1',date('d/m/Y').$public_key);
		$string	= $base.$token;

		return hash_hmac('sha512',$string,$private_key);
	}*/

	public static function getHash($base,$public_key,$private_key,$token_ws){
		$token	= hash('sha1',$token_ws.$public_key);
		$string	= $base.$token;

		return hash_hmac('sha512',$string,$private_key);
	}
	
	// if(!function_exists('hash_equals'))	{
		public static function hash_equals($str1, $str2){
			if(strlen($str1) != strlen($str2))
			{
				return false;
			}
			else
			{
				$res = $str1 ^ $str2;
				$ret = 0;
				for($i = strlen($res) - 1; $i >= 0; $i--)
				{
					$ret |= ord($res[$i]);
				}
				return !$ret;
			}
		}
	// }

	public static function getHashUnico($base,$public_key,$private_key){
		$unico	= bin2hex(openssl_random_pseudo_bytes(15));
		$token	= hash('sha1',date('d/m/Y').$public_key);
		$string	= $base.$token.$unico;

		return hash_hmac('sha512',$string,$private_key);
	}

	public static function getHashDatosGob($base,$public_key,$private_key,$token_ws){
		$token	= hash('sha1',$token_ws.$public_key);
		$string	= $base.$token;

		return hash_hmac('sha512',$string,$private_key);
    }
    
}