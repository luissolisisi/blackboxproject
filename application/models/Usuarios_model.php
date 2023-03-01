<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');


class Usuarios_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }
    public function get_Usuarios() {
        $entidad=$this->session->userdata('entidad');
        return $this->db->get_where('access_listas', array('status' => 'active','idEntidad'=>$entidad))->result_array();
    }
    public function new_Usuario ($data){
        $this->db->insert('access_listas', $data);
		    $result = ($this->db->affected_rows() > 0) ? true : false;
        return $result;
    }
    public function delete_Usuario($id,$data){
      $this->db->where('id',$id);
      $this->db->update('access_listas',$data);
      $result = ($this->db->affected_rows() > 0) ? true : false;
      return $result;
    }
    public function edit_Usuario($id,$data){
      $this->db->where('id',$id);
      $this->db->update('access_listas',$data);
      $result = ($this->db->affected_rows() > 0) ? true : false;
      return $result;
    }

    public function get_usuario($id){
        $query = $this->db->get_where('access_listas', array('id' => $id));
        return $query->result();
    }
    public function changePwd ($id,$data){
      $this->db->where('id',$id);
      $this->db->update('access_listas',$data);
      $result = ($this->db->affected_rows() > 0) ? true : false;
      return $result;
    }

    //$usuario=$this->session->userdata('name');
}

/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */
