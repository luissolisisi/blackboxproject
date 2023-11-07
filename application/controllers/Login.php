<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {



	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('binnacle_model');
		$this->load->library('session');

  }

	public function pagina_login()
	{
			$this->load->view('header');
			$this->load->view('login/login');
	 		$this->load->view('footer');
	}

	public function get_login()
	{
			$usuario = $this->input->post("user_name");
			$pwd=$this->input->post("password");
			$acceso1 = $this->login_model->validarsesion($usuario,$pwd);

			if($acceso1==1){
				$acceso = $this->login_model->get_Consulta_access($usuario,$pwd);
				$id; $p; $t;
				foreach ($acceso as $data){
					$id=$data['id'];
					switch ($data['paquete']) {
						case 'B':
								$p='2000';
								$t='62';
						break;
						case 'E':
								$p='4500';
								$t='124';
						break;
						case 'P':
								$p='10000';
								$t='186';
						break;
						case 'AN':
								$p='20000';
								$t='365';
						break;
						case 'A':
								$p='100000';
								$t='365000';
						break;
						default:
								$p='10000';
								$t='10000';
							break;
					}

					$sessiones = array(
							'id' 					=>	$data['id'],
							'name'    		=>  $data['name'],
							'lastname'   	=> $data['lastname'],
							'email' 			=>  $data['email'],
							'roll'  			=>  $data['roll'],
							'entidad'  		=>  $data['idEntidad'],
							'empresa'  		=>  $data['empresa'],
							'pais'  			=>  $data['pais'],
							'paquete'  		=>  $p,
							'f_limite'  	=>  $data['f_termino'],
							'tiempo'  	=>  	$t,
							);

				}
				$this->session->set_userdata($sessiones);
				
				redirect('dashboard');

			}else{

				$this->session->set_flashdata('message', 'Usuario y/o contraseña incorrectos intente de nuevo');
				$this->data['message'] = $this->session->flashdata('message');
			 redirect('login/pagina_login',$this->data);
			}

			if(count($acceso) > 0)
			{

			}
			else{

					}
	}

	public function search_customer_api_b() {

        $coincidencias = array();
        $ch = curl_init();




        curl_setopt($ch, CURLOPT_URL, "https://gt-servicios.com/prolistas/busquedaapi/searchpersonc");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        $parameters = "nombre=andres manuel&apaterno=lopez&amaterno=obrador&id_entidad=1500&tipo_busqueda=normal&rfc=&curp=&tipo_persona=FISICA";

        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/x-www-form-urlencoded",
            "X-API-KEY:201020594",
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response);

        

        foreach ($json->parameters->result as $j) {
            $array_j = array(
                'id' => $j[0],
                'name' => $j[1],
                'pertenece' => $j[2],
                'actividad' => $j[3],
                'tipo_lista' => $j[5],
                'status' => $j[6],
                'porcentaje' => $j[7],  
            );

            array_push($coincidencias, $array_j);
        }

        var_dump($coincidencias);
        
        return $coincidencias;
    }

	public function cerrarlogin(){
		$id=$this->session->userdata('id');
		$this->binnacle_model->bit_cerrar($id);
    $this->session->set_userdata($sessiones);
    $this->session->sess_destroy();
			redirect('login/pagina_login');
	}

}
