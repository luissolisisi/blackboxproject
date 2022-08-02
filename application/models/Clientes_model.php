<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');


class Clientes_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    public function get_table_record_row($table,$data_search){
        $query = $this->db->get_where($table, $data_search);
        
        try {
            $resp = array(
                'status' => true,
                'error' => '',
                'resp' => $query->row()
            );
        } catch (\Exception $e) {
            $resp = array(
                'status' => false,
                'error' => $e->getMessage(),
            );
        }

        return $resp;
    }
    
    public function get_table_record_result($table,$data_search){
        $query = $this->db->get_where($table, $data_search);
        
        try {
            $resp = array(
                'status' => true,
                'error' => '',
                'resp' => $query->result()
            );
        } catch (\Exception $e) {
            $resp = array(
                'status' => false,
                'error' => $e->getMessage(),
            );
        }

        return $resp;
    }
    
    public function get_table_all($table){
        
        $query = $this->db->get($table);
        
        try {
            $resp = array(
                'status' => true,
                'error' => '',
                'resp' => $query->result()
            );
        } catch (\Exception $e) {
            $resp = array(
                'status' => false,
                'error' => $e->getMessage(),
            );
        }

        return $resp;
    }
    
    public function update_record($column, $value_column, $table, $data) {
        $this->db->where($column, $value_column);
        $this->db->update($table, $data);

        try {

            $resp = array(
                'status' => true,
                'error' => ''
            );
        } catch (Exception $ex) {

            $resp = array(
                'status' => false,
                'error' => $ex->getMessage()
            );
        }


        return $resp;
    }
    
    function allposts_count($estatus = null) {
        if ($estatus != null) {
            $this->db->where('status', $estatus);
        }
        //$this->db->where('customer_brasil = 0');
        $query = $this->db->get('book_clientes');
        return $query->num_rows();
    }
    
    function allposts($limit, $start, $col, $dir, $estatus = null) {
        $query1 = "SET @numero := 0, @type := NULL";
        $this->db->query($query1);
        $this->db->select('*');
        $this->db->select("@numero:=@numero+1 AS 'orden'");
        $this->db->from('book_clientes');
        if ($estatus != null) {

            $this->db->where("status = $estatus");
        }
        
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();


        /* $query_set  =   "SET @numero=0;";
          $this->db->query($query_set);

          $query = $this->db->select('*')
          ->select('@numero:=@numero+1 AS `posicion`')
          ->from('book_clientes')
          ->limit($limit,$start)
          ->order_by($col,$dir)
          ->get();
         */


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }
    
    function posts_search($limit, $start, $search, $col, $dir, $estatus = null) {
        
        $query1 = "SET @numero := 0, @type := NULL";
        $this->db->query($query1);
        $this->db->select('*');

        if ($estatus != null) {
            $estatus = "`status` = " . $estatus . " and";
        } else {
            $estatus = "`status` != 4 and";
        }
        $limits = null;
        if ($limit != 'NaN') {
            $limits = "LIMIT " . $start . ", " . $limit;
        }

        
        
        
        $query1 = "SELECT *, @numero:=@numero+1 AS 'orden' FROM `book_clientes` WHERE " . $estatus . " (CONCAT_WS(' ', nombre,apaterno,amaterno) LIKE '%" . $search . "%' OR `nombre` LIKE '%" . $search . "%' ESCAPE '!' OR `apaterno` LIKE '%" . $search . "%' ESCAPE '!' OR `amaterno` LIKE '%" . $search . "%' ESCAPE '!' OR `tipo` LIKE '%" . $search . "%' ESCAPE '!' OR `rfc` LIKE '%" . $search . "%' ESCAPE '!' ) ORDER BY " . $col . " " . $dir . " " . $limits . " "; //ORDER BY `nombre` LIMIT 50
        $query = $this->db->query($query1);


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }
    
    function posts_search_count($search, $estatus = null) {
        if (!empty($estatus)) {
            $this->db->where('estado', $estatus);
        }
        //$this->db->where('customer_brasil = 0');
        $query = $this->db->like('id', $search)
                ->or_like('nombre', $search)
                ->or_like('apaterno', $search)
                ->or_like('amaterno', $search)
                ->or_like('rfc', $search)
                ->or_like('tipo', $search)
                ->get('book_clientes');
        return $query->num_rows();
    }


}
