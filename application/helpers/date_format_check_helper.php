<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists("date_format_check"))
{
	function date_format_check($date)
    {
        if (strpos($date, '/') !== FALSE)
        {
            $brithdate = explode('/', $date);
            return $brithdate[2] . "-" . $brithdate[1] . "-" . $brithdate[0];
        }
        else
        {
            return date('Y-m-d', strtotime($date));
        }
		
    }
}