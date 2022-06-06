<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;

class Busqueda extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('busquedas_model');
        $this->load->model('binnacle_model');
        if (!logged_in())
        {
          $this->session->set_flashdata('message', 'Tiempo expirado, ingrese denuevo ');
          $this->data['message'] = $this->session->flashdata('message');
          redirect('login/pagina_login', $this->data);
        }
      	  $this->load->helper('converter_to_uppercase');
    }


    public function downloads(){
        $this->load->helper('download');
        $path = file_get_contents(base_url()."assets/doc/demo.xlsx");
        $name = "demo.xlsx";
        force_download($name, $path);
    }
  //busqueda en las listas
    public function busqueda(){
      /*Carga para las listas de bsqueda, nacionales e internacionales*/
      $result1 = $this->busquedas_model-> get_nacionales();
      $data['nacionales'] = $result1;

      $result2 = $this->busquedas_model->get_internacionales();
      $data['internacionales'] = $result2;

      $result3 = $this->busquedas_model->get_totalBusquedas();
      $data['totalBusquedas'] = $result3;

      $this->load->view('header');
      menu_arriba();
      $this->load->view('busqueda/busqueda_listas',$data);
      $this->load->view('footer');
    }
    public function search_lists(){
      $listas=""; //listas en las que aparece
      $tipoBusqueda="";
      $numeroC100=0;
      $num=0;
      $final = Array();
      $stautus="";
      $nombre 	= trim($this->input->post('nombre'));
      $apaterno 	= trim($this->input->post('apaterno'));
      $amaterno 	= trim($this->input->post('amaterno'));
      $rfc 		= trim($this->input->post('rfc'));
      $curp 		= trim($this->input->post('curp'));
      $type 		= $this->input->post('type');
      $rfc_ban 	= 0;
      $buscar= $this->input->post('busqueda');

      $full_name1 = $nombre . " " . $apaterno . " " . $amaterno;
      $full_name= str_replace("'", " ", $full_name1);  
      $full_name= str_replace("-", " ", $full_name);

      $full_name2 = $nombre . " " . $apaterno . " " . $amaterno;
      $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia

      $trimabuscar = trim($full_name);
      $exist = false;
      $this->load->helper('converter_to_uppercase');
      $tipoBusqueda;
      if($buscar=="search_exactly_f"){
        $search = $this->busquedas_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp));
        //$search_unlocked = $this->busquedas_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp),'delete');
        $tipoBusqueda='Busqueda exacta';

      }
      elseif ($buscar=="search_extend"){
        $search = $this->busquedas_model->buscar_extendida(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
        //$search_unlocked = $this->busquedas_model->buscar_extendida(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
        $tipoBusqueda='Busqueda extendida';
      }
      else{
        $search = $this->busquedas_model->buscar(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
        //$search_unlocked = $this->busquedas_model->buscar(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
        $tipoBusqueda='Busqueda normal';

      }
      if (!empty($rfc)){
        if ($this->busquedas_model->search_rfc($rfc) ){
          $rfc_ban = 1;
        }
      }
      $html = '';
      //$html .= '<h3>Resultados</h3>';
      if ($search)
      {
        $html1= '';
        $html .='<tr role="row">';
        $html .='<td colspan="7" class= "text-center"><strong></strong></td>'; //LISTAS DE PERSONAS BLOQUEADAS
        $html .='</tr>';
        //$num=0;
        if (!empty($search))
        {

           $porcentaje = 0;
           foreach ($search as $fila){
              $full_name = $fila->nombre . " " . $fila->apaterno . " " . $fila->amaterno;
              $full_name = trim($full_name);
              if ($rfc_ban == 0){
                  similar_text(strtoupper (converter_to_uppercase($full_name_search)), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
              }
              else
              {
                  $porcentaje = 100;
                  $numeroC100=$numeroC100+1;
              }
              if(($fila->status)=='active'){
                $stautus='Activo';
              }else {
                $stautus='Baja, fecha de baja: '.$fila->updated_at;
              }
               $final[$num][0]=$fila->id;
               $final[$num][1]=$full_name;
               $final[$num][2]=$fila->pertenece;
               $final[$num][3]=$fila->actividad;
               $final[$num][4]=$fila->fecha;
               $final[$num][5]=$fila->tipo;
               $final[$num][6]=$fila->alias;
               $final[$num][7]=$stautus;
               $final[$num][8]=round($porcentaje,2);
               $num=$num+1;
           }
            //array bidimensional

            $volumen= Array();

            foreach ($final as $clave => $fila) {
                $volumen[$clave] = $fila['8'];

            }

            // Ordenar los datos con volumen descendiente, edición ascendiente
            // Agregar $datos como el último parámetro, para ordenar por la clave común
            array_multisort($volumen, SORT_DESC,$final);

           $html .='<tr role="row">';
           $html .='<td colspan="8" class= "text-center"><strong> Número de resultados: '.$num.'</strong></td>';
           $html .='</tr>';
           $html .= '<tr role="row">';

           foreach ($final as $dato){
             $html .='<tr role="row">

             <td><a href="#"  onclick="person_info('.$dato['0'] .')" >'.$dato['1']. '</a></td>
             <td>'.$dato['2']. '</td>
             <td>'.$dato['3']. '</td>
             <td>'.$dato['4']. '</td>
             <td>'.$dato['5']. '</td>
             <td>'.$dato['6']. '</td>
             <td>'.$dato['7']. '</td>
             <td>'.$dato['8']. '%</td>';

             $html .='</tr>';

             $html1 .='<tr role="row">

             <td><a href="#"  onclick="person_info('.$dato['0'] .')" >'.$dato['1']. '</a></td>
             <td>'.$dato['2']. '</td>
             <td>'.$dato['3']. '</td>
             <td>'.$dato['4']. '</td>
             <td>'.$dato['5']. '</td>
             <td>'.$dato['6']. '</td>
             <td>'.$dato['7']. '</td>
             <td>'.$dato['8']. '%</td>';

             $html1 .='</tr>';
             $listas.=$dato['5']." ";
            }

        }
        else
        {
          $html .='<tr role="row">';
          $html .='<td colspan="8" class= "text-center"><strong> - Sin resultados</strong></td>';
          $html .='</tr>';
        }

        $html .='<td colspan="8" align="center"><strong>Se encontraron coincidencias de: '.$trimabuscar.' </strong> <br> <br> <button class="btn btn-primary" id="print_result" data-name="'.$trimabuscar.'/SE ENCONTRÓ EN LISTAS/ " data-table="'.urlencode($html1).'">Imprimir</button>
        <input type="hidden" name="datos" id="datos" value="'.htmlentities($html1).'" >
        <input type="hidden" name="name" id="name" value="'.$trimabuscar.'" >
        <input type="hidden" name="estatus" id="estatus" value="SE ENCONTRÓ EN LISTAS" >
        </td>
        </tr>';

        echo $html;
      }
      else
      {
        echo'<tr role="row">
        <td colspan="8" align="center"><strong>No se encontraron coincidencias de: '.$trimabuscar.' </strong> <br> <br> <button class="btn btn-primary" id="print_result" data-name="'.$trimabuscar.'/NO SE ENCONTRÓ EN LISTAS/">Imprimir</button>
        <input type="hidden" name="datos" id="datos" value="-" >
        <input type="hidden" name="name" id="name" value="'.$trimabuscar.'" >
        <input type="hidden" name="estatus" id="estatus" value="NO SE ENCONTRÓ EN LISTAS" >
        </td>
        </tr>';
        echo $html;
      }
      $acceso2 = $this->binnacle_model->buscar_personas($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,'1',$listas);
    }
    public function search_lists_m(){
      $listas="";
      $tipoBusqueda="";
      $numeroC100=0;
          $num=0;
          $final = Array();
          $stautus="";
        $nombre = converter_to_uppercase(trim($this->input->post('razon_social')));
        $nombre2 = converter_to_uppercase(trim($this->input->post('razon_social')));
        $rfc = converter_to_uppercase(trim($this->input->post('rfc')));
        $type = $this->input->post('type');
        $trimabuscar = converter_to_uppercase(trim($nombre));
        $exist = false;
        $html1 = '';
        $html = '';
        $rfc_ban = 0;
        $buscar=$this->input->post('busqueda');
        if (!empty($rfc)){
           if ($this->busquedas_model->search_rfc($rfc) ){
              $rfc_ban = 1;
           }
        }

        if($buscar=="search_exactly_f"){
          $search = $this->busquedas_model->buscar_exacta_m($nombre,$rfc);
          $search_unlocked = $this->busquedas_model->buscar_exacta_m($nombre,$rfc,'delete');
          $tipoBusqueda="Busqueda exacta";

        }elseif($buscar=="search_extend"){
          $search = $this->busquedas_model->buscar_extendida_m($nombre,$rfc);
          $search_unlocked = $this->busquedas_model->buscar_extendida_m($nombre,$rfc);
          $tipoBusqueda="Busqueda extendida";
        }
        else
        {
          $search = $this->busquedas_model->buscar($trimabuscar, $nombre, $apaterno = "", $amaterno = "", $rfc, $curp = "");
          $search_unlocked = $this->busquedas_model->buscar($trimabuscar, $nombre, $apaterno, $amaterno, $rfc, $curp, 0);
          $tipoBusqueda="Busqueda normal";
        }

        if ($search)
        {
           $porcentaje = 0;
           foreach ($search as $fila)
           {
             $full_name = $fila->nombre;
             if ($rfc_ban == 0)
             {
                 similar_text(converter_to_uppercase ($trimabuscar), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
                 //$numeroC100=$numeroC100+1;
             }
             else{
                 $porcentaje = 100;
                 $numeroC100=$numeroC100+1;
             }
             if(($fila->status)=='active'){
               $stautus='Activo';
             }else {
               $stautus='Baja, fecha de baja: '.$fila->updated_at;
             }
             $final[$num][0]=$fila->id;
             $final[$num][1]=$full_name;
             $final[$num][2]=$fila->pertenece;
             $final[$num][3]=$fila->actividad;
             $final[$num][4]=$fila->fecha;
             $final[$num][5]=$fila->tipo;
             $final[$num][6]=$fila->alias;
             $final[$num][7]=$stautus;
             $final[$num][8]=round($porcentaje,2);
             $num=$num+1;
           }
           $volumen= Array();
           foreach ($final as $clave => $fila) {
               $volumen[$clave] = $fila['7'];
           }
           array_multisort($volumen, SORT_DESC,$final);
           $html .='<tr role="row">';
           $html .='<td colspan="8" class= "text-center"><strong> Número de resultados: '.$num.'</strong></td>';
           $html .='</tr>';
           $html .= '<tr role="row">';
           foreach ($final as $dato){
             $html .='<tr role="row">

             <td><a href="#"  onclick="person_info('.$dato['0'] .')" >'.$dato['1']. '</a></td>
             <td>'.$dato['2']. '</td>
             <td>'.$dato['3']. '</td>
             <td>'.$dato['4']. '</td>
             <td>'.$dato['5']. '</td>
             <td>'.$dato['6']. '</td>
             <td>'.$dato['7']. '</td>
             <td>'.$dato['8']. '%</td>';

             $html .='</tr>';
             $listas.=$dato['5']." ";

             $html1 .='<tr role="row">

             <td><a href="#"  onclick="person_info('.$dato['0'] .')" >'.$dato['1']. '</a></td>
             <td>'.$dato['2']. '</td>
             <td>'.$dato['3']. '</td>
             <td>'.$dato['4']. '</td>
             <td>'.$dato['5']. '</td>
             <td>'.$dato['6']. '</td>
             <td>'.$dato['7']. '</td>
             <td>'.$dato['8']. '%</td>';

             $html1 .='</tr>';



            }
            $html .='<td colspan="8" align="center"><strong>Se encontraron coincidencias de: '.$trimabuscar.' </strong> <br> <br> <button class="btn btn-primary" id="print_result" data-name="'.$trimabuscar.'/SE ENCONTRÓ EN LISTAS/ " data-table="'.urlencode($html1).'">Imprimir</button>
            <input type="hidden" name="datos" id="datos" value="'.htmlentities($html1).'" >
            <input type="hidden" name="name" id="name" value="'.$trimabuscar.'" >
            <input type="hidden" name="estatus" id="estatus" value="SE ENCONTRÓ EN LISTAS" >
            </td>
            </tr>';
        }
        else
        {
           $html .='<tr role="row">
           <td colspan="8" align="center"><strong>No se encontraron coincidencias de: '.$trimabuscar.' </strong> <br> <br> <button class="btn btn-primary" id="print_result" data-name="'.$trimabuscar.'/NO SE ENCONTRÓ EN LISTAS/">Imprimir</button>
           <input type="hidden" name="datos" id="datos" value="-" >
           <input type="hidden" name="name" id="name" value="'.$trimabuscar.'" >
           <input type="hidden" name="estatus" id="estatus" value="NO SE ENCONTRÓ EN LISTAS" >
           </td>
           </tr>';
        }
        echo $html;
        $acceso2 = $this->binnacle_model->buscar_personas($nombre2,$tipoBusqueda,'Persona Moral',$numeroC100,$num,'1',$listas);
    }
    public function print_result() {
      $estatus 	= $this->input->post("estatus");
      $name 		= $this->input->post("name");
      $datos 		= $this->input->post("datos");

      $data = array(
        'nombre'	=>	urldecode($name),	//AL DECODIFICA URL
        'estatus'	=>  urldecode($estatus),//AL DECODIFICA URL
        'datos'		=>  $datos
      );

      $options = new Options();
      $options->set('isRemoteEnabled', TRUE);
      $dompdf = new Dompdf($options);
      $vista = $this->load->view('busqueda/print_result', $data, true);

      $dompdf->loadHtml($vista);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $dompdf->stream($name);
    }

    public function print_result2() {
      $estatus 	= $this->input->post("estatus");
      $name 		= $this->input->post("name");
      $datos 		= $this->input->post("datos");

      $data = array(
        'nombre'	=>	urldecode($name),	//AL DECODIFICA URL
        'estatus'	=>  urldecode($estatus),//AL DECODIFICA URL
        'datos'		=>  $datos
      );

      $options = new Options();
      $options->set('isRemoteEnabled', TRUE);
      $dompdf = new Dompdf($options);
      $vista = $this->load->view('busqueda/print_resultM', $data, true);

      $dompdf->loadHtml($vista);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $dompdf->stream($name);
    }
    public function print_result3() {
      $estatus 	= $this->input->post("estatus");
      $name 		= $this->input->post("name");
      $datos 		= $this->input->post("datos");

      $data = array(
        'nombre'	=>	urldecode($name),	//AL DECODIFICA URL
        'estatus'	=>  urldecode($estatus),//AL DECODIFICA URL
        'datos'		=>  $datos
      );

      $options = new Options();
      $options->set('isRemoteEnabled', TRUE);
      $dompdf = new Dompdf($options);
      $vista = $this->load->view('busqueda/print_resultR', $data, true);

      $dompdf->loadHtml($vista);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $dompdf->stream($name);
    }
    public function print_result4() {
      $estatus 	= $this->input->post("estatus");
      $name 		= $this->input->post("name");
      $datos 		= $this->input->post("datos");

      $data = array(
        'nombre'	=>	urldecode($name),	//AL DECODIFICA URL
        'estatus'	=>  urldecode($estatus),//AL DECODIFICA URL
        'datos'		=>  $datos
      );

      $options = new Options();
      $options->set('isRemoteEnabled', TRUE);
      $dompdf = new Dompdf($options);
      $vista = $this->load->view('busqueda/print_resultI', $data, true);

      $dompdf->loadHtml($vista);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $dompdf->stream($name);
    }
    public function unlock_views(){
		    $id = $this->input->post('id');
		    $result = Array();
		    if($id > 0){
			    $result = $this->busquedas_model->get_list($id);
		    }
		    echo json_encode($result, JSON_UNESCAPED_UNICODE);
	  }
    public function busquedaMultiple(){
      //$opcion='NO';
      //if($_POST['opcion']==null){
      //  $opcion='NO';
      //}else{
        $opcion=$_POST['opcion'];

      //}
      $res="";
        $this->load->library('excel');
		    $operador= $this->session->userdata('id');
		    $entidad= $this->session->userdata('id');
	      $_FILES["archivo"]['size'];
		    $tipo       = $_FILES["archivo"]['type'];
		    $archivo   = $_FILES["archivo"]['name'];
		    $archivo_temp= $_FILES["archivo"]['tmp_name'];
		    $prefijo    = substr(md5(uniqid(rand())),0,6);
		    $lineas = file($archivo_temp);
		    $listadoCoincidencia=array();
		    $listadoNoCoincidencia=array();
        /***/
        $inputFileType = PHPExcel_IOFactory::identify($archivo_temp);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivo_temp);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestRow1=$highestRow-1;
        //$acceso2 = $this->binnacle_model->buscar_personas('Busqueda mediante Excel','Busqueda masiva','','','',$highestRow1,'');
        for ($row = 2; $row <= $highestRow; $row++){
        		$nombre=converter_to_uppercase(trim( $sheet->getCell("A".$row)->getValue()));
        	  $apellidoP=converter_to_uppercase(trim($sheet->getCell("B".$row)->getValue()));
        		$apellidoM=converter_to_uppercase(trim($sheet->getCell("C".$row)->getValue()));
			      $trimabuscar1=$nombre.' '.$apellidoP.' '.$apellidoM;
            $trimabuscar=converter_to_uppercase(trim($trimabuscar1));
            $registro= $this->busquedas_model->buscarMultiple($trimabuscar,$nombre,$apellidoP,$apellidoM,$opcion);
            /*if($opcion=='SI'){
              //echo "Entro opcion si";
			      $registro= $this->busquedas_model->buscar($trimabuscar,$nombre,$apellidoP,$apellidoM);
            }
            else{
              //echo "Entro opcion NO";
              $registro= $this->busquedas_model->busquedaM($trimabuscar,$nombre,$apellidoP,$apellidoM);
            }*/
            $tipo="";
            foreach($registro as $fila){
				       $tipo=$tipo." ".$fila->tipo;
               $rfc=$fila->rfc;
               $nac=$fila->nacionalidad;
               $obs=$fila->observaciones;
               $pertenece=$fila->pertenece;
               $actividad=$fila->actividad;
               $fecha=$fila->fecha;
               $situacion_c=$fila->situacion_del_contribuyente;
               $ofgp=$fila->numero_y_fecha_de_oficio_global_de_presuncion;
               $psp=$fila->publicacion_pagina_sat_presuntos;
               $pdp=$fila->publicacion_dof_presuntos;
               $psdes=$fila->publicacion_pagina_sat_desvirtuados;
               $pogdes=$fila->numero_fecha_oficio_global_contribuyentes_desvirtuaron;
               $pddes=$fila->publicacion_dof_desvirtuados;
               $pogdef=$fila->numero_y_fecha_de_oficio_global_de_definitivos;
               $psdef=$fila->publicacion_pagina_sat_definitivos;
               $pddef=$fila->publicacion_dof_definitivos;
               $pogsf=$fila->numero_y_fecha_de_oficio_global_de_sentencia_favorable;
               $pssf=$fila->publicacion_pagina_sat_sentencia_favorable;
               $pdsf=$fila->publicacion_dof_sentencia_favorable;

			      }

            $movimiento = "BUSQUEDA EN LISTAS";
			      $operacion = "Nueva busqueda, realizada por el usuario: " . $this->session->userdata('name_operador');
			      if(count($registro)>0) {

              $itemCoincidencia = array();
              //datos para ventana
              $itemCoincidencia['rfc']=$rfc;
              $itemCoincidencia['nac']=$nac;
              $itemCoincidencia['obs']=$obs;
              $itemCoincidencia['pertenece']=$pertenece;
              $itemCoincidencia['actividad']=$actividad;
              $itemCoincidencia['fecha']=$fecha;
              $itemCoincidencia['situacion_c']=$situacion_c;
              $itemCoincidencia['ofgp']=$ofgp;
              $itemCoincidencia['psp']=$psp;
              $itemCoincidencia['pdp']=$pdp;
              $itemCoincidencia['psdes']=$psdes;
              $itemCoincidencia['pdgdes']=$pogdes;
              $itemCoincidencia['pddes']=$pddes;
              $itemCoincidencia['pogdef']=$pogdef;
              $itemCoincidencia['psdef']=$psdef;
              $itemCoincidencia['pddef']=$pddef;
              $itemCoincidencia['pogsf']=$pogsf;
              $itemCoincidencia['pssf']=$pssf;
              $itemCoincidencia['pdsf']=$pdsf;
              $itemCoincidencia['tipo']=$tipo;
              //fin datos para
              $itemCoincidencia['nombre']=$nombre;
				      $itemCoincidencia['apellidoP']=$apellidoP;
				      $itemCoincidencia['apellidoM']=$apellidoM;
				      $mensaje=' Se encontró en la lista. '.$tipo;
              $completo=$nombre.' '.$apellidoP.' '.$apellidoM;
				      $comentarios = $mensaje;
              $res=$res.'<tr><td>'.$nombre.'</td><td>'.$apellidoP.'</td><td>'.$apellidoM.'</td><td>'.$comentarios.'</td><td>Coincidencia</td></tr>';
				      //bitacora($movimiento, $operacion, $comentarios, $id = NULL);
				      $itemCoincidencia['mensaje']=$mensaje;
				      $listadoCoincidencia[]=$itemCoincidencia;
              $acceso2 = $this->binnacle_model->buscar_personas($completo,'Busqueda masiva','Busqueda Masiva','','1','1',$tipo);

            }
            else
            {
				        $itemNoCoincidencia=array();
				        $itemNoCoincidencia['nombre']=$nombre;
				        $itemNoCoincidencia['apellidoP']=$apellidoP;
				        $itemNoCoincidencia['apellidoM']=$apellidoM;
				        $mensaje='No se encontró en la lista.';
                $completo=$nombre.' '.$apellidoP.' '.$apellidoM;
				        $comentarios = $mensaje;
				       // bitacora($movimiento, $operacion, $comentarios, $id = NULL);
                $itemNoCoincidencia['mensaje']=$mensaje;
				        $listadoNoCoincidencia[]=$itemNoCoincidencia;
                $res=$res.'<tr><td>'.$nombre.'</td><td>'.$apellidoP.'</td><td>'.$apellidoM.'</td><td>'.$comentarios.'</td><td>Sin coincidencia</td></tr>';
                $acceso2 = $this->binnacle_model->buscar_personas($completo,'Busqueda masiva','Busqueda Masiva','','0','1','');
            }

        }
        /****/

		    $data['noCoincidencia']=$listadoNoCoincidencia;
		    $data['coincidencia']=$listadoCoincidencia;
	      $data['tipo']=$tipo;
        $data['res']=$res;

       $this->load->view('header');
		   menu_arriba();
		   $this->load->view('busqueda/busquedaMultiple', $data);
		   $this->load->view('footer');
	  }
    public function unblock_person(){
		    $id 				= $this->input->post('id');
		    $related_trade 		= $this->input->post('oficio_relacionado');
		    $reason 			= $this->input->post('motivo');
		    $status 			= 'delete';
		    $result 			= false;
		    $data = array(
			     'status' 		=> $status,
			     'related_trade' => $related_trade,
			     'reason' 		=> $reason
		    );

		   if($this->busquedas_model->unblock_person($data, $id))
		   {
			    $result = true;
		   }

		   $salidaJson = array(
			   'result' => $result,
		   );

		  echo json_encode($salidaJson, JSON_UNESCAPED_UNICODE);
	  }
    public function subir_foto(){
    	$photo = $this->input->post('foto');
    	$id = $this->input->post('id_persona');
	    $this->multipurpose->__construct('');
    	$this->multipurpose->update('cat_lists', array('id' => $id), array('photo' => $photo));
      $row = $this->multipurpose->get_record('cat_lists', array('id' => $id));
      $data = array(
    		'foto_persona' => '-',
      );
    	if ($row){
    		$data = array(
    			'foto_persona' => $row->photo,
    		);
    	}
    	echo json_encode($data,JSON_UNESCAPED_SLASHES);
    	$this->multipurpose->__destruct();
    }

    public function sm(){
      echo "id1".$id;
        echo "id2".$id1=$_POST['id'];
        exit;
         $result1 = $this->busquedas_model-> get_persona($id1);
    }

    //nueba busqueda
    public function busquedanueva(){
      /*Carga para las listas de bsqueda, nacionales e internacionales*/
      $result1 = $this->busquedas_model-> get_nacionales();
      $data['nacionales'] = $result1;

      $result2 = $this->busquedas_model->get_internacionales();
      $data['internacionales'] = $result2;

      $result3 = $this->busquedas_model->get_totalBusquedas();
      $data['totalBusquedas'] = $result3;

      $this->load->view('header');
      menu_arriba();
      $this->load->view('busqueda/busqueda',$data);
      $this->load->view('footer');
    }
    public function searchfisica(){
      $listas=""; //listas en las que aparece
      $tipoBusqueda="";
      $numeroC100=0;
      $num=0;
      $final = Array();
      $stautus="";
      $nombre 	= trim($this->input->post('nombre'));
      $rfc 		= trim($this->input->post('rfc'));
      $curp 		= trim($this->input->post('curp'));
      $type 		= $this->input->post('busqueda'); // search_exactly_f|| search_extend
      $conf= $this->input->post('conf');// regulatorias || negras || peps || pepN || pepE || ci || todas
      $pJuridica='F';
      $rfc_ban 	= 0;
      $full_name = $nombre;
      $full_name2 = $nombre;
      $full_name_search = $nombre; //AL porcentaje de coincidencia
      $trimabuscar = trim($full_name);
      $exist = false;
      $this->load->helper('converter_to_uppercase');
      $tipoBusqueda;
      $listas1;
        //parametros para enviar
         /*Tipo de busqueda*/
        if($type=='search_exactly_f'){
          $tipoBusqueda='Exacta';
        }else{
          $tipoBusqueda='Extendida';
        }
        /* Listas de busqueda*/
        switch ($conf) {
          case 'regulatorias':
             $listas1= "
             AND tipo != 'CI'";
            break;
          case 'negras':
              $listas1="
              AND (tipo != 'CI' AND tipo != 'PEP')
              ";
            break;
          case 'peps':
              $listas1="
              AND  tipo = 'PEP'
              ";
            break;
          case 'pepE':
                $listas1="
                AND  tipo = 'PEP' AND (nacionalidad='MEXICO' OR nacionalidad='NACIONAL')
                ";
              break;
          case 'pepN':
              $listas1="
              AND  tipo = 'PEP' AND (nacionalidad !='MEXICO' AND nacionalidad !='NACIONAL')
              ";
             break;
          case 'ci':
                $listas1="
                AND  tipo = 'CI'";
              break;
          case 'todas':
                $listas1="
                ";
              break;
          default:
          $listas1= "
          AND tipo != 'CI'";
            break;
        }
        /////fin de parametros
        $search = $this->busquedas_model->busquedaNueva($nombre,$tipoBusqueda,$pJuridica,$listas1,$rfc,$curp);
        //$search_unlocked = $this->busquedas_model->buscar(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
        //$tipoBusqueda='Busqueda normal';



      $html = '';
      //$html .= '<h3>Resultados</h3>';
      if ($search)
      {
        $html1= '';
        $html .='<tr role="row">';
        $html .='<td colspan="7" class= "text-center"><strong></strong></td>'; //LISTAS DE PERSONAS BLOQUEADAS
        $html .='</tr>';
        //$num=0;
        if (!empty($search))
        {

           $porcentaje = 0;
           foreach ($search as $fila){
              $full_name = $fila->name;
              $full_name = trim($full_name);
              if ($rfc_ban == 0){
                  similar_text(strtoupper (converter_to_uppercase($full_name_search)), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
              }
              else
              {
                  $porcentaje = 100;
                  $numeroC100=$numeroC100+1;
              }
              if(($fila->status)=='active'){
                $stautus='Activo';
              }else {
                $stautus='Baja, fecha de baja: '.$fila->updated_at;
              }
               $final[$num][0]=$fila->id;
               $final[$num][1]=$full_name;
               $final[$num][2]=$fila->pertenece;
               $final[$num][3]=$fila->actividad;
               $final[$num][4]=$fila->fecha;
               $final[$num][5]=$fila->tipo;
               $final[$num][6]=$fila->alias;
               $final[$num][7]=$stautus;
               $final[$num][8]=round($porcentaje,2);
               $num=$num+1;
           }
            //array bidimensional

            $volumen= Array();

            foreach ($final as $clave => $fila) {
                $volumen[$clave] = $fila['8'];

            }

            // Ordenar los datos con volumen descendiente, edición ascendiente
            // Agregar $datos como el último parámetro, para ordenar por la clave común
            array_multisort($volumen, SORT_DESC,$final);

           $html .='<tr role="row">';
           $html .='<td colspan="8" class= "text-center"><strong> Número de resultados: '.$num.'</strong></td>';
           $html .='</tr>';
           $html .= '<tr role="row">';

           foreach ($final as $dato){
             $html .='<tr role="row">

             <td><a href="#"  onclick="person_info('.$dato['0'] .')" >'.$dato['1']. '</a></td>
             <td>'.$dato['2']. '</td>
             <td>'.$dato['3']. '</td>
             <td>'.$dato['4']. '</td>
             <td>'.$dato['5']. '</td>
             <td>'.$dato['6']. '</td>
             <td>'.$dato['7']. '</td>
             <td>'.$dato['8']. '%</td>';

             $html .='</tr>';

             $html1 .='<tr role="row">

             <td><a href="#"  onclick="person_info('.$dato['0'] .')" >'.$dato['1']. '</a></td>
             <td>'.$dato['2']. '</td>
             <td>'.$dato['3']. '</td>
             <td>'.$dato['4']. '</td>
             <td>'.$dato['5']. '</td>
             <td>'.$dato['6']. '</td>
             <td>'.$dato['7']. '</td>
             <td>'.$dato['8']. '%</td>';

             $html1 .='</tr>';
             $listas.=$dato['5']." ";
            }

        }
        else
        {
          $html .='<tr role="row">';
          $html .='<td colspan="8" class= "text-center"><strong> - Sin resultados</strong></td>';
          $html .='</tr>';
        }

        $html .='<td colspan="8" align="center"><strong>Se encontraron coincidencias de: '.$nombre.' </strong> <br> <br> <button class="btn btn-primary" id="print_result" data-name="'.$trimabuscar.'/SE ENCONTRÓ EN LISTAS/ " data-table="'.urlencode($html1).'">Imprimir</button>
        <input type="hidden" name="datos" id="datos" value="'.htmlentities($html1).'" >
        <input type="hidden" name="name" id="name" value="'.$trimabuscar.'" >
        <input type="hidden" name="estatus" id="estatus" value="SE ENCONTRÓ EN LISTAS" >
        </td>
        </tr>';

        echo $html;
      }
      else
      {
        echo'<tr role="row">
        <td colspan="8" align="center"><strong>No se encontraron coincidencias de: '.$trimabuscar.' </strong> <br> <br> <button class="btn btn-primary" id="print_result" data-name="'.$trimabuscar.'/NO SE ENCONTRÓ EN LISTAS/">Imprimir</button>
        <input type="hidden" name="datos" id="datos" value="-" >
        <input type="hidden" name="name" id="name" value="'.$trimabuscar.'" >
        <input type="hidden" name="estatus" id="estatus" value="NO SE ENCONTRÓ EN LISTAS" >
        </td>
        </tr>';
        echo $html;
      }
      $acceso2 = $this->binnacle_model->buscar_personas($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,'1',$listas);
    }
    public function searchmoral(){
      $listas=""; //listas en las que aparece
      $tipoBusqueda="";
      $numeroC100=0;
      $num=0;
      $final = Array();
      $stautus="";
      $nombre 	= trim($this->input->post('razon_social'));
      $rfc 		= trim($this->input->post('rfc'));
      //$curp 		= trim($this->input->post('curp'));
      $type 		= $this->input->post('busqueda'); // search_exactly_f|| search_extend
      $conf= $this->input->post('conf');// regulatorias || negras || ci || todas
      $pJuridica='M';
      $rfc_ban 	= 0;
      $full_name = $nombre;
      $full_name2 = $nombre;
      $full_name_search = $nombre; //AL porcentaje de coincidencia
      $trimabuscar = trim($full_name);
      $exist = false;
      $this->load->helper('converter_to_uppercase');
      $tipoBusqueda;
      $listas1;
        //parametros para enviar
         /*Tipo de busqueda*/
        if($type=='search_exactly_f'){
          $tipoBusqueda='Exacta';
        }else{
          $tipoBusqueda='Extendida';
        }
        /* Listas de busqueda*/
        switch ($conf) {
          case 'regulatorias':
             $listas1= "
             AND tipo != 'CI'";
            break;
          case 'negras':
              $listas1="
              AND (tipo != 'CI' AND tipo != 'PEP')
              ";
            break;

          case 'ci':
                $listas1="
                AND  tipo = 'CI'";
              break;
          case 'todas':
                $listas1="
                ";
              break;
          default:
          $listas1= "
          AND tipo != 'CI'";
            break;
        }
        /////fin de parametros
        $search = $this->busquedas_model->busquedaNueva($nombre,$tipoBusqueda,$pJuridica,$listas1,$rfc);
        //$search_unlocked = $this->busquedas_model->buscar(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
        //$tipoBusqueda='Busqueda normal';



      $html = '';
      //$html .= '<h3>Resultados</h3>';
      if ($search)
      {
        $html1= '';
        $html .='<tr role="row">';
        $html .='<td colspan="7" class= "text-center"><strong></strong></td>'; //LISTAS DE PERSONAS BLOQUEADAS
        $html .='</tr>';
        //$num=0;
        if (!empty($search))
        {

           $porcentaje = 0;
           foreach ($search as $fila){
              $full_name = $fila->name;
              $full_name = trim($full_name);
              if ($rfc_ban == 0){
                  similar_text(strtoupper (converter_to_uppercase($full_name_search)), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
              }
              else
              {
                  $porcentaje = 100;
                  $numeroC100=$numeroC100+1;
              }
              if(($fila->status)=='active'){
                $stautus='Activo';
              }else {
                $stautus='Baja, fecha de baja: '.$fila->updated_at;
              }
               $final[$num][0]=$fila->id;
               $final[$num][1]=$full_name;
               $final[$num][2]=$fila->pertenece;
               $final[$num][3]=$fila->actividad;
               $final[$num][4]=$fila->fecha;
               $final[$num][5]=$fila->tipo;
               $final[$num][6]=$fila->alias;
               $final[$num][7]=$stautus;
               $final[$num][8]=round($porcentaje,2);
               $num=$num+1;
           }
            //array bidimensional

            $volumen= Array();

            foreach ($final as $clave => $fila) {
                $volumen[$clave] = $fila['8'];

            }

            // Ordenar los datos con volumen descendiente, edición ascendiente
            // Agregar $datos como el último parámetro, para ordenar por la clave común
            array_multisort($volumen, SORT_DESC,$final);

           $html .='<tr role="row">';
           $html .='<td colspan="8" class= "text-center"><strong> Número de resultados: '.$num.'</strong></td>';
           $html .='</tr>';
           $html .= '<tr role="row">';

           foreach ($final as $dato){
             $html .='<tr role="row">

             <td><a href="#"  onclick="person_info('.$dato['0'] .')" >'.$dato['1']. '</a></td>
             <td>'.$dato['2']. '</td>
             <td>'.$dato['3']. '</td>
             <td>'.$dato['4']. '</td>
             <td>'.$dato['5']. '</td>
             <td>'.$dato['6']. '</td>
             <td>'.$dato['7']. '</td>
             <td>'.$dato['8']. '%</td>';

             $html .='</tr>';

             $html1 .='<tr role="row">

             <td><a href="#"  onclick="person_info('.$dato['0'] .')" >'.$dato['1']. '</a></td>
             <td>'.$dato['2']. '</td>
             <td>'.$dato['3']. '</td>
             <td>'.$dato['4']. '</td>
             <td>'.$dato['5']. '</td>
             <td>'.$dato['6']. '</td>
             <td>'.$dato['7']. '</td>
             <td>'.$dato['8']. '%</td>';

             $html1 .='</tr>';
             $listas.=$dato['5']." ";
            }

        }
        else
        {
          $html .='<tr role="row">';
          $html .='<td colspan="8" class= "text-center"><strong> - Sin resultados</strong></td>';
          $html .='</tr>';
        }

        $html .='<td colspan="8" align="center"><strong>Se encontraron coincidencias de: '.$nombre.' </strong> <br> <br> <button class="btn btn-primary" id="print_result" data-name="'.$trimabuscar.'/SE ENCONTRÓ EN LISTAS/ " data-table="'.urlencode($html1).'">Imprimir</button>
        <input type="hidden" name="datos" id="datos" value="'.htmlentities($html1).'" >
        <input type="hidden" name="name" id="name" value="'.$trimabuscar.'" >
        <input type="hidden" name="estatus" id="estatus" value="SE ENCONTRÓ EN LISTAS" >
        </td>
        </tr>';

        echo $html;
      }
      else
      {
        echo'<tr role="row">
        <td colspan="8" align="center"><strong>No se encontraron coincidencias de: '.$trimabuscar.' </strong> <br> <br> <button class="btn btn-primary" id="print_result" data-name="'.$trimabuscar.'/NO SE ENCONTRÓ EN LISTAS/">Imprimir</button>
        <input type="hidden" name="datos" id="datos" value="-" >
        <input type="hidden" name="name" id="name" value="'.$trimabuscar.'" >
        <input type="hidden" name="estatus" id="estatus" value="NO SE ENCONTRÓ EN LISTAS" >
        </td>
        </tr>';
        echo $html;
      }
      $acceso2 = $this->binnacle_model->buscar_personas($full_name2,$tipoBusqueda,'Persona Moral',$numeroC100,$num,'1',$listas);
    }
    public function unlock_views2(){
		    $id = $this->input->post('id');
		    $result = Array();
		    if($id > 0){
			    $result = $this->busquedas_model->get_listN($id);
		    }
		    echo json_encode($result, JSON_UNESCAPED_UNICODE);
	  }

}
