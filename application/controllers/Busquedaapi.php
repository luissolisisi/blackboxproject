<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Busquedaapi extends REST_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('busquedas_model');
        $this->load->model('busquedasb_model');
        $this->load->model('binnacle_model');
        $this->load->helper('converter_to_uppercase');
        $this->db = $this->load->database("default", TRUE);
    }

    //persona fisica
    public function searchlists_post(){
      $api_key_variable = $this->config->item('rest_key_name');
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      $apiK=$this->input->server($key_name);
      /*
      if($apiK=='201020594'){

      }
      else{
        $hoy =date("Y-m-d");

        $result3 = $this->busquedas_model->totalBusquedas_Api($apiK);
        $acceso=$this->busquedas_model->varSesion($apiK);
        $inicio=""; $paquete="";
        foreach ($acceso as $data){
          switch ($data['paquete']) {
            case 'B':
                $p='2000';
            break;
            case 'E':
                $p='4500';
            break;
            case 'P':
                $p='10000';
            break;

            case 'A':
                $p='100000';
            break;
            default:
                $p='10000';
              break;
          }
              $termino  	=  $data['f_termino'];
              $paquete  	=  $p;
        }
        if($paquete<=$result3){
          $response = array(
                'err' => TRUE,
                'message' => 'A alcanzado el limite de busquedas',
                );
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($termino < $hoy) {
          $response = array(
                'err' => TRUE,
                'message' => 'El periodo de su paquete ha terminado',
                );
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }


      }
      */


      //if ($this->form_validation->run('searchlists_post')) {
        $listas="";
        $tipoBusqueda="";
        $numeroC100=0;
        $num=0;
        $final = Array();
        $stautus="";

        $nombre= trim($this->post('nombre'));
        $apaterno= trim($this->post('paterno'));
        $amaterno= trim($this->post('materno'));
        $rfc= trim($this->post('rfc'));
        $curp= trim($this->post('curp'));
        $buscar= trim($this->post('tipo'));
        $idE=$this->post('id_entidad');
        $rfc_ban 	= 0;
        $type= "f";
        if($idE =="" or $idE==''){
          $idE=1500;
        }


        $full_name = $nombre . " " . $apaterno . " " . $amaterno;
        $full_name2 = $nombre . " " . $apaterno . " " . $amaterno;
        $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia
        $trimabuscar = trim($full_name);
        $exist = false;
        $this->load->helper('converter_to_uppercase');
        if($buscar=="search_exactly_f"){
          $search = $this->busquedas_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp));
          $search_unlocked = $this->busquedas_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp),'delete');
          $tipoBusqueda='Busqueda exacta';
          //$acceso2 = $this->binnacle_model->($full_name,'Busqueda exacta','Persona Fisica');

        }
        elseif ($buscar=="search_extend"){
          $search = $this->busquedas_model->buscar_extendidaapi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
          $search_unlocked = $this->busquedas_model->buscar_extendidaapi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
          $tipoBusqueda='Busqueda extendida';
        }
        else{
          $search = $this->busquedas_model->buscarApi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp),'active', $idE);
          $search_unlocked = $this->busquedas_model->buscarApi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete',$idE);
          $tipoBusqueda='Busqueda normal';

        }
        if (!empty($rfc)){
          if ($this->busquedas_model->search_rfc($rfc) ){
            $rfc_ban = 1;
          }
        }
        if ($search)
        {

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
                //if(($fila->tipo)=='CI' OR ($fila->actividad)=='CONTRIBUYENTE INCUMPLIDO'){

                //}else{
                  $final[$num][0]=$fila->id;
                   $final[$num][1]=$full_name;
                   $final[$num][2]=$fila->pertenece;
                   $final[$num][3]=$fila->actividad;
                   $final[$num][4]=$fila->fecha;
                   $final[$num][5]=$fila->tipo;
                   $final[$num][6]=$stautus;
                   $final[$num][7]=round($porcentaje,2);
                   $num=$num+1;
                   $listas.=$fila->tipo." ";
                //}

             }
              //array bidimensional

              $volumen= Array();

              foreach ($final as $clave => $fila) {
                  $volumen[$clave] = $fila['7'];

              }

              // Ordenar los datos con volumen descendiente, edición ascendiente
              // Agregar $datos como el último parámetro, para ordenar por la clave común
              array_multisort($volumen, SORT_DESC,$final);
              //echo json_encode($final);

             $acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas);
          }
        }
        if(!empty($final)) {
          $this->response($final);
            //echo json_encode($final);
        }
        else{
              $response = array(
                  'err' => TRUE,
                  'message' => 'No existe la persona ingresada',
              );
              $this->response($response, REST_Controller::HTTP_OK);
        }

      //}
        /*  else{
        $response = array(
              'err' => TRUE,
              'message' => 'Sus datos están incompletos verifique',
              );
          $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
      }*/

    }

    //persona moral
    public function searchlistsm_post(){
      $listas="";
      $api_key_variable = $this->config->item('rest_key_name');
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      $apiK=$this->input->server($key_name);

      if($apiK=='201020594'){

      }else{
        $hoy =date("Y-m-d");

        $result3 = $this->busquedas_model->totalBusquedas_Api($apiK);
        $acceso=$this->busquedas_model->varSesion($apiK);
        $inicio=""; $paquete="";
        foreach ($acceso as $data){
          switch ($data['paquete']) {
            case 'B':
                $p='2000';
            break;
            case 'E':
                $p='4500';
            break;
            case 'P':
                $p='10000';
            break;

            case 'A':
                $p='100000';
            break;
            default:
                $p='10000';
              break;
          }
              $termino  	=  $data['f_termino'];
              $paquete  	=  $p;
        }
        if($paquete<=$result3){
          $response = array(
                'err' => TRUE,
                'message' => 'A alcanzado el limite de busquedas',
                );
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($termino < $hoy) {
          $response = array(
                'err' => TRUE,
                'message' => 'El periodo de su paquete ha terminado',
                );
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }


      }
          if ($this->form_validation->run('searchlistsm_post')){
            $tipoBusqueda="";
            $numeroC100=0;
            $num=0;
            $final = Array();
            $stautus="";
            $nombre = converter_to_uppercase(trim($this->post('razon_social')));
            $nombre2 = converter_to_uppercase(trim($this->post('razon_social')));
            $rfc = converter_to_uppercase(trim($this->post('rfc')));
            $buscar=$this->post('busqueda');

            $trimabuscar = converter_to_uppercase(trim($nombre));
            $exist = false;

            $rfc_ban = 0;


            if (!empty($rfc)){
               if ($this->busquedas_model->search_rfc($rfc) ){
                  $rfc_ban = 1;
               }
            }

            if($buscar=="search_exactly_f"){
              $search = $this->busquedas_model->buscar_exacta_mApi($nombre,$rfc);
              $search_unlocked = $this->busquedas_model->buscar_exacta_mApi($nombre,$rfc,'delete');
              $tipoBusqueda="Busqueda exacta";
            }
            elseif($buscar=="search_extend"){
              $search = $this->busquedas_model->buscar_extendida_mApi($nombre,$rfc);
              $search_unlocked = $this->busquedas_model->buscar_extendida_mApi($nombre,$rfc);
              $tipoBusqueda="Busqueda extendida";
            }
            else{
              $id=1500;
              $search = $this->busquedas_model->buscarApi($trimabuscar, $nombre, $apaterno = "", $amaterno = "", $rfc, $curp = "",'active',$id);
              $search_unlocked = $this->busquedas_model->buscarApi($trimabuscar, $nombre, $apaterno, $amaterno, $rfc, $curp,'active',$id);
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
                 }
                 else {
                   $stautus='Baja, fecha de baja: '.$fila->updated_at;
                 }
                 //if(($fila->tipo)=='CI' OR ($fila->actividad)=='CONTRIBUYENTE INCUMPLIDO'){

                //}else{
                 $final[$num][0]=$fila->id;
                 $final[$num][1]=$full_name;
                 $final[$num][2]=$fila->pertenece;
                 $final[$num][3]=$fila->actividad;
                 $final[$num][4]=$fila->fecha;
                 $final[$num][5]=$fila->tipo;
                 $final[$num][6]=$stautus;
                 $final[$num][7]=round($porcentaje,2);
                 $num=$num+1;
                 $listas.=$fila->tipo." ";
               //}
               }
               $volumen= Array();
               foreach ($final as $clave => $fila) {
                   $volumen[$clave] = $fila['7'];
               }
               array_multisort($volumen, SORT_DESC,$final);


            }
            else{

            }
            $acceso2 = $this->binnacle_model->buscar_personasAPI($nombre2,$tipoBusqueda,'Persona Moral',$numeroC100,$num,$apiK,$listas);
            if(!empty($final)) {
                  $this->response($final);
            }
            else{
                  $response = array(
                      'err' => TRUE,
                      'message' => 'No existe la persona ingresada',
                  );
                  $this->response($response, REST_Controller::HTTP_OK);
            }

          }
          else{
            $response = array(
                  'err' => TRUE,
                  'message' => 'Sus datos están incompletos verifique',
                  );
              $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
          }

    }


    public function pruebas_post(){
      echo "Prueba de api correcta";
    }

    public function searchperson_post(){
      $api_key_variable = $this->config->item('rest_key_name');
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      $apiK=$this->input->server($key_name);
      $entidad=  $this->binnacle_model->getID($apiK);
      /*
      if($apiK=='201020594'){

      }
      else{
        $hoy =date("Y-m-d");

        $result3 = $this->busquedas_model->totalBusquedas_Api($apiK);
        $acceso=$this->busquedas_model->varSesion($apiK);
        $inicio=""; $paquete="";
        foreach ($acceso as $data){
          switch ($data['paquete']) {
            case 'B':
                $p='2000';
            break;
            case 'E':
                $p='4500';
            break;
            case 'P':
                $p='10000';
            break;

            case 'A':
                $p='100000';
            break;
            default:
                $p='10000';
              break;
          }
              $termino  	=  $data['f_termino'];
              $paquete  	=  $p;
        }
        if($paquete<=$result3){
          $tokenData = true;
          // Create a token
          //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
          // Set HTTP status code
          $status = parent::HTTP_BAD_REQUEST;
          $title_response = array(
            'swagger'   =>  '2.0',
            'info'  =>  array(
              'version'  =>   'v1.0.0',
              'title' =>  'API Searchperson',
              'description'   =>  'API to search persons or enterprise in diffent kind of list'
            ),
          );

          $host_response = array(
              'host'  =>  $_SERVER["HTTP_HOST"],
              'basePath'  =>  $_SERVER["REQUEST_URI"],
              //'schemes'   =>  $_SERVER['HTTPS']
              'schemes'   =>  'on'
          );

          $tags_response = array(
              'name'  =>  'Response',
              'description'   =>  'api to verify response'
          );
          $paths_response = array(
                '/test_resp' => array(
                    'post'  =>  array(
                        'tags'  => array(
                            'name'  =>  'Busquedas'
                          ),
                        'description'   =>  'Search in list',
                      ),
                ),
          );
          $parameters_response = array(
              'result'=>'A alcanzado su maximo de busquedas'
              );
          $resp_response = array(
                  200 =>  array(
                      'description'   =>  'The record was saved successfully',
                      'headers'   =>  array(
                          'StrictTransportSecurity'   =>  array(
                              'type'  =>  'string',
                              'description'   =>  'HTTPS strict transport security header',
                              'default'   =>  'max-age=31536000',
                          ),
                      ),
                  ),
                  403 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                  ),
                'Etag'  =>  array(
                    'type'  => 'string',
                    'description'   =>  'No update'
                ),
                'Cache-control' =>  array(
                      'type'  =>  'string',
                      'description'   =>  'Describes how long this response can be cached',
                      'default'   =>  'max-age=15552000'
                  ),
                'X-Frame-Options'   =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Prevent this request from being loaded in any iframes',
                    'default'  =>   'DENY',
                ),
                'X-Content-Type-Options'    =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                    'default'  =>   'nosniff',
                ),
            );
          $schema_response = array(
              'schema'    => array(
                  'type'  =>  'object'
              ),
              'properties'    =>  array(
                  'meta'  =>  array(
                      'title' =>  'Meta data',
                      'type'  =>  'object',
                  ),
                  'properties'    =>  array(
                      'LastUpdate'    =>  array(
                          'type'  =>  'string',
                          'format'    =>  'date-time'
                      ),
                      'TotalResults'  =>  array(
                          'type'  =>  'Integer'
                      ),
                  ),
              ),
              'Agreement' =>  array(
                  'type'  =>  'string',
                  'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
              ),
          );
          $license_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed'
          );
          $term_use_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed',
              'required'  =>  array(
                  'LastUpdate'    =>  0,
                  'TotalResults'  =>  0,
                  'Agreement' =>  0,
                  'License'   =>  0,
                  'TermOfUse' =>  0,
              ),
              'additionalProperties'  =>  false

          );


          $response = array(
              'status' => $status,
              'title' =>  $title_response,
              'host'  =>  $host_response,
              'produces'  =>  'application/json',
              'tags'  =>  $tags_response,
              'paths' =>  $paths_response,
              'parameters'    =>  $parameters_response,
              'responses' =>  $resp_response,
              'schema_and_meta_data'  =>  $schema_response,
              'license'   =>  $license_response,
              'termOfUse' =>  $term_use_response,
          );

          $this->response($response, $status);
          //  $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($termino < $hoy) {
          $tokenData = true;
          // Create a token
          //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
          // Set HTTP status code
          $status = parent::HTTP_BAD_REQUEST;
          $title_response = array(
            'swagger'   =>  '2.0',
            'info'  =>  array(
              'version'  =>   'v1.0.0',
              'title' =>  'API Searchperson',
              'description'   =>  'API to search persons or enterprise in diffent kind of list'
            ),
          );

          $host_response = array(
              'host'  =>  $_SERVER["HTTP_HOST"],
              'basePath'  =>  $_SERVER["REQUEST_URI"],
              //'schemes'   =>  $_SERVER['HTTPS']
              'schemes'   =>  'on'
          );

          $tags_response = array(
              'name'  =>  'Response',
              'description'   =>  'api to verify response'
          );
          $paths_response = array(
                '/test_resp' => array(
                    'post'  =>  array(
                        'tags'  => array(
                            'name'  =>  'Busquedas'
                          ),
                        'description'   =>  'Search in list',
                      ),
                ),
          );
          $parameters_response = array(
              'result'=>'Su paquete ha finalizado'
              );
          $resp_response = array(
                  200 =>  array(
                      'description'   =>  'The record was saved successfully',
                      'headers'   =>  array(
                          'StrictTransportSecurity'   =>  array(
                              'type'  =>  'string',
                              'description'   =>  'HTTPS strict transport security header',
                              'default'   =>  'max-age=31536000',
                          ),
                      ),
                  ),
                  403 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                  ),
                'Etag'  =>  array(
                    'type'  => 'string',
                    'description'   =>  'No update'
                ),
                'Cache-control' =>  array(
                      'type'  =>  'string',
                      'description'   =>  'Describes how long this response can be cached',
                      'default'   =>  'max-age=15552000'
                  ),
                'X-Frame-Options'   =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Prevent this request from being loaded in any iframes',
                    'default'  =>   'DENY',
                ),
                'X-Content-Type-Options'    =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                    'default'  =>   'nosniff',
                ),
            );
          $schema_response = array(
              'schema'    => array(
                  'type'  =>  'object'
              ),
              'properties'    =>  array(
                  'meta'  =>  array(
                      'title' =>  'Meta data',
                      'type'  =>  'object',
                  ),
                  'properties'    =>  array(
                      'LastUpdate'    =>  array(
                          'type'  =>  'string',
                          'format'    =>  'date-time'
                      ),
                      'TotalResults'  =>  array(
                          'type'  =>  'Integer'
                      ),
                  ),
              ),
              'Agreement' =>  array(
                  'type'  =>  'string',
                  'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
              ),
          );
          $license_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed'
          );
          $term_use_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed',
              'required'  =>  array(
                  'LastUpdate'    =>  0,
                  'TotalResults'  =>  0,
                  'Agreement' =>  0,
                  'License'   =>  0,
                  'TermOfUse' =>  0,
              ),
              'additionalProperties'  =>  false

          );


          $response = array(
              'status' => $status,
              'title' =>  $title_response,
              'host'  =>  $host_response,
              'produces'  =>  'application/json',
              'tags'  =>  $tags_response,
              'paths' =>  $paths_response,
              'parameters'    =>  $parameters_response,
              'responses' =>  $resp_response,
              'schema_and_meta_data'  =>  $schema_response,
              'license'   =>  $license_response,
              'termOfUse' =>  $term_use_response,
          );

          $this->response($response, $status);
        }


      }
      */
      if ($this->form_validation->run('searchperson_post')){
          //recibir valores
          $nombre= strtoupper(trim($this->post('nombre')));
            $apaterno= strtoupper(trim($this->post('apaterno')));
          $amaterno= strtoupper(trim($this->post('amaterno')));
          $tipo_busqueda= trim($this->post('tipo_busqueda'));
          $tipo_persona= strtoupper(trim($this->post('tipo_persona')));
          $curp= strtoupper(trim($this->post('curp')));
          $rfc= strtoupper(trim($this->post('rfc')));
            switch ($tipo_persona) {
              case 'FISICA':
                    $data = $this->post();
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $type= "f";
                    $rfc_ban 	= 0;

                    $full_name1 = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name= str_replace("'", " ", $full_name1);
                    $full_name= str_replace("-", " ", $full_name);
                    $full_name2 = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia
                    $trimabuscar = trim($full_name);
                    $exist = false;
                    $this->load->helper('converter_to_uppercase');
                    if($tipo_busqueda=="EXACTA"){
                      if ($apiK == 'KYC-sGcI6JrwL4Tszlip6P0VWBUkjezBOX/vQsxAjwaeQvhCA4dVt3ynTykjk34=') {
                        $search = $this->busquedas_model->buscar_exactaMas(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp));
                        $tipoBusqueda='Busqueda exacta';
                      }else{

                      $search = $this->busquedas_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp));
                      $search_unlocked = $this->busquedas_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp),'delete');
                      $tipoBusqueda='Busqueda exacta';
                    }
                    }
                    elseif ($tipo_busqueda=="EXTENDIDA"){
                        if ($apiK == 'KYC-sGcI6JrwL4Tszlip6P0VWBUkjezBOX/vQsxAjwaeQvhCA4dVt3ynTykjk34=') {
                          $search = $this->busquedas_model->buscar_extendidaapiMAS(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
                          $tipoBusqueda='Busqueda extendida';
                        }else{
                      $search = $this->busquedas_model->buscar_extendidaapi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
                      $search_unlocked = $this->busquedas_model->buscar_extendidaapi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
                      $tipoBusqueda='Busqueda extendida';
                    }
                    }
                    else{
                        if ($apiK == 'KYC-sGcI6JrwL4Tszlip6P0VWBUkjezBOX/vQsxAjwaeQvhCA4dVt3ynTykjk34=') {
                          $search = $this->busquedas_model->buscarApiMAS(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp),'active',$entidad);
                          $tipoBusqueda='Busqueda normal';
                        }
                      else{
                      $search = $this->busquedas_model->buscarApi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp),'active',$entidad);
                      $search_unlocked = $this->busquedas_model->buscarApi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete',$entidad);
                      $tipoBusqueda='Busqueda normal';
                    }

                    }
                    if (!empty($rfc)){
                      if ($this->busquedas_model->search_rfc($rfc) ){
                        $rfc_ban = 1;
                      }
                    }
                    if ($search)
                    {

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
                            $porcentaje==round($porcentaje,2);
                            if($porcentaje<'89.99%' and ($apiK=='KYC-omkM5J7jJprtyxO4p8NPfEY0va7BYRH/J7s28Q==' or $apiK=='KYC-gmlY9YuxM5v810m0ncx4bw1w3vSyJw==') ){


                            }elseif ($porcentaje<'69.99%' and $apiK=='KYC-i2oZ9Y/3LJv0xR2ypsNUe1wsga3wfkjvcupjrmvSZtJiP4l6rjfCH19lm36YFoMY') {
                              // code...
                            }
                            else{
                            $final[$num][0]=$fila->id;
                             $final[$num][1]=$full_name;
                             $final[$num][2]=$fila->pertenece;
                             $final[$num][3]=$fila->actividad;
                             $final[$num][4]=$fila->fecha;
                             $final[$num][5]=$fila->tipo;
                             $final[$num][6]=$stautus;
                             $final[$num][7]=round($porcentaje,2);
                             $num=$num+1;
                             $listas.=$fila->tipo." ";
                           }
                         }
                          //array bidimensional

                          $volumen= Array();

                          foreach ($final as $clave => $fila) {
                              $volumen[$clave] = $fila['7'];

                          }

                          // Ordenar los datos con volumen descendiente, edición ascendiente
                          // Agregar $datos como el último parámetro, para ordenar por la clave común
                          array_multisort($volumen, SORT_DESC,$final);
                          //echo json_encode($final);

                         //$acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas);
                      }
                    }
                    $acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada3'.$trimabuscar
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                break;
              case 'MORAL':
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $trimabuscar = converter_to_uppercase(trim($nombre));
                    $exist = false;
                    $rfc_ban = 0;

                    if (!empty($rfc)){
                       if ($this->busquedas_model->search_rfc($rfc) ){
                          $rfc_ban = 1;
                       }
                    }
                    if($tipo_busqueda=="EXACTA"){
                      if ($apiK == 'KYC-sGcI6JrwL4Tszlip6P0VWBUkjezBOX/vQsxAjwaeQvhCA4dVt3ynTykjk34=') {
                        $search = $this->busquedas_model->buscar_exacta_mApiMAS($nombre,$rfc);
                        $tipoBusqueda="Busqueda exacta";
                      }
                      else{
                      $search = $this->busquedas_model->buscar_exacta_mApi($nombre,$rfc);
                      $search_unlocked = $this->busquedas_model->buscar_exacta_mApi($nombre,$rfc,'delete');
                      $tipoBusqueda="Busqueda exacta";
                    }
                    }
                    elseif($tipo_busqueda=="EXTENDIDA"){
                      if ($apiK == 'KYC-sGcI6JrwL4Tszlip6P0VWBUkjezBOX/vQsxAjwaeQvhCA4dVt3ynTykjk34=') {
                        $search = $this->busquedas_model->buscar_extendida_mApiMAS($nombre,$rfc);
                        $tipoBusqueda="Busqueda extendida";
                      }else{
                      $search = $this->busquedas_model->buscar_extendida_mApi($nombre,$rfc);
                      $search_unlocked = $this->busquedas_model->buscar_extendida_mApi($nombre,$rfc);
                      $tipoBusqueda="Busqueda extendida";
                    }
                    }
                    else{
                      if ($apiK == 'KYC-sGcI6JrwL4Tszlip6P0VWBUkjezBOX/vQsxAjwaeQvhCA4dVt3ynTykjk34=') {
                        $id=1500;
                        $search = $this->busquedas_model->buscarApiMAS($trimabuscar, $nombre, $apaterno = "", $amaterno = "", $rfc, $curp = "",'active',$id);
                        $tipoBusqueda="Busqueda normal";
                      }else{
                      $id=1500;
                      $search = $this->busquedas_model->buscarApi($trimabuscar, $nombre, $apaterno = "", $amaterno = "", $rfc, $curp = "",'active',$id);
                      $search_unlocked = $this->busquedas_model->buscarApi($trimabuscar, $nombre, $apaterno, $amaterno, $rfc, $curp,'active',$id);
                      $tipoBusqueda="Busqueda normal";
                    }
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
                         }
                         else {
                           $stautus='Baja, fecha de baja: '.$fila->updated_at;
                         }
                         $porcentaje==round($porcentaje,2);
                         if($porcentaje<'89.99%' and ($apiK=='KYC-omkM5J7jJprtyxO4p8NPfEY0va7BYRH/J7s28Q==' or $apiK=='KYC-gmlY9YuxM5v810m0ncx4bw1w3vSyJw==') ){

                         }elseif (($porcentaje<'69.99%' and $apiK=='KYC-i2oZ9Y/3LJv0xR2ypsNUe1wsga3wfkjvcupjrmvSZtJiP4l6rjfCH19lm36YFoMY' )) {
                           // code...
                         }
                         else{
                         $final[$num][0]=$fila->id;
                         $final[$num][1]=$full_name;
                         $final[$num][2]=$fila->pertenece;
                         $final[$num][3]=$fila->actividad;
                         $final[$num][4]=$fila->fecha;
                         $final[$num][5]=$fila->tipo;
                         $final[$num][6]=$stautus;
                         $final[$num][7]=round($porcentaje,2);
                         $num=$num+1;
                         $listas.=$fila->tipo." ";
                       }
                       }
                       $volumen= Array();
                       foreach ($final as $clave => $fila) {
                           $volumen[$clave] = $fila['7'];
                       }
                       array_multisort($volumen, SORT_DESC,$final);
                    }
                    else{

                    }
                    $acceso2 = $this->binnacle_model->buscar_personasAPI($nombre,$tipoBusqueda,'Persona Moral',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
              break;

              default:
                  $tokenData = true;
                  // Create a token
                  //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                  // Set HTTP status code
                  $status = parent::HTTP_BAD_REQUEST;
                  $title_response = array(
                    'swagger'   =>  '2.0',
                    'info'  =>  array(
                      'version'  =>   'v1.0.0',
                      'title' =>  'API Searchperson',
                      'description'   =>  'API to search persons or enterprise in diffent kind of list'
                    ),
                  );

                  $host_response = array(
                      'host'  =>  $_SERVER["HTTP_HOST"],
                      'basePath'  =>  $_SERVER["REQUEST_URI"],
                      //'schemes'   =>  $_SERVER['HTTPS']
                      'schemes'   =>  'on'
                  );

                  $tags_response = array(
                      'name'  =>  'Response',
                      'description'   =>  'api to verify response'
                  );
                  $paths_response = array(
                        '/test_resp' => array(
                            'post'  =>  array(
                                'tags'  => array(
                                    'name'  =>  'Busquedas'
                                  ),
                                'description'   =>  'Search in list',
                              ),
                        ),
                  );
                  $parameters_response = array(
                      'result'=>'Opcion no valida'
                      );
                  $resp_response = array(
                          200 =>  array(
                              'description'   =>  'The record was saved successfully',
                              'headers'   =>  array(
                                  'StrictTransportSecurity'   =>  array(
                                      'type'  =>  'string',
                                      'description'   =>  'HTTPS strict transport security header',
                                      'default'   =>  'max-age=31536000',
                                  ),
                              ),
                          ),
                          403 =>  array(
                            'description'   =>  'The record was saved successfully',
                            'headers'   =>  array(
                                'StrictTransportSecurity'   =>  array(
                                    'type'  =>  'string',
                                    'description'   =>  'HTTPS strict transport security header',
                                    'default'   =>  'max-age=31536000',
                                ),
                            ),
                          ),
                        'Etag'  =>  array(
                            'type'  => 'string',
                            'description'   =>  'No update'
                        ),
                        'Cache-control' =>  array(
                              'type'  =>  'string',
                              'description'   =>  'Describes how long this response can be cached',
                              'default'   =>  'max-age=15552000'
                          ),
                        'X-Frame-Options'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Prevent this request from being loaded in any iframes',
                            'default'  =>   'DENY',
                        ),
                        'X-Content-Type-Options'    =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                            'default'  =>   'nosniff',
                        ),
                    );
                  $schema_response = array(
                      'schema'    => array(
                          'type'  =>  'object'
                      ),
                      'properties'    =>  array(
                          'meta'  =>  array(
                              'title' =>  'Meta data',
                              'type'  =>  'object',
                          ),
                          'properties'    =>  array(
                              'LastUpdate'    =>  array(
                                  'type'  =>  'string',
                                  'format'    =>  'date-time'
                              ),
                              'TotalResults'  =>  array(
                                  'type'  =>  'Integer'
                              ),
                          ),
                      ),
                      'Agreement' =>  array(
                          'type'  =>  'string',
                          'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                      ),
                  );
                  $license_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed'
                  );
                  $term_use_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed',
                      'required'  =>  array(
                          'LastUpdate'    =>  0,
                          'TotalResults'  =>  0,
                          'Agreement' =>  0,
                          'License'   =>  0,
                          'TermOfUse' =>  0,
                      ),
                      'additionalProperties'  =>  false

                  );


                  $response = array(
                      'status' => $status,
                      'title' =>  $title_response,
                      'host'  =>  $host_response,
                      'produces'  =>  'application/json',
                      'tags'  =>  $tags_response,
                      'paths' =>  $paths_response,
                      'parameters'    =>  $parameters_response,
                      'responses' =>  $resp_response,
                      'schema_and_meta_data'  =>  $schema_response,
                      'license'   =>  $license_response,
                      'termOfUse' =>  $term_use_response,
                  );

                  $this->response($response, $status);
              break;
            }

      }else{
        $tokenData = true;
        // Create a token
        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
        // Set HTTP status code
        $status = parent::HTTP_BAD_REQUEST;
        $title_response = array(
          'swagger'   =>  '2.0',
          'info'  =>  array(
            'version'  =>   'v1.0.0',
            'title' =>  'API Searchperson',
            'description'   =>  'API to search persons or enterprise in diffent kind of list'
          ),
        );

        $host_response = array(
            'host'  =>  $_SERVER["HTTP_HOST"],
            'basePath'  =>  $_SERVER["REQUEST_URI"],
            //'schemes'   =>  $_SERVER['HTTPS']
            'schemes'   =>  'on'
        );

        $tags_response = array(
            'name'  =>  'Response',
            'description'   =>  'api to verify response'
        );
        $paths_response = array(
              '/test_resp' => array(
                  'post'  =>  array(
                      'tags'  => array(
                          'name'  =>  'Busquedas'
                        ),
                      'description'   =>  'Search in list',
                    ),
              ),
        );
        $parameters_response = array(
            'result'=>'Sus datos estan incompletos, verifiquelos '
            );
        $resp_response = array(
                200 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                ),
                403 =>  array(
                  'description'   =>  'The record was saved successfully',
                  'headers'   =>  array(
                      'StrictTransportSecurity'   =>  array(
                          'type'  =>  'string',
                          'description'   =>  'HTTPS strict transport security header',
                          'default'   =>  'max-age=31536000',
                      ),
                  ),
                ),
              'Etag'  =>  array(
                  'type'  => 'string',
                  'description'   =>  'No update'
              ),
              'Cache-control' =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Describes how long this response can be cached',
                    'default'   =>  'max-age=15552000'
                ),
              'X-Frame-Options'   =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Prevent this request from being loaded in any iframes',
                  'default'  =>   'DENY',
              ),
              'X-Content-Type-Options'    =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                  'default'  =>   'nosniff',
              ),
          );
        $schema_response = array(
            'schema'    => array(
                'type'  =>  'object'
            ),
            'properties'    =>  array(
                'meta'  =>  array(
                    'title' =>  'Meta data',
                    'type'  =>  'object',
                ),
                'properties'    =>  array(
                    'LastUpdate'    =>  array(
                        'type'  =>  'string',
                        'format'    =>  'date-time'
                    ),
                    'TotalResults'  =>  array(
                        'type'  =>  'Integer'
                    ),
                ),
            ),
            'Agreement' =>  array(
                'type'  =>  'string',
                'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
            ),
        );
        $license_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed'
        );
        $term_use_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed',
            'required'  =>  array(
                'LastUpdate'    =>  0,
                'TotalResults'  =>  0,
                'Agreement' =>  0,
                'License'   =>  0,
                'TermOfUse' =>  0,
            ),
            'additionalProperties'  =>  false

        );


        $response = array(
            'status' => $status,
            'title' =>  $title_response,
            'host'  =>  $host_response,
            'produces'  =>  'application/json',
            'tags'  =>  $tags_response,
            'paths' =>  $paths_response,
            'parameters'    =>  $parameters_response,
            'responses' =>  $resp_response,
            'schema_and_meta_data'  =>  $schema_response,
            'license'   =>  $license_response,
            'termOfUse' =>  $term_use_response,
        );

        $this->response($response, $status);
      }


    }

    public function searchpersonpld_post(){
      $api_key_variable = $this->config->item('rest_key_name');
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      $apiK=$this->input->server($key_name);

      if ($this->form_validation->run('searchpersonpld_post')){
          //recibir valores
          $nombre= strtoupper(trim($this->post('nombre')));
            $apaterno= strtoupper(trim($this->post('apaterno')));
          $amaterno= strtoupper(trim($this->post('amaterno')));
          $tipo_busqueda= trim($this->post('tipo_busqueda'));
          $tipo_persona= strtoupper(trim($this->post('tipo_persona')));
          $curp= strtoupper(trim($this->post('curp')));
          $rfc= strtoupper(trim($this->post('rfc')));
            switch ($tipo_persona) {
              case 'FISICA':
                    $data = $this->post();
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $numeroC100_2=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $type= "f";
                    $rfc_ban 	= 0;

                    $full_name = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name2 = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia
                    $trimabuscar = trim($full_name);
                    $exist = false;
                    $this->load->helper('converter_to_uppercase');
                    if($tipo_busqueda=="EXACTA"){
                      $search = $this->busquedas_model->buscar_exacta_pld_dont_lpb(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp),$this->post('id_entidad'));
                      $search_lpb = $this->busquedas_model->buscar_exacta_lpb(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp),$this->post('id_entidad'));
                      //$search_unlocked = $this->busquedas_model->buscar_exacta_pld_dont_lpb(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp),'delete');
                      //$search_plb_unlocked = $this->busquedas_model->buscar_exacta_lpb(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp),$this->post('id_entidad'),'delete');
                      $tipoBusqueda='Busqueda exacta';
                    }
                    elseif ($tipo_busqueda=="EXTENDIDA"){
                      $search = $this->busquedas_model->buscar_extendidaapi_pld_dont_lpb(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
                     // $search_unlocked = $this->busquedas_model->buscar_extendidaapi_pld_dont_lpb(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
                      $search_lpb = $this->busquedas_model->buscar_extendidaapi_pld_lpb(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp),$this->post('id_entidad'));
                      //$search_lpb_unlocked = $this->busquedas_model->buscar_extendidaapi_pld_lpb(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp),$this->post('id_entidad'),'delete');
                      $tipoBusqueda='Busqueda extendida';
                    }
                    else{
                      $search = $this->busquedas_model->buscarApi_propld(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
                      $search_lpb = $this->busquedas_model->buscarApi_propld_lpb(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp),$this->post('id_entidad'));
                      //$search_unlocked = $this->busquedas_model->buscarApi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
                      $tipoBusqueda='Busqueda normal';

                    }
                    if (!empty($rfc)){
                      if ($this->busquedas_model->search_rfc($rfc) ){
                        $rfc_ban = 1;
                      }
                    }
                   /*if ($search)
                    {

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
                             $final[$num][6]=$stautus;
                             $final[$num][7]=round($porcentaje,2);
                             $num=$num+1;
                             $listas.=$fila->tipo." ";
                         }
                          //array bidimensional

                          $volumen= Array();

                          foreach ($final as $clave => $fila) {
                              $volumen[$clave] = $fila['7'];

                          }

                          // Ordenar los datos con volumen descendiente, edición ascendiente
                          // Agregar $datos como el último parámetro, para ordenar por la clave común
                          array_multisort($volumen, SORT_DESC,$final);
                          //echo json_encode($final);

                         $acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas);
                      }
                    }*/

                    $porcentaje = 0;
                    $result_busquedas = array();
                    $count_pld = 0;
                    foreach ($search as $ser){
                        $full_name = $ser->nombre . " " . $ser->apaterno . " " . $ser->amaterno;
                        $full_name = trim($full_name);
                        if ($rfc_ban == 0){
                            similar_text(strtoupper (converter_to_uppercase($full_name_search)), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
                        } else {
                            $porcentaje = 100;
                            $numeroC100=$numeroC100+1;
                        }
                        if(($ser->status)=='active'){
                          $stautus='Activo';
                        }else {
                          $stautus='Baja, fecha de baja: '.$ser->updated_at;
                        }
                        $listas .=$ser->tipo." ";
                        $array_search = array(
                            'id'    =>  $ser->id,
                            'full_name' =>  $full_name,
                            'pertenece' =>  $ser->pertenece,
                            'actividad' =>  $ser->actividad,
                            'fecha' =>  $ser->fecha,
                            'tipo'  =>  $ser->tipo,
                            'status'    =>  $stautus,
                            'porcentaje'    => round($porcentaje,2)
                        );

                        array_push($result_busquedas, $array_search);

                        $count_pld ++;
                    }

                    $count_lpb = 0;
                    foreach ($search_lpb as $serlpb){
                        $listas_lpb .=$serlpb->tipo." ";
                        $full_name = $serlpb->nombre . " " . $serlpb->apaterno . " " . $serlpb->amaterno;
                        $full_name = trim($full_name);
                        if ($rfc_ban == 0){
                            similar_text(strtoupper (converter_to_uppercase($full_name_search)), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
                        } else {
                            $porcentaje = 100;
                            $numeroC100_2 = $numeroC100_2+1;
                        }
                        if(($ser->status)=='active'){
                          $stautus='Activo';
                        }else {
                          $stautus='Baja, fecha de baja: '.$ser->updated_at;
                        }
                        $array_search_lpb = array(
                            'id'    =>  $serlpb->id,
                            'full_name' =>  $full_name,
                            'pertenece' =>  $serlpb->pertenece,
                            'actividad' =>  $serlpb->actividad,
                            'fecha' =>  $serlpb->fecha,
                            'tipo'  =>  $serlpb->tipo,
                            'porcentaje'    => round($porcentaje,2)
                        );

                        array_push($result_busquedas, $array_search_lpb);

                        $count_lpb ++;
                    }

                    $total_results = $count_pld + $count_lpb;
                    $total_listas = $listas.' '.$listas_lpb;
                    $total_numeroC100 = $numeroC100 + $numeroC100_2;

                    $acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$total_numeroC100,$total_results,$apiK,$total_listas);
                    if(!empty($result_busquedas)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'  =>  $result_busquedas
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                break;
              case 'MORAL':
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $trimabuscar = converter_to_uppercase(trim($nombre));
                    $exist = false;
                    $rfc_ban = 0;

                    if (!empty($rfc)){
                       if ($this->busquedas_model->search_rfc($rfc) ){
                          $rfc_ban = 1;
                       }
                    }
                    if($tipo_busqueda=="EXACTA"){
                      $search = $this->busquedas_model->buscar_exacta_mApi_pld($nombre,$rfc);
                      $search_lpb = $this->busquedas_model->buscar_exacta_mApi_pld_lpb($nombre,$rfc,$this->post('id_entidad'));
                      //$search_unlocked = $this->busquedas_model->buscar_exacta_mApi($nombre,$rfc,'delete');
                      $tipoBusqueda="Busqueda exacta";
                    }
                    elseif($tipo_busqueda=="EXTENDIDA"){
                      $search = $this->busquedas_model->buscar_extendida_mApi_propld($nombre,$rfc);
                      $search_lpb = $this->busquedas_model->buscar_extendida_mApi_propld_lpb($nombre,$rfc,$this->post('id_entidad'));
                      //$search_unlocked = $this->busquedas_model->buscar_extendida_mApi($nombre,$rfc);
                      $tipoBusqueda="Busqueda extendida";
                    }
                    else{
                      $search = $this->busquedas_model->buscarApi_propld($trimabuscar, $nombre, $apaterno = "", $amaterno = "", $rfc, $curp = "");
                      $search_lpb = $this->busquedas_model->buscarApi_propld_lpb($trimabuscar, $nombre, $apaterno = "", $amaterno = "", $rfc, $curp = "",$this->post('id_entidad'));
                      //$search_unlocked = $this->busquedas_model->buscarApi($trimabuscar, $nombre, $apaterno, $amaterno, $rfc, $curp, 0);
                      $tipoBusqueda="Busqueda normal";
                    }
                    /*if ($search)
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
                         }
                         else {
                           $stautus='Baja, fecha de baja: '.$fila->updated_at;
                         }
                         $final[$num][0]=$fila->id;
                         $final[$num][1]=$full_name;
                         $final[$num][2]=$fila->pertenece;
                         $final[$num][3]=$fila->actividad;
                         $final[$num][4]=$fila->fecha;
                         $final[$num][5]=$fila->tipo;
                         $final[$num][6]=$stautus;
                         $final[$num][7]=round($porcentaje,2);
                         $num=$num+1;
                         $listas.=$fila->tipo." ";
                       }
                       $volumen= Array();
                       foreach ($final as $clave => $fila) {
                           $volumen[$clave] = $fila['7'];
                       }
                       array_multisort($volumen, SORT_DESC,$final);
                    }
                    else{

                    }*/

                    $porcentaje = 0;
                    $result_busquedas = array();
                    $count_pld = 0;
                    foreach ($search as $ser){
                        $full_name = $ser->nombre . " " . $ser->apaterno . " " . $ser->amaterno;
                        $full_name = trim($full_name);
                        if ($rfc_ban == 0){
                            similar_text(strtoupper (converter_to_uppercase($full_name_search)), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
                        } else {
                            $porcentaje = 100;
                            $numeroC100=$numeroC100+1;
                        }
                        if(($ser->status)=='active'){
                          $stautus='Activo';
                        }else {
                          $stautus='Baja, fecha de baja: '.$ser->updated_at;
                        }
                        $listas .=$ser->tipo." ";
                        $array_search = array(
                            'id'    =>  $ser->id,
                            'full_name' =>  $full_name,
                            'pertenece' =>  $ser->pertenece,
                            'actividad' =>  $ser->actividad,
                            'fecha' =>  $ser->fecha,
                            'tipo'  =>  $ser->tipo,
                            'status'    =>  $stautus,
                            'porcentaje'    => round($porcentaje,2)
                        );

                        array_push($result_busquedas, $array_search);

                        $count_pld ++;
                    }

                    $count_lpb = 0;
                    foreach ($search_lpb as $serlpb){
                        $listas_lpb .=$serlpb->tipo." ";
                        $full_name = $serlpb->nombre . " " . $serlpb->apaterno . " " . $serlpb->amaterno;
                        $full_name = trim($full_name);
                        if ($rfc_ban == 0){
                            similar_text(strtoupper (converter_to_uppercase($full_name_search)), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
                        } else {
                            $porcentaje = 100;
                            $numeroC100_2 = $numeroC100_2+1;
                        }
                        if(($ser->status)=='active'){
                          $stautus='Activo';
                        }else {
                          $stautus='Baja, fecha de baja: '.$ser->updated_at;
                        }
                        $array_search_lpb = array(
                            'id'    =>  $serlpb->id,
                            'full_name' =>  $full_name,
                            'pertenece' =>  $serlpb->pertenece,
                            'actividad' =>  $serlpb->actividad,
                            'fecha' =>  $serlpb->fecha,
                            'tipo'  =>  $serlpb->tipo,
                            'porcentaje'    => round($porcentaje,2)
                        );

                        array_push($result_busquedas, $array_search_lpb);

                        $count_pld ++;
                    }

                    $total_results = $count_pld + $count_lpb;
                    $total_listas = $listas.' '.$listas_lpb;
                    $total_numeroC100 = $numeroC100 + $numeroC100_2;
                    //$acceso2 = $this->binnacle_model->buscar_personasAPI($nombre,$tipoBusqueda,'Persona Moral',$numeroC100,$num,$apiK,$listas);
                    $acceso2 = $this->binnacle_model->buscar_personasAPI($nombre,$tipoBusqueda,'Persona Moral',$total_numeroC100,$total_results,$apiK,$total_listas);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'  =>  $result_busquedas
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
              break;

              default:
                  $tokenData = true;
                  // Create a token
                  //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                  // Set HTTP status code
                  $status = parent::HTTP_BAD_REQUEST;
                  $title_response = array(
                    'swagger'   =>  '2.0',
                    'info'  =>  array(
                      'version'  =>   'v1.0.0',
                      'title' =>  'API Searchperson',
                      'description'   =>  'API to search persons or enterprise in diffent kind of list'
                    ),
                  );

                  $host_response = array(
                      'host'  =>  $_SERVER["HTTP_HOST"],
                      'basePath'  =>  $_SERVER["REQUEST_URI"],
                      //'schemes'   =>  $_SERVER['HTTPS']
                      'schemes'   =>  'on'
                  );

                  $tags_response = array(
                      'name'  =>  'Response',
                      'description'   =>  'api to verify response'
                  );
                  $paths_response = array(
                        '/test_resp' => array(
                            'post'  =>  array(
                                'tags'  => array(
                                    'name'  =>  'Busquedas'
                                  ),
                                'description'   =>  'Search in list',
                              ),
                        ),
                  );
                  $parameters_response = array(
                      'result'=>'Opcion no valida'
                      );
                  $resp_response = array(
                          200 =>  array(
                              'description'   =>  'The record was saved successfully',
                              'headers'   =>  array(
                                  'StrictTransportSecurity'   =>  array(
                                      'type'  =>  'string',
                                      'description'   =>  'HTTPS strict transport security header',
                                      'default'   =>  'max-age=31536000',
                                  ),
                              ),
                          ),
                          403 =>  array(
                            'description'   =>  'The record was saved successfully',
                            'headers'   =>  array(
                                'StrictTransportSecurity'   =>  array(
                                    'type'  =>  'string',
                                    'description'   =>  'HTTPS strict transport security header',
                                    'default'   =>  'max-age=31536000',
                                ),
                            ),
                          ),
                        'Etag'  =>  array(
                            'type'  => 'string',
                            'description'   =>  'No update'
                        ),
                        'Cache-control' =>  array(
                              'type'  =>  'string',
                              'description'   =>  'Describes how long this response can be cached',
                              'default'   =>  'max-age=15552000'
                          ),
                        'X-Frame-Options'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Prevent this request from being loaded in any iframes',
                            'default'  =>   'DENY',
                        ),
                        'X-Content-Type-Options'    =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                            'default'  =>   'nosniff',
                        ),
                    );
                  $schema_response = array(
                      'schema'    => array(
                          'type'  =>  'object'
                      ),
                      'properties'    =>  array(
                          'meta'  =>  array(
                              'title' =>  'Meta data',
                              'type'  =>  'object',
                          ),
                          'properties'    =>  array(
                              'LastUpdate'    =>  array(
                                  'type'  =>  'string',
                                  'format'    =>  'date-time'
                              ),
                              'TotalResults'  =>  array(
                                  'type'  =>  'Integer'
                              ),
                          ),
                      ),
                      'Agreement' =>  array(
                          'type'  =>  'string',
                          'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                      ),
                  );
                  $license_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed'
                  );
                  $term_use_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed',
                      'required'  =>  array(
                          'LastUpdate'    =>  0,
                          'TotalResults'  =>  0,
                          'Agreement' =>  0,
                          'License'   =>  0,
                          'TermOfUse' =>  0,
                      ),
                      'additionalProperties'  =>  false

                  );


                  $response = array(
                      'status' => $status,
                      'title' =>  $title_response,
                      'host'  =>  $host_response,
                      'produces'  =>  'application/json',
                      'tags'  =>  $tags_response,
                      'paths' =>  $paths_response,
                      'parameters'    =>  $parameters_response,
                      'responses' =>  $resp_response,
                      'schema_and_meta_data'  =>  $schema_response,
                      'license'   =>  $license_response,
                      'termOfUse' =>  $term_use_response,
                  );

                  $this->response($response, $status);
              break;
            }

      }else{
        $tokenData = true;
        // Create a token
        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
        // Set HTTP status code
        $status = parent::HTTP_BAD_REQUEST;
        $title_response = array(
          'swagger'   =>  '2.0',
          'info'  =>  array(
            'version'  =>   'v1.0.0',
            'title' =>  'API Searchperson',
            'description'   =>  'API to search persons or enterprise in diffent kind of list'
          ),
        );

        $host_response = array(
            'host'  =>  $_SERVER["HTTP_HOST"],
            'basePath'  =>  $_SERVER["REQUEST_URI"],
            //'schemes'   =>  $_SERVER['HTTPS']
            'schemes'   =>  'on'
        );

        $tags_response = array(
            'name'  =>  'Response',
            'description'   =>  'api to verify response'
        );
        $paths_response = array(
              '/test_resp' => array(
                  'post'  =>  array(
                      'tags'  => array(
                          'name'  =>  'Busquedas'
                        ),
                      'description'   =>  'Search in list',
                    ),
              ),
        );
        $parameters_response = array(
            'result'=>'Sus datos estan incompletos, verifiquelos '
            );
        $resp_response = array(
                200 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                ),
                403 =>  array(
                  'description'   =>  'The record was saved successfully',
                  'headers'   =>  array(
                      'StrictTransportSecurity'   =>  array(
                          'type'  =>  'string',
                          'description'   =>  'HTTPS strict transport security header',
                          'default'   =>  'max-age=31536000',
                      ),
                  ),
                ),
              'Etag'  =>  array(
                  'type'  => 'string',
                  'description'   =>  'No update'
              ),
              'Cache-control' =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Describes how long this response can be cached',
                    'default'   =>  'max-age=15552000'
                ),
              'X-Frame-Options'   =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Prevent this request from being loaded in any iframes',
                  'default'  =>   'DENY',
              ),
              'X-Content-Type-Options'    =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                  'default'  =>   'nosniff',
              ),
          );
        $schema_response = array(
            'schema'    => array(
                'type'  =>  'object'
            ),
            'properties'    =>  array(
                'meta'  =>  array(
                    'title' =>  'Meta data',
                    'type'  =>  'object',
                ),
                'properties'    =>  array(
                    'LastUpdate'    =>  array(
                        'type'  =>  'string',
                        'format'    =>  'date-time'
                    ),
                    'TotalResults'  =>  array(
                        'type'  =>  'Integer'
                    ),
                ),
            ),
            'Agreement' =>  array(
                'type'  =>  'string',
                'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
            ),
        );
        $license_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed'
        );
        $term_use_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed',
            'required'  =>  array(
                'LastUpdate'    =>  0,
                'TotalResults'  =>  0,
                'Agreement' =>  0,
                'License'   =>  0,
                'TermOfUse' =>  0,
            ),
            'additionalProperties'  =>  false

        );


        $response = array(
            'status' => $status,
            'title' =>  $title_response,
            'host'  =>  $host_response,
            'produces'  =>  'application/json',
            'tags'  =>  $tags_response,
            'paths' =>  $paths_response,
            'parameters'    =>  $parameters_response,
            'responses' =>  $resp_response,
            'schema_and_meta_data'  =>  $schema_response,
            'license'   =>  $license_response,
            'termOfUse' =>  $term_use_response,
        );

        $this->response($response, $status);
      }


    }

    public function searchpersonlpb_post() {
        $api_key_variable = $this->config->item('rest_key_name');
        $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
        $apiK = $this->input->server($key_name);

        if ($this->form_validation->run('searchpersonlpb_post')) {
            //recibir valores
            $nombre = strtoupper(trim($this->post('nombre')));
            $apaterno = strtoupper(trim($this->post('apaterno')));
            $amaterno = strtoupper(trim($this->post('amaterno')));
            $tipo_busqueda = trim($this->post('tipo_busqueda'));
            $tipo_persona = strtoupper(trim($this->post('tipo_persona')));
            $curp = strtoupper(trim($this->post('curp')));
            $rfc = strtoupper(trim($this->post('rfc')));
            switch ($tipo_persona) {
                case 'FISICA':
                    $data = $this->post();
                    $listas = "";
                    $tipoBusqueda = "";
                    $numeroC100 = 0;
                    $num = 0;
                    $final = Array();
                    $stautus = "";
                    $type = "f";
                    $rfc_ban = 0;

                    $full_name = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name2 = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia
                    $trimabuscar = trim($full_name);
                    $exist = false;
                    $this->load->helper('converter_to_uppercase');
                    if ($tipo_busqueda == "EXACTA") {
                        $search = $this->busquedas_model->buscarApi_propld_lpb(converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
                        $search_unlocked = $this->busquedas_model->buscar_exacta(converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
                        $tipoBusqueda = 'Busqueda exacta';
                    } elseif ($tipo_busqueda == "EXTENDIDA") {
                        $search = $this->busquedas_model->buscarApi_propld_lpb(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
                        $search_unlocked = $this->busquedas_model->buscar_extendidaapi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
                        $tipoBusqueda = 'Busqueda extendida';
                    } else {
                        $search = $this->busquedas_model->buscarApi_propld_lpb(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp),(int)$this->post('id_entidad'));
                        $search_unlocked = $this->busquedas_model->buscarApi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete',(int)$this->post('id_entidad'));
                        $tipoBusqueda = 'Busqueda normal';
                    }
                    if (!empty($rfc)) {
                        if ($this->busquedas_model->search_rfc($rfc)) {
                            $rfc_ban = 1;
                        }
                    }
                    if ($search) {

                        if (!empty($search)) {

                            $porcentaje = 0;
                            foreach ($search as $fila) {
                                $full_name = $fila->nombre . " " . $fila->apaterno . " " . $fila->amaterno;
                                $full_name = trim($full_name);
                                if ($rfc_ban == 0) {
                                    similar_text(strtoupper(converter_to_uppercase($full_name_search)), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
                                } else {
                                    $porcentaje = 100;
                                    $numeroC100 = $numeroC100 + 1;
                                }
                                if (($fila->status) == 'active') {
                                    $stautus = 'Activo';
                                } else {
                                    $stautus = 'Baja, fecha de baja: ' . $fila->updated_at;
                                }
                                $final[$num][0] = $fila->id;
                                $final[$num][1] = $full_name;
                                $final[$num][2] = $fila->pertenece;
                                $final[$num][3] = $fila->actividad;
                                $final[$num][4] = $fila->fecha;
                                $final[$num][5] = $fila->tipo;
                                $final[$num][6] = $stautus;
                                $final[$num][7] = round($porcentaje, 2);
                                $num = $num + 1;
                                $listas.=$fila->tipo . " ";
                            }
                            //array bidimensional

                            $volumen = Array();

                            foreach ($final as $clave => $fila) {
                                $volumen[$clave] = $fila['7'];
                            }

                            // Ordenar los datos con volumen descendiente, edición ascendiente
                            // Agregar $datos como el último parámetro, para ordenar por la clave común
                            array_multisort($volumen, SORT_DESC, $final);
                            //echo json_encode($final);

                            $acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2, $tipoBusqueda, 'Persona Fisica', $numeroC100, $num, $apiK, $listas);
                        }
                    }
                    if (!empty($final)) {
                        $tokenData = true;
                        // Create a token
                        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                        // Set HTTP status code
                        $status = parent::HTTP_OK;
                        $title_response = array(
                            'swagger' => '2.0',
                            'info' => array(
                                'version' => 'v1.0.0',
                                'title' => 'API Searchperson',
                                'description' => 'API to search persons or enterprise in diffent kind of list'
                            ),
                        );

                        $host_response = array(
                            'host' => $_SERVER["HTTP_HOST"],
                            'basePath' => $_SERVER["REQUEST_URI"],
                            //'schemes'   =>  $_SERVER['HTTPS']
                            'schemes' => 'on'
                        );

                        $tags_response = array(
                            'name' => 'Response',
                            'description' => 'api to verify response'
                        );
                        $paths_response = array(
                            '/test_resp' => array(
                                'post' => array(
                                    'tags' => array(
                                        'name' => 'Busquedas'
                                    ),
                                    'description' => 'Search in list',
                                ),
                            ),
                        );
                        $parameters_response = array(
                            'result' => $final
                        );
                        $resp_response = array(
                            200 => array(
                                'description' => 'The record was saved successfully',
                                'headers' => array(
                                    'StrictTransportSecurity' => array(
                                        'type' => 'string',
                                        'description' => 'HTTPS strict transport security header',
                                        'default' => 'max-age=31536000',
                                    ),
                                ),
                            ),
                            403 => array(
                                'description' => 'The record was saved successfully',
                                'headers' => array(
                                    'StrictTransportSecurity' => array(
                                        'type' => 'string',
                                        'description' => 'HTTPS strict transport security header',
                                        'default' => 'max-age=31536000',
                                    ),
                                ),
                            ),
                            'Etag' => array(
                                'type' => 'string',
                                'description' => 'No update'
                            ),
                            'Cache-control' => array(
                                'type' => 'string',
                                'description' => 'Describes how long this response can be cached',
                                'default' => 'max-age=15552000'
                            ),
                            'X-Frame-Options' => array(
                                'type' => 'string',
                                'description' => 'Prevent this request from being loaded in any iframes',
                                'default' => 'DENY',
                            ),
                            'X-Content-Type-Options' => array(
                                'type' => 'string',
                                'description' => 'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default' => 'nosniff',
                            ),
                        );
                        $schema_response = array(
                            'schema' => array(
                                'type' => 'object'
                            ),
                            'properties' => array(
                                'meta' => array(
                                    'title' => 'Meta data',
                                    'type' => 'object',
                                ),
                                'properties' => array(
                                    'LastUpdate' => array(
                                        'type' => 'string',
                                        'format' => 'date-time'
                                    ),
                                    'TotalResults' => array(
                                        'type' => 'Integer'
                                    ),
                                ),
                            ),
                            'Agreement' => array(
                                'type' => 'string',
                                'enum' => 'El uso de la API y el dato que sea intercambiado a través de esta será '
                            ),
                        );
                        $license_response = array(
                            'description' => 'To be confirmed',
                            'type' => 'string',
                            'format' => 'uri',
                            'enum' => 'To be confirmed'
                        );
                        $term_use_response = array(
                            'description' => 'To be confirmed',
                            'type' => 'string',
                            'format' => 'uri',
                            'enum' => 'To be confirmed',
                            'required' => array(
                                'LastUpdate' => 0,
                                'TotalResults' => 0,
                                'Agreement' => 0,
                                'License' => 0,
                                'TermOfUse' => 0,
                            ),
                            'additionalProperties' => false
                        );


                        $response = array(
                            'status' => $status,
                            'title' => $title_response,
                            'host' => $host_response,
                            'produces' => 'application/json',
                            'tags' => $tags_response,
                            'paths' => $paths_response,
                            'parameters' => $parameters_response,
                            'responses' => $resp_response,
                            'schema_and_meta_data' => $schema_response,
                            'license' => $license_response,
                            'termOfUse' => $term_use_response,
                        );

                        $this->response($response, $status);
                    } else {
                        $tokenData = true;
                        // Create a token
                        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                        // Set HTTP status code
                        $status = parent::HTTP_OK;
                        $title_response = array(
                            'swagger' => '2.0',
                            'info' => array(
                                'version' => 'v1.0.0',
                                'title' => 'API Searchperson',
                                'description' => 'API to search persons or enterprise in diffent kind of list'
                            ),
                        );

                        $host_response = array(
                            'host' => $_SERVER["HTTP_HOST"],
                            'basePath' => $_SERVER["REQUEST_URI"],
                            //'schemes'   =>  $_SERVER['HTTPS']
                            'schemes' => 'on'
                        );

                        $tags_response = array(
                            'name' => 'Response',
                            'description' => 'api to verify response'
                        );
                        $paths_response = array(
                            '/test_resp' => array(
                                'post' => array(
                                    'tags' => array(
                                        'name' => 'Busquedas'
                                    ),
                                    'description' => 'Search in list',
                                ),
                            ),
                        );
                        $parameters_response = array(
                            'result' => 'No existe la persona ingresada'
                        );
                        $resp_response = array(
                            200 => array(
                                'description' => 'The record was saved successfully',
                                'headers' => array(
                                    'StrictTransportSecurity' => array(
                                        'type' => 'string',
                                        'description' => 'HTTPS strict transport security header',
                                        'default' => 'max-age=31536000',
                                    ),
                                ),
                            ),
                            403 => array(
                                'description' => 'The record was saved successfully',
                                'headers' => array(
                                    'StrictTransportSecurity' => array(
                                        'type' => 'string',
                                        'description' => 'HTTPS strict transport security header',
                                        'default' => 'max-age=31536000',
                                    ),
                                ),
                            ),
                            'Etag' => array(
                                'type' => 'string',
                                'description' => 'No update'
                            ),
                            'Cache-control' => array(
                                'type' => 'string',
                                'description' => 'Describes how long this response can be cached',
                                'default' => 'max-age=15552000'
                            ),
                            'X-Frame-Options' => array(
                                'type' => 'string',
                                'description' => 'Prevent this request from being loaded in any iframes',
                                'default' => 'DENY',
                            ),
                            'X-Content-Type-Options' => array(
                                'type' => 'string',
                                'description' => 'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default' => 'nosniff',
                            ),
                        );
                        $schema_response = array(
                            'schema' => array(
                                'type' => 'object'
                            ),
                            'properties' => array(
                                'meta' => array(
                                    'title' => 'Meta data',
                                    'type' => 'object',
                                ),
                                'properties' => array(
                                    'LastUpdate' => array(
                                        'type' => 'string',
                                        'format' => 'date-time'
                                    ),
                                    'TotalResults' => array(
                                        'type' => 'Integer'
                                    ),
                                ),
                            ),
                            'Agreement' => array(
                                'type' => 'string',
                                'enum' => 'El uso de la API y el dato que sea intercambiado a través de esta será '
                            ),
                        );
                        $license_response = array(
                            'description' => 'To be confirmed',
                            'type' => 'string',
                            'format' => 'uri',
                            'enum' => 'To be confirmed'
                        );
                        $term_use_response = array(
                            'description' => 'To be confirmed',
                            'type' => 'string',
                            'format' => 'uri',
                            'enum' => 'To be confirmed',
                            'required' => array(
                                'LastUpdate' => 0,
                                'TotalResults' => 0,
                                'Agreement' => 0,
                                'License' => 0,
                                'TermOfUse' => 0,
                            ),
                            'additionalProperties' => false
                        );


                        $response = array(
                            'status' => $status,
                            'title' => $title_response,
                            'host' => $host_response,
                            'produces' => 'application/json',
                            'tags' => $tags_response,
                            'paths' => $paths_response,
                            'parameters' => $parameters_response,
                            'responses' => $resp_response,
                            'schema_and_meta_data' => $schema_response,
                            'license' => $license_response,
                            'termOfUse' => $term_use_response,
                        );

                        $this->response($response, $status);
                    }
                    break;
                case 'MORAL':
                    $listas = "";
                    $tipoBusqueda = "";
                    $numeroC100 = 0;
                    $num = 0;
                    $final = Array();
                    $stautus = "";
                    $trimabuscar = converter_to_uppercase(trim($nombre));
                    $exist = false;
                    $rfc_ban = 0;

                    if (!empty($rfc)) {
                        if ($this->busquedas_model->search_rfc($rfc)) {
                            $rfc_ban = 1;
                        }
                    }
                    if ($tipo_busqueda == "EXACTA") {
                        $search = $this->busquedas_model->buscar_exacta_mApi($nombre, $rfc);
                        $search_unlocked = $this->busquedas_model->buscar_exacta_mApi($nombre, $rfc, 'delete');
                        $tipoBusqueda = "Busqueda exacta";
                    } elseif ($tipo_busqueda == "EXTENDIDA") {
                        $search = $this->busquedas_model->buscar_extendida_mApi($nombre, $rfc);
                        $search_unlocked = $this->busquedas_model->buscar_extendida_mApi($nombre, $rfc);
                        $tipoBusqueda = "Busqueda extendida";
                    } else {
                        $search = $this->busquedas_model->buscarApi_propld_lpb($trimabuscar, $nombre, $apaterno = "", $amaterno = "", $rfc, $curp = "");
                        $search_unlocked = $this->busquedas_model->buscarApi($trimabuscar, $nombre, $apaterno, $amaterno, $rfc, $curp, 'active',1500);
                        $tipoBusqueda = "Busqueda normal";
                    }
                    if ($search) {
                        $porcentaje = 0;
                        foreach ($search as $fila) {
                            $full_name = $fila->nombre;
                            if ($rfc_ban == 0) {
                                similar_text(converter_to_uppercase($trimabuscar), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
                                //$numeroC100=$numeroC100+1;
                            } else {
                                $porcentaje = 100;
                                $numeroC100 = $numeroC100 + 1;
                            }
                            if (($fila->status) == 'active') {
                                $stautus = 'Activo';
                            } else {
                                $stautus = 'Baja, fecha de baja: ' . $fila->updated_at;
                            }
                            $final[$num][0] = $fila->id;
                            $final[$num][1] = $full_name;
                            $final[$num][2] = $fila->pertenece;
                            $final[$num][3] = $fila->actividad;
                            $final[$num][4] = $fila->fecha;
                            $final[$num][5] = $fila->tipo;
                            $final[$num][6] = $stautus;
                            $final[$num][7] = round($porcentaje, 2);
                            $num = $num + 1;
                            $listas.=$fila->tipo . " ";
                        }
                        $volumen = Array();
                        foreach ($final as $clave => $fila) {
                            $volumen[$clave] = $fila['7'];
                        }
                        array_multisort($volumen, SORT_DESC, $final);
                    } else {

                    }
                    $acceso2 = $this->binnacle_model->buscar_personasAPI($nombre, $tipoBusqueda, 'Persona Moral', $numeroC100, $num, $apiK, $listas);
                    if (!empty($final)) {
                        $tokenData = true;
                        // Create a token
                        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                        // Set HTTP status code
                        $status = parent::HTTP_OK;
                        $title_response = array(
                            'swagger' => '2.0',
                            'info' => array(
                                'version' => 'v1.0.0',
                                'title' => 'API Searchperson',
                                'description' => 'API to search persons or enterprise in diffent kind of list'
                            ),
                        );

                        $host_response = array(
                            'host' => $_SERVER["HTTP_HOST"],
                            'basePath' => $_SERVER["REQUEST_URI"],
                            //'schemes'   =>  $_SERVER['HTTPS']
                            'schemes' => 'on'
                        );

                        $tags_response = array(
                            'name' => 'Response',
                            'description' => 'api to verify response'
                        );
                        $paths_response = array(
                            '/test_resp' => array(
                                'post' => array(
                                    'tags' => array(
                                        'name' => 'Busquedas'
                                    ),
                                    'description' => 'Search in list',
                                ),
                            ),
                        );
                        $parameters_response = array(
                            'result' => $final
                        );
                        $resp_response = array(
                            200 => array(
                                'description' => 'The record was saved successfully',
                                'headers' => array(
                                    'StrictTransportSecurity' => array(
                                        'type' => 'string',
                                        'description' => 'HTTPS strict transport security header',
                                        'default' => 'max-age=31536000',
                                    ),
                                ),
                            ),
                            403 => array(
                                'description' => 'The record was saved successfully',
                                'headers' => array(
                                    'StrictTransportSecurity' => array(
                                        'type' => 'string',
                                        'description' => 'HTTPS strict transport security header',
                                        'default' => 'max-age=31536000',
                                    ),
                                ),
                            ),
                            'Etag' => array(
                                'type' => 'string',
                                'description' => 'No update'
                            ),
                            'Cache-control' => array(
                                'type' => 'string',
                                'description' => 'Describes how long this response can be cached',
                                'default' => 'max-age=15552000'
                            ),
                            'X-Frame-Options' => array(
                                'type' => 'string',
                                'description' => 'Prevent this request from being loaded in any iframes',
                                'default' => 'DENY',
                            ),
                            'X-Content-Type-Options' => array(
                                'type' => 'string',
                                'description' => 'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default' => 'nosniff',
                            ),
                        );
                        $schema_response = array(
                            'schema' => array(
                                'type' => 'object'
                            ),
                            'properties' => array(
                                'meta' => array(
                                    'title' => 'Meta data',
                                    'type' => 'object',
                                ),
                                'properties' => array(
                                    'LastUpdate' => array(
                                        'type' => 'string',
                                        'format' => 'date-time'
                                    ),
                                    'TotalResults' => array(
                                        'type' => 'Integer'
                                    ),
                                ),
                            ),
                            'Agreement' => array(
                                'type' => 'string',
                                'enum' => 'El uso de la API y el dato que sea intercambiado a través de esta será '
                            ),
                        );
                        $license_response = array(
                            'description' => 'To be confirmed',
                            'type' => 'string',
                            'format' => 'uri',
                            'enum' => 'To be confirmed'
                        );
                        $term_use_response = array(
                            'description' => 'To be confirmed',
                            'type' => 'string',
                            'format' => 'uri',
                            'enum' => 'To be confirmed',
                            'required' => array(
                                'LastUpdate' => 0,
                                'TotalResults' => 0,
                                'Agreement' => 0,
                                'License' => 0,
                                'TermOfUse' => 0,
                            ),
                            'additionalProperties' => false
                        );


                        $response = array(
                            'status' => $status,
                            'title' => $title_response,
                            'host' => $host_response,
                            'produces' => 'application/json',
                            'tags' => $tags_response,
                            'paths' => $paths_response,
                            'parameters' => $parameters_response,
                            'responses' => $resp_response,
                            'schema_and_meta_data' => $schema_response,
                            'license' => $license_response,
                            'termOfUse' => $term_use_response,
                        );

                        $this->response($response, $status);
                    } else {
                        $tokenData = true;
                        // Create a token
                        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                        // Set HTTP status code
                        $status = parent::HTTP_OK;
                        $title_response = array(
                            'swagger' => '2.0',
                            'info' => array(
                                'version' => 'v1.0.0',
                                'title' => 'API Searchperson',
                                'description' => 'API to search persons or enterprise in diffent kind of list'
                            ),
                        );

                        $host_response = array(
                            'host' => $_SERVER["HTTP_HOST"],
                            'basePath' => $_SERVER["REQUEST_URI"],
                            //'schemes'   =>  $_SERVER['HTTPS']
                            'schemes' => 'on'
                        );

                        $tags_response = array(
                            'name' => 'Response',
                            'description' => 'api to verify response'
                        );
                        $paths_response = array(
                            '/test_resp' => array(
                                'post' => array(
                                    'tags' => array(
                                        'name' => 'Busquedas'
                                    ),
                                    'description' => 'Search in list',
                                ),
                            ),
                        );
                        $parameters_response = array(
                            'result' => 'No existe la persona ingresada'
                        );
                        $resp_response = array(
                            200 => array(
                                'description' => 'The record was saved successfully',
                                'headers' => array(
                                    'StrictTransportSecurity' => array(
                                        'type' => 'string',
                                        'description' => 'HTTPS strict transport security header',
                                        'default' => 'max-age=31536000',
                                    ),
                                ),
                            ),
                            403 => array(
                                'description' => 'The record was saved successfully',
                                'headers' => array(
                                    'StrictTransportSecurity' => array(
                                        'type' => 'string',
                                        'description' => 'HTTPS strict transport security header',
                                        'default' => 'max-age=31536000',
                                    ),
                                ),
                            ),
                            'Etag' => array(
                                'type' => 'string',
                                'description' => 'No update'
                            ),
                            'Cache-control' => array(
                                'type' => 'string',
                                'description' => 'Describes how long this response can be cached',
                                'default' => 'max-age=15552000'
                            ),
                            'X-Frame-Options' => array(
                                'type' => 'string',
                                'description' => 'Prevent this request from being loaded in any iframes',
                                'default' => 'DENY',
                            ),
                            'X-Content-Type-Options' => array(
                                'type' => 'string',
                                'description' => 'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default' => 'nosniff',
                            ),
                        );
                        $schema_response = array(
                            'schema' => array(
                                'type' => 'object'
                            ),
                            'properties' => array(
                                'meta' => array(
                                    'title' => 'Meta data',
                                    'type' => 'object',
                                ),
                                'properties' => array(
                                    'LastUpdate' => array(
                                        'type' => 'string',
                                        'format' => 'date-time'
                                    ),
                                    'TotalResults' => array(
                                        'type' => 'Integer'
                                    ),
                                ),
                            ),
                            'Agreement' => array(
                                'type' => 'string',
                                'enum' => 'El uso de la API y el dato que sea intercambiado a través de esta será '
                            ),
                        );
                        $license_response = array(
                            'description' => 'To be confirmed',
                            'type' => 'string',
                            'format' => 'uri',
                            'enum' => 'To be confirmed'
                        );
                        $term_use_response = array(
                            'description' => 'To be confirmed',
                            'type' => 'string',
                            'format' => 'uri',
                            'enum' => 'To be confirmed',
                            'required' => array(
                                'LastUpdate' => 0,
                                'TotalResults' => 0,
                                'Agreement' => 0,
                                'License' => 0,
                                'TermOfUse' => 0,
                            ),
                            'additionalProperties' => false
                        );


                        $response = array(
                            'status' => $status,
                            'title' => $title_response,
                            'host' => $host_response,
                            'produces' => 'application/json',
                            'tags' => $tags_response,
                            'paths' => $paths_response,
                            'parameters' => $parameters_response,
                            'responses' => $resp_response,
                            'schema_and_meta_data' => $schema_response,
                            'license' => $license_response,
                            'termOfUse' => $term_use_response,
                        );

                        $this->response($response, $status);
                    }
                    break;

                default:
                    $tokenData = true;
                    // Create a token
                    //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                    // Set HTTP status code
                    $status = parent::HTTP_BAD_REQUEST;
                    $title_response = array(
                        'swagger' => '2.0',
                        'info' => array(
                            'version' => 'v1.0.0',
                            'title' => 'API Searchperson',
                            'description' => 'API to search persons or enterprise in diffent kind of list'
                        ),
                    );

                    $host_response = array(
                        'host' => $_SERVER["HTTP_HOST"],
                        'basePath' => $_SERVER["REQUEST_URI"],
                        //'schemes'   =>  $_SERVER['HTTPS']
                        'schemes' => 'on'
                    );

                    $tags_response = array(
                        'name' => 'Response',
                        'description' => 'api to verify response'
                    );
                    $paths_response = array(
                        '/test_resp' => array(
                            'post' => array(
                                'tags' => array(
                                    'name' => 'Busquedas'
                                ),
                                'description' => 'Search in list',
                            ),
                        ),
                    );
                    $parameters_response = array(
                        'result' => 'Opcion no valida'
                    );
                    $resp_response = array(
                        200 => array(
                            'description' => 'The record was saved successfully',
                            'headers' => array(
                                'StrictTransportSecurity' => array(
                                    'type' => 'string',
                                    'description' => 'HTTPS strict transport security header',
                                    'default' => 'max-age=31536000',
                                ),
                            ),
                        ),
                        403 => array(
                            'description' => 'The record was saved successfully',
                            'headers' => array(
                                'StrictTransportSecurity' => array(
                                    'type' => 'string',
                                    'description' => 'HTTPS strict transport security header',
                                    'default' => 'max-age=31536000',
                                ),
                            ),
                        ),
                        'Etag' => array(
                            'type' => 'string',
                            'description' => 'No update'
                        ),
                        'Cache-control' => array(
                            'type' => 'string',
                            'description' => 'Describes how long this response can be cached',
                            'default' => 'max-age=15552000'
                        ),
                        'X-Frame-Options' => array(
                            'type' => 'string',
                            'description' => 'Prevent this request from being loaded in any iframes',
                            'default' => 'DENY',
                        ),
                        'X-Content-Type-Options' => array(
                            'type' => 'string',
                            'description' => 'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                            'default' => 'nosniff',
                        ),
                    );
                    $schema_response = array(
                        'schema' => array(
                            'type' => 'object'
                        ),
                        'properties' => array(
                            'meta' => array(
                                'title' => 'Meta data',
                                'type' => 'object',
                            ),
                            'properties' => array(
                                'LastUpdate' => array(
                                    'type' => 'string',
                                    'format' => 'date-time'
                                ),
                                'TotalResults' => array(
                                    'type' => 'Integer'
                                ),
                            ),
                        ),
                        'Agreement' => array(
                            'type' => 'string',
                            'enum' => 'El uso de la API y el dato que sea intercambiado a través de esta será '
                        ),
                    );
                    $license_response = array(
                        'description' => 'To be confirmed',
                        'type' => 'string',
                        'format' => 'uri',
                        'enum' => 'To be confirmed'
                    );
                    $term_use_response = array(
                        'description' => 'To be confirmed',
                        'type' => 'string',
                        'format' => 'uri',
                        'enum' => 'To be confirmed',
                        'required' => array(
                            'LastUpdate' => 0,
                            'TotalResults' => 0,
                            'Agreement' => 0,
                            'License' => 0,
                            'TermOfUse' => 0,
                        ),
                        'additionalProperties' => false
                    );


                    $response = array(
                        'status' => $status,
                        'title' => $title_response,
                        'host' => $host_response,
                        'produces' => 'application/json',
                        'tags' => $tags_response,
                        'paths' => $paths_response,
                        'parameters' => $parameters_response,
                        'responses' => $resp_response,
                        'schema_and_meta_data' => $schema_response,
                        'license' => $license_response,
                        'termOfUse' => $term_use_response,
                    );

                    $this->response($response, $status);
                    break;
            }
        } else {
            $tokenData = true;
            // Create a token
            //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
            // Set HTTP status code
            $status = parent::HTTP_BAD_REQUEST;
            $title_response = array(
                'swagger' => '2.0',
                'info' => array(
                    'version' => 'v1.0.0',
                    'title' => 'API Searchperson',
                    'description' => 'API to search persons or enterprise in diffent kind of list'
                ),
            );

            $host_response = array(
                'host' => $_SERVER["HTTP_HOST"],
                'basePath' => $_SERVER["REQUEST_URI"],
                //'schemes'   =>  $_SERVER['HTTPS']
                'schemes' => 'on'
            );

            $tags_response = array(
                'name' => 'Response',
                'description' => 'api to verify response'
            );
            $paths_response = array(
                '/test_resp' => array(
                    'post' => array(
                        'tags' => array(
                            'name' => 'Busquedas'
                        ),
                        'description' => 'Search in list',
                    ),
                ),
            );
            $parameters_response = array(
                'result' => 'Sus datos estan incompletos, verifiquelos '
            );
            $resp_response = array(
                200 => array(
                    'description' => 'The record was saved successfully',
                    'headers' => array(
                        'StrictTransportSecurity' => array(
                            'type' => 'string',
                            'description' => 'HTTPS strict transport security header',
                            'default' => 'max-age=31536000',
                        ),
                    ),
                ),
                403 => array(
                    'description' => 'The record was saved successfully',
                    'headers' => array(
                        'StrictTransportSecurity' => array(
                            'type' => 'string',
                            'description' => 'HTTPS strict transport security header',
                            'default' => 'max-age=31536000',
                        ),
                    ),
                ),
                'Etag' => array(
                    'type' => 'string',
                    'description' => 'No update'
                ),
                'Cache-control' => array(
                    'type' => 'string',
                    'description' => 'Describes how long this response can be cached',
                    'default' => 'max-age=15552000'
                ),
                'X-Frame-Options' => array(
                    'type' => 'string',
                    'description' => 'Prevent this request from being loaded in any iframes',
                    'default' => 'DENY',
                ),
                'X-Content-Type-Options' => array(
                    'type' => 'string',
                    'description' => 'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                    'default' => 'nosniff',
                ),
            );
            $schema_response = array(
                'schema' => array(
                    'type' => 'object'
                ),
                'properties' => array(
                    'meta' => array(
                        'title' => 'Meta data',
                        'type' => 'object',
                    ),
                    'properties' => array(
                        'LastUpdate' => array(
                            'type' => 'string',
                            'format' => 'date-time'
                        ),
                        'TotalResults' => array(
                            'type' => 'Integer'
                        ),
                    ),
                ),
                'Agreement' => array(
                    'type' => 'string',
                    'enum' => 'El uso de la API y el dato que sea intercambiado a través de esta será '
                ),
            );
            $license_response = array(
                'description' => 'To be confirmed',
                'type' => 'string',
                'format' => 'uri',
                'enum' => 'To be confirmed'
            );
            $term_use_response = array(
                'description' => 'To be confirmed',
                'type' => 'string',
                'format' => 'uri',
                'enum' => 'To be confirmed',
                'required' => array(
                    'LastUpdate' => 0,
                    'TotalResults' => 0,
                    'Agreement' => 0,
                    'License' => 0,
                    'TermOfUse' => 0,
                ),
                'additionalProperties' => false
            );


            $response = array(
                'status' => $status,
                'title' => $title_response,
                'host' => $host_response,
                'produces' => 'application/json',
                'tags' => $tags_response,
                'paths' => $paths_response,
                'parameters' => $parameters_response,
                'responses' => $resp_response,
                'schema_and_meta_data' => $schema_response,
                'license' => $license_response,
                'termOfUse' => $term_use_response,
            );

            $this->response($response, $status);
        }
    }



    public function searchpersonPruebas_post(){
      $api_key_variable = $this->config->item('rest_key_name');
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      $apiK=$this->input->server($key_name);

      if ($this->form_validation->run('searchpersonPruebas_post')){
          //recibir valores
          $nombre= strtoupper(trim($this->post('nombre')));
          $apaterno= strtoupper(trim($this->post('apaterno')));
          $amaterno= strtoupper(trim($this->post('amaterno')));
          $id_entidad=$this->post('id_entidad');
          $data = $this->post();
          $listas="";
          $tipoBusqueda="";
          $numeroC100=0;
          $numeroC100_2=0;
          $num=0;
          $final = Array();
          $stautus="";
          $type= "f";
          $rfc_ban 	= 0;

          $full_name = $nombre . " " . $apaterno . " " . $amaterno;
          $full_name2 = $nombre . " " . $apaterno . " " . $amaterno;
          $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia
          $trimabuscar = trim($full_name);
          $exist = false;
          $this->load->helper('converter_to_uppercase');
          $search = $this->busquedas_model->buscarPruebas(converter_to_uppercase($trimabuscar),$id_entidad);
          $tipoBusqueda='Busqueda normal';

          $porcentaje = 0;
          $result_busquedas = array();
          $count_pld = 0;
          foreach ($search as $ser){
              $full_name = $ser->nombre . " " . $ser->apaterno . " " . $ser->amaterno;
              $full_name = trim($full_name);
              if ($rfc_ban == 0){
                similar_text(strtoupper (converter_to_uppercase($full_name_search)), converter_to_uppercase($full_name), $porcentaje); //AL porcentaje de coincidencias
              }
              else {
                    $porcentaje = 100;
                    $numeroC100=$numeroC100+1;
              }
              if(($ser->status)=='active'){
                  $stautus='Activo';
              }
              else {
                  $stautus='Baja, fecha de baja: '.$ser->updated_at;
              }
              $listas .=$ser->tipo." ";
              $array_search = array(
                  'id'    =>  $ser->id,
                  'full_name' =>  $full_name,
                  'pertenece' =>  $ser->pertenece,
                  'actividad' =>  $ser->actividad,
                  'fecha' =>  $ser->fecha,
                  'tipo'  =>  $ser->tipo,
                  'status'    =>  $stautus,
                  'porcentaje'    => round($porcentaje,2)
              );

              array_push($result_busquedas, $array_search);
              $count_pld ++;
            }

                    $count_lpb = 0;
                    if(!empty($result_busquedas)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'  =>  $result_busquedas
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }





      }
      else{
        $tokenData = true;
        $status = parent::HTTP_BAD_REQUEST;
        $title_response = array(
          'swagger'   =>  '2.0',
          'info'  =>  array(
            'version'  =>   'v1.0.0',
            'title' =>  'API Searchperson',
            'description'   =>  'API to search persons or enterprise in diffent kind of list'
          ),
        );

        $host_response = array(
            'host'  =>  $_SERVER["HTTP_HOST"],
            'basePath'  =>  $_SERVER["REQUEST_URI"],
            //'schemes'   =>  $_SERVER['HTTPS']
            'schemes'   =>  'on'
        );

        $tags_response = array(
            'name'  =>  'Response',
            'description'   =>  'api to verify response'
        );
        $paths_response = array(
              '/test_resp' => array(
                  'post'  =>  array(
                      'tags'  => array(
                          'name'  =>  'Busquedas'
                        ),
                      'description'   =>  'Search in list',
                    ),
              ),
        );
        $parameters_response = array(
            'result'=>'Sus datos estan incompletos, verifiquelos '
            );
        $resp_response = array(
                200 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                ),
                403 =>  array(
                  'description'   =>  'The record was saved successfully',
                  'headers'   =>  array(
                      'StrictTransportSecurity'   =>  array(
                          'type'  =>  'string',
                          'description'   =>  'HTTPS strict transport security header',
                          'default'   =>  'max-age=31536000',
                      ),
                  ),
                ),
              'Etag'  =>  array(
                  'type'  => 'string',
                  'description'   =>  'No update'
              ),
              'Cache-control' =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Describes how long this response can be cached',
                    'default'   =>  'max-age=15552000'
                ),
              'X-Frame-Options'   =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Prevent this request from being loaded in any iframes',
                  'default'  =>   'DENY',
              ),
              'X-Content-Type-Options'    =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                  'default'  =>   'nosniff',
              ),
          );
        $schema_response = array(
            'schema'    => array(
                'type'  =>  'object'
            ),
            'properties'    =>  array(
                'meta'  =>  array(
                    'title' =>  'Meta data',
                    'type'  =>  'object',
                ),
                'properties'    =>  array(
                    'LastUpdate'    =>  array(
                        'type'  =>  'string',
                        'format'    =>  'date-time'
                    ),
                    'TotalResults'  =>  array(
                        'type'  =>  'Integer'
                    ),
                ),
            ),
            'Agreement' =>  array(
                'type'  =>  'string',
                'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
            ),
        );
        $license_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed'
        );
        $term_use_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed',
            'required'  =>  array(
                'LastUpdate'    =>  0,
                'TotalResults'  =>  0,
                'Agreement' =>  0,
                'License'   =>  0,
                'TermOfUse' =>  0,
            ),
            'additionalProperties'  =>  false

        );


        $response = array(
            'status' => $status,
            'title' =>  $title_response,
            'host'  =>  $host_response,
            'produces'  =>  'application/json',
            'tags'  =>  $tags_response,
            'paths' =>  $paths_response,
            'parameters'    =>  $parameters_response,
            'responses' =>  $resp_response,
            'schema_and_meta_data'  =>  $schema_response,
            'license'   =>  $license_response,
            'termOfUse' =>  $term_use_response,
        );

        $this->response($response, $status);
      }
    }

    public function searchpersonYTP_post(){
      $api_key_variable = $this->config->item('rest_key_name');
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      $apiK=$this->input->server($key_name);
      $entidad=  $this->binnacle_model->getID($apiK);

      if ($this->form_validation->run('searchperson_post')){
          //recibir valores
          $nombre= strtoupper(trim($this->post('nombre')));
            $apaterno= strtoupper(trim($this->post('apaterno')));
          $amaterno= strtoupper(trim($this->post('amaterno')));
          $tipo_busqueda= trim($this->post('tipo_busqueda'));
          $tipo_persona= strtoupper(trim($this->post('tipo_persona')));
          $curp= strtoupper(trim($this->post('curp')));
          $rfc= strtoupper(trim($this->post('rfc')));
            switch ($tipo_persona) {
              case 'FISICA':
                    $data = $this->post();
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $type= "f";
                    $rfc_ban 	= 0;

                    $full_name = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name2 = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia
                    $trimabuscar = trim($full_name);
                    $exist = false;
                    $this->load->helper('converter_to_uppercase');

                      $search = $this->busquedas_model->busquedaYotepresto(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno),$rfc);
                      $tipoBusqueda='Busqueda normal';

                    if ($search)
                    {

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
                            $porcentaje==round($porcentaje,2);
                            if($porcentaje <'89.99%' and ($apiK=='KYC-omkM5J7jJprtyxO4p8NPfEY0va7BYRH/J7s28Q==' or $apiK=='KYC-gmlY9YuxM5v810m0ncx4bw1w3vSyJw==') ){


                            }
                            else{
                            $final[$num][0]=$fila->id;
                             $final[$num][1]=$full_name;
                             $final[$num][2]=$fila->pertenece;
                             $final[$num][3]=$fila->actividad;
                             $final[$num][4]=$fila->fecha;
                             $final[$num][5]=$fila->tipo;
                             $final[$num][6]=$stautus;
                             $final[$num][7]=round($porcentaje,2);
                             $num=$num+1;
                             $listas.=$fila->tipo." ";
                           }
                         }
                          //array bidimensional

                          $volumen= Array();

                          foreach ($final as $clave => $fila) {
                              $volumen[$clave] = $fila['7'];

                          }

                          // Ordenar los datos con volumen descendiente, edición ascendiente
                          // Agregar $datos como el último parámetro, para ordenar por la clave común
                          array_multisort($volumen, SORT_DESC,$final);
                          //echo json_encode($final);

                         //$acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas);
                      }
                    }
                    $acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica YTP',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                break;
              case 'MORAL':
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $trimabuscar = converter_to_uppercase(trim($nombre));
                    $exist = false;
                    $rfc_ban = 0;


                      $id=1500;
                      $search = $this->busquedas_model->busquedaYoteprestoM($nombre,$rfc);
                      $tipoBusqueda="Busqueda normal";

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
                         }
                         else {
                           $stautus='Baja, fecha de baja: '.$fila->updated_at;
                         }
                         $porcentaje==round($porcentaje,2);
                         if($porcentaje<'89.99%' and ($apiK=='KYC-omkM5J7jJprtyxO4p8NPfEY0va7BYRH/J7s28Q==' or $apiK=='KYC-gmlY9YuxM5v810m0ncx4bw1w3vSyJw==') ){

                          }
                         else{
                         $final[$num][0]=$fila->id;
                         $final[$num][1]=$full_name;
                         $final[$num][2]=$fila->pertenece;
                         $final[$num][3]=$fila->actividad;
                         $final[$num][4]=$fila->fecha;
                         $final[$num][5]=$fila->tipo;
                         $final[$num][6]=$stautus;
                         $final[$num][7]=round($porcentaje,2);
                         $num=$num+1;
                         $listas.=$fila->tipo." ";
                       }
                       }
                       $volumen= Array();
                       foreach ($final as $clave => $fila) {
                           $volumen[$clave] = $fila['7'];
                       }
                       array_multisort($volumen, SORT_DESC,$final);
                    }
                    else{

                    }
                    $acceso2 = $this->binnacle_model->buscar_personasAPI($nombre,$tipoBusqueda,'Persona Moral YTP',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
              break;

              default:
                  $tokenData = true;
                  // Create a token
                  //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                  // Set HTTP status code
                  $status = parent::HTTP_BAD_REQUEST;
                  $title_response = array(
                    'swagger'   =>  '2.0',
                    'info'  =>  array(
                      'version'  =>   'v1.0.0',
                      'title' =>  'API Searchperson',
                      'description'   =>  'API to search persons or enterprise in diffent kind of list'
                    ),
                  );

                  $host_response = array(
                      'host'  =>  $_SERVER["HTTP_HOST"],
                      'basePath'  =>  $_SERVER["REQUEST_URI"],
                      //'schemes'   =>  $_SERVER['HTTPS']
                      'schemes'   =>  'on'
                  );

                  $tags_response = array(
                      'name'  =>  'Response',
                      'description'   =>  'api to verify response'
                  );
                  $paths_response = array(
                        '/test_resp' => array(
                            'post'  =>  array(
                                'tags'  => array(
                                    'name'  =>  'Busquedas'
                                  ),
                                'description'   =>  'Search in list',
                              ),
                        ),
                  );
                  $parameters_response = array(
                      'result'=>'Opcion no valida'
                      );
                  $resp_response = array(
                          200 =>  array(
                              'description'   =>  'The record was saved successfully',
                              'headers'   =>  array(
                                  'StrictTransportSecurity'   =>  array(
                                      'type'  =>  'string',
                                      'description'   =>  'HTTPS strict transport security header',
                                      'default'   =>  'max-age=31536000',
                                  ),
                              ),
                          ),
                          403 =>  array(
                            'description'   =>  'The record was saved successfully',
                            'headers'   =>  array(
                                'StrictTransportSecurity'   =>  array(
                                    'type'  =>  'string',
                                    'description'   =>  'HTTPS strict transport security header',
                                    'default'   =>  'max-age=31536000',
                                ),
                            ),
                          ),
                        'Etag'  =>  array(
                            'type'  => 'string',
                            'description'   =>  'No update'
                        ),
                        'Cache-control' =>  array(
                              'type'  =>  'string',
                              'description'   =>  'Describes how long this response can be cached',
                              'default'   =>  'max-age=15552000'
                          ),
                        'X-Frame-Options'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Prevent this request from being loaded in any iframes',
                            'default'  =>   'DENY',
                        ),
                        'X-Content-Type-Options'    =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                            'default'  =>   'nosniff',
                        ),
                    );
                  $schema_response = array(
                      'schema'    => array(
                          'type'  =>  'object'
                      ),
                      'properties'    =>  array(
                          'meta'  =>  array(
                              'title' =>  'Meta data',
                              'type'  =>  'object',
                          ),
                          'properties'    =>  array(
                              'LastUpdate'    =>  array(
                                  'type'  =>  'string',
                                  'format'    =>  'date-time'
                              ),
                              'TotalResults'  =>  array(
                                  'type'  =>  'Integer'
                              ),
                          ),
                      ),
                      'Agreement' =>  array(
                          'type'  =>  'string',
                          'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                      ),
                  );
                  $license_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed'
                  );
                  $term_use_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed',
                      'required'  =>  array(
                          'LastUpdate'    =>  0,
                          'TotalResults'  =>  0,
                          'Agreement' =>  0,
                          'License'   =>  0,
                          'TermOfUse' =>  0,
                      ),
                      'additionalProperties'  =>  false

                  );


                  $response = array(
                      'status' => $status,
                      'title' =>  $title_response,
                      'host'  =>  $host_response,
                      'produces'  =>  'application/json',
                      'tags'  =>  $tags_response,
                      'paths' =>  $paths_response,
                      'parameters'    =>  $parameters_response,
                      'responses' =>  $resp_response,
                      'schema_and_meta_data'  =>  $schema_response,
                      'license'   =>  $license_response,
                      'termOfUse' =>  $term_use_response,
                  );

                  $this->response($response, $status);
              break;
            }

      }else{
        $tokenData = true;
        // Create a token
        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
        // Set HTTP status code
        $status = parent::HTTP_BAD_REQUEST;
        $title_response = array(
          'swagger'   =>  '2.0',
          'info'  =>  array(
            'version'  =>   'v1.0.0',
            'title' =>  'API Searchperson',
            'description'   =>  'API to search persons or enterprise in diffent kind of list'
          ),
        );

        $host_response = array(
            'host'  =>  $_SERVER["HTTP_HOST"],
            'basePath'  =>  $_SERVER["REQUEST_URI"],
            //'schemes'   =>  $_SERVER['HTTPS']
            'schemes'   =>  'on'
        );

        $tags_response = array(
            'name'  =>  'Response',
            'description'   =>  'api to verify response'
        );
        $paths_response = array(
              '/test_resp' => array(
                  'post'  =>  array(
                      'tags'  => array(
                          'name'  =>  'Busquedas'
                        ),
                      'description'   =>  'Search in list',
                    ),
              ),
        );
        $parameters_response = array(
            'result'=>'Sus datos estan incompletos, verifiquelos '
            );
        $resp_response = array(
                200 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                ),
                403 =>  array(
                  'description'   =>  'The record was saved successfully',
                  'headers'   =>  array(
                      'StrictTransportSecurity'   =>  array(
                          'type'  =>  'string',
                          'description'   =>  'HTTPS strict transport security header',
                          'default'   =>  'max-age=31536000',
                      ),
                  ),
                ),
              'Etag'  =>  array(
                  'type'  => 'string',
                  'description'   =>  'No update'
              ),
              'Cache-control' =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Describes how long this response can be cached',
                    'default'   =>  'max-age=15552000'
                ),
              'X-Frame-Options'   =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Prevent this request from being loaded in any iframes',
                  'default'  =>   'DENY',
              ),
              'X-Content-Type-Options'    =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                  'default'  =>   'nosniff',
              ),
          );
        $schema_response = array(
            'schema'    => array(
                'type'  =>  'object'
            ),
            'properties'    =>  array(
                'meta'  =>  array(
                    'title' =>  'Meta data',
                    'type'  =>  'object',
                ),
                'properties'    =>  array(
                    'LastUpdate'    =>  array(
                        'type'  =>  'string',
                        'format'    =>  'date-time'
                    ),
                    'TotalResults'  =>  array(
                        'type'  =>  'Integer'
                    ),
                ),
            ),
            'Agreement' =>  array(
                'type'  =>  'string',
                'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
            ),
        );
        $license_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed'
        );
        $term_use_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed',
            'required'  =>  array(
                'LastUpdate'    =>  0,
                'TotalResults'  =>  0,
                'Agreement' =>  0,
                'License'   =>  0,
                'TermOfUse' =>  0,
            ),
            'additionalProperties'  =>  false

        );


        $response = array(
            'status' => $status,
            'title' =>  $title_response,
            'host'  =>  $host_response,
            'produces'  =>  'application/json',
            'tags'  =>  $tags_response,
            'paths' =>  $paths_response,
            'parameters'    =>  $parameters_response,
            'responses' =>  $resp_response,
            'schema_and_meta_data'  =>  $schema_response,
            'license'   =>  $license_response,
            'termOfUse' =>  $term_use_response,
        );

        $this->response($response, $status);
      }


    }
    
    public function searchpersonc_post(){
      $api_key_variable = $this->config->item('rest_key_name');
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      $apiK=$this->input->server($key_name);
      $entidad=  $this->binnacle_model->getID($apiK);
      /*
      if($apiK=='201020594'){

      }
      else{
        $hoy =date("Y-m-d");

        $result3 = $this->busquedas_model->totalBusquedas_Api($apiK);
        $acceso=$this->busquedas_model->varSesion($apiK);
        $inicio=""; $paquete="";
        foreach ($acceso as $data){
          switch ($data['paquete']) {
            case 'B':
                $p='2000';
            break;
            case 'E':
                $p='4500';
            break;
            case 'P':
                $p='10000';
            break;

            case 'A':
                $p='100000';
            break;
            default:
                $p='10000';
              break;
          }
              $termino  	=  $data['f_termino'];
              $paquete  	=  $p;
        }
        if($paquete<=$result3){
          $tokenData = true;
          // Create a token
          //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
          // Set HTTP status code
          $status = parent::HTTP_BAD_REQUEST;
          $title_response = array(
            'swagger'   =>  '2.0',
            'info'  =>  array(
              'version'  =>   'v1.0.0',
              'title' =>  'API Searchperson',
              'description'   =>  'API to search persons or enterprise in diffent kind of list'
            ),
          );

          $host_response = array(
              'host'  =>  $_SERVER["HTTP_HOST"],
              'basePath'  =>  $_SERVER["REQUEST_URI"],
              //'schemes'   =>  $_SERVER['HTTPS']
              'schemes'   =>  'on'
          );

          $tags_response = array(
              'name'  =>  'Response',
              'description'   =>  'api to verify response'
          );
          $paths_response = array(
                '/test_resp' => array(
                    'post'  =>  array(
                        'tags'  => array(
                            'name'  =>  'Busquedas'
                          ),
                        'description'   =>  'Search in list',
                      ),
                ),
          );
          $parameters_response = array(
              'result'=>'A alcanzado su maximo de busquedas'
              );
          $resp_response = array(
                  200 =>  array(
                      'description'   =>  'The record was saved successfully',
                      'headers'   =>  array(
                          'StrictTransportSecurity'   =>  array(
                              'type'  =>  'string',
                              'description'   =>  'HTTPS strict transport security header',
                              'default'   =>  'max-age=31536000',
                          ),
                      ),
                  ),
                  403 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                  ),
                'Etag'  =>  array(
                    'type'  => 'string',
                    'description'   =>  'No update'
                ),
                'Cache-control' =>  array(
                      'type'  =>  'string',
                      'description'   =>  'Describes how long this response can be cached',
                      'default'   =>  'max-age=15552000'
                  ),
                'X-Frame-Options'   =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Prevent this request from being loaded in any iframes',
                    'default'  =>   'DENY',
                ),
                'X-Content-Type-Options'    =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                    'default'  =>   'nosniff',
                ),
            );
          $schema_response = array(
              'schema'    => array(
                  'type'  =>  'object'
              ),
              'properties'    =>  array(
                  'meta'  =>  array(
                      'title' =>  'Meta data',
                      'type'  =>  'object',
                  ),
                  'properties'    =>  array(
                      'LastUpdate'    =>  array(
                          'type'  =>  'string',
                          'format'    =>  'date-time'
                      ),
                      'TotalResults'  =>  array(
                          'type'  =>  'Integer'
                      ),
                  ),
              ),
              'Agreement' =>  array(
                  'type'  =>  'string',
                  'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
              ),
          );
          $license_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed'
          );
          $term_use_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed',
              'required'  =>  array(
                  'LastUpdate'    =>  0,
                  'TotalResults'  =>  0,
                  'Agreement' =>  0,
                  'License'   =>  0,
                  'TermOfUse' =>  0,
              ),
              'additionalProperties'  =>  false

          );


          $response = array(
              'status' => $status,
              'title' =>  $title_response,
              'host'  =>  $host_response,
              'produces'  =>  'application/json',
              'tags'  =>  $tags_response,
              'paths' =>  $paths_response,
              'parameters'    =>  $parameters_response,
              'responses' =>  $resp_response,
              'schema_and_meta_data'  =>  $schema_response,
              'license'   =>  $license_response,
              'termOfUse' =>  $term_use_response,
          );

          $this->response($response, $status);
          //  $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($termino < $hoy) {
          $tokenData = true;
          // Create a token
          //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
          // Set HTTP status code
          $status = parent::HTTP_BAD_REQUEST;
          $title_response = array(
            'swagger'   =>  '2.0',
            'info'  =>  array(
              'version'  =>   'v1.0.0',
              'title' =>  'API Searchperson',
              'description'   =>  'API to search persons or enterprise in diffent kind of list'
            ),
          );

          $host_response = array(
              'host'  =>  $_SERVER["HTTP_HOST"],
              'basePath'  =>  $_SERVER["REQUEST_URI"],
              //'schemes'   =>  $_SERVER['HTTPS']
              'schemes'   =>  'on'
          );

          $tags_response = array(
              'name'  =>  'Response',
              'description'   =>  'api to verify response'
          );
          $paths_response = array(
                '/test_resp' => array(
                    'post'  =>  array(
                        'tags'  => array(
                            'name'  =>  'Busquedas'
                          ),
                        'description'   =>  'Search in list',
                      ),
                ),
          );
          $parameters_response = array(
              'result'=>'Su paquete ha finalizado'
              );
          $resp_response = array(
                  200 =>  array(
                      'description'   =>  'The record was saved successfully',
                      'headers'   =>  array(
                          'StrictTransportSecurity'   =>  array(
                              'type'  =>  'string',
                              'description'   =>  'HTTPS strict transport security header',
                              'default'   =>  'max-age=31536000',
                          ),
                      ),
                  ),
                  403 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                  ),
                'Etag'  =>  array(
                    'type'  => 'string',
                    'description'   =>  'No update'
                ),
                'Cache-control' =>  array(
                      'type'  =>  'string',
                      'description'   =>  'Describes how long this response can be cached',
                      'default'   =>  'max-age=15552000'
                  ),
                'X-Frame-Options'   =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Prevent this request from being loaded in any iframes',
                    'default'  =>   'DENY',
                ),
                'X-Content-Type-Options'    =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                    'default'  =>   'nosniff',
                ),
            );
          $schema_response = array(
              'schema'    => array(
                  'type'  =>  'object'
              ),
              'properties'    =>  array(
                  'meta'  =>  array(
                      'title' =>  'Meta data',
                      'type'  =>  'object',
                  ),
                  'properties'    =>  array(
                      'LastUpdate'    =>  array(
                          'type'  =>  'string',
                          'format'    =>  'date-time'
                      ),
                      'TotalResults'  =>  array(
                          'type'  =>  'Integer'
                      ),
                  ),
              ),
              'Agreement' =>  array(
                  'type'  =>  'string',
                  'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
              ),
          );
          $license_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed'
          );
          $term_use_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed',
              'required'  =>  array(
                  'LastUpdate'    =>  0,
                  'TotalResults'  =>  0,
                  'Agreement' =>  0,
                  'License'   =>  0,
                  'TermOfUse' =>  0,
              ),
              'additionalProperties'  =>  false

          );


          $response = array(
              'status' => $status,
              'title' =>  $title_response,
              'host'  =>  $host_response,
              'produces'  =>  'application/json',
              'tags'  =>  $tags_response,
              'paths' =>  $paths_response,
              'parameters'    =>  $parameters_response,
              'responses' =>  $resp_response,
              'schema_and_meta_data'  =>  $schema_response,
              'license'   =>  $license_response,
              'termOfUse' =>  $term_use_response,
          );

          $this->response($response, $status);
        }


      }
      */
      if ($this->form_validation->run('searchperson_post')){
          //recibir valores
          $nombre= strtoupper(trim($this->post('nombre')));
            $apaterno= strtoupper(trim($this->post('apaterno')));
          $amaterno= strtoupper(trim($this->post('amaterno')));
          $tipo_busqueda= trim($this->post('tipo_busqueda'));
          $tipo_persona= strtoupper(trim($this->post('tipo_persona')));
          $curp= strtoupper(trim($this->post('curp')));
          $rfc= strtoupper(trim($this->post('rfc')));
            switch ($tipo_persona) {
              case 'FISICA':
                    $data = $this->post();
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $type= "f";
                    $rfc_ban 	= 0;
                    
                    if($apaterno != null){
                        $apaterno_signo = "+".$apaterno;
                    }else{
                        $apaterno_signo = $apaterno;
                    }
                    
                    if($amaterno != null){
                        $amaterno_signo = "+".$amaterno;
                    }else{
                        $amaterno_signo = $amaterno;
                    }

                    $full_name1 = "+".$nombre . " " .$apaterno_signo. " " . $amaterno_signo;
                    $full_name= str_replace("'", " ", $full_name1);
                    $full_name= str_replace("-", " ", $full_name);
                    //$full_name2 = "+".$nombre . " " ."+". $apaterno . " " ."+". $amaterno;
                    $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia
                    $trimabuscar = trim($full_name);
                    $exist = false;
                    $this->load->helper('converter_to_uppercase');
                    if($tipo_busqueda=="EXACTA"){
                      $search = $this->busquedasb_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp));
                      $search_unlocked = $this->busquedasb_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp),'delete');
                      $tipoBusqueda='Busqueda exacta';
                    }
                    elseif ($tipo_busqueda=="EXTENDIDA"){
                      $search = $this->busquedasb_model->buscar_extendidaapi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
                      $search_unlocked = $this->busquedasb_model->buscar_extendidaapi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
                      $tipoBusqueda='Busqueda extendida';
                    }
                    else{
                      $search = $this->busquedasb_model->buscarConcatenacion($trimabuscar,$entidad);
                      //$search_unlocked = $this->busquedasb_model->buscarConcatenacion($trimabuscar,$entidad);
                      $tipoBusqueda='Busqueda normal';

                    }
                    if (!empty($rfc)){
                      if ($this->busquedasb_model->search_rfc($rfc) ){
                        $rfc_ban = 1;
                      }
                    }
                    if ($search)
                    {

                      if (!empty($search))
                      {

                         $porcentaje = 0;
                         $count = 0;
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
                            $porcentaje==round($porcentaje,2);
                            if(floatval($porcentaje) > 70){
                                $final[$num][0]=$fila->id;
                                $final[$num][1]=$full_name;
                                $final[$num][2]=$fila->pertenece;
                                $final[$num][3]=$fila->actividad;
                                $final[$num][4]=$fila->fecha;
                                $final[$num][5]=$fila->tipo;
                                $final[$num][6]=$stautus;
                                $final[$num][7]=round($porcentaje,2);
                                $num=$num+1;
                                $listas.=$fila->tipo." ";

                            }
                            
                           if($count == 15){
                               break;
                           }
                           
                           $count ++;
                         }
                          //array bidimensional

                          $volumen= Array();

                          foreach ($final as $clave => $fila) {
                              $volumen[$clave] = $fila['7'];

                          }

                          // Ordenar los datos con volumen descendiente, edición ascendiente
                          // Agregar $datos como el último parámetro, para ordenar por la clave común
                          array_multisort($volumen, SORT_DESC,$final);
                          //echo json_encode($final);

                         //$acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas);
                      }
                    }
                    //$acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada3'.$trimabuscar
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                break;
              case 'MORAL':
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $trimabuscar = converter_to_uppercase(trim($nombre));
                    $trimabuscar_signo = "+".$trimabuscar;
                    $exist = false;
                    $rfc_ban = 0;

                    if (!empty($rfc)){
                       if ($this->busquedasb_model->search_rfc($rfc) ){
                          $rfc_ban = 1;
                       }
                    }
                    if($tipo_busqueda=="EXACTA"){
                      $search = $this->busquedasb_model->buscar_exacta_mApi($nombre,$rfc);
                      $search_unlocked = $this->busquedasb_model->buscar_exacta_mApi($nombre,$rfc,'delete');
                      $tipoBusqueda="Busqueda exacta";
                    }
                    elseif($tipo_busqueda=="EXTENDIDA"){
                      $search = $this->busquedasb_model->buscar_extendida_mApi($nombre,$rfc);
                      $search_unlocked = $this->busquedasb_model->buscar_extendida_mApi($nombre,$rfc);
                      $tipoBusqueda="Busqueda extendida";
                    }
                    else{
                      $id=1500;
                      $search = $this->busquedasb_model->buscarConcatenacion($trimabuscar_signo,$entidad);
                      $search_unlocked = $this->busquedasb_model->buscarConcatenacion($trimabuscar_signo,$entidad);
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
                         }
                         else {
                           $stautus='Baja, fecha de baja: '.$fila->updated_at;
                         }
                         $porcentaje==round($porcentaje,2);
                         if($porcentaje<'89.99%' and ($apiK=='KYC-omkM5J7jJprtyxO4p8NPfEY0va7BYRH/J7s28Q==' or $apiK=='KYC-gmlY9YuxM5v810m0ncx4bw1w3vSyJw==') ){

                         }elseif (($porcentaje<'69.99%' and $apiK=='KYC-i2oZ9Y/3LJv0xR2ypsNUe1wsga3wfkjvcupjrmvSZtJiP4l6rjfCH19lm36YFoMY' )) {
                           // code...
                         }
                         else{
                         $final[$num][0]=$fila->id;
                         $final[$num][1]=$full_name;
                         $final[$num][2]=$fila->pertenece;
                         $final[$num][3]=$fila->actividad;
                         $final[$num][4]=$fila->fecha;
                         $final[$num][5]=$fila->tipo;
                         $final[$num][6]=$stautus;
                         $final[$num][7]=round($porcentaje,2);
                         $num=$num+1;
                         $listas.=$fila->tipo." ";
                       }
                       }
                       $volumen= Array();
                       foreach ($final as $clave => $fila) {
                           $volumen[$clave] = $fila['7'];
                       }
                       array_multisort($volumen, SORT_DESC,$final);
                    }
                    else{

                    }
                    //$acceso2 = $this->binnacle_model->buscar_personasAPI($nombre,$tipoBusqueda,'Persona Moral',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
              break;

              default:
                  $tokenData = true;
                  // Create a token
                  //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                  // Set HTTP status code
                  $status = parent::HTTP_BAD_REQUEST;
                  $title_response = array(
                    'swagger'   =>  '2.0',
                    'info'  =>  array(
                      'version'  =>   'v1.0.0',
                      'title' =>  'API Searchperson',
                      'description'   =>  'API to search persons or enterprise in diffent kind of list'
                    ),
                  );

                  $host_response = array(
                      'host'  =>  $_SERVER["HTTP_HOST"],
                      'basePath'  =>  $_SERVER["REQUEST_URI"],
                      //'schemes'   =>  $_SERVER['HTTPS']
                      'schemes'   =>  'on'
                  );

                  $tags_response = array(
                      'name'  =>  'Response',
                      'description'   =>  'api to verify response'
                  );
                  $paths_response = array(
                        '/test_resp' => array(
                            'post'  =>  array(
                                'tags'  => array(
                                    'name'  =>  'Busquedas'
                                  ),
                                'description'   =>  'Search in list',
                              ),
                        ),
                  );
                  $parameters_response = array(
                      'result'=>'Opcion no valida'
                      );
                  $resp_response = array(
                          200 =>  array(
                              'description'   =>  'The record was saved successfully',
                              'headers'   =>  array(
                                  'StrictTransportSecurity'   =>  array(
                                      'type'  =>  'string',
                                      'description'   =>  'HTTPS strict transport security header',
                                      'default'   =>  'max-age=31536000',
                                  ),
                              ),
                          ),
                          403 =>  array(
                            'description'   =>  'The record was saved successfully',
                            'headers'   =>  array(
                                'StrictTransportSecurity'   =>  array(
                                    'type'  =>  'string',
                                    'description'   =>  'HTTPS strict transport security header',
                                    'default'   =>  'max-age=31536000',
                                ),
                            ),
                          ),
                        'Etag'  =>  array(
                            'type'  => 'string',
                            'description'   =>  'No update'
                        ),
                        'Cache-control' =>  array(
                              'type'  =>  'string',
                              'description'   =>  'Describes how long this response can be cached',
                              'default'   =>  'max-age=15552000'
                          ),
                        'X-Frame-Options'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Prevent this request from being loaded in any iframes',
                            'default'  =>   'DENY',
                        ),
                        'X-Content-Type-Options'    =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                            'default'  =>   'nosniff',
                        ),
                    );
                  $schema_response = array(
                      'schema'    => array(
                          'type'  =>  'object'
                      ),
                      'properties'    =>  array(
                          'meta'  =>  array(
                              'title' =>  'Meta data',
                              'type'  =>  'object',
                          ),
                          'properties'    =>  array(
                              'LastUpdate'    =>  array(
                                  'type'  =>  'string',
                                  'format'    =>  'date-time'
                              ),
                              'TotalResults'  =>  array(
                                  'type'  =>  'Integer'
                              ),
                          ),
                      ),
                      'Agreement' =>  array(
                          'type'  =>  'string',
                          'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                      ),
                  );
                  $license_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed'
                  );
                  $term_use_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed',
                      'required'  =>  array(
                          'LastUpdate'    =>  0,
                          'TotalResults'  =>  0,
                          'Agreement' =>  0,
                          'License'   =>  0,
                          'TermOfUse' =>  0,
                      ),
                      'additionalProperties'  =>  false

                  );


                  $response = array(
                      'status' => $status,
                      'title' =>  $title_response,
                      'host'  =>  $host_response,
                      'produces'  =>  'application/json',
                      'tags'  =>  $tags_response,
                      'paths' =>  $paths_response,
                      'parameters'    =>  $parameters_response,
                      'responses' =>  $resp_response,
                      'schema_and_meta_data'  =>  $schema_response,
                      'license'   =>  $license_response,
                      'termOfUse' =>  $term_use_response,
                  );

                  $this->response($response, $status);
              break;
            }

      }else{
        $tokenData = true;
        // Create a token
        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
        // Set HTTP status code
        $status = parent::HTTP_BAD_REQUEST;
        $title_response = array(
          'swagger'   =>  '2.0',
          'info'  =>  array(
            'version'  =>   'v1.0.0',
            'title' =>  'API Searchperson',
            'description'   =>  'API to search persons or enterprise in diffent kind of list'
          ),
        );

        $host_response = array(
            'host'  =>  $_SERVER["HTTP_HOST"],
            'basePath'  =>  $_SERVER["REQUEST_URI"],
            //'schemes'   =>  $_SERVER['HTTPS']
            'schemes'   =>  'on'
        );

        $tags_response = array(
            'name'  =>  'Response',
            'description'   =>  'api to verify response'
        );
        $paths_response = array(
              '/test_resp' => array(
                  'post'  =>  array(
                      'tags'  => array(
                          'name'  =>  'Busquedas'
                        ),
                      'description'   =>  'Search in list',
                    ),
              ),
        );
        $parameters_response = array(
            'result'=>'Sus datos estan incompletos, verifiquelos '
            );
        $resp_response = array(
                200 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                ),
                403 =>  array(
                  'description'   =>  'The record was saved successfully',
                  'headers'   =>  array(
                      'StrictTransportSecurity'   =>  array(
                          'type'  =>  'string',
                          'description'   =>  'HTTPS strict transport security header',
                          'default'   =>  'max-age=31536000',
                      ),
                  ),
                ),
              'Etag'  =>  array(
                  'type'  => 'string',
                  'description'   =>  'No update'
              ),
              'Cache-control' =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Describes how long this response can be cached',
                    'default'   =>  'max-age=15552000'
                ),
              'X-Frame-Options'   =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Prevent this request from being loaded in any iframes',
                  'default'  =>   'DENY',
              ),
              'X-Content-Type-Options'    =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                  'default'  =>   'nosniff',
              ),
          );
        $schema_response = array(
            'schema'    => array(
                'type'  =>  'object'
            ),
            'properties'    =>  array(
                'meta'  =>  array(
                    'title' =>  'Meta data',
                    'type'  =>  'object',
                ),
                'properties'    =>  array(
                    'LastUpdate'    =>  array(
                        'type'  =>  'string',
                        'format'    =>  'date-time'
                    ),
                    'TotalResults'  =>  array(
                        'type'  =>  'Integer'
                    ),
                ),
            ),
            'Agreement' =>  array(
                'type'  =>  'string',
                'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
            ),
        );
        $license_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed'
        );
        $term_use_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed',
            'required'  =>  array(
                'LastUpdate'    =>  0,
                'TotalResults'  =>  0,
                'Agreement' =>  0,
                'License'   =>  0,
                'TermOfUse' =>  0,
            ),
            'additionalProperties'  =>  false

        );


        $response = array(
            'status' => $status,
            'title' =>  $title_response,
            'host'  =>  $host_response,
            'produces'  =>  'application/json',
            'tags'  =>  $tags_response,
            'paths' =>  $paths_response,
            'parameters'    =>  $parameters_response,
            'responses' =>  $resp_response,
            'schema_and_meta_data'  =>  $schema_response,
            'license'   =>  $license_response,
            'termOfUse' =>  $term_use_response,
        );

        $this->response($response, $status);
      }


    }

    public function searchpersonb_post(){
      $api_key_variable = $this->config->item('rest_key_name');
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      $apiK=$this->input->server($key_name);
      $entidad=  $this->binnacle_model->getID($apiK);
      /*
      if($apiK=='201020594'){

      }
      else{
        $hoy =date("Y-m-d");

        $result3 = $this->busquedas_model->totalBusquedas_Api($apiK);
        $acceso=$this->busquedas_model->varSesion($apiK);
        $inicio=""; $paquete="";
        foreach ($acceso as $data){
          switch ($data['paquete']) {
            case 'B':
                $p='2000';
            break;
            case 'E':
                $p='4500';
            break;
            case 'P':
                $p='10000';
            break;

            case 'A':
                $p='100000';
            break;
            default:
                $p='10000';
              break;
          }
              $termino  	=  $data['f_termino'];
              $paquete  	=  $p;
        }
        if($paquete<=$result3){
          $tokenData = true;
          // Create a token
          //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
          // Set HTTP status code
          $status = parent::HTTP_BAD_REQUEST;
          $title_response = array(
            'swagger'   =>  '2.0',
            'info'  =>  array(
              'version'  =>   'v1.0.0',
              'title' =>  'API Searchperson',
              'description'   =>  'API to search persons or enterprise in diffent kind of list'
            ),
          );

          $host_response = array(
              'host'  =>  $_SERVER["HTTP_HOST"],
              'basePath'  =>  $_SERVER["REQUEST_URI"],
              //'schemes'   =>  $_SERVER['HTTPS']
              'schemes'   =>  'on'
          );

          $tags_response = array(
              'name'  =>  'Response',
              'description'   =>  'api to verify response'
          );
          $paths_response = array(
                '/test_resp' => array(
                    'post'  =>  array(
                        'tags'  => array(
                            'name'  =>  'Busquedas'
                          ),
                        'description'   =>  'Search in list',
                      ),
                ),
          );
          $parameters_response = array(
              'result'=>'A alcanzado su maximo de busquedas'
              );
          $resp_response = array(
                  200 =>  array(
                      'description'   =>  'The record was saved successfully',
                      'headers'   =>  array(
                          'StrictTransportSecurity'   =>  array(
                              'type'  =>  'string',
                              'description'   =>  'HTTPS strict transport security header',
                              'default'   =>  'max-age=31536000',
                          ),
                      ),
                  ),
                  403 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                  ),
                'Etag'  =>  array(
                    'type'  => 'string',
                    'description'   =>  'No update'
                ),
                'Cache-control' =>  array(
                      'type'  =>  'string',
                      'description'   =>  'Describes how long this response can be cached',
                      'default'   =>  'max-age=15552000'
                  ),
                'X-Frame-Options'   =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Prevent this request from being loaded in any iframes',
                    'default'  =>   'DENY',
                ),
                'X-Content-Type-Options'    =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                    'default'  =>   'nosniff',
                ),
            );
          $schema_response = array(
              'schema'    => array(
                  'type'  =>  'object'
              ),
              'properties'    =>  array(
                  'meta'  =>  array(
                      'title' =>  'Meta data',
                      'type'  =>  'object',
                  ),
                  'properties'    =>  array(
                      'LastUpdate'    =>  array(
                          'type'  =>  'string',
                          'format'    =>  'date-time'
                      ),
                      'TotalResults'  =>  array(
                          'type'  =>  'Integer'
                      ),
                  ),
              ),
              'Agreement' =>  array(
                  'type'  =>  'string',
                  'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
              ),
          );
          $license_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed'
          );
          $term_use_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed',
              'required'  =>  array(
                  'LastUpdate'    =>  0,
                  'TotalResults'  =>  0,
                  'Agreement' =>  0,
                  'License'   =>  0,
                  'TermOfUse' =>  0,
              ),
              'additionalProperties'  =>  false

          );


          $response = array(
              'status' => $status,
              'title' =>  $title_response,
              'host'  =>  $host_response,
              'produces'  =>  'application/json',
              'tags'  =>  $tags_response,
              'paths' =>  $paths_response,
              'parameters'    =>  $parameters_response,
              'responses' =>  $resp_response,
              'schema_and_meta_data'  =>  $schema_response,
              'license'   =>  $license_response,
              'termOfUse' =>  $term_use_response,
          );

          $this->response($response, $status);
          //  $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($termino < $hoy) {
          $tokenData = true;
          // Create a token
          //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
          // Set HTTP status code
          $status = parent::HTTP_BAD_REQUEST;
          $title_response = array(
            'swagger'   =>  '2.0',
            'info'  =>  array(
              'version'  =>   'v1.0.0',
              'title' =>  'API Searchperson',
              'description'   =>  'API to search persons or enterprise in diffent kind of list'
            ),
          );

          $host_response = array(
              'host'  =>  $_SERVER["HTTP_HOST"],
              'basePath'  =>  $_SERVER["REQUEST_URI"],
              //'schemes'   =>  $_SERVER['HTTPS']
              'schemes'   =>  'on'
          );

          $tags_response = array(
              'name'  =>  'Response',
              'description'   =>  'api to verify response'
          );
          $paths_response = array(
                '/test_resp' => array(
                    'post'  =>  array(
                        'tags'  => array(
                            'name'  =>  'Busquedas'
                          ),
                        'description'   =>  'Search in list',
                      ),
                ),
          );
          $parameters_response = array(
              'result'=>'Su paquete ha finalizado'
              );
          $resp_response = array(
                  200 =>  array(
                      'description'   =>  'The record was saved successfully',
                      'headers'   =>  array(
                          'StrictTransportSecurity'   =>  array(
                              'type'  =>  'string',
                              'description'   =>  'HTTPS strict transport security header',
                              'default'   =>  'max-age=31536000',
                          ),
                      ),
                  ),
                  403 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                  ),
                'Etag'  =>  array(
                    'type'  => 'string',
                    'description'   =>  'No update'
                ),
                'Cache-control' =>  array(
                      'type'  =>  'string',
                      'description'   =>  'Describes how long this response can be cached',
                      'default'   =>  'max-age=15552000'
                  ),
                'X-Frame-Options'   =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Prevent this request from being loaded in any iframes',
                    'default'  =>   'DENY',
                ),
                'X-Content-Type-Options'    =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                    'default'  =>   'nosniff',
                ),
            );
          $schema_response = array(
              'schema'    => array(
                  'type'  =>  'object'
              ),
              'properties'    =>  array(
                  'meta'  =>  array(
                      'title' =>  'Meta data',
                      'type'  =>  'object',
                  ),
                  'properties'    =>  array(
                      'LastUpdate'    =>  array(
                          'type'  =>  'string',
                          'format'    =>  'date-time'
                      ),
                      'TotalResults'  =>  array(
                          'type'  =>  'Integer'
                      ),
                  ),
              ),
              'Agreement' =>  array(
                  'type'  =>  'string',
                  'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
              ),
          );
          $license_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed'
          );
          $term_use_response = array(
              'description'   =>  'To be confirmed',
              'type'  =>  'string',
              'format'    =>  'uri',
              'enum'  =>  'To be confirmed',
              'required'  =>  array(
                  'LastUpdate'    =>  0,
                  'TotalResults'  =>  0,
                  'Agreement' =>  0,
                  'License'   =>  0,
                  'TermOfUse' =>  0,
              ),
              'additionalProperties'  =>  false

          );


          $response = array(
              'status' => $status,
              'title' =>  $title_response,
              'host'  =>  $host_response,
              'produces'  =>  'application/json',
              'tags'  =>  $tags_response,
              'paths' =>  $paths_response,
              'parameters'    =>  $parameters_response,
              'responses' =>  $resp_response,
              'schema_and_meta_data'  =>  $schema_response,
              'license'   =>  $license_response,
              'termOfUse' =>  $term_use_response,
          );

          $this->response($response, $status);
        }


      }
      */
      if ($this->form_validation->run('searchperson_post')){
          //recibir valores
          $nombre= strtoupper(trim($this->post('nombre')));
            $apaterno= strtoupper(trim($this->post('apaterno')));
          $amaterno= strtoupper(trim($this->post('amaterno')));
          $tipo_busqueda= trim($this->post('tipo_busqueda'));
          $tipo_persona= strtoupper(trim($this->post('tipo_persona')));
          $curp= strtoupper(trim($this->post('curp')));
          $rfc= strtoupper(trim($this->post('rfc')));
            switch ($tipo_persona) {
              case 'FISICA':
                    $data = $this->post();
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $type= "f";
                    $rfc_ban 	= 0;

                    $full_name1 = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name= str_replace("'", " ", $full_name1);
                    $full_name= str_replace("-", " ", $full_name);
                    $full_name2 = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia
                    $trimabuscar = trim($full_name);
                    $exist = false;
                    $this->load->helper('converter_to_uppercase');
                    if($tipo_busqueda=="EXACTA"){
                      $search = $this->busquedasb_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp));
                      $search_unlocked = $this->busquedasb_model->buscar_exacta(converter_to_uppercase($nombre),converter_to_uppercase($apaterno),converter_to_uppercase($amaterno),converter_to_uppercase($rfc),converter_to_uppercase($curp),'delete');
                      $tipoBusqueda='Busqueda exacta';
                    }
                    elseif ($tipo_busqueda=="EXTENDIDA"){
                      $search = $this->busquedasb_model->buscar_extendidaapi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp));
                      $search_unlocked = $this->busquedasb_model->buscar_extendidaapi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete');
                      $tipoBusqueda='Busqueda extendida';
                    }
                    else{
                      $search = $this->busquedasb_model->buscarApi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp),'active',$entidad);
                      $search_unlocked = $this->busquedasb_model->buscarApi(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno), converter_to_uppercase($rfc), converter_to_uppercase($curp), 'delete',$entidad);
                      $tipoBusqueda='Busqueda normal';

                    }
                    if (!empty($rfc)){
                      if ($this->busquedasb_model->search_rfc($rfc) ){
                        $rfc_ban = 1;
                      }
                    }
                    if ($search)
                    {

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
                            $porcentaje==round($porcentaje,2);
                            if($porcentaje<'89.99%' and ($apiK=='KYC-omkM5J7jJprtyxO4p8NPfEY0va7BYRH/J7s28Q==' or $apiK=='KYC-gmlY9YuxM5v810m0ncx4bw1w3vSyJw==') ){


                            }elseif ($porcentaje<'69.99%' and $apiK=='KYC-i2oZ9Y/3LJv0xR2ypsNUe1wsga3wfkjvcupjrmvSZtJiP4l6rjfCH19lm36YFoMY') {
                              // code...
                            }
                            else{
                            $final[$num][0]=$fila->id;
                             $final[$num][1]=$full_name;
                             $final[$num][2]=$fila->pertenece;
                             $final[$num][3]=$fila->actividad;
                             $final[$num][4]=$fila->fecha;
                             $final[$num][5]=$fila->tipo;
                             $final[$num][6]=$stautus;
                             $final[$num][7]=round($porcentaje,2);
                             $num=$num+1;
                             $listas.=$fila->tipo." ";
                           }
                         }
                          //array bidimensional

                          $volumen= Array();

                          foreach ($final as $clave => $fila) {
                              $volumen[$clave] = $fila['7'];

                          }

                          // Ordenar los datos con volumen descendiente, edición ascendiente
                          // Agregar $datos como el último parámetro, para ordenar por la clave común
                          array_multisort($volumen, SORT_DESC,$final);
                          //echo json_encode($final);

                         //$acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas);
                      }
                    }
                    //$acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada3'.$trimabuscar
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                break;
              case 'MORAL':
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $trimabuscar = converter_to_uppercase(trim($nombre));
                    $exist = false;
                    $rfc_ban = 0;

                    if (!empty($rfc)){
                       if ($this->busquedasb_model->search_rfc($rfc) ){
                          $rfc_ban = 1;
                       }
                    }
                    if($tipo_busqueda=="EXACTA"){
                      $search = $this->busquedasb_model->buscar_exacta_mApi($nombre,$rfc);
                      $search_unlocked = $this->busquedasb_model->buscar_exacta_mApi($nombre,$rfc,'delete');
                      $tipoBusqueda="Busqueda exacta";
                    }
                    elseif($tipo_busqueda=="EXTENDIDA"){
                      $search = $this->busquedasb_model->buscar_extendida_mApi($nombre,$rfc);
                      $search_unlocked = $this->busquedasb_model->buscar_extendida_mApi($nombre,$rfc);
                      $tipoBusqueda="Busqueda extendida";
                    }
                    else{
                      $id=1500;
                      $search = $this->busquedasb_model->buscarApi($trimabuscar, $nombre, $apaterno = "", $amaterno = "", $rfc, $curp = "",'active',$id);
                      $search_unlocked = $this->busquedasb_model->buscarApi($trimabuscar, $nombre, $apaterno, $amaterno, $rfc, $curp,'active',$id);
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
                         }
                         else {
                           $stautus='Baja, fecha de baja: '.$fila->updated_at;
                         }
                         $porcentaje==round($porcentaje,2);
                         if($porcentaje<'89.99%' and ($apiK=='KYC-omkM5J7jJprtyxO4p8NPfEY0va7BYRH/J7s28Q==' or $apiK=='KYC-gmlY9YuxM5v810m0ncx4bw1w3vSyJw==') ){

                         }elseif (($porcentaje<'69.99%' and $apiK=='KYC-i2oZ9Y/3LJv0xR2ypsNUe1wsga3wfkjvcupjrmvSZtJiP4l6rjfCH19lm36YFoMY' )) {
                           // code...
                         }
                         else{
                         $final[$num][0]=$fila->id;
                         $final[$num][1]=$full_name;
                         $final[$num][2]=$fila->pertenece;
                         $final[$num][3]=$fila->actividad;
                         $final[$num][4]=$fila->fecha;
                         $final[$num][5]=$fila->tipo;
                         $final[$num][6]=$stautus;
                         $final[$num][7]=round($porcentaje,2);
                         $num=$num+1;
                         $listas.=$fila->tipo." ";
                       }
                       }
                       $volumen= Array();
                       foreach ($final as $clave => $fila) {
                           $volumen[$clave] = $fila['7'];
                       }
                       array_multisort($volumen, SORT_DESC,$final);
                    }
                    else{

                    }
                    //$acceso2 = $this->binnacle_model->buscar_personasAPI($nombre,$tipoBusqueda,'Persona Moral',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
              break;

              default:
                  $tokenData = true;
                  // Create a token
                  //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                  // Set HTTP status code
                  $status = parent::HTTP_BAD_REQUEST;
                  $title_response = array(
                    'swagger'   =>  '2.0',
                    'info'  =>  array(
                      'version'  =>   'v1.0.0',
                      'title' =>  'API Searchperson',
                      'description'   =>  'API to search persons or enterprise in diffent kind of list'
                    ),
                  );

                  $host_response = array(
                      'host'  =>  $_SERVER["HTTP_HOST"],
                      'basePath'  =>  $_SERVER["REQUEST_URI"],
                      //'schemes'   =>  $_SERVER['HTTPS']
                      'schemes'   =>  'on'
                  );

                  $tags_response = array(
                      'name'  =>  'Response',
                      'description'   =>  'api to verify response'
                  );
                  $paths_response = array(
                        '/test_resp' => array(
                            'post'  =>  array(
                                'tags'  => array(
                                    'name'  =>  'Busquedas'
                                  ),
                                'description'   =>  'Search in list',
                              ),
                        ),
                  );
                  $parameters_response = array(
                      'result'=>'Opcion no valida'
                      );
                  $resp_response = array(
                          200 =>  array(
                              'description'   =>  'The record was saved successfully',
                              'headers'   =>  array(
                                  'StrictTransportSecurity'   =>  array(
                                      'type'  =>  'string',
                                      'description'   =>  'HTTPS strict transport security header',
                                      'default'   =>  'max-age=31536000',
                                  ),
                              ),
                          ),
                          403 =>  array(
                            'description'   =>  'The record was saved successfully',
                            'headers'   =>  array(
                                'StrictTransportSecurity'   =>  array(
                                    'type'  =>  'string',
                                    'description'   =>  'HTTPS strict transport security header',
                                    'default'   =>  'max-age=31536000',
                                ),
                            ),
                          ),
                        'Etag'  =>  array(
                            'type'  => 'string',
                            'description'   =>  'No update'
                        ),
                        'Cache-control' =>  array(
                              'type'  =>  'string',
                              'description'   =>  'Describes how long this response can be cached',
                              'default'   =>  'max-age=15552000'
                          ),
                        'X-Frame-Options'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Prevent this request from being loaded in any iframes',
                            'default'  =>   'DENY',
                        ),
                        'X-Content-Type-Options'    =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                            'default'  =>   'nosniff',
                        ),
                    );
                  $schema_response = array(
                      'schema'    => array(
                          'type'  =>  'object'
                      ),
                      'properties'    =>  array(
                          'meta'  =>  array(
                              'title' =>  'Meta data',
                              'type'  =>  'object',
                          ),
                          'properties'    =>  array(
                              'LastUpdate'    =>  array(
                                  'type'  =>  'string',
                                  'format'    =>  'date-time'
                              ),
                              'TotalResults'  =>  array(
                                  'type'  =>  'Integer'
                              ),
                          ),
                      ),
                      'Agreement' =>  array(
                          'type'  =>  'string',
                          'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                      ),
                  );
                  $license_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed'
                  );
                  $term_use_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed',
                      'required'  =>  array(
                          'LastUpdate'    =>  0,
                          'TotalResults'  =>  0,
                          'Agreement' =>  0,
                          'License'   =>  0,
                          'TermOfUse' =>  0,
                      ),
                      'additionalProperties'  =>  false

                  );


                  $response = array(
                      'status' => $status,
                      'title' =>  $title_response,
                      'host'  =>  $host_response,
                      'produces'  =>  'application/json',
                      'tags'  =>  $tags_response,
                      'paths' =>  $paths_response,
                      'parameters'    =>  $parameters_response,
                      'responses' =>  $resp_response,
                      'schema_and_meta_data'  =>  $schema_response,
                      'license'   =>  $license_response,
                      'termOfUse' =>  $term_use_response,
                  );

                  $this->response($response, $status);
              break;
            }

      }else{
        $tokenData = true;
        // Create a token
        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
        // Set HTTP status code
        $status = parent::HTTP_BAD_REQUEST;
        $title_response = array(
          'swagger'   =>  '2.0',
          'info'  =>  array(
            'version'  =>   'v1.0.0',
            'title' =>  'API Searchperson',
            'description'   =>  'API to search persons or enterprise in diffent kind of list'
          ),
        );

        $host_response = array(
            'host'  =>  $_SERVER["HTTP_HOST"],
            'basePath'  =>  $_SERVER["REQUEST_URI"],
            //'schemes'   =>  $_SERVER['HTTPS']
            'schemes'   =>  'on'
        );

        $tags_response = array(
            'name'  =>  'Response',
            'description'   =>  'api to verify response'
        );
        $paths_response = array(
              '/test_resp' => array(
                  'post'  =>  array(
                      'tags'  => array(
                          'name'  =>  'Busquedas'
                        ),
                      'description'   =>  'Search in list',
                    ),
              ),
        );
        $parameters_response = array(
            'result'=>'Sus datos estan incompletos, verifiquelos '
            );
        $resp_response = array(
                200 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                ),
                403 =>  array(
                  'description'   =>  'The record was saved successfully',
                  'headers'   =>  array(
                      'StrictTransportSecurity'   =>  array(
                          'type'  =>  'string',
                          'description'   =>  'HTTPS strict transport security header',
                          'default'   =>  'max-age=31536000',
                      ),
                  ),
                ),
              'Etag'  =>  array(
                  'type'  => 'string',
                  'description'   =>  'No update'
              ),
              'Cache-control' =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Describes how long this response can be cached',
                    'default'   =>  'max-age=15552000'
                ),
              'X-Frame-Options'   =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Prevent this request from being loaded in any iframes',
                  'default'  =>   'DENY',
              ),
              'X-Content-Type-Options'    =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                  'default'  =>   'nosniff',
              ),
          );
        $schema_response = array(
            'schema'    => array(
                'type'  =>  'object'
            ),
            'properties'    =>  array(
                'meta'  =>  array(
                    'title' =>  'Meta data',
                    'type'  =>  'object',
                ),
                'properties'    =>  array(
                    'LastUpdate'    =>  array(
                        'type'  =>  'string',
                        'format'    =>  'date-time'
                    ),
                    'TotalResults'  =>  array(
                        'type'  =>  'Integer'
                    ),
                ),
            ),
            'Agreement' =>  array(
                'type'  =>  'string',
                'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
            ),
        );
        $license_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed'
        );
        $term_use_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed',
            'required'  =>  array(
                'LastUpdate'    =>  0,
                'TotalResults'  =>  0,
                'Agreement' =>  0,
                'License'   =>  0,
                'TermOfUse' =>  0,
            ),
            'additionalProperties'  =>  false

        );


        $response = array(
            'status' => $status,
            'title' =>  $title_response,
            'host'  =>  $host_response,
            'produces'  =>  'application/json',
            'tags'  =>  $tags_response,
            'paths' =>  $paths_response,
            'parameters'    =>  $parameters_response,
            'responses' =>  $resp_response,
            'schema_and_meta_data'  =>  $schema_response,
            'license'   =>  $license_response,
            'termOfUse' =>  $term_use_response,
        );

        $this->response($response, $status);
      }


    }


    public function searchpersonYTPb_post(){
      $api_key_variable = $this->config->item('rest_key_name');
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      $apiK=$this->input->server($key_name);
      $entidad=  $this->binnacle_model->getID($apiK);

      if ($this->form_validation->run('searchperson_post')){
          //recibir valores
          $nombre= strtoupper(trim($this->post('nombre')));
            $apaterno= strtoupper(trim($this->post('apaterno')));
          $amaterno= strtoupper(trim($this->post('amaterno')));
          $tipo_busqueda= trim($this->post('tipo_busqueda'));
          $tipo_persona= strtoupper(trim($this->post('tipo_persona')));
          $curp= strtoupper(trim($this->post('curp')));
          $rfc= strtoupper(trim($this->post('rfc')));
            switch ($tipo_persona) {
              case 'FISICA':
                    $data = $this->post();
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $type= "f";
                    $rfc_ban 	= 0;

                    $full_name = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name2 = $nombre . " " . $apaterno . " " . $amaterno;
                    $full_name_search = $nombre . " " . $apaterno . " " . $amaterno; //AL porcentaje de coincidencia
                    $trimabuscar = trim($full_name);
                    $exist = false;
                    $this->load->helper('converter_to_uppercase');

                      $search = $this->busquedasb_model->busquedaYotepresto(converter_to_uppercase($trimabuscar), converter_to_uppercase($nombre), converter_to_uppercase($apaterno), converter_to_uppercase($amaterno),$rfc);
                      $tipoBusqueda='Busqueda normal';

                    if ($search)
                    {

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
                            $porcentaje==round($porcentaje,2);
                            if($porcentaje <'89.99%' and ($apiK=='KYC-omkM5J7jJprtyxO4p8NPfEY0va7BYRH/J7s28Q==' or $apiK=='KYC-gmlY9YuxM5v810m0ncx4bw1w3vSyJw==') ){


                            }
                            else{
                            $final[$num][0]=$fila->id;
                             $final[$num][1]=$full_name;
                             $final[$num][2]=$fila->pertenece;
                             $final[$num][3]=$fila->actividad;
                             $final[$num][4]=$fila->fecha;
                             $final[$num][5]=$fila->tipo;
                             $final[$num][6]=$stautus;
                             $final[$num][7]=round($porcentaje,2);
                             $num=$num+1;
                             $listas.=$fila->tipo." ";
                           }
                         }
                          //array bidimensional

                          $volumen= Array();

                          foreach ($final as $clave => $fila) {
                              $volumen[$clave] = $fila['7'];

                          }

                          // Ordenar los datos con volumen descendiente, edición ascendiente
                          // Agregar $datos como el último parámetro, para ordenar por la clave común
                          array_multisort($volumen, SORT_DESC,$final);
                          //echo json_encode($final);

                         //$acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica',$numeroC100,$num,$apiK,$listas);
                      }
                    }
                    //$acceso2 = $this->binnacle_model->buscar_personasAPI($full_name2,$tipoBusqueda,'Persona Fisica YTP',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                break;
              case 'MORAL':
                    $listas="";
                    $tipoBusqueda="";
                    $numeroC100=0;
                    $num=0;
                    $final = Array();
                    $stautus="";
                    $trimabuscar = converter_to_uppercase(trim($nombre));
                    $exist = false;
                    $rfc_ban = 0;


                      $id=1500;
                      $search = $this->busquedasb_model->busquedaYoteprestoM($nombre,$rfc);
                      $tipoBusqueda="Busqueda normal";

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
                         }
                         else {
                           $stautus='Baja, fecha de baja: '.$fila->updated_at;
                         }
                         $porcentaje==round($porcentaje,2);
                         if($porcentaje<'89.99%' and ($apiK=='KYC-omkM5J7jJprtyxO4p8NPfEY0va7BYRH/J7s28Q==' or $apiK=='KYC-gmlY9YuxM5v810m0ncx4bw1w3vSyJw==') ){

                          }
                         else{
                         $final[$num][0]=$fila->id;
                         $final[$num][1]=$full_name;
                         $final[$num][2]=$fila->pertenece;
                         $final[$num][3]=$fila->actividad;
                         $final[$num][4]=$fila->fecha;
                         $final[$num][5]=$fila->tipo;
                         $final[$num][6]=$stautus;
                         $final[$num][7]=round($porcentaje,2);
                         $num=$num+1;
                         $listas.=$fila->tipo." ";
                       }
                       }
                       $volumen= Array();
                       foreach ($final as $clave => $fila) {
                           $volumen[$clave] = $fila['7'];
                       }
                       array_multisort($volumen, SORT_DESC,$final);
                    }
                    else{

                    }
                    //$acceso2 = $this->binnacle_model->buscar_personasAPI($nombre,$tipoBusqueda,'Persona Moral YTP',$numeroC100,$num,$apiK,$listas,$entidad);
                    if(!empty($final)) {
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>$final
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
                    else{
                      $tokenData = true;
                      // Create a token
                      //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                      // Set HTTP status code
                      $status = parent::HTTP_OK;
                      $title_response = array(
                        'swagger'   =>  '2.0',
                        'info'  =>  array(
                          'version'  =>   'v1.0.0',
                          'title' =>  'API Searchperson',
                          'description'   =>  'API to search persons or enterprise in diffent kind of list'
                        ),
                      );

                      $host_response = array(
                          'host'  =>  $_SERVER["HTTP_HOST"],
                          'basePath'  =>  $_SERVER["REQUEST_URI"],
                          //'schemes'   =>  $_SERVER['HTTPS']
                          'schemes'   =>  'on'
                      );

                      $tags_response = array(
                          'name'  =>  'Response',
                          'description'   =>  'api to verify response'
                      );
                      $paths_response = array(
                            '/test_resp' => array(
                                'post'  =>  array(
                                    'tags'  => array(
                                        'name'  =>  'Busquedas'
                                      ),
                                    'description'   =>  'Search in list',
                                  ),
                            ),
                      );
                      $parameters_response = array(
                          'result'=>'No existe la persona ingresada'
                          );
                      $resp_response = array(
                              200 =>  array(
                                  'description'   =>  'The record was saved successfully',
                                  'headers'   =>  array(
                                      'StrictTransportSecurity'   =>  array(
                                          'type'  =>  'string',
                                          'description'   =>  'HTTPS strict transport security header',
                                          'default'   =>  'max-age=31536000',
                                      ),
                                  ),
                              ),
                              403 =>  array(
                                'description'   =>  'The record was saved successfully',
                                'headers'   =>  array(
                                    'StrictTransportSecurity'   =>  array(
                                        'type'  =>  'string',
                                        'description'   =>  'HTTPS strict transport security header',
                                        'default'   =>  'max-age=31536000',
                                    ),
                                ),
                              ),
                            'Etag'  =>  array(
                                'type'  => 'string',
                                'description'   =>  'No update'
                            ),
                            'Cache-control' =>  array(
                                  'type'  =>  'string',
                                  'description'   =>  'Describes how long this response can be cached',
                                  'default'   =>  'max-age=15552000'
                              ),
                            'X-Frame-Options'   =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Prevent this request from being loaded in any iframes',
                                'default'  =>   'DENY',
                            ),
                            'X-Content-Type-Options'    =>  array(
                                'type'  =>  'string',
                                'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                                'default'  =>   'nosniff',
                            ),
                        );
                      $schema_response = array(
                          'schema'    => array(
                              'type'  =>  'object'
                          ),
                          'properties'    =>  array(
                              'meta'  =>  array(
                                  'title' =>  'Meta data',
                                  'type'  =>  'object',
                              ),
                              'properties'    =>  array(
                                  'LastUpdate'    =>  array(
                                      'type'  =>  'string',
                                      'format'    =>  'date-time'
                                  ),
                                  'TotalResults'  =>  array(
                                      'type'  =>  'Integer'
                                  ),
                              ),
                          ),
                          'Agreement' =>  array(
                              'type'  =>  'string',
                              'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                          ),
                      );
                      $license_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed'
                      );
                      $term_use_response = array(
                          'description'   =>  'To be confirmed',
                          'type'  =>  'string',
                          'format'    =>  'uri',
                          'enum'  =>  'To be confirmed',
                          'required'  =>  array(
                              'LastUpdate'    =>  0,
                              'TotalResults'  =>  0,
                              'Agreement' =>  0,
                              'License'   =>  0,
                              'TermOfUse' =>  0,
                          ),
                          'additionalProperties'  =>  false

                      );


                      $response = array(
                          'status' => $status,
                          'title' =>  $title_response,
                          'host'  =>  $host_response,
                          'produces'  =>  'application/json',
                          'tags'  =>  $tags_response,
                          'paths' =>  $paths_response,
                          'parameters'    =>  $parameters_response,
                          'responses' =>  $resp_response,
                          'schema_and_meta_data'  =>  $schema_response,
                          'license'   =>  $license_response,
                          'termOfUse' =>  $term_use_response,
                      );

                      $this->response($response, $status);
                    }
              break;

              default:
                  $tokenData = true;
                  // Create a token
                  //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
                  // Set HTTP status code
                  $status = parent::HTTP_BAD_REQUEST;
                  $title_response = array(
                    'swagger'   =>  '2.0',
                    'info'  =>  array(
                      'version'  =>   'v1.0.0',
                      'title' =>  'API Searchperson',
                      'description'   =>  'API to search persons or enterprise in diffent kind of list'
                    ),
                  );

                  $host_response = array(
                      'host'  =>  $_SERVER["HTTP_HOST"],
                      'basePath'  =>  $_SERVER["REQUEST_URI"],
                      //'schemes'   =>  $_SERVER['HTTPS']
                      'schemes'   =>  'on'
                  );

                  $tags_response = array(
                      'name'  =>  'Response',
                      'description'   =>  'api to verify response'
                  );
                  $paths_response = array(
                        '/test_resp' => array(
                            'post'  =>  array(
                                'tags'  => array(
                                    'name'  =>  'Busquedas'
                                  ),
                                'description'   =>  'Search in list',
                              ),
                        ),
                  );
                  $parameters_response = array(
                      'result'=>'Opcion no valida'
                      );
                  $resp_response = array(
                          200 =>  array(
                              'description'   =>  'The record was saved successfully',
                              'headers'   =>  array(
                                  'StrictTransportSecurity'   =>  array(
                                      'type'  =>  'string',
                                      'description'   =>  'HTTPS strict transport security header',
                                      'default'   =>  'max-age=31536000',
                                  ),
                              ),
                          ),
                          403 =>  array(
                            'description'   =>  'The record was saved successfully',
                            'headers'   =>  array(
                                'StrictTransportSecurity'   =>  array(
                                    'type'  =>  'string',
                                    'description'   =>  'HTTPS strict transport security header',
                                    'default'   =>  'max-age=31536000',
                                ),
                            ),
                          ),
                        'Etag'  =>  array(
                            'type'  => 'string',
                            'description'   =>  'No update'
                        ),
                        'Cache-control' =>  array(
                              'type'  =>  'string',
                              'description'   =>  'Describes how long this response can be cached',
                              'default'   =>  'max-age=15552000'
                          ),
                        'X-Frame-Options'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Prevent this request from being loaded in any iframes',
                            'default'  =>   'DENY',
                        ),
                        'X-Content-Type-Options'    =>  array(
                            'type'  =>  'string',
                            'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                            'default'  =>   'nosniff',
                        ),
                    );
                  $schema_response = array(
                      'schema'    => array(
                          'type'  =>  'object'
                      ),
                      'properties'    =>  array(
                          'meta'  =>  array(
                              'title' =>  'Meta data',
                              'type'  =>  'object',
                          ),
                          'properties'    =>  array(
                              'LastUpdate'    =>  array(
                                  'type'  =>  'string',
                                  'format'    =>  'date-time'
                              ),
                              'TotalResults'  =>  array(
                                  'type'  =>  'Integer'
                              ),
                          ),
                      ),
                      'Agreement' =>  array(
                          'type'  =>  'string',
                          'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
                      ),
                  );
                  $license_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed'
                  );
                  $term_use_response = array(
                      'description'   =>  'To be confirmed',
                      'type'  =>  'string',
                      'format'    =>  'uri',
                      'enum'  =>  'To be confirmed',
                      'required'  =>  array(
                          'LastUpdate'    =>  0,
                          'TotalResults'  =>  0,
                          'Agreement' =>  0,
                          'License'   =>  0,
                          'TermOfUse' =>  0,
                      ),
                      'additionalProperties'  =>  false

                  );


                  $response = array(
                      'status' => $status,
                      'title' =>  $title_response,
                      'host'  =>  $host_response,
                      'produces'  =>  'application/json',
                      'tags'  =>  $tags_response,
                      'paths' =>  $paths_response,
                      'parameters'    =>  $parameters_response,
                      'responses' =>  $resp_response,
                      'schema_and_meta_data'  =>  $schema_response,
                      'license'   =>  $license_response,
                      'termOfUse' =>  $term_use_response,
                  );

                  $this->response($response, $status);
              break;
            }

      }else{
        $tokenData = true;
        // Create a token
        //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.dHJ1ZQ.4-gmjSSooAYhnkXrvkR-zNwJmAU60tEaB65yPLm3o40';
        // Set HTTP status code
        $status = parent::HTTP_BAD_REQUEST;
        $title_response = array(
          'swagger'   =>  '2.0',
          'info'  =>  array(
            'version'  =>   'v1.0.0',
            'title' =>  'API Searchperson',
            'description'   =>  'API to search persons or enterprise in diffent kind of list'
          ),
        );

        $host_response = array(
            'host'  =>  $_SERVER["HTTP_HOST"],
            'basePath'  =>  $_SERVER["REQUEST_URI"],
            //'schemes'   =>  $_SERVER['HTTPS']
            'schemes'   =>  'on'
        );

        $tags_response = array(
            'name'  =>  'Response',
            'description'   =>  'api to verify response'
        );
        $paths_response = array(
              '/test_resp' => array(
                  'post'  =>  array(
                      'tags'  => array(
                          'name'  =>  'Busquedas'
                        ),
                      'description'   =>  'Search in list',
                    ),
              ),
        );
        $parameters_response = array(
            'result'=>'Sus datos estan incompletos, verifiquelos '
            );
        $resp_response = array(
                200 =>  array(
                    'description'   =>  'The record was saved successfully',
                    'headers'   =>  array(
                        'StrictTransportSecurity'   =>  array(
                            'type'  =>  'string',
                            'description'   =>  'HTTPS strict transport security header',
                            'default'   =>  'max-age=31536000',
                        ),
                    ),
                ),
                403 =>  array(
                  'description'   =>  'The record was saved successfully',
                  'headers'   =>  array(
                      'StrictTransportSecurity'   =>  array(
                          'type'  =>  'string',
                          'description'   =>  'HTTPS strict transport security header',
                          'default'   =>  'max-age=31536000',
                      ),
                  ),
                ),
              'Etag'  =>  array(
                  'type'  => 'string',
                  'description'   =>  'No update'
              ),
              'Cache-control' =>  array(
                    'type'  =>  'string',
                    'description'   =>  'Describes how long this response can be cached',
                    'default'   =>  'max-age=15552000'
                ),
              'X-Frame-Options'   =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Prevent this request from being loaded in any iframes',
                  'default'  =>   'DENY',
              ),
              'X-Content-Type-Options'    =>  array(
                  'type'  =>  'string',
                  'description'   =>  'Ensures each page has a content type and prevents browsers from doing MIME type sniffing',
                  'default'  =>   'nosniff',
              ),
          );
        $schema_response = array(
            'schema'    => array(
                'type'  =>  'object'
            ),
            'properties'    =>  array(
                'meta'  =>  array(
                    'title' =>  'Meta data',
                    'type'  =>  'object',
                ),
                'properties'    =>  array(
                    'LastUpdate'    =>  array(
                        'type'  =>  'string',
                        'format'    =>  'date-time'
                    ),
                    'TotalResults'  =>  array(
                        'type'  =>  'Integer'
                    ),
                ),
            ),
            'Agreement' =>  array(
                'type'  =>  'string',
                'enum'  =>  'El uso de la API y el dato que sea intercambiado a través de esta será '
            ),
        );
        $license_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed'
        );
        $term_use_response = array(
            'description'   =>  'To be confirmed',
            'type'  =>  'string',
            'format'    =>  'uri',
            'enum'  =>  'To be confirmed',
            'required'  =>  array(
                'LastUpdate'    =>  0,
                'TotalResults'  =>  0,
                'Agreement' =>  0,
                'License'   =>  0,
                'TermOfUse' =>  0,
            ),
            'additionalProperties'  =>  false

        );


        $response = array(
            'status' => $status,
            'title' =>  $title_response,
            'host'  =>  $host_response,
            'produces'  =>  'application/json',
            'tags'  =>  $tags_response,
            'paths' =>  $paths_response,
            'parameters'    =>  $parameters_response,
            'responses' =>  $resp_response,
            'schema_and_meta_data'  =>  $schema_response,
            'license'   =>  $license_response,
            'termOfUse' =>  $term_use_response,
        );

        $this->response($response, $status);
      }


    }






}
