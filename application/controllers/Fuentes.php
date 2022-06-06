<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Fuentes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fuentes_model');
        $this->load->model('binnacle_model');
        if (!logged_in()){
          $this->session->set_flashdata('message', 'Tiempo expirado, ingrese denuevo ');
          $this->data['message'] = $this->session->flashdata('message');
          redirect('login/pagina_login', $this->data);
        }
    }

    public function mostrar_fuentes(){
        $fuente = $this->fuentes_model->get_fuentes();
        $data['fuentes'] = $fuente;
        $this->load->view('header');
        menu_arriba();
        $this->load->view('fuentes/fuentes_info',$data);
        $this->load->view('footer');
    }
    public function new_fuente() {
      //variables que vienen del formulario

      $date= date("Y-m-d");
      $data = Array();
      $data['id_entidad']	   = $this->session->userdata('entidad');
      $data['clave']	       = $this->input->post("clave");
      $data['nombre']	       = $this->input->post("nombre");
      $data['estatus']	     = "active";
      $data['url']	         = $this->input->post("url");
      $data['created_at']	   = $date;
      $data['pais']	   = $this->session->userdata('pais');

      $acceso = $this->fuentes_model->new_Fuente($data);
      $acceso2 = $this->binnacle_model->bit_newFuente($this->input->post("nombre"));

      if($acceso){
        redirect('fuentes/mostrar_fuentes');
      }
    }
    public function edit_fuente() {
      $id=$this->input->post("idE");
      $data = Array();
      $data['clave']	      = $this->input->post("claveE");
      $data['nombre']	          = $this->input->post("nombreE");
      $data['url']	            =$this->input->post("urlE");

      $acceso = $this->fuentes_model->edit_Fuente($id,$data);
      $acceso2 = $this->binnacle_model->bit_editFuente($id);
      if($acceso){
        redirect('fuentes/mostrar_fuentes');
      }else {
        echo"Registro no insertado";
      }
    }
    public function delete_Fuente() {
        echo $id=$this->input->post("id");
        $acceso = $this->fuentes_model->delete_Fuente($id);
        $acceso2 = $this->binnacle_model->bit_deleteFuente($id);
        if($acceso){
          redirect('fuentes/mostrar_fuentes');
        }
    }

    public function terminos(){
      $this->load->view('header');
      menu_arriba();
      $this->load->view('fuentes/terminos');
      $this->load->view('footer');
    }



}
