<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');


class Busquedas_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }


    /*Pagina de las busquedas */
    public function get_totalBusquedas(){
      $entidad=$this->session->userdata('entidad');
      $query = $this->db->query("SELECT sum(busqueda) as total from listas_binnacle WHERE id_entidad='".$entidad."' AND seccion='Buscar'");
			$row = $query->row();
			return $row->total;
    }
    public function get_nacionales(){
      return $this->db->get_where('cat_listas',array('status' => 'active','clave_tipo'=>'Nacional'))->result_array();
    }
    public function get_internacionales(){
      $this->db->group_by("nombre");
      return $this->db->get_where('cat_listas',array('status' => 'active','clave_tipo'=>'Internacional'))->result_array();
    }
    public function get_list($id = 0){
		   $result = $this->db->get_where('cat_lists', array('id' => $id));
		   if ($result->num_rows() > 0)
		   {
			    return $result->result();
		   }
		   return Array();
	  }

    public function get_listN($id = 0){
		   $result = $this->db->get_where('book_listas', array('id' => $id));
		   if ($result->num_rows() > 0)
		   {
			    return $result->result();
		   }
		   return Array();
	  }

    /*Busqueda para persona fisica*/
    public function buscar_exacta($nombre, $apaterno, $amaterno,$rfc, $curp,$status = "active"){
            $id_entidad=$this->session->userdata('entidad');
            $fullname = $nombre.$apaterno.$amaterno;
            $fullname1 = $nombre." ".$apaterno." ".$amaterno;
            if (!empty($rfc && $curp)){
               $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1' and rfc = '$rfc' and curp = '$curp' AND
               (id_entidad=1500 OR id_entidad='$id_entidad')";
            }
            elseif(!empty ($curp)){
                $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1' and curp = '$curp' AND
                (id_entidad=1500 OR id_entidad='$id_entidad')";
            }
            elseif(!empty ($rfc)){
                $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1'  and rfc = '$rfc'AND
                (id_entidad=1500 OR id_entidad='$id_entidad')";
            }
            else{
                $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1' AND
                (id_entidad=1500 OR id_entidad='$id_entidad')";
            }
            $query = $this->db->query($search);


            $rows = $query->custom_result_object('Busquedas_model');

            if (isset($rows)){
                foreach ($rows as $row){
                  $row->id = intval($row->id);
                  $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
                }
            }

            return $rows;
    }

    /*Busqueda para persona fisica para propld plb*/
    public function buscar_exacta_pld_dont_lpb($nombre, $apaterno, $amaterno,$rfc, $curp,$status = "active"){
            $fullname = $nombre.$apaterno.$amaterno;
            $fullname1 = $nombre." ".$apaterno." ".$amaterno;
            if (!empty($rfc && $curp)){
               $search = "SELECT * FROM cat_lists where pertence != 'LPB' and concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1' and rfc = '$rfc' and curp = '$curp'";
            }
            elseif(!empty ($curp)){
                $search = "SELECT * FROM cat_lists where pertence != 'LPB' and concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1' and curp = '$curp'";
            }
            elseif(!empty ($rfc)){
                $search = "SELECT * FROM cat_lists where pertence != 'LPB' and concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1'  and rfc = '$rfc'";
            }
            else{
                $search = "SELECT * FROM cat_lists where pertence != 'LPB' and concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1'";
            }
            $query = $this->db->query($search);

            if (empty($query->num_rows())){
                $query = $this->db->get_where('cat_lists', array('nombre' => $nombre.' '.$apaterno.' '.$amaterno));
                if (empty($query->num_rows())){
                  $query = $this->db->get_where('cat_lists', array('nombre' => $apaterno.' '.$amaterno.' '.$nombre ));
                }
            }
            $rows = $query->custom_result_object('Busquedas_model');

            if (isset($rows)){
                foreach ($rows as $row){
                  $row->id = intval($row->id);
                  $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
                }
            }

            return $rows;
    }

    /*Busqueda para persona fisica para propld plb*/
    public function buscar_exacta_lpb($nombre, $apaterno, $amaterno,$rfc, $curp,$id_entidad,$status = "active"){
            $fullname = $nombre.$apaterno.$amaterno;
            $fullname1 = $nombre." ".$apaterno." ".$amaterno;
            if (!empty($rfc && $curp)){
               $search = "SELECT * FROM cat_lists where id_entidad = $id_entidad and pertence = 'LPB' and concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1' and rfc = '$rfc' and curp = '$curp'";
            }
            elseif(!empty ($curp)){
                $search = "SELECT * FROM cat_lists where id_entidad = $id_entidad and pertence = 'LPB' and concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1' and curp = '$curp'";
            }
            elseif(!empty ($rfc)){
                $search = "SELECT * FROM cat_lists where id_entidad = $id_entidad and pertence = 'LPB' and concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1'  and rfc = '$rfc'";
            }
            else{
                $search = "SELECT * FROM cat_lists where id_entidad = $id_entidad and pertence = 'LPB' and concat(nombre,apaterno,amaterno) = '$fullname' or alias='$fullname1'";
            }
            $query = $this->db->query($search);

            if (empty($query->num_rows())){
                $query = $this->db->get_where('cat_lists', array('nombre' => $nombre.' '.$apaterno.' '.$amaterno));
                if (empty($query->num_rows())){
                  $query = $this->db->get_where('cat_lists', array('nombre' => $apaterno.' '.$amaterno.' '.$nombre ));
                }
            }
            $rows = $query->custom_result_object('Busquedas_model');

            if (isset($rows)){
                foreach ($rows as $row){
                  $row->id = intval($row->id);
                  $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
                }
            }

            return $rows;
    }

    public function buscar($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="", $status = "active"){
        $id_entidad=$this->session->userdata('entidad');
    		if(!empty($rfc) && !empty($curp))	{
    			$search =  "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where rfc='".$rfc."' AND curp = '".$curp."' AND
          (id_entidad=1500 or id_entidad=0 OR id_entidad IS NULL OR id_entidad='$id_entidad')";
    		}
    		elseif (!empty($rfc) ){
    			$search =  "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where rfc='".$rfc."'AND
          (id_entidad=1500 or id_entidad=0 OR id_entidad IS NULL OR id_entidad='$id_entidad')";
    		}
    		elseif (!empty($curp) ){
    			$search =  "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias  FROM cat_lists where curp='".$curp."'AND
          (id_entidad=1500 or id_entidad='$id_entidad')";
    		}
    		else{
    			$search = "
    						SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
     						FROM cat_lists
     						WHERE ( concat_ws(' ', nombre, apaterno, amaterno)
    	   				  	LIKE '%".$trimabuscar."%'
                    OR alias ='".$trimabuscar."'
    	   				  	OR (nombre LIKE '%".$nombre."%'
    	   				  	AND apaterno = '".$apaterno."'
    						    AND amaterno = '".$amaterno."') AND
                    (id_entidad=1500 or id_entidad=".$id_entidad."))";
    			$search_order = " ORDER BY id DESC;";
        	$search .= $search_order;
    		}
        //echo $search;
        //exit;
    		$query = $this->db->query($search);



    		$rows = $query->custom_result_object('Busquedas_model');

        if (isset($rows)){
    			foreach ($rows as $row){
    				$row->id = intval($row->id);
    				$row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
    			}
    		}
    		return $rows;
    }
    public function buscarApi($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="", $status = "active",$idE){
       $fullname = $nombre.$apaterno.$amaterno;
       $fullname1 = $nombre." ".$apaterno." ".$amaterno;
       $entidad= $idE;

       	if(!empty($rfc) && !empty($curp))	{
    			$search =  "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where rfc='".$rfc."' AND curp = '".$curp."'";
    		}
    		elseif (!empty($rfc) ){
    			$search =  "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where rfc='".$rfc."'";
    		}
    		elseif (!empty($curp) ){
    			$search =  "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where curp='".$curp."'";
    		}
    		else{
    			$search = "
          SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
          FROM cat_lists
          WHERE ( concat_ws(' ', nombre, apaterno, amaterno)
              LIKE '%".$trimabuscar."%'
              OR alias ='".$trimabuscar."'
              OR (nombre LIKE '%".$nombre."%'
              AND apaterno = '".$apaterno."'
              AND amaterno = '".$amaterno."') AND
              (id_entidad=1500 or id_entidad=".$entidad."))";
            $search_order = " ORDER BY id DESC;";
            $search .= $search_order;
    		}
        $query = $this->db->query($search);


    		$rows = $query->custom_result_object('Busquedas_model');

        if (isset($rows)){
    			foreach ($rows as $row){
    				$row->id = intval($row->id);
    				$row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
    			}
    		}
    		return $rows;
    }

    //busqueda para propld sin lista lpb
    public function buscarApi_propld($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="", $status = "active"){
    		if(!empty($rfc) && !empty($curp))	{
    			$search =  "SELECT * FROM cat_lists where and pertenece != 'LPB' and rfc='".$rfc."' AND curp = '".$curp."'";
    		}
    		elseif (!empty($rfc) ){
    			$search =  "SELECT * FROM cat_lists where pertenece != 'LPB' and rfc='".$rfc."'";
    		}
    		elseif (!empty($curp) ){
    			$search =  "SELECT * FROM cat_lists where pertenece != 'LPB' and curp='".$curp."'";
    		}
    		else{
    			$search = "
    						SELECT *
     						FROM cat_lists
     						WHERE pertenece != 'LPB' and ( concat_ws(' ', nombre, apaterno, amaterno)
    	   				  	LIKE '%".$trimabuscar."%'
                    OR alias='".$trimabuscar."'
    	   				  	OR nombre LIKE '%".$nombre."%'
    	   				  	AND apaterno = '".$apaterno."'
    						    AND amaterno = '".$amaterno."') and id_entidad=1500";
    			$search_order = " ORDER BY id DESC;";
        	$search .= $search_order;
    		}

    		$query = $this->db->query($search);

    		if (empty($query->num_rows())){
    			$query = $this->db->get_where('cat_lists', array('nombre' => $nombre.' '.$apaterno.' '.$amaterno));
    			if (empty($query->num_rows())){
    				$query = $this->db->get_where('cat_lists', array('nombre' => $apaterno.' '.$amaterno.' '.$nombre));
    			}
    		}

    		$rows = $query->custom_result_object('Busquedas_model');

        if (isset($rows)){
    			foreach ($rows as $row){
    				$row->id = intval($row->id);
    				$row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
    			}
    		}
    		return $rows;
    }

    //busqueda para propld con lista lpb
    public function buscarApi_propld_lpb($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="",$id_entidad, $status = "active"){
    		if(!empty($rfc) && !empty($curp))	{
    			$search =  "SELECT * FROM cat_lists where and pertenece = 'LPB' and id_entidad = $id_entidad and rfc='".$rfc."' AND curp = '".$curp."'";
    		}
    		elseif (!empty($rfc) ){
    			$search =  "SELECT * FROM cat_lists where pertenece = 'LPB' and id_entidad = $id_entidad and rfc='".$rfc."'";
    		}
    		elseif (!empty($curp) ){
    			$search =  "SELECT * FROM cat_lists where pertenece = 'LPB' and id_entidad = $id_entidad and curp='".$curp."'";
    		}
    		else{
    			$search = "
    						SELECT *
     						FROM cat_lists
     						WHERE pertenece = 'LPB' and id_entidad = $id_entidad and ( concat_ws(' ', nombre, apaterno, amaterno)
    	   				  	LIKE '%".$trimabuscar."%'
                    OR alias='".$trimabuscar."'
    	   				  	OR nombre LIKE '%".$nombre."%'
    	   				  	AND apaterno = '".$apaterno."'
    						    AND amaterno = '".$amaterno."' AND pertenece = 'LPB' and id_entidad = $id_entidad)";
    			$search_order = " ORDER BY id DESC;";
        	$search .= $search_order;
    		}

    		$query = $this->db->query($search);

    		if (empty($query->num_rows())){
    			$query = $this->db->get_where('cat_lists', array('nombre' => $nombre.' '.$apaterno.' '.$amaterno));
    			if (empty($query->num_rows())){
    				$query = $this->db->get_where('cat_lists', array('nombre' => $apaterno.' '.$amaterno.' '.$nombre));
    			}
    		}

          //print_r($this->db->last_query());
          //var_dump($query->num_rows());
          //if (empty($query->num_rows())){
          //$query = $this->db->get_where('cat_lists', array('nombre' => $nombre.' '.$apaterno.' '.$amaterno));
          //if (empty($query->num_rows())){
          //$query = $this->db->get_where('cat_lists', array('nombre' => $apaterno.' '.$amaterno.' '.$nombre));
          //}
          //}

    		$rows = $query->custom_result_object('Busquedas_model');
                //var_dump($rows);
        if (isset($rows)){
    			foreach ($rows as $row){
    				$row->id = intval($row->id);
    				$row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
    			}
    		}
                //var_dump($query);
    		return $rows;
    }

    public function search_rfc($rfc =''){
  	     $query = $this->db->get_where('cat_lists', array('rfc' => $rfc));
  	     if ($query->num_rows() > 0){
	          return true;
  	     }
         else{
           return false;
         }
    }
    public function buscar_extendida($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="", $status = "active"){
          $id_entidad=$this->session->userdata('entidad');
          $search = "
          SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
          FROM cat_lists
          WHERE  (id_entidad=1500 OR id_entidad=".$id_entidad.") AND
          (nombre LIKE '%".$nombre."%'
          or apaterno LIKE '%".$apaterno."%'
          or amaterno LIKE '%".$amaterno."%'
          OR alias='".$trimabuscar."'
          AND rfc LIKE '%". $rfc."%'
          AND curp LIKE '%". $curp."%')";
            $search_order = " ORDER BY id DESC;";
            $search .= $search_order;
          $query = $this->db->query($search);
          $rows = $query->custom_result_object('Busquedas_model');

          if (isset($rows)){
            foreach ($rows as $row){
              $row->id = intval($row->id);
              $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
            }
          }
          return $rows;
      }

    public function buscar_extendidaapi($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="", $status = "active"){
            $id_entidad=$this->session->userdata('entidad');
            $search = "
            SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
            FROM cat_lists
            WHERE  (id_entidad=1500 ) AND
            (nombre LIKE '%".$nombre."%'
            or apaterno LIKE '%".$apaterno."%'
            or amaterno LIKE '%".$amaterno."%'
            OR alias='".$trimabuscar."'
            )";
              $search_order = " ORDER BY id DESC;";

            $search .= $search_order;

            $query = $this->db->query($search);



            $rows = $query->custom_result_object('Busquedas_model');

            if (isset($rows)){
              foreach ($rows as $row){
                $row->id = intval($row->id);
                $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
              }
            }
            return $rows;
        }

        //BUSQUEDA PARA PROPLD SIN LPB
        public function buscar_extendidaapi_pld_dont_lpb($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="", $status = "active"){
            $search = "
            SELECT *
            FROM cat_lists
            WHERE nombre LIKE '%".$nombre."%'
            or apaterno LIKE '%".$apaterno."%'
            AND amaterno LIKE '%".$amaterno."%'
            OR alias='".$trimabuscar."'
            AND rfc LIKE '%". $rfc."%'
            AND curp LIKE '%". $curp."%' AND pertenece != 'LPB'";
              $search_order = " ORDER BY id DESC;";
              $search .= $search_order;
            $query = $this->db->query($search);

            if (empty($query->num_rows())){
              $query = $this->db->get_where('cat_lists', array('nombre' => $nombre.' '.$apaterno.' '.$amaterno));
              if (empty($query->num_rows())){
                $query = $this->db->get_where('cat_lists', array('nombre' => $apaterno.' '.$amaterno.' '.$nombre));
              }
            }

            $rows = $query->custom_result_object('Busquedas_model');

            if (isset($rows)){
              foreach ($rows as $row){
                $row->id = intval($row->id);
                $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
              }
            }
            return $rows;
        }

        //BUSQUEDA PARA PROPLD SOLO LPB
        public function buscar_extendidaapi_pld_lpb($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="",$id_entidad, $status = "active"){
            $search = "
            SELECT *
            FROM cat_lists
            WHERE nombre LIKE '%".$nombre."%'
            or apaterno LIKE '%".$apaterno."%'
            AND amaterno LIKE '%".$amaterno."%'
            OR alias='".$trimabuscar."'
            AND rfc LIKE '%". $rfc."%'
            AND curp LIKE '%". $curp."%' AND id_entidad=$id_entidad AND pertenece = 'LPB'";
              $search_order = " ORDER BY id DESC;";
              $search .= $search_order;
            $query = $this->db->query($search);

            if (empty($query->num_rows())){
              $query = $this->db->get_where('cat_lists', array('nombre' => $nombre.' '.$apaterno.' '.$amaterno));
              if (empty($query->num_rows())){
                $query = $this->db->get_where('cat_lists', array('nombre' => $apaterno.' '.$amaterno.' '.$nombre));
              }
            }

            $rows = $query->custom_result_object('Busquedas_model');

            if (isset($rows)){
              foreach ($rows as $row){
                $row->id = intval($row->id);
                $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
              }
            }
            return $rows;
        }

    /*Busqueda para persona Moral*/
    public function buscar_exacta_m($nombre,$rfc,$status = "active"){
            $id_entidad=$this->session->userdata('entidad');
          if(!empty($rfc)){
              $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where nombre = '$nombre' or alias='$nombre' and rfc = '$rfc' AND
              (id_entidad=1500 or id_entidad=0 OR id_entidad IS NULL OR id_entidad=$id_entidad)";
          }
          else{
              $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where (id_entidad=1500 or id_entidad=0 OR id_entidad IS NULL OR id_entidad=$id_entidad)
                and (nombre = '$nombre' or alias='$nombre')";
          }
          $query = $this->db->query($search);

          $rows = $query->custom_result_object('busquedas_model');
          if (isset($rows)){
              foreach ($rows as $row){
                  $row->id = intval($row->id);
                  $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
              }
          }
          return $rows;
          }
    public function buscar_exacta_mApi($nombre,$rfc,$status = "active"){
        if(!empty($rfc)){
            $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where nombre = '$nombre' or alias='$nombre' and rfc = '$rfc'";
        }
        else{
            $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where nombre = '$nombre' or alias='$nombre'";
        }
        $query = $this->db->query($search);

        $rows = $query->custom_result_object('busquedas_model');
        if (isset($rows)){
            foreach ($rows as $row){
                  $row->id = intval($row->id);
                  $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
            }
        }
        return $rows;
    }

    //api para utilizar la busqueda de personas morales en propld
    public function buscar_exacta_mApi_pld($nombre,$rfc,$status = "active"){
        if(!empty($rfc)){
            $search = "SELECT * FROM cat_lists where nombre = '$nombre' or alias='$nombre' and rfc = '$rfc' and pertence != 'LPB'";
        }
        else{
            $search = "SELECT * FROM cat_lists where nombre = '$nombre' and pertence != 'LPB'";
        }
        $query = $this->db->query($search);
        if (empty($query->num_rows())){
            $query = $this->db->get_where('cat_lists', array('nombre' => $nombre));
            if (empty($query->num_rows())){
                $query = $this->db->get_where('cat_lists', array('nombre' => $nombre));
            }
        }
        $rows = $query->custom_result_object('busquedas_model');
        if (isset($rows)){
            foreach ($rows as $row){
                  $row->id = intval($row->id);
                  $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
            }
        }
        return $rows;
    }

    //api para utilizar la busqueda de personas morales en propld sobre la lista lpb
    public function buscar_exacta_mApi_pld_lpb($nombre,$rfc,$id_entidad,$status = "active"){
        if(!empty($rfc)){
            $search = "SELECT * FROM cat_lists where nombre = '$nombre' or alias='$nombre' and rfc = '$rfc' and pertence = 'LPB' and id_entidad = $id_entidad";
        }
        else{
            $search = "SELECT * FROM cat_lists where nombre = '$nombre' and pertence = 'LPB' and id_entidad = $id_entidad";
        }
        $query = $this->db->query($search);
        if (empty($query->num_rows())){
            $query = $this->db->get_where('cat_lists', array('nombre' => $nombre));
            if (empty($query->num_rows())){
                $query = $this->db->get_where('cat_lists', array('nombre' => $nombre));
            }
        }
        $rows = $query->custom_result_object('busquedas_model');
        if (isset($rows)){
            foreach ($rows as $row){
                  $row->id = intval($row->id);
                  $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
            }
        }
        return $rows;
    }

    public function unblock_person($data, $id){
		   $query = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = 'related_trade' AND TABLE_NAME = 'cat_lists' AND TABLE_SCHEMA = '".$this->db_g->database."' ");
		   if ($query->num_rows() == 0){
			      $query = $this->db_g->query("ALTER TABLE cat_lists ADD related_trade varchar(50)  NULL");
		   }

       $query = $this->db_g->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = 'reason' AND TABLE_NAME = 'cat_lists' AND TABLE_SCHEMA = '".$this->db_g->database."' ");
		   if ($query->num_rows() == 0){
			     $query = $this->db_g->query("ALTER TABLE cat_lists ADD reason varchar(50)  NULL");
		   }

       $this->db->where('id', $id);
		   $this->db->update('cat_lists', $data);

		  if($this->db_g->affected_rows() > 0):
			    return true;
		  endif;
		  return false;
    }
    public function buscar_extendida_m($nombre,$rfc,$status = "active"){
      $id_entidad=$this->session->userdata('entidad');
      if(!empty($rfc)){
          $search = "
          SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
          FROM cat_lists
          WHERE (id_entidad=1500 OR id_entidad=".$id_entidad.") AND
              (nombre LIKE '%".$nombre."%'
              OR alias like'%".$nombre."%'
              OR rfc LIKE '%".$rfc."%')";
          $search_order = " ORDER BY id DESC;";
          $search .= $search_order;
      }
      else{
        $search = "
              SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
              FROM cat_lists
              WHERE  nombre
                  LIKE '%".$nombre."%'
                  OR alias ='".$nombre."'
                  OR (nombre LIKE '%".$nombre."%'
                ) AND
                  (id_entidad=1500 or id_entidad=".$id_entidad.")";
        $search_order = " ORDER BY id DESC;";
        $search .= $search_order;
      }
      $query = $this->db->query($search);

      $rows = $query->custom_result_object('busquedas_model');
      if (isset($rows)){
          foreach ($rows as $row){
              $row->id = intval($row->id);
              $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
          }
      }
      return $rows;
    }
    public function buscar_extendida_mApi($nombre,$rfc,$status = "active"){
      $id_entidad=$this->session->userdata('entidad');
      if(!empty($rfc)){
        $search = "
        SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
        FROM cat_lists
        WHERE (id_entidad=1500) AND
            (nombre LIKE '%".$nombre."%'
            OR alias like'%".$nombre."%'
            OR rfc LIKE '%".$rfc."%')";
        $search_order = " ORDER BY id DESC;";
        $search .= $search_order;
      }
      else{
        $search = "
              SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
              FROM cat_lists
              WHERE  nombre
                  LIKE '%".$nombre."%'
                  OR alias ='".$nombre."'
                  OR (nombre LIKE '%".$nombre."%'
                ) AND
                  (id_entidad=1500)";
        $search_order = " ORDER BY id DESC;";
        $search .= $search_order;
      }

      $query = $this->db->query($search);

      $rows = $query->custom_result_object('busquedas_model');
      if (isset($rows)){
          foreach ($rows as $row){
              $row->id = intval($row->id);
              $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
          }
      }
      return $rows;
    }
    /*Fin de pagina de busqueda*/

    //busqueda extendida para propld
    public function buscar_extendida_mApi_propld($nombre,$rfc,$status = "active"){
      if(!empty($rfc)){
          $search = "
          SELECT *
          FROM cat_lists
          WHERE and pertenece != 'LPB' and nombre LIKE '%".$nombre."%'
                  OR rfc LIKE '%".$rfc."%' and id_entidad=1500";

          $search_order = " ORDER BY id DESC;";
          $search .= $search_order;
      }
      else{
        $search = "
        SELECT *
        FROM cat_lists
        WHERE nombre LIKE '%".$nombre."%' and id_entidad=1500";
        $search_order = " ORDER BY id DESC;";
        $search .= $search_order;
      }
      $query = $this->db->query($search);
      if (empty($query->num_rows())){
          $query = $this->db->get_where('cat_lists', array('nombre' => $nombre));
          if (empty($query->num_rows())){
            $query = $this->db->get_where('cat_lists', array('nombre' => $nombre));
          }
      }
      $rows = $query->custom_result_object('busquedas_model');
      if (isset($rows)){
          foreach ($rows as $row){
              $row->id = intval($row->id);
              $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
          }
      }
      return $rows;
    }

    //busqueda extendida para propld en la lista LPB
    public function buscar_extendida_mApi_propld_lpb($nombre,$rfc,$id_entidad,$status = "active"){
      if(!empty($rfc)){
          $search = "
          SELECT *
          FROM cat_lists
          WHERE and pertenece = 'LPB' and id_entidad = $id_entidad and nombre LIKE '%".$nombre."%'
                  OR rfc LIKE '%".$rfc."%'";

          $search_order = " ORDER BY id DESC;";
          $search .= $search_order;
      }
      else{
        $search = "
        SELECT *
        FROM cat_lists
        WHERE nombre LIKE '%".$nombre."%'";
        $search_order = " ORDER BY id DESC;";
        $search .= $search_order;
      }
      $query = $this->db->query($search);
      if (empty($query->num_rows())){
          $query = $this->db->get_where('cat_lists', array('nombre' => $nombre));
          if (empty($query->num_rows())){
            $query = $this->db->get_where('cat_lists', array('nombre' => $nombre));
          }
      }
      $rows = $query->custom_result_object('busquedas_model');
      if (isset($rows)){
          foreach ($rows as $row){
              $row->id = intval($row->id);
              $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
          }
      }
      return $rows;
    }

    /*Verificacion de las busquedas de la api*/

    public function totalBusquedas_Api($apiK){
      //obtener el total de busquedas
      $query = $this->db->query("SELECT sum(busqueda) as total from listas_binnacle WHERE id_entidad='".$apiK."' AND seccion='Buscar API'");
      $row = $query->row();
      return $row->total;
    }
    public function varSesion($apiK){
      $query = $this->db->query("select * from entidades_prolistas where idEntidad='" .$apiK."'" );
      return $query->result_array();
    }

    public function busquedaM($trimabuscar, $nombre, $apaterno, $amaterno){
        $id_entidad=$this->session->userdata('entidad');
    		$search = "
    						SELECT *
     						FROM cat_lists
     						WHERE ( concat_ws(' ', nombre, apaterno, amaterno)
    	   				  	LIKE '%".$trimabuscar."%'
                    OR nombre LIKE '%".$nombre."%'
    	   				  	AND apaterno = '".$apaterno."'
    						    AND amaterno = '".$amaterno."') AND
                    (id_entidad=1500 or id_entidad=".$id_entidad.")
                     AND tipo !='CI' AND actividad !='CONTRIBUYENTE INCUMPLIDO'";
    			$search_order = " ORDER BY id DESC;";
        	$search .= $search_order;
        //echo $search; exit;
    		$query = $this->db->query($search);

    		if (empty($query->num_rows())){
    			$query = $this->db->get_where('cat_lists', array('nombre' => $nombre.' '.$apaterno.' '.$amaterno));
    			if (empty($query->num_rows())){
    				$query = $this->db->get_where('cat_lists', array('nombre' => $apaterno.' '.$amaterno.' '.$nombre));
    			}
    		}

    		$rows = $query->custom_result_object('Busquedas_model');

        if (isset($rows)){
    			foreach ($rows as $row){
    				$row->id = intval($row->id);
    				$row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
    			}
    		}
    		return $rows;
    }


    public function buscarMultiple($trimabuscar,$nombre,$apellidoP,$apellidoM,$opcion){

        switch ($opcion) {
          case 'negras':
            //$opcion1="AND (tipo = 'MARSHAL DISTRICT OFFICES' or tipo = 'BIS' or tipo = 'DDTC' or tipo = 'DEA' or tipo = 'DOJ' or tipo = 'FBI' or tipo = 'ICE' or tipo = 'INTERPOL' or tipo = 'OFAC' or tipo = 'ONU' or tipo = 'PGR' or tipo = 'PGJ' or tipo = 'TREAS' or tipo = 'UIF' )";
            $opcion1="AND tipo IN ('MARSHAL DISTRICT OFFICES', 'BIS','DDTC', 'DEA', 'DOJ','FBI','ICE' ,'INTERPOL','OFAC', 'ONU', 'PGR', 'PGJ' ,'TREAS','UIF' )";

          break;

          case 'pep':
              //$opcion1="AND (tipo ='PEP' or tipo='PEP-CIA' or tipo= 'PEP-RULERS')";
              $opcion1="AND tipo in ('PEP','PEP-CIA','PEP-RULERS')";
          break;
          case '69b':
                $opcion1="AND tipo ='69B'";
          break;

          case 'CI':
                  $opcion1="AND tipo ='CI'";
          break;

          case 'todas':
                  $opcion1="";
            break;

        }
        $id_entidad=$this->session->userdata('entidad');
    		$search = "
    						SELECT *
     						FROM cat_lists
     						WHERE ( concat_ws(' ', nombre, apaterno, amaterno)
    	   				  	LIKE '%".$trimabuscar."%') AND id_entidad IN(1500,".$id_entidad.")
                     ".$opcion1;
    			$search_order = " ORDER BY id DESC;";
        	$search .= $search_order;
      //  echo $search; exit;

    		$query = $this->db->query($search);

    		/*if (empty($query->num_rows())){
    			$query = $this->db->get_where('cat_lists', array('nombre' => $nombre.' '.$apaterno.' '.$amaterno));
    			if (empty($query->num_rows())){
    				$query = $this->db->get_where('cat_lists', array('nombre' => $apaterno.' '.$amaterno.' '.$nombre));
    			}
    		}*/

    		$rows = $query->custom_result_object('Busquedas_model');

        if (isset($rows)){
    			foreach ($rows as $row){
    				$row->id = intval($row->id);
    				$row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
    			}
    		}
    		return $rows;
    }

  /*BUSQUEDA NUEVA*/

  public function busquedaNueva($nombre,$tipoBusqueda,$pJuridica,$listas,$rfc,$curp=''){
      $search1;
      $search;
      $id_entidad=$this->session->userdata('entidad');
      if (!empty($rfc && $curp)){
         $search1 = " and rfc = '$rfc' and curp = '$curp'";
      }
      elseif(!empty ($curp)){
          $search1 = " and curp = '$curp' ";
      }
      elseif(!empty ($rfc)){
          $search1 = " and rfc = '$rfc' ";
      }
      else{
          $search1=" ";
      }

      if($tipoBusqueda=='Exacta'){
        $search = "
        SELECT *
        FROM book_listas
        WHERE  name= '".$nombre."'".$listas." and personalidad_juridica='".$pJuridica."' ".$search1." OR alias ='".$nombre."' AND
        (id_entidad=1500 or id_entidad=".$id_entidad.")";

      }else{
        $search = "
        SELECT *
        FROM book_listas
        WHERE  name LIKE '%".$nombre."%'".$listas." and personalidad_juridica='".$pJuridica."' ".$search1." OR alias ='".$nombre."' AND
        (id_entidad=1500 or OR id_entidad=".$id_entidad.")";
      }





      //echo $search;
      //exit;
      $query = $this->db->query($search);


      $rows = $query->custom_result_object('Busquedas_model');

      if (isset($rows)){
        foreach ($rows as $row){
          $row->id = intval($row->id);
          $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
        }
      }
      return $rows;
  }


  public function buscarPruebas($nombre,$id_entidad){
    $search = "
            SELECT *
            FROM cat_lists
            WHERE ( concat_ws(' ', nombre, apaterno, amaterno)
                LIKE '%".$nombre."%') AND
                id_entidad IN (1500,".$id_entidad." )";
      $search_order = " ORDER BY id DESC;";
      $search .= $search_order;
      $query = $this->db->query($search);
      $rows = $query->custom_result_object('Busquedas_model');
      if (isset($rows)){
            foreach ($rows as $row){
              $row->id = intval($row->id);
              $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
            }
      }
    return $rows;
  }


  public function busquedaYotepresto($trimabuscar, $nombre, $apaterno, $amaterno,$rfc){
       $fullname = $nombre.$apaterno.$amaterno;
       $fullname1 = $nombre." ".$apaterno." ".$amaterno;

        if(!$rfc==''){
          $search = "
                  SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at FROM cat_lists where rfc='$rfc'  AND tipo != 'CI'";
              $query = $this->db->query($search);


       if (empty($query->num_rows())){
          $search2 = "
                  SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at FROM cat_lists where nombre like '%$nombre%' and apaterno='$apaterno' and amaterno='$amaterno' AND tipo != 'CI'";
              $query = $this->db->query($search2);
        }
        }else{
          $search2 = "
                  SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at FROM cat_lists where nombre like '%$nombre%' and apaterno='$apaterno' and amaterno='$amaterno' AND tipo != 'CI'";
              $query = $this->db->query($search2);
        }


    		$rows = $query->custom_result_object('Busquedas_model');

        if (isset($rows)){
    			foreach ($rows as $row){
    				$row->id = intval($row->id);
    				$row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
    			}
    		}
    		return $rows;
    }

    public function busquedaYoteprestoM($nombre,$rfc){


      if(!$rfc==''){
        $search = "
                SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at FROM cat_lists where rfc='$rfc'  AND tipo != 'CI'";
            $query = $this->db->query($search);


     if (empty($query->num_rows())){
        $search2 = "
                SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at FROM cat_lists where nombre LIKE '%$nombre%' or alias='$nombre' AND tipo != 'CI'";
            $query = $this->db->query($search2);
      }
      }else{
        $search2 = "
              SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at FROM cat_lists where nombre LIKE '%$nombre%' or alias='$nombre' AND tipo != 'CI'";
      }




          $rows = $query->custom_result_object('Busquedas_model');

          if (isset($rows)){
            foreach ($rows as $row){
              $row->id = intval($row->id);
              $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
            }
          }
          return $rows;
      }


