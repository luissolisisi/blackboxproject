<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Bitacora extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('binnacle_model');
        if (!logged_in()){
          $this->session->set_flashdata('message', 'Tiempo expirado, ingrese denuevo ');
          $this->data['message'] = $this->session->flashdata('message');
          redirect('login/pagina_login', $this->data);
        }
    }

    public function get_bitacora(){
      $columns = array(
            0=>'id',
            1=>'usuario',
            2=>'ip',
            3=>'date',
            4=>'seccion',
            5=>'accion',
            6=>'detalles',

      );
      $limit = $this->input->post('length');
      $start = $this->input->post('start');
      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $totalData = $this->binnacle_model->all_count_move();
      $totalFiltered = $totalData;

      $posts = $this->binnacle_model->all_moves($limit,$start,$order,$dir);

      $i=1;
      $data = array();
      if(!empty($posts)){
           foreach ($posts as $k){
            $nestedData['id'] =$k->id;
            $nestedData['usuario'] = $k->name;
            $nestedData['ip'] = $k->ip;
            $nestedData['date'] = $k->date;
            $nestedData['seccion'] = $k->seccion;
            $nestedData['accion'] = $k->accion;
            $nestedData['detalles'] = $k->detalles;
            $data[] = $nestedData;
            $i++;
        }
      }
      $json_data = array(
                "draw"            => intval($this->input->post('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
      );
      echo json_encode($json_data);

    }

    public function contenido_bitacora(){
      $this->load->view('header');
      menu_arriba();
      $this->load->view('bitacora/bitacora');
      $this->load->view('footer');
    }
}
