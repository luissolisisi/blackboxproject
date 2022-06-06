<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('binnacle_model');
        if (!logged_in()){
          $this->session->set_flashdata('message', 'Tiempo expirado, ingrese denuevo ');
          $this->data['message'] = $this->session->flashdata('message');
          redirect('login/pagina_login', $this->data);
        }
    }
    public function mostrar_usuarios(){
    		$usuarios = $this->usuarios_model->get_Usuarios();
				$data['usuarios'] = $usuarios;
				$this->load->view('header');
				menu_arriba();
				$this->load->view('usuarios/usuarios',$data);
		 		$this->load->view('footer');
    }
    function delete_user() {
        $id=$this->input->post("id");
        $data = Array();
        $data['status']	= 'inactive';
        $acceso = $this->usuarios_model->delete_Usuario($id,$data);
        $acceso2=$this->binnacle_model->bit_deleteUser($id);
        if($acceso){
          redirect('usuarios/mostrar_usuarios');
        }
    }
    public function new_user() {
      //variables que vienen del formulario_login
      $pwd=$this->input->post("pwd");
      $nombre	    = $this->input->post("nombre")." ".$this->input->post("apellidos");
      $password=md5(crypt($pwd, 'rl'));
      $data = Array();
      $data['name']	    = $this->input->post("nombre");
      $data['lastname']	= $this->input->post("apellidos");
      $data['email']	  = $this->input->post("email");
      $data['pwd']	    =$password;
      $data['status']	  ='active';
      $data['roll']	    =$this->input->post("roll");
      $data['idEntidad']	    =$this->session->userdata('entidad');
      $acceso = $this->usuarios_model->new_Usuario($data);
      $acceso2=$this->binnacle_model->bit_newUser($nombre);
      if($acceso){
        redirect('usuarios/mostrar_usuarios');
      }

    }
    public function edit_user() {
      $id=$this->input->post("idE");
      $pwd=$this->input->post("pwdE");
      $password=md5(crypt($pwd, 'rl'));
      $data = Array();
      $data['name']	    = $this->input->post("nombreE");
      $data['lastname']	= $this->input->post("apellidosE");
      $data['email']	  = $this->input->post("emailE");
      $data['pwd']	    =$password;

      $acceso = $this->usuarios_model->edit_Usuario($id,$data);
      $acceso2=$this->binnacle_model->bit_editUser($id);
      if($acceso){
        redirect('usuarios/mostrar_usuarios');

      }
    }
    public function verPerfil(){
      $data = array();
      $idUser=$this->session->userdata('id');
      $usuarios   =   $this->usuarios_model->get_usuario($idUser);
      foreach ($usuarios as $usuario){
            $data['id']       =   $usuario->id;
            $data['name']     =   $usuario->name;
            $data['lastname'] =   $usuario->lastname;
            $data['email']    =   $usuario->email;
            $data['pwd']      =   $usuario->pwd;
            $data['status']   =   $usuario->status;
            if($usuario->roll=='1'){
              $data['roll']='Super Usuario';
            }else if($usuario->roll=='2'){
              $data['roll']='Administrador';
            }else{
              $data['roll']='Operador';
            }

        }
      $this->load->view('header');
      menu_arriba();
      $this->load->view('usuarios/perfil',$data);
      $this->load->view('footer');
    }
    public function changePwd(){
      $id=$this->input->post("id");
      $pwd=$this->input->post("pN");
      $pwdC=$this->input->post("pNV");
      if($pwd==$pwdC){
        $password=md5(crypt($pwd, 'rl'));
      }
      else{
        $this->session->set_flashdata('message', 'Contraseñas distintas, ingrese denuevo');
        $this->data['message'] = $this->session->flashdata('message');
        redirect('usuarios/verPerfil', $this->data);
      }
      $data = Array();
      $data['pwd']	    =$password;
      $acceso = $this->usuarios_model->changePwd($id,$data);
      $acceso2 = $this->binnacle_model->bit_changePWD($id);
      if($acceso){
        $this->session->set_flashdata('message', 'Contraseña Actualizada');
        $this->data['message'] = $this->session->flashdata('message');
        redirect('usuarios/verPerfil', $this->data);
      }else{
        $this->session->set_flashdata('message', 'No se pudo actualizar intente mas tarde');
        $this->data['message'] = $this->session->flashdata('message');
        redirect('usuarios/verPerfil', $this->data);
      }
    }

}