/**busquedas para maskapital \ sin alias **/
//FISICA
  ///normal
  public function buscarApiMAS($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="", $status = "active",$idE){
     $fullname = $nombre.$apaterno.$amaterno;
     $fullname1 = $nombre." ".$apaterno." ".$amaterno;
     $entidad= $idE;

      if(!empty($rfc) && !empty($curp))	{
        $search =  "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where rfc='".$rfc."' AND curp = '".$curp."'";
      }
      elseif (!empty($rfc) ){
        $search =  "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where rfc='".$rfc."'";
      }
      elseif (!empty($curp) ){
        $search =  "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where curp='".$curp."'";
      }
      else{
        $search = "
        SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
        FROM cat_lists
        WHERE ( concat_ws(' ', nombre, apaterno, amaterno)
            LIKE '%".$trimabuscar."%'
            OR (nombre LIKE '%".$nombre."%'
            AND apaterno = '".$apaterno."'
            AND amaterno = '".$amaterno."') AND
            (id_entidad=1500 or id_entidad=".$entidad."))";
          $search_order = " ORDER BY id DESC;";
          $search .= $search_order;
      }
      $query = $this->db->query($search);



      $rows = $query->custom_result_object('Busquedas_model');

      if (isset($rows)){
        foreach ($rows as $row){
          $row->id = intval($row->id);
          $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
        }
      }
      return $rows;
  }

  ///EXACTA
  public function buscar_exactaMas($nombre, $apaterno, $amaterno,$rfc, $curp,$status = "active"){
          $id_entidad=$this->session->userdata('entidad');
          $fullname = $nombre.$apaterno.$amaterno;
          $fullname1 = $nombre." ".$apaterno." ".$amaterno;
          if (!empty($rfc && $curp)){
             $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where concat(nombre,apaterno,amaterno) = '$fullname' and rfc = '$rfc' and curp = '$curp' AND
             (id_entidad=1500 OR id_entidad='$id_entidad')";
          }
          elseif(!empty ($curp)){
              $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where concat(nombre,apaterno,amaterno) = '$fullname' and curp = '$curp' AND
              (id_entidad=1500 OR id_entidad='$id_entidad')";
          }
          elseif(!empty ($rfc)){
              $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where concat(nombre,apaterno,amaterno) = '$fullname'  and rfc = '$rfc'AND
              (id_entidad=1500 OR id_entidad='$id_entidad')";
          }
          else{
              $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where concat(nombre,apaterno,amaterno) = '$fullname' AND
              (id_entidad=1500 OR id_entidad='$id_entidad')";
          }
          $query = $this->db->query($search);

          $rows = $query->custom_result_object('Busquedas_model');

          if (isset($rows)){
              foreach ($rows as $row){
                $row->id = intval($row->id);
                $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
              }
          }

          return $rows;
  }
  ///EXTENDIDA

  public function buscar_extendidaapiMAS($trimabuscar, $nombre, $apaterno, $amaterno, $rfc="", $curp="", $status = "active"){
          $id_entidad=$this->session->userdata('entidad');
          $search = "
          SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
          FROM cat_lists
          WHERE  (id_entidad=1500 ) AND
          (nombre LIKE '%".$nombre."%'
          or apaterno = '".$apaterno."'
          or amaterno = '".$amaterno."'
          )";
            $search_order = " ORDER BY id DESC;";

          $search .= $search_order;

          $query = $this->db->query($search);



          $rows = $query->custom_result_object('Busquedas_model');

          if (isset($rows)){
            foreach ($rows as $row){
              $row->id = intval($row->id);
              $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
            }
          }
          return $rows;
      }

      //BUSQUEDA PARA PROPLD SIN LPB



  //moarl
    ///normal
    ///EXACTA
    public function buscar_exacta_mApiMAS($nombre,$rfc,$status = "active"){
        if(!empty($rfc)){
            $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where nombre = '$nombre'and rfc = '$rfc'";
        }
        else{
            $search = "SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias FROM cat_lists where nombre = '$nombre'";
        }
        $query = $this->db->query($search);

        $rows = $query->custom_result_object('busquedas_model');
        if (isset($rows)){
            foreach ($rows as $row){
                  $row->id = intval($row->id);
                  $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
            }
        }
        return $rows;
    }


    ///EXTENDIDA
    public function buscar_extendida_mApiMAS($nombre,$rfc,$status = "active"){
      $id_entidad=$this->session->userdata('entidad');
      if(!empty($rfc)){
        $search = "
        SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
        FROM cat_lists
        WHERE (id_entidad=1500) AND
            (nombre LIKE '%".$nombre."%'
            OR rfc LIKE '%".$rfc."%')";
        $search_order = " ORDER BY id DESC;";
        $search .= $search_order;
      }
      else{
        $search = "
              SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
              FROM cat_lists
              WHERE  nombre
                  LIKE '%".$nombre."%'
                  OR (nombre LIKE '%".$nombre."%'
                ) AND
                  (id_entidad=1500)";
        $search_order = " ORDER BY id DESC;";
        $search .= $search_order;
      }

      $query = $this->db->query($search);

      $rows = $query->custom_result_object('busquedas_model');
      if (isset($rows)){
          foreach ($rows as $row){
              $row->id = intval($row->id);
              $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
          }
      }
      return $rows;
    }


/**fin busquedas para maskapital \ sin alias **/


/**PRUENA CONCATENACION**/


public function buscarConcatenacion($trimabuscar,$entidad) {
        
        
            $search = "
            SELECT id,nombre,apaterno,amaterno,pertenece,actividad,fecha,tipo,status,updated_at,alias
            FROM cat_lists
            WHERE ( nombre_completo
                LIKE '%" . $trimabuscar . "%'
                OR alias ='" . $trimabuscar . "'
                AND
                (id_entidad=1500 or id_entidad=" . $entidad . "))";
            $search_order = " ORDER BY id DESC;";
            $search .= $search_order;
        
        //echo $search;
        //exit;
        
        $query = $this->db_pro_a->query($search); 

        $rows = $query->custom_result_object('Busquedasb_model');

        if (isset($rows)) {
            foreach ($rows as $row) {
                $row->id = intval($row->id);
                $row->photo = isset($row->photo) ? base_url() . 'files/photos/' . $row->photo : NULL;
            }
        }
        return $rows;
    }














}


/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */
