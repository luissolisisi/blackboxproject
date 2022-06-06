<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
        if (!logged_in()){
          $this->session->set_flashdata('message', 'Tiempo expirado, ingrese denuevo ');
          $this->data['message'] = $this->session->flashdata('message');
          redirect('login/pagina_login', $this->data);
        }
    }

    public function view(){
        //Nacionales
        $data['nacionales'] = $this->dashboard_model->nacionales("México");
        //internacional
        //Nacionales
        $data['internacionales'] = $this->dashboard_model->internacional();
        //VISTA
        $this->load->view('header');
        menu_arriba();
        $this->load->view('graficas/dash',$data);
        $this->load->view('footer');
    }
    public function view2(){
        //busqudas
        $totalRegistros=$this->dashboard_model->get_totalBusquedas();
        $data['totalRegistros']=$totalRegistros;
        //uSUARIOS
        $totalU=$this->dashboard_model->get_totalUsuarios();
        $data['totalU']=$totalU;
        //Universales
        $data['universales'] = $this->dashboard_model->universales();

        //paises otros
        $nac1=$this->dashboard_model->nacionales1("México");
        $data['nac1']=$nac1;
        $usn=$this->dashboard_model->usa();
        $data['usn']=$usn;
        $otros=$this->dashboard_model->otros("México");
        $data['otros']=$otros;


        //VISTA
        $this->load->view('header');
        menu_arriba();
        $this->load->view('graficas/dash2',$data);
        $this->load->view('footer');
    }

}
