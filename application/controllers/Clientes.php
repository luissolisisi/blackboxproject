<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->model('clientes_model');
        if (!logged_in()) {
            $this->session->set_flashdata('message', 'Tiempo expirado, ingrese denuevo ');
            $this->data['message'] = $this->session->flashdata('message');
            redirect('login/pagina_login', $this->data);
        }
    }

    public function get_clientes() {
        //AB LO TENEMOS QUE COMENTAR EN PROXIMAS VERSIONES:
        //$this->customers_model->check_null_customers(); // - AL 0,1,2
        $this->load->view('header');
        menu_arriba();

        $this->load->view('clientes/clientes_all');

        $this->load->view('footer');
    }

    public function get_rules_ko_express($id_customer) {

//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';

        $data_search_cliente = array(
            'id' => $id_customer,
        );

        $score_rules_ok_express = 0;

        $customer = $this->clientes_model->get_table_record_row('book_clientes', $data_search_cliente);

        $rules_express = $this->clientes_model->get_table_all('rules_ok_express');
        
        $rulesOK = array();

        foreach ($rules_express['resp'] as $re) {

            if ($re->id == 1) {
                if ((int) $customer['resp']->age >= 18 && (int) $customer['resp']->age <= 69) {
                    $score_rules_ok_express += 1;
                    
                    $array_edad = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->age,
                        'caumple'   =>  1,
                    );
                    
                    array_push($rulesOK,$array_edad);
                }else{
                    $array_edad = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->age,
                        'caumple'   =>  0,
                    );
                    
                    array_push($rulesOK,$array_edad);
                }
            } elseif ($re->id == 2) {
                if ($customer['resp']->estado == 'CIUDAD DE MEXICO') {
                    $score_rules_ok_express += 1;
                    
                    $array_cobertura = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->estado,
                        'caumple'   =>  1,
                    );
                    
                    array_push($rulesOK,$array_cobertura);
                }else{
                    $array_cobertura = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->estado,
                        'caumple'   =>  0,
                    );
                    
                    array_push($rulesOK,$array_cobertura);
                }
            } elseif ($re->id == 3) {
                if (floatval($customer['resp']->bcs_score) <= 614) {
                    $score_rules_ok_express += 1;
                    
                    $array_bcScore = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->bcs_score,
                        'caumple'   =>  1,
                    );
                    
                    array_push($rulesOK,$array_bcScore);
                }else{
                    $array_bcScore = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->bcs_score,
                        'caumple'   =>  0,
                    );
                    
                    array_push($rulesOK,$array_bcScore);
                }
            } elseif ($re->id == 4) {
                if (floatval($customer['resp']->fico_score) <= 580) {
                    $score_rules_ok_express += 1;
                    
                    $array_ficoScore = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->fico_score,
                        'caumple'   =>  1,
                    );
                    
                    array_push($rulesOK,$array_ficoScore);
                }else{
                    $array_ficoScore = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->fico_score,
                        'caumple'   =>  0,
                    );
                    
                    array_push($rulesOK,$array_ficoScore);
                }
            } elseif ($re->id == 5) {
                if (floatval($customer['resp']->ultimas_consultas) >= 15) {
                    $score_rules_ok_express += 1;
                    
                    $array_consultas = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->ultimas_consultas,
                        'caumple'   =>  1,
                    );
                    
                    array_push($rulesOK,$array_consultas);
                }else{
                    $array_consultas = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->ultimas_consultas,
                        'caumple'   =>  0,
                    );
                    
                    array_push($rulesOK,$array_consultas);
                }
            } elseif ($re->id == 6) {
                if (floatval($customer['resp']->mop4_saldos_totales) >= 40) {
                    $score_rules_ok_express += 1;
                    
                    $array_mpSaldo = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->mop4_saldos_totales,
                        'caumple'   =>  1,
                    );
                    
                    array_push($rulesOK,$array_mpSaldo);
                }else{
                    $array_mpSaldo = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->mop4_saldos_totales,
                        'caumple'   =>  0,
                    );
                    
                    array_push($rulesOK,$array_mpSaldo);
                }
            } elseif ($re->id == 7) {
                if (floatval($customer['resp']->mop9_financieras) > 0) {
                    $score_rules_ok_express += 1;
                    
                    $array_mpFinanciera = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->mop9_financieras,
                        'caumple'   =>  1,
                    );
                    
                    array_push($rulesOK,$array_mpFinanciera);
                }else{
                    $array_mpFinanciera = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->mop9_financieras,
                        'caumple'   =>  0,
                    );
                    
                    array_push($rulesOK,$array_mpFinanciera);
                }
            } elseif ($re->id == 8) {
                if (floatval($customer['resp']->demandas) == 0) {
                    $score_rules_ok_express += 1;
                    
                    $array_demandas = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->demandas,
                        'caumple'   =>  1,
                    );
                    
                    array_push($rulesOK,$array_demandas);
                }else{
                    $array_demandas = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->demandas,
                        'caumple'   =>  0,
                    );
                    
                    array_push($rulesOK,$array_demandas);
                }
            } elseif ($re->id == 9) {
                if (floatval($customer['resp']->pld) == 0) {
                    $score_rules_ok_express += 1;
                    
                    $array_pld = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->pld,
                        'caumple'   =>  1,
                    );
                    
                    array_push($rulesOK,$array_pld);
                }else{
                    $array_pld = array(
                        'criterio'  =>  $re->criterio,
                        'rule'  =>  $re->rule,
                        'valor' =>  $customer['resp']->pld,
                        'caumple'   =>  0,
                    );
                    
                    array_push($rulesOK,$array_pld);
                }
            }
        }

        if (count($rules_express['resp']) == $score_rules_ok_express) {

            $data_update_score = array(
                'status_rules' => 1,
            );

            $this->clientes_model->update_record('id', $id_customer, 'book_clientes', $data_update_score);
        }
        
        return $rulesOK;

        //var_dump($count_criterios);
    }

    public function clientes_all() {
        
        $columns = array(
            0 => 'orden',
            1 => 'nombre',
            2 => 'rfc',
            3 => 'estado',
            
            4 => 'estatus',
            5 => 'reglas',
            6 => 'id',
            
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->clientes_model->allposts_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->clientes_model->allposts($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];
            $posts = $this->clientes_model->posts_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->clientes_model->posts_search_count($search);
        }

        $i = 1;
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['orden'] = $post->orden;
                $nestedData['nombre'] = substr(strip_tags($post->nombre . ' ' . $post->apaterno . ' ' . $post->amaterno), 0, 70);
                $nestedData['rfc'] = $post->rfc;
                $nestedData['estado'] = $post->estado;
                
//                $producto = $this->clientes_model->get_table_record_row('cat_productos',array('clave' => $post->producto));
//                
//                $nestedData['producto'] = $producto['resp']->nombre;
                
                //label label-success
                if($post->status_rules == 1){
                    $celdaRulesOk = "<td><span class='label label-success'>Success</span></td>";
                } else{
                    $celdaRulesOk = "<td><span class='label label-danger'>Danger</span></td>";
                }
                
                if($post->status == 1){
                    $nestedData['estatus'] = 'ACTIVO';
                }elseif($post->status == 2){
                    $nestedData['estatus'] = 'DESACTIVADO';
                }
                
                $nestedData['reglas'] = $celdaRulesOk;
                $nestedData['id'] = '<td class="center"><a href="' . base_url('clientes/profile_cliente/') . $post->id . '"><i class="fas fa-folder-open"></i></a></td>';

                $data[] = $nestedData;
                $i++;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
    
    public function profile_cliente($id_customer){
        
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
        
        $respCustomer = $this->clientes_model->get_table_record_row('book_clientes',array('id' => $id_customer));
        
        $customer = array();
        
        $respTipoPersona = $this->clientes_model->get_table_record_row('cat_personas',array('id' => $respCustomer['resp']->tipo_persona));

        $respProducto = $this->clientes_model->get_table_record_row('cat_productos',array('clave' => $respCustomer['resp']->producto));

        $respStatus = $this->clientes_model->get_table_record_row('cat_status',array('id' => $respCustomer['resp']->status));

        $rulesOk = $this->get_rules_ko_express($id_customer);
        
        $respServicios = $this->clientes_model->get_table_record_row('book_servicios',array('id_expediente' => $respCustomer['resp']->id));
        
        

        $arrayCustomer = array(
            'id'    =>  $respCustomer['resp']->id,
            'nombre'    =>  $respCustomer['resp']->nombre,
            'apaterno'  =>  $respCustomer['resp']->apaterno,
            'amaterno'  =>  $respCustomer['resp']->amaterno,
            'tipo_persona'  =>  $respTipoPersona['resp']->nombre,
            'rfc'   =>  $respCustomer['resp']->rfc,
            'curp'  =>  $respCustomer['resp']->curp,
            'age'   =>  $respCustomer['resp']->age,
            'latitude'  =>  $respCustomer['resp']->latitude,
            'length'    =>  $respCustomer['resp']->length,
            'municipio' =>  $respCustomer['resp']->municipio,
            'estado'    =>  $respCustomer['resp']->estado,
            'fuente_ingresos'   =>  $respCustomer['resp']->fuente_ingresos,
            
            'status_rules'    =>  $respCustomer['resp']->status_rules,
            'status'    =>  $respStatus['resp']->nombre,
            'rulesOk'   =>  $rulesOk,
            'matrizPerfilamiento'   =>  $respServicios['resp'],
        );

        array_push($customer,$arrayCustomer);
            
        
        
        $data['customer'] = $customer;
        
        $this->load->view('header');
        menu_arriba();

        $this->load->view('clientes/profile_cliente',$data);

        $this->load->view('footer');
    }
    
    public function customer_new(){
        
        $cat_personas = $this->clientes_model->get_table_all('cat_personas');
        
        $cat_productos = $this->clientes_model->get_table_all('cat_productos');
        
        $data['cat_personas'] = $cat_personas['resp'];
        
        $data['cat_productos'] = $cat_productos['resp'];
        
        $this->load->view('header');
        menu_arriba();

        $this->load->view('clientes/form_new_customer',$data);

        $this->load->view('footer');
    }
    
    public function insert_customer(){

        $demanda = 0;

        if($this->input->post('demandas') == 'on'){
            $demanda = 1;
        }else{
            $demanda = 0;
        }

        $pld = 0;

        if($this->input->post('pld') == 'on'){
            $pld = 1;
        }else{
            $pld = 0;
        }

        $dataInsertCustomer = array(

            'nombre'    =>  $this->input->post('nombre'),
            'apaterno'  =>  $this->input->post('apaterno'),
            'amaterno'  =>  $this->input->post('amaterno'),
            'tipo_persona'  =>  $this->input->post('tipo_persona'),
            'rfc'  =>  $this->input->post('rfc'),
            'curp'  =>  $this->input->post('curp'),
            'age'  =>  $this->input->post('age'),
            'municipio'  =>  $this->input->post('municipio'),
            'estado'  =>  $this->input->post('estado'),
            'fuente_ingresos'  =>  $this->input->post('fuente_ingresos'),
            'bcs_score'  =>  $this->input->post('bcs_score'),
            'fico_score'  =>  $this->input->post('fico_score'),
            'ultimas_consultas'  =>  $this->input->post('ultimas_consultas'),
            'mop4_saldos_totales'  =>  $this->input->post('mop4_saldos_totales'),
            'mop9_financieras'  =>  $this->input->post('mop9_financieras'),
            'demandas'  =>  $pld,
            'pld'  =>  $this->input->post('pld'),
            'producto'  =>  $this->input->post('producto'),
            'created_date'  =>  date('Y-m-d H:i:s'),
            'status'    =>  1
            
        );

        $id_expediente = $this->clientes_model->insert_customer($dataInsertCustomer);

        $dataInsertServicio = array(

            'clave_producto'  =>  $this->input->post('clave_producto'),
            'monto_solicitado'  =>  $this->input->post('monto_solicitado'),
            'id_expediente'  =>  $id_expediente['id'],
            'plazos'  =>  $this->input->post('plazos'),
            'plazo_promedio'  =>  $this->input->post('plazo_promedio'),
            'monto_promedio'  =>  $this->input->post('monto_promedio'),
            'credito_promedio'  =>  $this->input->post('credito_promedio'),
            'destino_credito'  =>  $this->input->post('destino_credito'),
            
        );

        $this->clientes_model->insert_servicio($dataInsertServicio);

        if($id_expediente['status'] == true){
            $response = $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                'text' => 'Insertado correctamente',
                'status' => 200
            )));
        }else{
            $response = $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                'text' => 'No se pudo registrar el cliente',
                'status' => 500
            )));
        }

        

        return $response;            
        
        
    }

}
