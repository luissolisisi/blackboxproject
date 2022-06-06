<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');


class Dashboard_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }
    public function nacionales($pais){
      $query =$this->db->query("SELECT clave_pertenece,numero  FROM cat_listas WHERE pais ='".$pais."' AND STATUS='active';");
      return $query->result_array();
    }
    public function internacional(){
      $query =$this->db->query("SELECT count(NUMERO) as numero, continente FROM cat_listas  GROUP BY continente");
      return $query->result_array();
    }

    //dash2
    //numero de busquedas
    public function get_totalBusquedas(){
      $entidad=$this->session->userdata('entidad');
      $query = $this->db->query("SELECT COUNT(id) as total from listas_binnacle WHERE id_entidad='".$entidad."' AND seccion='Buscar'");
			$row = $query->row();
			return $row->total;
    }
    //numero de usuarios
    public function get_totalUsuarios(){
      $entidad=$this->session->userdata('entidad');
      $query = $this->db->query("SELECT COUNT(id) as usuarios FROM access_listas WHERE identidad=".$entidad);
			$row = $query->row();
			return $row->usuarios;
    }
    //listas universales
    public function universales(){
      $query =$this->db->query("SELECT SUM(numero) as numero, clave_pertenece FROM cat_listas where continente='UNIVERSALES' GROUP BY clave_pertenece");
      return $query->result_array();
    }
    //paises
      //mexico o nacionalos
      public function nacionales1($pais){
        $query =$this->db->query("SELECT count(numero) as mn FROM cat_listas WHERE pais ='".$pais."' AND STATUS='active';");
        $row = $query->row();
  			return $row->mn;
      }
      //estados unidos
      public function usa(){
        $query =$this->db->query("SELECT count(numero) as usn  FROM cat_listas WHERE pais ='EE.UU.' AND STATUS='active';");
        $row = $query->row();
  			return $row->usn;
      }
      //continentes
      public function otros($pais){
        $query =$this->db->query("SELECT COUNT(numero) as otro FROM cat_listas WHERE pais !='EE.UU.' and pais !='".$pais."' AND STATUS='active';");
        $row = $query->row();
  			return $row->otro;
      }
}
