<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;

class Listas extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('listas_model');
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
    public function mostrar_listas(){
    		$lista = $this->listas_model->get_lista();
        $totaListas=$this->listas_model->total_listas();
        $totalRegistros=$this->listas_model->total_registros();
				$data['listas'] = $lista;
        $data['totalListas']=$totaListas;
        $data['totalRegistros']=$totalRegistros;
				$this->load->view('header');
				menu_arriba();
				$this->load->view('listas/listas',$data);
		 		$this->load->view('footer');
    }
    public function delete_Lista() {
        echo $id=$this->input->post("id");
        $acceso = $this->listas_model->delete_Lista($id);
        $acceso2 = $this->binnacle_model->bit_deleteLista($id);
        if($acceso){
          redirect('listas/mostrar_listas');
        }
    }
    public function new_lista() {
      //variables que vienen del formulario
      $nombre= $this->input->post("nombre");
      $date= date("Y-m-d");
      $data = Array();
      $data['clave_tipo']	      = "Nacional";
      $data['clave_pertenece']	= $this->input->post("clave_pertenece");
      $data['nombre']	          = $this->input->post("nombre");
      $data['considerado']	    ="1";
      $data['liga']	            =$this->input->post("fuente");
      $data['status']	          ="active";
      $data['date']	            =$date;
      $data['numero']	          ="";
      $data['id_entidad']	          =$this->session->userdata('entidad');
      $data['pais']	          =$this->session->userdata('pais');
      $data['tipo_lista'] =$this->input->post("tipo_color");
      $data['prioridad'] ="alta";

      $acceso = $this->listas_model->new_Lista($data);
      $acceso2 = $this->binnacle_model->bit_newLista($nombre);

      if($acceso){
        redirect('listas/mostrar_listas');
      }
    }
    public function edit_lista() {
      $date= date("Y-m-d");
      $id=$this->input->post("idE");
      $data = Array();
      $data['clave_tipo']	      = $this->input->post("clave_tipoE");
      $data['clave_pertenece']	= $this->input->post("clave_perteneceE");
      $data['nombre']	          = $this->input->post("nombreE");
      $data['considerado']	    ="1";
      $data['liga']	            =$this->input->post("fuenteE");
      $data['date']	          =$date;
      $acceso = $this->listas_model->edit_Lista($id,$data);
      $acceso2 = $this->binnacle_model->bit_editLista($id);
      if($acceso){
        redirect('listas/mostrar_listas');
      }else {
        echo"Registro no insertado";
      }
    }
    //Fin ABC de las listas


    /*Agregar persona a las listas*/
    public function get_list_persons(){
      $columns = array(
				    0=>'nombre',
				    1=>'rfc',
				    2=>'curp',
				    3=>'nacionalidad',
				    4=>'actividad',
				    5=>'fecha',
				    6=>'status',
				    7=> 'tipo',
            8=>'id',
		  );
      $id_entidad= $this->session->userdata('entidad');
		  $limit = $this->input->post('length');
		  $start = $this->input->post('start');
		  $order = $columns[$this->input->post('order')[0]['column']];
		  $dir = $this->input->post('order')[0]['dir'];
		  $totalData = $this->listas_model->all_count_in_persons_list($id_entidad);
		  $totalFiltered = $totalData;

		  if(empty($this->input->post('search')['value'])){
						$posts = $this->listas_model->all_persons_list($limit,$start,$order,$dir, $id_entidad);
		  }else{
				   $search = $this->input->post('search')['value'];
				   $posts =  $this->listas_model->search_person_list($limit,$start,$search,$order,$dir);
				   $totalFiltered = $this->listas_model->search_persons_count($search,NULL);
		  }
		  $i=1;
		  $data = array();
		  if(!empty($posts)){
			     foreach ($posts as $k){
						$nestedData['nombre'] = $k->nombre.' '.$k->apaterno.' '.$k->amaterno;
						$nestedData['rfc'] = $k->rfc;
						$nestedData['curp'] = $k->curp;
						$nestedData['nacionalidad'] = $k->nacionalidad;
						$nestedData['actividad'] = $k->actividad;
						$nestedData['fecha'] = $k->fecha;
						$nestedData['status'] = $k->status;
						$nestedData['tipo'] = $k->tipo;
						$nestedData['id'] = '<td class="center">'.
                      '<a data-toggle="modal"
                      data-nyfdogdp= "'.$k->numero_y_fecha_de_oficio_global_de_presuncion.'"
                      data-nyfdogdsf= "'.$k->numero_y_fecha_de_oficio_global_de_sentencia_favorable.'"
                      data-id= "'.$k->id.'"
                      data-n= "'.$k->nombre.'"
                      data-p= "'.$k->apaterno.'"
                      data-m= "'.$k->amaterno.'"
                      data-rfc= "'.$k->rfc.'"
                      data-curp= "'.$k->curp.'"
                      data-act= "'.$k->actividad.'"
                      data-dom= "'.$k->domicilio.'"
                      data-na= "'.$k->nacionalidad.'"
                      data-nfogcd= "'.$k->numero_fecha_oficio_global_contribuyentes_desvirtuaron.'"
                      data-nyfdogdd= "'.$k->numero_y_fecha_de_oficio_global_de_definitivos.'"
                      data-nopb= "'.$k->numero_oficio_personas_bloqueadas.'"
                      data-obs= "'.$k->observaciones.'"

                      class="open-Modal btn btn-primary" href="#edit_user"><i class="fas fa-pencil-alt"></i>
                      </a>
                      <a data-toggle="modal" data-id="'.$k->id.'" class="open-Modal btn btn-primary" href="#delete_user"><i class="fas fa-trash-alt"></i></a>

                    </td>';


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
    public function get_Persona(){
      $lista = $this->listas_model->get_lista();
      $data['listas'] = $lista;

      $this->load->view('header');
      menu_arriba();
      $this->load->view('listas/personas',$data);
      $this->load->view('footer');
    }
    public function upload_files_to_excel($value=''){
    	 $this->load->helper('date_format_check');
    	 $this->load->library('excel');
    	 $archivo_temp = $_FILES["archivo"]['tmp_name'];
    	 if (!file_exists($archivo_temp)){
    		return false;
    	 }

    	 $objPHPExcel = PHPExcel_IOFactory::load($archivo_temp);
    	 $objPHPExcel->setActiveSheetIndex(0);

		   $total_sheets = $objPHPExcel->getSheetCount();
     	 $allSheetName = $objPHPExcel->getSheetNames();
    	 $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
     	 $highestRow = $objWorksheet->getHighestRow();
     	 $highestColumn = $objWorksheet->getHighestColumn();
     	 $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
     	 $data = Array();
		   for ($row = 2; $row <= $highestRow; ++$row){
			     $curp = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
			     $rfc = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
			     $nombre = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
			     $apaterno = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
			     $amaterno = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
			     $actividad = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
			     $nacionalidad = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
			     $procedencia = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
           $fecha_alta = $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
			     $fecha_alta = strtotime('+1 day',PHPExcel_Shared_Date::ExcelToPHP($fecha_alta) ) ;
			     $fecha_alta = date('Y-m-d', $fecha_alta);
           $situacion_del_contribuyente = $objWorksheet->getCellByColumnAndRow(9, $row)->getValue();
			     $tipo = $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();
			     $numero_y_fecha_de_oficio_global_de_presuncion = $objWorksheet->getCellByColumnAndRow(11, $row)->getValue();
			     $publicacion_pagina_sat_presuntos = $objWorksheet->getCellByColumnAndRow(12, $row)->getValue();
			     $publicacion_pagina_sat_presuntos = strtotime('+1 day',PHPExcel_Shared_Date::ExcelToPHP($publicacion_pagina_sat_presuntos) ) ;
			     $publicacion_pagina_sat_presuntos = date('Y-m-d', $publicacion_pagina_sat_presuntos);
			     $publicacion_dof_presuntos = $objWorksheet->getCellByColumnAndRow(13, $row)->getValue();
			     $publicacion_dof_presuntos = strtotime('+1 day',PHPExcel_Shared_Date::ExcelToPHP($publicacion_dof_presuntos) ) ;
			     $publicacion_dof_presuntos = date('Y-m-d', $publicacion_dof_presuntos);
			     $publicacion_pagina_sat_desvirtuados = $objWorksheet->getCellByColumnAndRow(14, $row)->getValue();
			     $publicacion_pagina_sat_desvirtuados = strtotime('+1 day',PHPExcel_Shared_Date::ExcelToPHP($publicacion_pagina_sat_desvirtuados) ) ;
			     $publicacion_pagina_sat_desvirtuados = date('Y-m-d', $publicacion_pagina_sat_desvirtuados);
           $numero_fecha_oficio_global_contribuyentes_desvirtuaron = $objWorksheet->getCellByColumnAndRow(15, $row)->getValue();
			     $publicacion_dof_desvirtuados = $objWorksheet->getCellByColumnAndRow(16, $row)->getValue();
			     $publicacion_dof_desvirtuados = strtotime('+1 day',PHPExcel_Shared_Date::ExcelToPHP($publicacion_dof_desvirtuados) ) ;
			     $publicacion_dof_desvirtuados = date('Y-m-d', $publicacion_dof_desvirtuados);
			     $numero_y_fecha_de_oficio_global_de_definitivos = $objWorksheet->getCellByColumnAndRow(17, $row)->getValue();
			     $publicacion_pagina_sat_definitivos = $objWorksheet->getCellByColumnAndRow(18, $row)->getValue();
			     $publicacion_pagina_sat_definitivos = strtotime('+1 day',PHPExcel_Shared_Date::ExcelToPHP($publicacion_pagina_sat_definitivos) ) ;
			     $publicacion_pagina_sat_definitivos = date('Y-m-d', $publicacion_pagina_sat_definitivos);
			     $publicacion_dof_definitivos = $objWorksheet->getCellByColumnAndRow(19, $row)->getValue();
			     $publicacion_dof_definitivos = strtotime('+1 day',PHPExcel_Shared_Date::ExcelToPHP($publicacion_dof_definitivos) ) ;
			     $publicacion_dof_definitivos = date('Y-m-d', $publicacion_dof_definitivos);
			     $numero_y_fecha_de_oficio_global_de_sentencia_favorable = $objWorksheet->getCellByColumnAndRow(20, $row)->getValue();
			     $publicacion_pagina_sat_sentencia_favorable = $objWorksheet->getCellByColumnAndRow(21, $row)->getValue();
			     $publicacion_pagina_sat_sentencia_favorable = strtotime('+1 day',PHPExcel_Shared_Date::ExcelToPHP($publicacion_pagina_sat_sentencia_favorable) ) ;
			     $publicacion_pagina_sat_sentencia_favorable = date('Y-m-d', $publicacion_pagina_sat_sentencia_favorable);
			     $publicacion_dof_sentencia_favorable = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();
			     $publicacion_dof_sentencia_favorable = strtotime('+1 day',PHPExcel_Shared_Date::ExcelToPHP($publicacion_dof_sentencia_favorable) ) ;
			     $publicacion_dof_sentencia_favorable = date('Y-m-d', $publicacion_dof_sentencia_favorable);
			     $numero_oficio_personas_bloqueadas = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
           if (!empty($nombre)){
				         $data['curp']	= converter_to_uppercase($curp);
				         $data['rfc'] 	= converter_to_uppercase($rfc);
				         $data['apaterno'] = converter_to_uppercase($apaterno);
				         $data['nombre'] = converter_to_uppercase($nombre);
				         $data['amaterno'] = converter_to_uppercase($amaterno);
				         $data['pertenece'] = converter_to_uppercase($tipo);
				         $data['actividad'] = converter_to_uppercase($actividad);
				         $data['nacionalidad'] = converter_to_uppercase($nacionalidad);
				         $data['domicilio'] = converter_to_uppercase($procedencia);
				         $data['fecha'] = converter_to_uppercase($fecha_alta);
				         $data['situacion_del_contribuyente'] = converter_to_uppercase($situacion_del_contribuyente);
				         $data['tipo'] = converter_to_uppercase($tipo);
				         $data['numero_y_fecha_de_oficio_global_de_presuncion'] = converter_to_uppercase($numero_y_fecha_de_oficio_global_de_presuncion);
				         $data['publicacion_pagina_sat_presuntos'] = converter_to_uppercase($publicacion_pagina_sat_presuntos);
				         $data['publicacion_dof_presuntos'] = converter_to_uppercase($publicacion_dof_presuntos);
				         $data['publicacion_pagina_sat_desvirtuados'] = converter_to_uppercase($publicacion_pagina_sat_desvirtuados);
				         $data['numero_fecha_oficio_global_contribuyentes_desvirtuaron'] = converter_to_uppercase($numero_fecha_oficio_global_contribuyentes_desvirtuaron);
				         $data['publicacion_dof_desvirtuados'] = converter_to_uppercase($publicacion_dof_desvirtuados);
				         $data['numero_y_fecha_de_oficio_global_de_definitivos'] = converter_to_uppercase($numero_y_fecha_de_oficio_global_de_definitivos);
				         $data['publicacion_pagina_sat_definitivos'] = converter_to_uppercase($publicacion_pagina_sat_definitivos);
				         $data['publicacion_dof_definitivos'] = converter_to_uppercase($publicacion_dof_definitivos);
				         $data['numero_y_fecha_de_oficio_global_de_sentencia_favorable'] = converter_to_uppercase($numero_y_fecha_de_oficio_global_de_sentencia_favorable);
				         $data['publicacion_pagina_sat_sentencia_favorable'] = converter_to_uppercase($publicacion_pagina_sat_sentencia_favorable);
				         $data['publicacion_dof_sentencia_favorable'] = converter_to_uppercase($publicacion_dof_sentencia_favorable);
				         $data['numero_oficio_personas_bloqueadas'] = converter_to_uppercase($numero_oficio_personas_bloqueadas);
                 $data['id_entidad'] = $this->session->userdata('entidad');
                 $data['created_at'] = date('Y-m-d');
           }

           $insert_lista = $this->listas_model->people_in_entity_lists($data);
       }
	      redirect('listas/get_persona','refresh');
    }
    public function delete_person(){
      $id=$this->input->post("id");
      $acceso = $this->listas_model->delete_person($id);
      $acceso2 = $this->binnacle_model->bit_deletePersona($id);

      if($acceso){
        redirect('listas/get_Persona');
      }
    }
    public function add_person(){
      $persona= $this->input->post('nombre')." ".$this->input->post('apaterno')." ".$this->input->post('amaterno');
      $data = array(
        'nombre'    =>  strtoupper($this->input->post('nombre')),
        'apaterno'  =>  strtoupper($this->input->post('apaterno')),
        'amaterno'  =>  strtoupper($this->input->post('amaterno')),
        'rfc'   =>  strtoupper($this->input->post('rfc')),
        'curp'  =>  strtoupper($this->input->post('curp')),
        'domicilio' =>  strtoupper($this->input->post('domicilio')),
        'nacionalidad'  =>  strtoupper($this->input->post('nacionalidad')),
        'observaciones' =>  strtoupper($this->input->post('observaciones')),
        'actividad' =>  strtoupper($this->input->post('actividad')),
        'situacion_del_contribuyente' => converter_to_uppercase($this->input->post('situacion_del_contribuyente')),
        'numero_y_fecha_de_oficio_global_de_presuncion' => converter_to_uppercase($this->input->post('numero_y_fecha_de_oficio_global_de_presuncion')),
        'publicacion_pagina_sat_presuntos' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_presuntos')),
        'publicacion_dof_presuntos' => converter_to_uppercase($this->input->post('publicacion_dof_presuntos')),
        'publicacion_pagina_sat_desvirtuados' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_desvirtuados')),
        'numero_fecha_oficio_global_contribuyentes_desvirtuaron' => converter_to_uppercase($this->input->post('numero_fecha_oficio_global_contribuyentes_desvirtuaron')),
        'publicacion_dof_desvirtuados' => converter_to_uppercase($this->input->post('publicacion_dof_desvirtuados')),
        'numero_y_fecha_de_oficio_global_de_definitivos' => converter_to_uppercase($this->input->post('numero_y_fecha_de_oficio_global_de_definitivos')),
        'publicacion_pagina_sat_definitivos' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_definitivos')),
        'publicacion_dof_definitivos' => converter_to_uppercase($this->input->post('publicacion_dof_definitivos')),
        'numero_y_fecha_de_oficio_global_de_sentencia_favorable' => converter_to_uppercase($this->input->post('numero_y_fecha_de_oficio_global_de_sentencia_favorable')),
        'publicacion_pagina_sat_sentencia_favorable' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_sentencia_favorable')),
        'publicacion_dof_sentencia_favorable' => converter_to_uppercase($this->input->post('publicacion_dof_sentencia_favorable')),
        'numero_oficio_personas_bloqueadas' => converter_to_uppercase($this->input->post('numero_oficio_personas_bloqueadas')),
        'tipo' 		     => converter_to_uppercase($this->input->post('tipo_lista')),
        'id_entidad' => $this->session->userdata('entidad'),
        'created_at'=> date('Y-m-d H:i:s'),
			  'status'    => 'active'
      );
      $acceso = $this->listas_model->new_Person($data);
      $acceso2 = $this->binnacle_model->bit_newPersona($persona);
      if($acceso){
        redirect('listas/get_Persona');
      }
      else{
        echo "Registro no insertado";
      }
    }
    public function edit_person(){
      echo $id=$this->input->post("idE");
      $data = array(
        'nombre'    =>  strtoupper($this->input->post('nombreE')),
        'apaterno'  =>  strtoupper($this->input->post('apaternoE')),
        'amaterno'  =>  strtoupper($this->input->post('amaternoE')),
        'rfc'   =>  strtoupper($this->input->post('rfcE')),
        'curp'  =>  strtoupper($this->input->post('curpE')),
        'domicilio' =>  strtoupper($this->input->post('domicilioE')),
        'nacionalidad'  =>  strtoupper($this->input->post('nacionalidadE')),
        'observaciones' =>  strtoupper($this->input->post('observacionesE')),
        'actividad' =>  strtoupper($this->input->post('actividadE')),
        'situacion_del_contribuyente' => converter_to_uppercase($this->input->post('situacion_del_contribuyenteE')),
        'numero_y_fecha_de_oficio_global_de_presuncion' => converter_to_uppercase($this->input->post('numero_y_fecha_de_oficio_global_de_presuncionE')),
        'publicacion_pagina_sat_presuntos' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_presuntosE')),
        'publicacion_dof_presuntos' => converter_to_uppercase($this->input->post('publicacion_dof_presuntosE')),
        'publicacion_pagina_sat_desvirtuados' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_desvirtuadosE')),
        'numero_fecha_oficio_global_contribuyentes_desvirtuaron' => converter_to_uppercase($this->input->post('numero_fecha_oficio_global_contribuyentes_desvirtuaronE')),
        'publicacion_dof_desvirtuados' => converter_to_uppercase($this->input->post('publicacion_dof_desvirtuadosE')),
        'numero_y_fecha_de_oficio_global_de_definitivos' => converter_to_uppercase($this->input->post('numero_y_fecha_de_oficio_global_de_definitivosE')),
        'publicacion_pagina_sat_definitivos' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_definitivosE')),
        'publicacion_dof_definitivos' => converter_to_uppercase($this->input->post('publicacion_dof_definitivosE')),
        'numero_y_fecha_de_oficio_global_de_sentencia_favorable' => converter_to_uppercase($this->input->post('numero_y_fecha_de_oficio_global_de_sentencia_favorableE')),
        'publicacion_pagina_sat_sentencia_favorable' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_sentencia_favorableE')),
        'publicacion_dof_sentencia_favorable' => converter_to_uppercase($this->input->post('publicacion_dof_sentencia_favorableE')),
        'numero_oficio_personas_bloqueadas' => converter_to_uppercase($this->input->post('numero_oficio_personas_bloqueadasE')),
        'updated_at'=> date('Y-m-d H:i:s'),
      );
      $acceso = $this->listas_model->edit_Person($id,$data);
      $acceso2 = $this->binnacle_model->bit_editPerson($id);
      if($acceso){
        redirect('listas/get_persona');
      }else {
        echo"Registro no insertado";
      }
    }
    /*Contenido de las listas*/

    public function get_contenido(){
      $columns = array(
            0=>'nombre',
            1=>'rfc',
            2=>'curp',
            3=>'nacionalidad',
            4=>'actividad',
            5=>'fecha',
            6=>'status',
            7=> 'tipo',
            8=>'id',
      );
      $id_entidad= $this->session->userdata('entidad');
      $limit = $this->input->post('length');
      $start = $this->input->post('start');
      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $totalData = $this->listas_model->all_count_in_persons_list($id_entidad);
      $totalFiltered = $totalData;

      if(empty($this->input->post('search')['value'])){
            $posts = $this->listas_model->all_persons_list($limit,$start,$order,$dir, $id_entidad);
      }else{
           $search = $this->input->post('search')['value'];
           $posts =  $this->listas_model->search_person_list($limit,$start,$search,$order,$dir);
           $totalFiltered = $this->listas_model->search_persons_count($search,NULL);
      }
      $i=1;
      $data = array();
      if(!empty($posts)){
           foreach ($posts as $k){
             $nestedData['nombre'] = '<td class="center">'.
              '<a data-toggle="modal"
             data-nyfdogdp= "'.$k->numero_y_fecha_de_oficio_global_de_presuncion.'"
             data-nyfdogdsf= "'.$k->numero_y_fecha_de_oficio_global_de_sentencia_favorable.'"
             data-n= "'.$k->nombre.'"
             data-p= "'.$k->apaterno.'"
             data-m= "'.$k->amaterno.'"
             data-rfc= "'.$k->rfc.'"
             data-curp= "'.$k->curp.'"
             data-act= "'.$k->actividad.'"
             data-dom= "'.$k->domicilio.'"
             data-na= "'.$k->nacionalidad.'"
             data-nfogcd= "'.$k->numero_fecha_oficio_global_contribuyentes_desvirtuaron.'"
             data-nyfdogdd= "'.$k->numero_y_fecha_de_oficio_global_de_definitivos.'"
             data-nopb= "'.$k->numero_oficio_personas_bloqueadas.'"
             data-obs= "'.$k->observaciones.'"
             data-sc="'.$k->situacion_del_contribuyente.'"
             data-ppsp="'.$k->publicacion_pagina_sat_presuntos.'"
             data-pdd="'.$k->publicacion_dof_definitivos.'"
             data-ppssf="'.$k->publicacion_pagina_sat_sentencia_favorable.'"
             data-pdp="'.$k->publicacion_dof_presuntos.'"
             data-ppsd="'.$k->publicacion_pagina_sat_desvirtuados.'"
             data-pddes="'.$k->publicacion_dof_desvirtuados.'"
             data-ppsdef="'.$k->publicacion_pagina_sat_definitivos.'"
             data-pdsf="'.$k->publicacion_dof_sentencia_favorable.'"
             data-tipo="'.$k->pertenece.'"
             class="open-Modal"
             href="#show_user">
            '.$k->nombre.' '.$k->apaterno.' '.$k->amaterno.'
             </a></td>';
            $nestedData['rfc'] = $k->rfc;
            $nestedData['curp'] = $k->curp;
            $nestedData['nacionalidad'] = $k->nacionalidad;
            $nestedData['actividad'] = $k->actividad;
            $nestedData['fecha'] = $k->fecha;
            $nestedData['status'] = $k->status;
            $nestedData['tipo'] = $k->tipo;
            $nestedData['id'] = '<td class="center">
                        <a data-toggle="modal"
                        data-nyfdogdp= "'.$k->numero_y_fecha_de_oficio_global_de_presuncion.'"
                        data-nyfdogdsf= "'.$k->numero_y_fecha_de_oficio_global_de_sentencia_favorable.'"
                        data-id= "'.$k->id.'"
                        data-n= "'.$k->nombre.'"
                        data-p= "'.$k->apaterno.'"
                        data-m= "'.$k->amaterno.'"
                        data-rfc= "'.$k->rfc.'"
                        data-curp= "'.$k->curp.'"
                        data-act= "'.$k->actividad.'"
                        data-dom= "'.$k->domicilio.'"
                        data-na= "'.$k->nacionalidad.'"
                        data-nfogcd= "'.$k->numero_fecha_oficio_global_contribuyentes_desvirtuaron.'"
                        data-nyfdogdd= "'.$k->numero_y_fecha_de_oficio_global_de_definitivos.'"
                        data-nopb= "'.$k->numero_oficio_personas_bloqueadas.'"
                        data-obs= "'.$k->observaciones.'"
                        class="open-Modal btn btn-primary" href="#edit_user"><i class="fas fa-pencil-alt"></i>
                        </a>
                        <a data-toggle="modal" data-id="'.$k->id.'"class="open-Modal btn btn-primary" href="#deleteL_user"><i class="fas fa-minus-circle"></i></a>

                      </td>';
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
    public function contenido_listas(){
      $this->load->view('header');
      menu_arriba();
      $this->load->view('listas/contenido_listas');
      $this->load->view('footer');
    }
    public function deleteL_contenido(){
      $id=$this->input->post("id");
      $acceso = $this->listas_model->delete_person($id);
      $acceso2 = $this->binnacle_model->bit_contenidoDelete($id);
      if($acceso){
        redirect('listas/contenido_listas');
      }
    }
    public function edit_contenido(){
      echo $id=$this->input->post("idE");
      $data = array(
        'nombre'    =>  strtoupper($this->input->post('nombreE')),
        'apaterno'  =>  strtoupper($this->input->post('apaternoE')),
        'amaterno'  =>  strtoupper($this->input->post('amaternoE')),
        'rfc'   =>  strtoupper($this->input->post('rfcE')),
        'curp'  =>  strtoupper($this->input->post('curpE')),
        'domicilio' =>  strtoupper($this->input->post('domicilioE')),
        'nacionalidad'  =>  strtoupper($this->input->post('nacionalidadE')),
        'observaciones' =>  strtoupper($this->input->post('observacionesE')),
        'actividad' =>  strtoupper($this->input->post('actividadE')),
        'situacion_del_contribuyente' => converter_to_uppercase($this->input->post('situacion_del_contribuyenteE')),
        'numero_y_fecha_de_oficio_global_de_presuncion' => converter_to_uppercase($this->input->post('numero_y_fecha_de_oficio_global_de_presuncionE')),
        'publicacion_pagina_sat_presuntos' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_presuntosE')),
        'publicacion_dof_presuntos' => converter_to_uppercase($this->input->post('publicacion_dof_presuntosE')),
        'publicacion_pagina_sat_desvirtuados' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_desvirtuadosE')),
        'numero_fecha_oficio_global_contribuyentes_desvirtuaron' => converter_to_uppercase($this->input->post('numero_fecha_oficio_global_contribuyentes_desvirtuaronE')),
        'publicacion_dof_desvirtuados' => converter_to_uppercase($this->input->post('publicacion_dof_desvirtuadosE')),
        'numero_y_fecha_de_oficio_global_de_definitivos' => converter_to_uppercase($this->input->post('numero_y_fecha_de_oficio_global_de_definitivosE')),
        'publicacion_pagina_sat_definitivos' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_definitivosE')),
        'publicacion_dof_definitivos' => converter_to_uppercase($this->input->post('publicacion_dof_definitivosE')),
        'numero_y_fecha_de_oficio_global_de_sentencia_favorable' => converter_to_uppercase($this->input->post('numero_y_fecha_de_oficio_global_de_sentencia_favorableE')),
        'publicacion_pagina_sat_sentencia_favorable' => converter_to_uppercase($this->input->post('publicacion_pagina_sat_sentencia_favorableE')),
        'publicacion_dof_sentencia_favorable' => converter_to_uppercase($this->input->post('publicacion_dof_sentencia_favorableE')),
        'numero_oficio_personas_bloqueadas' => converter_to_uppercase($this->input->post('numero_oficio_personas_bloqueadasE')),
        'updated_at'=> date('Y-m-d H:i:s'),
      );
      $acceso = $this->listas_model->edit_Person($id,$data);
      $acceso2 = $this->binnacle_model->bit_contenidoEdit($id);

      if($acceso){
        redirect('listas/contenido_listas');
      }else {
        echo"Registro no insertado";
      }
    }
    public function deleteF_contenido(){
      $id=$this->input->post("id");
      $acceso = $this->listas_model->delete_personF($id);
      if($acceso){
        redirect('listas/contenido_listas');
      }else {
        echo "No se pudo realizar el borrado";
      }
    }
    /*Contenido Oculto */
    public function contenido_oculto(){
      $persona = $this->listas_model->ver_bloqueados();
      $data['personas'] = $persona;

      $this->load->view('header');
      menu_arriba();
      $this->load->view('listas/contenido_oculto',$data);
      $this->load->view('footer');
    }
    public function restore_person(){
      $id=$this->input->post("id");
      $acceso = $this->listas_model->recover_person($id);
      $acceso2 = $this->binnacle_model->bit_restorePerson($id);

      if($acceso){
        redirect('listas/contenido_oculto');
      }else{
        echo "No se pudo restaurar";
      }

    }
    /*Descargar archivo de Excel*/
    public function downloads(){
        $this->load->helper('download');
        $path = file_get_contents(base_url()."assets/doc/demo.xlsx");
        $name = "demo.xlsx";
        force_download($name, $path);
    }
    public function downloadsU(){
        $this->load->helper('download');
        $path = file_get_contents(base_url()."assets/doc/cargaMasivaListas.xlsx");
        $name = "cargaMasivaListas.xlsx";
        force_download($name, $path);
    }

    /**Historico de las listas*/
    public function updateListasCompletas(){
      $time = time();
      //echo "fecha". date("d-m-Y (H:i:s:m)", $time);
      //RUTA
      $dirname = $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']);

      $acceso="false";
      $id=$this->input->post("idH");
      $clave_tipoH=$this->input->post("clave_tipoH");
      $tipoVaciado=$this->input->post("tipo");
      $date=date('Y-m-d');
          switch ($clave_tipoH) {
            case 'OFAC':
              //DESCARGAR EL CVS
              $url = 'https://www.treasury.gov/ofac/downloads/alt.csv';

              $destination_folder = $dirname.'/assets/listas_completas/OFAC/';

              $newfname = $destination_folder .'ofac'.$date.'.csv'; //set your file ext
              if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
              }
              if ($file) {
                  if(!$newf = fopen ($newfname, "a")){
                    echo "No existe la ruta de destino";
                    exit;
                  }
                  if ($newf)
                    while(!feof($file)) {
                      fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                    }
              }
              if ($file) {
                  fclose($file);
              }
              if ($newf) {
                  fclose($newf);
              }

              //eliminar y mover al historico si tiene historico
              if($tipoVaciado=='conHistorico'){
                $mover    = $this->listas_model->moverHistorico('ALT','OFAC');
                $eliminar = $this->listas_model->eliminarHistorio('ALT','OFAC');
              } else{}
                $eliminar = $this->listas_model->eliminarHistorio('ALT','OFAC');
              //lIMPIAR CVS
              //Guardar en un arreglo global
              $url2 = $newfname;
              $linea = 0;
              $arrGlobal = array();
              $archivo = fopen($url2, "r");
              while (($datos = fgetcsv($archivo, ",")) == true)
              {
                $i=0;
                $n=0;
                $linea++;

                       $array = explode(",", $datos[3]);
                       for($i;$i<count($array);$i++){
                         if(!$i==0){//nobres
                          $arrGlobal[$linea][$n]=$array[$i];
                         }else{//apellido
                           if(count($array)==1){//persona moral
                             $arrGlobal[$linea][$n]="";
                             $arrGlobal[$linea][$n+1]="";
                            $arrGlobal[$linea][$n+2]=$array[$i];
                           }else{//persona fisica
                             $array2 = explode(" ", $array[$i]);
                              for($n=0;$n<count($array2);$n++){
                                  //echo $linea." persona FISICA apellido". count($array2);
                                  $arrGlobal[$linea][$n]=$array2[$n];
                                  if(count($array2)==1){
                                    $arrGlobal[$linea][$n+1]="";
                                    $n++;
                                  }
                              }
                           }
                         }

                       }
              }
              foreach($arrGlobal as $global)
              {
                    $i=0;
                    $insertar= $this->listas_model->insertHistorico($global[$i+2],$global[$i],$global[$i+1],'OFAC','ALT');

                    $i++;
                  //  echo $global[$i].", ".$global[$i+1].", ".$global[$i+2];
              }
              fclose($archivo);


              //agregar a bitacora
              $acceso2 = $this->binnacle_model->updateListas('con historico','OFAC-ALT');
              $acceso= $this->listas_model->editListaH($id,$linea);
              break;

            case 'OFAC-SND':
              $url = 'https://www.treasury.gov/ofac/downloads/sdn.csv';

              $destination_folder = $dirname.'/assets/listas_completas/OFAC/';

              $newfname = $destination_folder .'ofac_SND'.$date.'.csv'; //set your file ext
              if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
              }
              if ($file) {
                  if(!$newf = fopen ($newfname, "a")){
                    echo "No existe la ruta de destino";
                    exit;
                  }
                  if ($newf)
                    while(!feof($file)) {
                      fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                    }
              }
              if ($file) {
                fclose($file);
              }
              if ($newf) {
                fclose($newf);
              }
              //eliminar y mover al historico si tiene historico
              if($tipoVaciado=='conHistorico'){
                  $mover    = $this->listas_model->moverHistorico('SDN','OFAC');
                  $eliminar = $this->listas_model->eliminarHistorio('SDN'.'OFAC');
              } else{}
                  $eliminar = $this->listas_model->eliminarHistorio('SDN'.'OFAC');
                //lIMPIAR CVS
                //Guardar en un arreglo global
              $url2 = $newfname;
              $linea = 0;
              $arrGlobal = array();
              $archivo = fopen($url2, "r");
              while (($datos = fgetcsv($archivo, ",")) == true){
                $i=0;
                $n=0;
                $linea++;
                $array = explode(",", $datos[1]); // posición 3 a 1
                     for($i;$i<count($array);$i++){
                       if(!$i==0){//nobres
                        $arrGlobal[$linea][$n]=$array[$i];
                       }else{//apellido
                         if(count($array)==1){//persona moral
                           $arrGlobal[$linea][$n]="";
                           $arrGlobal[$linea][$n+1]="";
                          $arrGlobal[$linea][$n+2]=$array[$i];
                         }else{//persona fisica
                           $array2 = explode(" ", $array[$i]);
                            for($n=0;$n<count($array2);$n++){
                                //echo $linea." persona FISICA apellido". count($array2);
                                $arrGlobal[$linea][$n]=$array2[$n];
                                if(count($array2)==1){
                                  $arrGlobal[$linea][$n+1]="";
                                  $n++;
                                }
                            }
                         }
                       }

                     }
              }
              foreach($arrGlobal as $global){
                  $i=0;
                  $insertar= $this->listas_model->insertHistorico($global[$i+2],$global[$i],$global[$i+1],'OFAC', 'SDN');
                  $i++;
                //  echo $global[$i].", ".$global[$i+1].", ".$global[$i+2];
              }
              fclose($archivo);
              //agregar a bitacora
              $acceso2 = $this->binnacle_model->updateListas('con historico','OFAC-SDN');
              $acceso= $this->listas_model->editListaH($id,$linea);
            break;


            case '69B':

                $des; $def; $preF; $preM; $senF;
                $data2;
                $linea=0; $ds=0; $df=0; $sf=0; $pM=0; $pf=0; $n=0;
                $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Listado_Completo_69-B.csv';
                $destination_folder = $dirname.'/assets/listas_completas/69B/';
                $newfname = $destination_folder .'69B'.$date.'.csv'; //set your file ext
                if(!$file = fopen ($url, "rb")){
                    echo "No existe archivo origen";
                    exit;
                }
                if ($file) {
                  if(!$newf = fopen ($newfname, "a")){
                      echo "No existe la ruta de destino";
                      exit;
                  }
                  if ($newf)
                    while(!feof($file)) {
                      fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                    }
                }
                if ($file) {
                  fclose($file);
                }
                if ($newf) {
                  fclose($newf);
                }
                //definir quien tipo de insersion
                $url2 = $newfname;
                //$linea = 3;
                $arrGlobal = array();
                $archivo = fopen($url2, "r");
                while (($datos = fgetcsv($archivo, ",")) == true)
                {
                  $linea++;
                      if($datos[1]=='XXXXXXXXXXXX'||$datos[1]=='XXXXXXXXXXX'||$datos[1]=='XXXXXXXXXXXXX'){
                          $n++;
                      }
                      else{
                        switch ($datos[3]) {
                          case 'Desvirtuado':
                            $des[$ds][0]=$datos[1];//rfc
                            $des[$ds][1]=$datos[8];//pub sat
                            $des[$ds][2]=$datos[9]; //nofecha
                            $des[$ds][3]=$datos[10];//dof
                            $ds++;
                          break;

                          case 'Definitivo':
                            $def[$df][0]=$datos[1];//rfc
                            $def[$df][1]=$datos[11];//oficio global
                            $def[$df][2]=$datos[12];//sat
                            $def[$df][3]=$datos[13];//dof
                            $df++;
                          break;

                          case 'Sentencia Favorable':
                            $senf[$sf][0]=$datos[1];//rfc
                            $senf[$sf][1]=$datos[14];//noFecha
                            $senf[$sf][2]=$datos[15];//sat
                            $senf[$sf][3]=$datos[17];//dof
                            $sf++;
                          break;

                          case 'Presunto':
                            $rfcsize=  strlen($datos[1]);
                            if($rfcsize==12){
                              $preM[$pM][0]=$datos[1];//rfc
                              $preM[$pM][1]=$datos[2];//nombre
                              $preM[$pM][2]=$datos[4];//noFecha
                              $preM[$pM][3]=$datos[5];//sat
                              $preM[$pM][4]=$datos[7];//dof
                              $pM++;
                            }
                            else{
                              //persona FISICA
                              $nombre= "";
                              $apaterno= "";
                              $amaterno= "";
                              //detereminar si el nombre es 4 0 3 silabas
                              $nombre1  = $datos[2];
                              $separar = explode(" ", $nombre1);
                              $nombresize =sizeof($separar);
                              if($nombresize==4){
                                $nombre= $separar[2]." ".$separar[3];
                                $apaterno= $separar[0];
                                $amaterno= $separar[1];
                              }
                              else{
                                $nombre= $separar[2];
                                $apaterno= $separar[0];
                                $amaterno= $separar[1];
                              }
                              //ENVIO DE DATO
                              $preF[$pf][0]=$nombre;//nombre
                              $preF[$pf][1]=$apaterno;//apaterno
                              $preF[$pf][2]=$amaterno;//amateno
                              $preF[$pf][3]=$datos[1];//RFC
                              $preF[$pf][4]=$datos[4];//NOfECHA
                              $preF[$pf][5]=$datos[5];//SAT
                              $preF[$pf][6]=$datos[7];//DOF
                              $pf++;
                            }
                          break;


                          default:
                            $n++;
                          break;
                        }
                      }
                }
                //enviar sentencia favorable
                $this->listas_model->editarFavorable($sf,$senf);
                //enviar DESVIRTUAD
                $this->listas_model->editarDesvirtuado($ds,$des);
                //enviar definitivo
                $this->listas_model->editarDefinitivo($df,$def);
                //enviar presunto Moral
                $this->listas_model->nuevoPresuntoM($pM,$preM);
                //enviar presunto fisico
                $this->listas_model->nuevoPresuntoF($pf,$preF);
                $actual = $this->listas_model->get_totalcontenido('69B');
                $numero=$actual+$linea;
                $acceso2 = $this->binnacle_model->updateListas('normal','69B');
                $acceso= $this->listas_model->editListaH($id,$numero);
            break;

            case 'CI':
            //
            $total=0;
            //mover de la tabla princial a la tabla secundaria
            //$mover    = $this->listas_model->moverHistoricoCI();
            $eliminar = $this->listas_model->eliminarHistorioCI();
            //establecer los array 1 de insersion y uno de update
            $dataCan= array(
        					 array(
                     'rfc' => 'RCF',
                     'observaciones'=>'observaciones',
                     'actividad'=>'actividad',
                     'fecha'=>'1992-10-16',
                     'situacion_del_contribuyente'=>'Cancelados',
                     'nombre'=>'Canceados',
                     'apaterno'=>'',
                     'amaterno'=>'',
                     'tipo'=>'CI',
                     'pertenece' => 'SAT',
                     'status'=>'active',
                     'created_at'=>'1992-10-16'
        					 )
			          );
            $datacCan2= array(
                            array(
                              'rfc' => 'RCF',
                              'observaciones'=>'observaciones',
                              'actividad'=>'actividad',
                              'fecha'=>'1992-10-16',
                              'situacion_del_contribuyente'=>'Cancelados',
                              'nombre'=>'Canceados 07_15',
                              'apaterno'=>'',
                              'amaterno'=>'',
                              'tipo'=>'CI',
                              'pertenece' => 'SAT',
                              'status'=>'active',
                              'created_at'=>'1992-10-16'
                           )
                        );
            $datacCon07= array(
                            array(
                              'rfc' => 'RCF',
                              'observaciones'=>'observaciones',
                              'actividad'=>'actividad',
                              'fecha'=>'1992-10-16',
                              'situacion_del_contribuyente'=>'CONDONADOS',
                              'nombre'=>'Condonado',
                              'apaterno'=>'',
                              'amaterno'=>'',
                              'tipo'=>'CI',
                              'pertenece' => 'SAT',
                              'status'=>'active',
                              'created_at'=>'1992-10-16'
                            )
                          );
            $datacCon21= array(
                              array(
                                'rfc' => 'RCF',
                                'observaciones'=>'observaciones',
                                'actividad'=>'actividad',
                                'fecha'=>'1992-10-16',
                                'situacion_del_contribuyente'=>'CONDONADOS 21',
                                'nombre'=>'CONDONADOS 21',
                                'apaterno'=>'',
                                'amaterno'=>'',
                                'tipo'=>'CI',
                                'pertenece' => 'SAT',
                                'status'=>'active',
                                'created_at'=>'1992-10-16'
                                   )
                             );
            $datacCon74= array(
                            array(
                              'rfc' => 'RCF',
                              'observaciones'=>'observaciones',
                              'actividad'=>'actividad',
                              'fecha'=>'1992-10-16',
                              'situacion_del_contribuyente'=>'CONDONADOS 74',
                              'nombre'=>'CONDON  74',
                              'apaterno'=>'',
                              'amaterno'=>'',
                              'tipo'=>'CI',
                              'pertenece' => 'SAT',
                              'status'=>'active',
                              'created_at'=>'1992-10-16'
                            )
                          );
            $datacCon14= array(
                                array(
                                  'rfc' => 'RCF',
                                  'observaciones'=>'observaciones',
                                  'actividad'=>'actividad',
                                  'fecha'=>'1992-10-16',
                                  'situacion_del_contribuyente'=>'CONDONADOS 146',
                                  'nombre'=>'CONDONADOS 146',
                                  'apaterno'=>'',
                                  'amaterno'=>'',
                                  'tipo'=>'CI',
                                  'pertenece' => 'SAT',
                                  'status'=>'active',
                                  'created_at'=>'1992-10-16'
                                  )
                              );//
            $datacConD= array(
                              array(
                                      'rfc' => 'RCF',
                                      'observaciones'=>'observaciones',
                                      'actividad'=>'actividad',
                                      'fecha'=>'1992-10-16',
                                      'situacion_del_contribuyente'=>'CONDONADOS Decreto',
                                      'nombre'=>'CONDONADOS Decreto',
                                      'apaterno'=>'',
                                      'amaterno'=>'',
                                      'tipo'=>'CI',
                                      'pertenece' => 'SAT',
                                      'status'=>'active',
                                      'created_at'=>'1992-10-16'
                                    )
                             );
            $datacEli= array(
                            array(
                                  'rfc' => 'RCF',
                                  'observaciones'=>'observaciones',
                                  'actividad'=>'actividad',
                                  'fecha'=>'1992-10-16',
                                  'situacion_del_contribuyente'=>'Eliminados',
                                  'nombre'=>'Eliminados',
                                  'apaterno'=>'',
                                  'amaterno'=>'',
                                  'tipo'=>'CI',
                                  'pertenece' => 'SAT',
                                  'status'=>'active',
                                  'created_at'=>'1992-10-16'
                                  )
                          );
            $datacExi= array(
                            array(
                                'rfc' => 'RCF',
                                'observaciones'=>'observaciones',
                                'actividad'=>'actividad',
                                'fecha'=>'1992-10-16',
                                'situacion_del_contribuyente'=>'Exigibles',
                                'nombre'=>'Exigibles',
                                'apaterno'=>'',
                                'amaterno'=>'',
                                'tipo'=>'CI',
                                'pertenece' => 'SAT',
                                'status'=>'active',
                                'created_at'=>'1992-10-16'
                                 )
                          );
            $datacFir= array(
                        array(
                          'rfc' => 'RCF',
                          'observaciones'=>'observaciones',
                          'actividad'=>'actividad',
                          'fecha'=>'1992-10-16',
                          'situacion_del_contribuyente'=>'FIRMES',
                          'nombre'=>'FIRMES',
                          'apaterno'=>'',
                          'amaterno'=>'',
                          'tipo'=>'CI',
                          'pertenece' => 'SAT',
                          'status'=>'active',
                          'created_at'=>'1992-10-16'
                              )
                      );
            $datacNoLoc= array(
                                  array(
                                        'rfc' => 'RCF',
                                        'observaciones'=>'observaciones',
                                        'actividad'=>'actividad',
                                        'fecha'=>'1992-10-16',
                                        'situacion_del_contribuyente'=>'NO localizados',
                                        'nombre'=>'NO localizados',
                                        'apaterno'=>'',
                                        'amaterno'=>'',
                                        'tipo'=>'CI',
                                        'pertenece' => 'SAT',
                                        'status'=>'active',
                                        'created_at'=>'1992-10-16'
                                    )
                              );
            $datacRetorno= array(
                                  array(
                                    'rfc' => 'RCF',
                                    'observaciones'=>'observaciones',
                                    'actividad'=>'actividad',
                                    'fecha'=>'1992-10-16',
                                    'situacion_del_contribuyente'=>'Retornoinversiones',
                                    'nombre'=>'Retornoinversiones',
                                    'apaterno'=>'',
                                    'amaterno'=>'',
                                    'tipo'=>'CI',
                                    'pertenece' => 'SAT',
                                    'status'=>'active',
                                    'created_at'=>'1992-10-16'
                                        )
                            );
            $datacSen= array(
                              array(
                                'rfc' => 'RCF',
                                'observaciones'=>'observaciones',
                                'actividad'=>'actividad',
                                'fecha'=>'1992-10-16',
                                'situacion_del_contribuyente'=>'Sentencia FAVORABLE',
                                'nombre'=>'SENTENCIA FAVORABLE',
                                'apaterno'=>'',
                                'amaterno'=>'',
                                'tipo'=>'CI',
                                'pertenece' => 'SAT',
                                'status'=>'active',
                                'created_at'=>'1992-10-16'
                                    )
                            );



            //RECORRER CADA UNO DE LOS EXCEL Y METERLO EN EL ARRAY correspondiente
            //condonados por 21CFF
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Condonadosart21CFF.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_condonados21_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            $archivo = fopen($url2, "r");

            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }else{
                    $total++;
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                    $datos[1] = str_replace ( ";", '', $datos[1]);
                    $datos[1] = str_replace ( ":", '', $datos[1]);
                    $datos[1] = str_replace ( "+", '', $datos[1]);
                    $datos[1] = str_replace ( "-", '', $datos[1]);
                    $datos[1] = str_replace ( "*", '', $datos[1]);
                    $datos[1] = str_replace ( "/", '', $datos[1]);

                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      array_push ($datacCon21, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }else{

                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacCon21 , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }


            }

            ////condonados por decreto
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/CondonadosporDecreto.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_condonadosDecreto_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $total++;
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                     $datos[1] = str_replace ( ";", '', $datos[1]);
                     $datos[1] = str_replace ( ":", '', $datos[1]);
                     $datos[1] = str_replace ( "+", '', $datos[1]);
                     $datos[1] = str_replace ( "-", '', $datos[1]);
                     $datos[1] = str_replace ( "*", '', $datos[1]);
                     $datos[1] = str_replace ( "/", '', $datos[1]);
                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      array_push ($datacConD, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }
                    else{
                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacConD , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }
            }

            //Condonados 146BCFF
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Condonadosart146BCFF.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_condonados146_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $total++;
                    $datos[3] = str_replace ( ".", '', $datos[3]);
                    $datos[3] = str_replace ( '"', '', $datos[3]);
                    $datos[3] = str_replace ( ",", '', $datos[3]);
                     $datos[3] = str_replace ( ";", '', $datos[3]);
                     $datos[3] = str_replace ( ":", '', $datos[3]);
                     $datos[3] = str_replace ( "+", '', $datos[3]);
                     $datos[3] = str_replace ( "-", '', $datos[3]);
                     $datos[3] = str_replace ( "*", '', $datos[3]);
                     $datos[3] = str_replace ( "/", '', $datos[3]);

                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      array_push ($datacCon14, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }
                    else{
                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacCon14 , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }
            }

            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Retornoinversiones.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_retornoInversion_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $total++;
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                     $datos[1] = str_replace ( ";", '', $datos[1]);
                     $datos[1] = str_replace ( ":", '', $datos[1]);
                     $datos[1] = str_replace ( "+", '', $datos[1]);
                     $datos[1] = str_replace ( "-", '', $datos[1]);
                     $datos[1] = str_replace ( "*", '', $datos[1]);
                     $datos[1] = str_replace ( "/", '', $datos[1]);
                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      array_push ($datacRetorno, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }
                    else{
                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacRetorno , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }
            }

            //sentencias
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Sentencias.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_sentencias_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $total++;
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                     $datos[1] = str_replace ( ";", '', $datos[1]);
                     $datos[1] = str_replace ( ":", '', $datos[1]);
                     $datos[1] = str_replace ( "+", '', $datos[1]);
                     $datos[1] = str_replace ( "-", '', $datos[1]);
                     $datos[1] = str_replace ( "*", '', $datos[1]);
                     $datos[1] = str_replace ( "/", '', $datos[1]);
                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4];
                      array_push ($datacSen, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }
                    else{
                      $obs= 'Fecha de primer publicacion: '.$datos[4];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacSen , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }
            }
            //Exigibles
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Exigibles.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_exigibles_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){

                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                     $datos[1] = str_replace ( ";", '', $datos[1]);
                     $datos[1] = str_replace ( ":", '', $datos[1]);
                     $datos[1] = str_replace ( "+", '', $datos[1]);
                     $datos[1] = str_replace ( "-", '', $datos[1]);
                     $datos[1] = str_replace ( "*", '', $datos[1]);
                     $datos[1] = str_replace ( "/", '', $datos[1]);
                    $total++;
                    if ($datos[2]=='M'){
                      array_push ($datacExi, array(
                        'rfc' => $rfc,
                        'observaciones'=>'',
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }
                    else{
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacExi , array(
                        'rfc' => $rfc,
                        'observaciones'=>'',
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }
            }

            //Condonados 07_15
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Condonados_07_15.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_condonado0715_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[2]);
                  if($rfc=='RFC'){

                  }else{
                    $datos[3] = str_replace ( ".", '', $datos[3]);
                    $datos[3] = str_replace ( ",", '', $datos[3]);
                     $datos[3] = str_replace ( ";", '', $datos[3]);
                     $datos[3] = str_replace ( ":", '', $datos[3]);
                     $datos[3] = str_replace ( "+", '', $datos[3]);
                     $datos[3] = str_replace ( "-", '', $datos[3]);
                     $datos[3] = str_replace ( "*", '', $datos[3]);
                     $datos[3] = str_replace ( "/", '', $datos[3]);
                    $total++;
                    if ($datos[1]=='Persona moral'){
                      $obs= 'Fecha de primer publicacion: '.$datos[0].' Monto del adeudo:'.$datos[4];
                      array_push ($datacCon07, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>'CONDONADOS',
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>'CONDONADOS',
                        'nombre'=>$datos[3],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }else{

                      $obs= 'Fecha de primer publicacion: '.$datos[0].' Monto del adeudo:'.$datos[4];
                      $array = explode(" ", $datos[3]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacCon07 , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>'CONDONADOS',
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>'CONDONADOS',
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }


            }

            //Condonados 74CFF
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Condonadosart74CFF.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_condonados74CFF_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                     $datos[1] = str_replace ( ";", '', $datos[1]);
                     $datos[1] = str_replace ( ":", '', $datos[1]);
                     $datos[1] = str_replace ( "+", '', $datos[1]);
                     $datos[1] = str_replace ( "-", '', $datos[1]);
                     $datos[1] = str_replace ( "*", '', $datos[1]);
                     $datos[1] = str_replace ( "/", '', $datos[1]);
                    $total++;
                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      array_push ($datacCon74, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }else{

                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacCon74 , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }


            }

            //Cancelados07_15
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Cancelados_07_15.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_cancelados0715_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[2]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $total++;
                    $datos[3] = str_replace ( ".", '', $datos[3]);
                    $datos[3] = str_replace ( '"', '', $datos[3]);
                    $datos[3] = str_replace ( ",", '', $datos[3]);
                     $datos[3] = str_replace ( ";", '', $datos[3]);
                     $datos[3] = str_replace ( ":", '', $datos[3]);
                     $datos[3] = str_replace ( "+", '', $datos[3]);
                     $datos[3] = str_replace ( "-", '', $datos[3]);
                     $datos[3] = str_replace ( "*", '', $datos[3]);
                     $datos[3] = str_replace ( "/", '', $datos[3]);

                    if ($datos[1]=='Persona Moral'){
                      $obs= 'Fecha de primer publicacion: '.$datos[0].' Monto del adeudo:'.$datos[4];
                      array_push ($datacCan2, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>'CANCELADOS',
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>'CANCELADOS',
                        'nombre'=>$datos[3],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }else{

                      $obs= 'Fecha de primer publicacion: '.$datos[0].' Monto del adeudo:'.$datos[4];
                      $array = explode(" ", $datos[3]); // posición 3 a 1
                            if(count($array)==3){
                              $apaterno=$array[0];
                              $amaterno=$array[1];
                              $nombre=$array[2];
                            }elseif(count($array)==4){
                              $apaterno=$array[0];
                              $amaterno=$array[1];
                              $nombre=$array[2]." ".$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacCan2 , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>'CANCELADOS',
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>'CANCELADOS',
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }


            }

            //Eliminados
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Eliminados.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_elimininados_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                     $datos[1] = str_replace ( ";", '', $datos[1]);
                     $datos[1] = str_replace ( ":", '', $datos[1]);
                     $datos[1] = str_replace ( "+", '', $datos[1]);
                     $datos[1] = str_replace ( "-", '', $datos[1]);
                     $datos[1] = str_replace ( "*", '', $datos[1]);
                     $datos[1] = str_replace ( "/", '', $datos[1]);

                    $total++;
                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      array_push ($datacEli, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }
                    else{

                      $obs= 'Fecha de primer publicacion: '.$datos[4].' Monto del adeudo:'.$datos[5];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacEli , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }


            }
            //No localizados
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/No%20localizados.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_nolocalizados_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $total++;
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                     $datos[1] = str_replace ( ";", '', $datos[1]);
                     $datos[1] = str_replace ( ":", '', $datos[1]);
                     $datos[1] = str_replace ( "+", '', $datos[1]);
                     $datos[1] = str_replace ( "-", '', $datos[1]);
                     $datos[1] = str_replace ( "*", '', $datos[1]);
                     $datos[1] = str_replace ( "/", '', $datos[1]);
                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4];
                      array_push ($datacNoLoc, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }
                    else{

                      $obs= 'Fecha de primer publicacion: '.$datos[4];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacNoLoc , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }


            }

            //Cancelados
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Cancelados.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_cancelados_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                     $datos[1] = str_replace ( ";", '', $datos[1]);
                     $datos[1] = str_replace ( ":", '', $datos[1]);
                     $datos[1] = str_replace ( "+", '', $datos[1]);
                     $datos[1] = str_replace ( "-", '', $datos[1]);
                     $datos[1] = str_replace ( "*", '', $datos[1]);
                     $datos[1] = str_replace ( "/", '', $datos[1]);
                    $total++;
                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4].'Monto: '.$datos[5];
                      array_push ($dataCan, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>$datos[6],
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }
                    else{

                      $obs= 'Fecha de primer publicacion: '.$datos[4].'Monto: '.$datos[5];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $dataCan , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                            ));
                    }

                  }


            }

            //Firmes
            $numero=0;
            $url = 'http://omawww.sat.gob.mx/cifras_sat/Documents/Firmes.csv';
            $destination_folder = $dirname.'/assets/listas_completas/CI/';
            $newfname = $destination_folder .'ci_firmes_'.$date.'.csv'; //set your file ext
            if(!$file = fopen ($url, "rb")){
                echo "No existe archivo origen";
                exit;
            }
            if ($file) {
              if(!$newf = fopen ($newfname, "a")){
                  echo "No existe la ruta de destino";
                  exit;
              }
              if ($newf)
                while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
            if ($file) {
              fclose($file);
            }
            if ($newf) {
              fclose($newf);
            }
            //definir quien tipo de insersion
            $url2 = $newfname;
            //$linea = 3;
            $arrGlobal = array();
            $archivo = fopen($url2, "r");
            while (($datos = fgetcsv($archivo, ",")) == true){
                    $rfc = preg_replace('([^A-Za-z0-9])', '', $datos[0]);
                  if($rfc=='RFC'){

                  }
                  else{
                    $total++;
                    $datos[1] = str_replace ( ".", '', $datos[1]);
                    $datos[1] = str_replace ( ",", '', $datos[1]);
                     $datos[1] = str_replace ( ";", '', $datos[1]);
                     $datos[1] = str_replace ( ":", '', $datos[1]);
                     $datos[1] = str_replace ( "+", '', $datos[1]);
                     $datos[1] = str_replace ( "-", '', $datos[1]);
                     $datos[1] = str_replace ( "*", '', $datos[1]);
                     $datos[1] = str_replace ( "/", '', $datos[1]);
                    if ($datos[2]=='M'){
                      $obs= 'Fecha de primer publicacion: '.$datos[4];
                      array_push ($datacFir, array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$datos[1],
                        'apaterno'=>'',
                        'amaterno'=>'',
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                      ));

                    }else{

                      $obs= 'Fecha de primer publicacion: '.$datos[4];
                      $array = explode(" ", $datos[1]); // posición 3 a 1
                            if(count($array)==3){
                              $nombre=$array[0];
                              $apaterno=$array[1];
                              $amaterno=$array[2];
                            }elseif(count($array)==4){
                              $nombre=$array[0]." ".$array[1];
                              $apaterno=$array[2];
                              $amaterno=$array[3];
                            }else{
                              $nombre=$datos[1];
                              $apaterno="";
                              $amaterno="";
                            }
                      array_push ( $datacFir , array(
                        'rfc' => $rfc,
                        'observaciones'=>$obs,
                        'actividad'=>$datos[3],
                        'fecha'=>'',
                        'situacion_del_contribuyente'=>$datos[3],
                        'nombre'=>$nombre,
                        'apaterno'=>$apaterno,
                        'amaterno'=>$amaterno,
                        'tipo'=>'CI',
                        'pertenece' => 'SAT',
                        'status'=>'active',
                        'created_at'=>date('Y-m-d')
                						));
                    }

                  }


            }

             $consolidado21=$this->listas_model->insertCi($datacCon21);
             $condonadoD=$this->listas_model->insertCi($datacConD);
             $condonado14=$this->listas_model->insertCi($datacCon14);
             $retorno=$this->listas_model->insertCi($datacRetorno);
             $sencia=$this->listas_model->insertCi($datacSen);
             $exigibles=$this->listas_model->insertCi($datacExi);
             $exigibles=$this->listas_model->insertCi($datacCon07);
             $condona74=$this->listas_model->insertCi($datacCon74);
             $cancelados2=$this->listas_model->insertCi($datacCan2);
             $eliminados=$this->listas_model->insertCi($datacEli);
             $noLoc=$this->listas_model->insertCi($datacNoLoc);
             $can=$this->listas_model->insertCi($dataCan);
             $fir=$this->listas_model->insertCi($datacFir);

            $acceso2 = $this->binnacle_model->updateListas('normal','CI');
            $acceso= $this->listas_model->editListaH($id,$total);
            break;


            default:
                echo "No existe la opcion";
                $acceso='true';
            break;
          }
      if($acceso=='true'){
        redirect('listas/mostrar_listas');
      }else{
        echo"No se pude realizar el update";
      }

      //echo "<br>fecha1". date("d-m-Y (H:i:s:m)", $time);
      //echo "linea ".$linea."ds:  ".$ds.". df:".$df." sf:".$sf." pm:".$pM." pf: ".$pf." n:".$n;


    }

    public function paises(){
      $paises = $this->listas_model->get_paises();

  		$data = array(
  					'paises'		=>	$paises,
  				);


    		$this->load->view('header');
				menu_arriba();
				$this->load->view('listas/paises',$data);
		 		$this->load->view('footer');
    }


}
