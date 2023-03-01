<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists("logged_in"))
{
	function logged_in()
	{
		$CI =& get_instance();
        $id= $CI->session->userdata('id');
        if (!empty($id))
        {
            return $id;
        }
        return null;
	}
}
