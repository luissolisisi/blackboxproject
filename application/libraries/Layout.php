<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
	/**
	 * Layouts Class. PHP5 only.
	 *
	 */

	// Contendra un Objeto Instanciado de CodeIgniter
	private $CI;

	private $title = NULL;

	private $modul = NULL;

	private $title_separetor = " | ";

	private $includes = array();

	public function __construct()
	{
		$this->CI =& get_instance();
		
	}

	public function set_title($title)
	{
		$this->title = $title;
	}
	public function set_modulo($modul)
	{
		$this->modul = $modul;
	}

	public function view($view_name,$params = array(),$layout = "default") // default = v1
	{

		
		$rendered_view = $this->CI->load->view($view_name,$params,TRUE);

		if($this->title !== NULL)
		{
			$this->title = $this->title;
		}
		if($this->modul !== NULL)
		{
			$this->modul = $this->modul;
		}
		//if('' == $_SERVER['HTTP_HOST']): $layout='v2'; endif;
		// Ahora cargamos el Layout, y le enviamos la vista que acabamos de Renderizar 
		$this->CI->load->view("layouts/".$layout, array("content" => $rendered_view));
	}
}

?>
