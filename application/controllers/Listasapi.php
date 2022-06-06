<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Listasapi extends REST_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('listas_model');
        $this->load->model('binnacle_model');
        $this->load->helper('converter_to_uppercase');
        $this->db = $this->load->database("default", TRUE);
    }
    /*
    private function verify_request() {
        // Get all the headers
        $headers = $this->input->request_headers();

        // Extract the token
        $token = $headers['Authorization'];

        // Use try-catch
        // JWT library throws exception if the token is not valid
        try {
            // Validate the token
            // Successfull validation will return the decoded user data else returns false
            $data = AUTHORIZATION::validateToken($token);
            if ($data === false) {
                $status = parent::HTTP_UNAUTHORIZED;
                $response = ['status' => $status, 'msg' => 'Unauthorized Access!'];
                $this->response($response, $status);

                exit();
            } else {
                return $data;
            }
        } catch (Exception $e) {
            // Token is invalid
            // Send the unathorized access message
            $status = parent::HTTP_UNAUTHORIZED;
            $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
            $this->response($response, $status);
        }
    }
    */
    public function paises_post() {
        $this->load->library('form_validation');
        $pais = $this->post('pais');

        if ($this->form_validation->run('paises_post')) {

            $pais = $this->post('pais');
            $country = $this->listas_model->get_pais($pais);

            if (empty($country) == 1) {
              $datarespuesta = array(
                  array(
                      'pais' => $pais,
                      'error' =>$status = parent::HTTP_BAD_REQUEST,
                      'message' => 'NO EXISTE EL PAIS INGRESADO'


                  )
              );

            }else{
            foreach ($country as $p):
              $pais1=$p['pais'];
              $no_cooperante=$p['no_cooperante'];
              $paraiso=$p['paraiso'];
              $deficiencia=$p['deficiencia'];
              $alerta=$p['alerta'];
              $riesgo=$p['riesgo'];
            endforeach;

            switch ($riesgo) {
              case '30':
                $riesgo='BAJO';
                break;
              case '70':
                  $riesgo='MEDIO';
              break;
              case '100':
                    $riesgo='ALTO';
              break;

              case '3':
                    $riesgo='ALTO';
              break;

              default:
                    $riesgo = 'SIN RIESGO';
                break;
            }
            if($alerta== 1){
              $alerta = 'CON ALERTAMIENTO';
            }
            else{
              $alerta = 'SIN ALERTAMIENTO';
            }


            if($no_cooperante== 1){
              $no_cooperante = 'NO COOPERANTE';
            }
            else{
              $no_cooperante = 'SIN OBSERVACIONES';
            }

            if($paraiso== 1){
              $paraiso = 'PARAISO FISCAL';
            }
            else{
              $paraiso = 'SIN OBSERVACIONES';
            }

            if($deficiencia== 1){
              $deficiencia = 'CON DEFICIENCIAS';
            }
            else{
              $deficiencia = 'SIN OBSERVACIONES';
            }

            $this->db = $this->load->database("default", TRUE);

            $datarespuesta = array(
                array(
                    'pais' => $pais1,
                    'no_cooperante' => $no_cooperante,
                    'paraiso_fiscal' => $paraiso,
                    'deficiencia' => $deficiencia,
                    'alerta' => $alerta,
                    'riesgo' => $riesgo

                )
            );
          }





            $resp_com = $this->resp($datarespuesta);

            $this->response($resp_com);
        } else {
            $response = array(
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'HAY ERRORES EN EL ENVÍO DE INFORMACIÓN.',
                'errors' => '',
            );
            $resp_com = $this->resp($response);
            $this->response($resp_com, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function test_post(){
      echo 'hola';
    }


    public function lpbIngreso_post() {
        $this->load->library('form_validation');
        if ($this->form_validation->run('lpb_post')) {

            ///ingreso de los datos
            $nombre = $this->post('nombre');
            $apaterno = $this->post('paterno');
            $amaterno = $this->post('materno');
            $rfc = $this->post('rfc');
            $curp = $this->post('curp');
            $nacionalidad = $this->post('nacionalidad');
            $nombre_completo =$nombre. ' '. $apaterno.' '.$amaterno;

            $full_name= str_replace("'", " ", $nombre_completo);
            $full_name= str_replace("-", " ", $full_name);
            $full_name= str_replace(".", "", $full_name);
            $full_name= str_replace(",", "", $full_name);
            $alias = $full_name;

            $observaciones = $this->post('observaciones');
            $actividad = $this->post('actividad');
            $fecha = $this->post('fecha');
            $tipo = 'LPB';
            $situacion = $this->post('situacion_contribuyente');
            $oficio = $this->post('numero_oficio');
            $status = 'active';
            $created = date('Y-m-d');
            $id_entidad = $this->post('id_entidad');

            $data = array(
              'nombre' => $nombre,
              'apaterno' => $apaterno,
              'amaterno' => $amaterno,
              'rfc' => $rfc,
              'curp' => $curp,
              'nacionalidad' => $nacionalidad,
              'alias' => $full_name,
              'observaciones' => $observaciones,
              'actividad' => $actividad,
              'fecha' => $fecha,
              'tipo' => $tipo,
              'situacion_del_contribuyente' => $situacion,
              'numero_oficio_personas_bloqueadas' => $oficio,
              'status' => $status,
              'created_at' => $created,
              'id_entidad' => $id_entidad,
              'nombre_completo'=> $nombre_completo


            );
            $acceso = $this->listas_model->new_Person($data);

            $datarespuesta = array(
                array(
                    'Nombre' => $nombre_completo,
                    'Lista' => $tipo,
                    'Estatus' => 'Registro ingresado correctamente',

                )
            );









            $resp_com = $this->resp($datarespuesta);

            $this->response($resp_com);
        } else {
            $response = array(
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'HAY ERRORES EN EL ENVÍO DE INFORMACIÓN.',
                'errors' => '',
            );
            $resp_com = $this->resp($response);
            $this->response($resp_com, REST_Controller::HTTP_BAD_REQUEST);
        }
    }







    public function resp($response_api) {
        $title_response = array(
            'swagger' => '2.0',
            'info' => array(
                'version' => 'v1.0.0',
                'title' => 'Bulk Load',
                'description' => 'API insert multiple records'
            ),
        );

        $host_response = array(
            //'host' => $_SERVER["HTTP_HOST"],
            'basePath' => $_SERVER["REQUEST_URI"],
            //'schemes' => $_SERVER['HTTPS']
        );

        $tags_response = array(
            'name' => 'Bulk Load',
            'description' => 'Search Countries'
        );

        $paths_response = array(
            '/paises' => array(
                'post' => array(
                    'tags' => array(
                        'name' => 'pais'
                    ),
                    'description' => 'Get country information',
                    'parameters' => array(
                        array(
                            'name' => 'pais',
                            'type' => 'text',
                            'description' => 'Name of country',
                            'in' => 'body',
                            'required' => true
                        ),
                    ),
                ),
            ),
            '/lpbIngreso' => array(
                'post' => array(
                    'tags' => array(
                        'name' => 'Alta de LPB'
                    ),
                    'description' => 'API to create a person from blocked person lists',
                    'parameters' => array(
                        array(
                            'name' => 'name',
                            'type' => 'text',
                            'description' => 'Name of people or company',
                            'in' => 'body',
                            'required' => true
                        ),
                        array(
                            'name' => 'paterno',
                            'type' => 'text',
                            'description' => 'First family name',
                            'in' => 'body',
                            'required' => false
                        ),
                        array(
                            'name' => 'materno',
                            'type' => 'text',
                            'description' => 'Second family name',
                            'in' => 'body',
                            'required' => false
                        ),
                        array(
                            'name' => 'rfc',
                            'type' => 'text',
                            'description' => 'RFC of the people o company ',
                            'in' => 'body',
                            'required' => false
                        ),
                        array(
                            'name' => 'curp',
                            'type' => 'text',
                            'description' => 'CURP of the people',
                            'in' => 'body',
                            'required' => false
                        ),
                        array(
                            'name' => 'nacionalidad',
                            'type' => 'text',
                            'description' => 'Country of birth',
                            'in' => 'body',
                            'required' => false
                        ),
                        array(
                            'name' => 'observaciones',
                            'type' => 'text',
                            'description' => 'Coments about the person',
                            'in' => 'body',
                            'required' => false
                        ),
                        array(
                            'name' => 'actividad',
                            'type' => 'text',
                            'description' => 'person´s activity',
                            'in' => 'body',
                            'required' => false
                        ),
                        array(
                            'name' => 'situacion_contribuyente',
                            'type' => 'text',
                            'description' => 'Civil status of the person',
                            'in' => 'body',
                            'required' => false
                        ),
                        array(
                            'name' => 'numero_oficio',
                            'type' => 'text',
                            'description' => 'official number issued by the CNBV',
                            'in' => 'body',
                            'required' => false
                        ),
                        array(
                            'name' => 'id_entidad',
                            'type' => 'text',
                            'description' => 'entity id',
                            'in' => 'body',
                            'required' => false
                        ),
                    ),
                ),
            )


        );

        $resp_response = array(
            200 => array(
                'description' => 'The country exists in the record',
                'headers' => array(
                    'StrictTransportSecurity' => array(
                        'type' => 'string',
                        'description' => 'HTTPS strict transport security header',
                        'default' => 'max-age=31536000',
                    ),
                ),
            ),
            400 => array(
                'description' => 'Error bd',
                'headers' => array(
                    'StrictTransportSecurity' => array(
                        'type' => 'string',
                        'description' => 'HTTPS strict transport security header',
                        'default' => 'max-age=31536000',
                    ),
                ),
            ),
            400 => array(
                'description' => 'The country provided does not exist.',
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

        $security_response = array(
            'ApiKeyAuth' => array(
                'type' => 'apiKey',
                'in' => 'header',
                'name' => 'X-API-KEY'
            ),
            'TokenAuth' => array(
                'type' => 'apiKey',
                'in' => 'header',
                'name' => 'Authorization'
            ),
        );


        $response = array(
            'title' => $title_response,
            'host' => $host_response,
            'securityDefinitions' => $security_response,
            'produces' => 'application/json',
            'tags' => $tags_response,
            'paths' => $paths_response,
            'responses' => $resp_response,
            'schema_and_meta_data' => $schema_response,
            'license' => $license_response,
            'termOfUse' => $term_use_response,
            'response_api' => $response_api
        );

        return $response;
    }

}
