<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Muffin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if (!logged_in()) {
            $this->session->set_flashdata('message', 'Tiempo expirado, ingrese denuevo ');
            $this->data['message'] = $this->session->flashdata('message');
            redirect('login/pagina_login', $this->data);
        }
    }

    public function get_data_muffin() {
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://app.moffin.mx/api/v1/forms");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $parameters = array(
            
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            
            "Authorization: Token 8699a069f6b97a7f015872bab6103910cb7c3b0ed952bceb8a2675e9b2d05894"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        

        return json_decode($response);

    }

    public function customers_muffin_all(){

        $customers = array();

        $respCustomers = $this->get_data_muffin();

        foreach($respCustomers->results as $rc){

            $array = array(

                'id'    =>  $rc->id,
                'accountType'   =>  $rc->accountType,
                'name' =>  $rc->firstName.' '.$rc->middleName.' '.$rc->firstLastName.' '.$rc->secondLastName,
                'rfc'   =>  $rc->rfc,
                'curp'  =>  $rc->curp,
                'email' =>  $rc->email
                

            );

            array_push($customers, $array);

        }

        $data['customers'] = $customers; 

        $this->load->view('header');
        menu_arriba();

        $this->load->view('muffin/get_clientes',$data);

        $this->load->view('footer');

        
    }

    public function get_clientes_muffin() {
        //AB LO TENEMOS QUE COMENTAR EN PROXIMAS VERSIONES:
        //$this->customers_model->check_null_customers(); // - AL 0,1,2
        $this->load->view('header');
        menu_arriba();

        $this->load->view('clientes/clientes_all');

        $this->load->view('footer');
    }

    public function profile_cliente_muffin($id_customer){
        
        
        
        $respCustomer = $this->get_data_muffin_profile($id_customer);

        
        
        $customer = array(

            'id'    =>  $respCustomer->id,
            'accountType'   =>  $respCustomer->accountType,
            'firstName' =>  $respCustomer->firstName,
            'middleName'    =>  $respCustomer->middleName,
            'firstLastName' =>  $respCustomer->firstLastName,
            'secondLastName'    =>  $respCustomer->secondLastName,
            'tradeName' =>  $respCustomer->tradeName,
            'rfc'   =>  $respCustomer->rfc,
            'curp'  =>  $respCustomer->curp,
            'nationality'   =>  $respCustomer->nationality,
            'birthdate' =>  $respCustomer->birthdate,
            'address'   =>  $respCustomer->address,
            'address2'  =>  $respCustomer->address2,
            'exteriorNumber'    =>  $respCustomer->exteriorNumber,
            'interiorNumber'    =>  $respCustomer->interiorNumber,
            'neighborhood'  =>  $respCustomer->neighborhood,
            'city'  =>  $respCustomer->city,
            'state' =>  $respCustomer->state,
            'zipCode'   =>  $respCustomer->zipCode,
            'country'   =>  $respCustomer->country,
            'municipality'  =>  $respCustomer->municipality,
            'monthlyIncome' =>  $respCustomer->monthlyIncome,
            'loanAmount'    =>  $respCustomer->loanAmount,
            'extraInformation'  =>  $respCustomer->extraInformation,
            'completedDate' =>  $respCustomer->completedDate,
            'profileId' =>  $respCustomer->profileId,
            'createdAt' =>  $respCustomer->createdAt,
            'updatedAt' =>  $respCustomer->updatedAt,
            'formConfig'    =>  $respCustomer->formConfig,
            'email' =>  $respCustomer->email,
            'phone' =>  $respCustomer->phone

        );
        
        
        
        

        $data['customer'] = $customer;
        
        $this->load->view('header');
        menu_arriba();

        $this->load->view('muffin/profile_cliente_muffin',$data);

        $this->load->view('footer');
    }

    public function get_data_muffin_profile($id) {
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://app.moffin.mx/api/v1/forms/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $parameters = array(
            
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            
            "Authorization: Token 8699a069f6b97a7f015872bab6103910cb7c3b0ed952bceb8a2675e9b2d05894"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        

        return json_decode($response);

    }

    

}
