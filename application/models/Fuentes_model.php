<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');


class Fuentes_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

      /*Visalizar fuentes*/
      /*Pagina de listas*/
      public function total_listas(){
        return $query = $this->db->get('cat_listas')->num_rows();

      }
      public function total_registros(){

        $query = $this->db->query("SELECT SUM(numero)as suma FROM cat_listas;");
  			$row = $query->row();
  			return $row->suma;

      }
      public function get_fuentes() {
          $entidad=$this->session->userdata('entidad');
          return $this->db->get_where('fuentes_informacion',array('estatus' => 'active','id_entidad'=>$entidad))->result_array();
      }
      /* Inicio ABC de las listas */
      public function new_Fuente ($data){
          $this->db->insert('fuentes_informacion', $data);
  		    $result = ($this->db->affected_rows() > 0) ? true : false;
          return $result;
      }
      public function delete_Fuente($id){
        $this->db->where('id',$id);
        $this->db->update('fuentes_informacion',['estatus' => 'inactive']);
        $result = ($this->db->affected_rows() > 0) ? true : false;
        return $result;
      }
      public function edit_Fuente($id,$data){
        $this->db->where('id',$id);
        $this->db->update('fuentes_informacion',$data);
        $result = ($this->db->affected_rows() > 0) ? true : false;
        return $result;
      }



}
