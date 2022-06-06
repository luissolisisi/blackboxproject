<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;

class Historial extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('historial_model');
        $this->load->model('binnacle_model');
        if (!logged_in())
        {
          $this->session->set_flashdata('message', 'Tiempo expirado, ingrese denuevo ');
          $this->data['message'] = $this->session->flashdata('message');
          redirect('login/pagina_login', $this->data);
        }
      	  $this->load->helper('converter_to_uppercase');
    }

    //Inicio ABC de las listas
    public function mostrar_historial(){
        $historial = $this->historial_model->get_consultas();
        $data['historial'] = $historial;
        $this->load->view('header');
				menu_arriba();
				$this->load->view('bitacora/busqueda2',$data);
		 		$this->load->view('footer');
    }
    public function mostrar_historial2(){
        $historial = $this->historial_model->get_consultas2();
        $data['historial'] = $historial;
        $this->load->view('header');
				menu_arriba();
				$this->load->view('bitacora/busqueda3',$data);
		 		$this->load->view('footer');
    }

    public function eliminar(){
      echo $id=$_POST['idE'];
      $acceso = $this->historial_model->delete_seguimiento($id);
      if($acceso){
        redirect('historial/mostrar_historial2');
      }else{
        echo "error";
      }
    }

    public function buscar(){
      $var="";
      $imprimir="";
      $nombre = $this->input->post('id');
      //$search="";
      $search = $this->historial_model->busqueda($nombre);
      $var="<table>
          <thead>
              <th>Nombre</th>
              <th>Pertenece</th>
              <th>Actividad</th>
              <th>Tipo</th>
              <th>Estatus</th>
          </thead><tbody>";
          if ($search)
          {
            foreach ($search as $fila)
            {
              $var=$var.'<tr>';
              $var=$var.'<td>'.$fila->nombre.' '.$fila->apaterno.' '.$fila->amaterno.'</td>';
              $var=$var.'<td>'.$fila->pertenece.'</td>';
              $var=$var.'<td>'.$fila->actividad.'</td>';
              $var=$var.'<td>'.$fila->tipo.'</td>';
              $var=$var.'<td>'.$fila->status.'</td>';
              $var=$var.'</tr>';

              $imprimir=$imprimir.'<tr>';
              $imprimir=$imprimir.'<td>'.$fila->nombre.' '.$fila->apaterno.' '.$fila->amaterno.'</td>';
              $imprimir=$imprimir.'<td>'.$fila->pertenece.'</td>';
              $imprimir=$imprimir.'<td>'.$fila->actividad.'</td>';
              $imprimir=$imprimir.'<td>'.$fila->tipo.'</td>';
              $imprimir=$imprimir.'<td>'.$fila->status.'</td>';
              $imprimir=$imprimir.'</tr>';
            }
          }else{
            $var=$var.'<tr>';
            $var=$var."<td colspan='5'>No encontrado en listas</td>";
            $var=$var.'</tr>';

            $imprimir=$imprimir.'<tr>';
            $imprimir=$imprimir."<td colspan='5'>No encontrado en listas</td>";
            $imprimir=$imprimir.'</tr>';
          }
        //$imprimir=$var;
      $var=$var.'<input type="hidden" name="datos" id="datos" value="'.$imprimir.'" >';
      $var=$var.'<td colspan="5" align="center"><button class="btn btn-primary" id="print_result" data-table="'.urlencode($imprimir).'">Imprimir</button>';
      echo $var;

    }
  }
