<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function __construct() {
			parent::__construct();
			if (!logged_in())
			{
				$this->session->set_flashdata('message', 'Tiempo expirado, ingrese denuevo ');
				$this->data['message'] = $this->session->flashdata('message');
				redirect('login/pagina_login', $this->data);
			}
	}

	public function index()
	{
		//$this->load->view('welcome_message');

		$this->load->library('layout');
		$list_clients = array(
			'nombre' => 'Álvaro',
		);


		$data = array(
			'title' => 'Busqueda en Listas',
			'list_clients' => $list_clients
		);
		$this->layout->view('welcome_message',$data);
	}
}
