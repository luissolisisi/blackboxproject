<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists("converter_to_uppercase"))
{
	function converter_to_uppercase($string)
	{	
		if (!mb_detect_encoding($string, 'UTF-8', true) ) //false -> true :: Se verifica sí es UTF-8
		{
			$string = utf8_encode($string); 
		}	
		
		$string = strtr(strtoupper($string),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"); // CONVIERTE A MAYUSCULAS
		$string = str_replace("ñ", "Ñ", $string);

		$string = preg_replace('([^A-Za-z0-9ÁÉÍÓÚÑÄËÏÖÜ ])', '', $string); //LIMPIA
		return $string;
	}
}