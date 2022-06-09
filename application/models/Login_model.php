<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model{


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    public function validarsesion($username, $password){
      $pwd=md5(crypt($password, 'rl'));
      $query = $this->db->query("SELECT count(id) as id from access_listas where email='" . $username ."' and pwd='" .$pwd."' and status='active' " );
      $row = $query->row();
			return $row->id;
    }

    public function get_Consulta_access($username,$password)
    {
      $pwd=md5(crypt($password, 'rl'));

      $search = "
      SELECT * FROM access_listas WHERE email='" . $username ."' and pwd='" .$pwd."' and status='active' ";
      echo $search;
      $query = $this->db->query($search);
      return $query->result_array();

    }





}
