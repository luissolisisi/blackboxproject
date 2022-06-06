<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists("menu_arriba"))
{
	function menu_arriba()
	{
		$CI =& get_instance();		
		//$CI->load->model('alerts_model');

            $data = array(                  
                  'p'  =>   'p',
                        
            );            

            $CI->load->view('menu_arriba', $data);
	}
}