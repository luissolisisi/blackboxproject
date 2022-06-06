<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');


class Listas_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    /*Pagina de listas*/
    public function total_listas(){
      $entidad=$this->session->userdata('entidad');
      $query = $this->db->query("SELECT count(id)as suma FROM cat_listas where id_entidad=".$entidad.";");
			$row = $query->row();
			return $row->suma;

    }
    public function total_registros(){
      $entidad=$this->session->userdata('entidad');
      $query = $this->db->query("SELECT SUM(numero)as suma FROM cat_listas where id_entidad=".$entidad.";");
			$row = $query->row();
			return $row->suma;

    }
    public function get_lista() {
        $entidad=$this->session->userdata('entidad');
        return $this->db->get_where('cat_listas',array('status' => 'active','id_entidad'=>$entidad))->result_array();
    }
    /* Inicio ABC de las listas */
    public function new_Lista ($data){
        $this->db->insert('cat_listas', $data);
		    $result = ($this->db->affected_rows() > 0) ? true : false;
        return $result;
    }
    public function delete_Lista($id){
      $this->db->where('id',$id);
      $this->db->update('cat_listas',['status' => 'inactive']);
      $result = ($this->db->affected_rows() > 0) ? true : false;
      return $result;
    }
    public function edit_Lista($id,$data){
      $this->db->where('id',$id);
      $this->db->update('cat_listas',$data);
      $result = ($this->db->affected_rows() > 0) ? true : false;
      return $result;
    }
    /*Fin ABC de las listas*/



    /*Agregar persona a las listas*/
    public function all_count_in_persons_list($id){
      $this->db->SELECT('id');
		  $this->db->WHERE('id_entidad = "'.$id.'"');
		  $query  = $this->db->GET('cat_lists');
      return $query->num_rows();
    }
    public function all_persons_list($limit,$start,$col,$dir, $id_entidad){
        $query1 = "SET @numero := 0, @type := NULL";
        $this->db->query($query1);
        $this->db->select('*');
        $this->db->select("@numero:=@numero+1 AS 'orden'");
        $this->db->from('cat_lists');
        $this->db->where('status', 'active');
        $this->db->where('id_entidad', $id_entidad);
        $this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return null;
    }
    public function search_person_list($limit,$start,$search,$col,$dir){
        $query1 = "SET @numero := 0, @type := NULL";
        $this->db->query($query1);
        $this->db->select('*');
        $limits = null;
        if ($limit != 'NaN'){
            $limits = "LIMIT ".$start.", ".$limit;
        }
        $query1 = "SELECT *, @numero:=@numero+1 AS 'orden' FROM `cat_lists` WHERE (CONCAT_WS(' ', nombre,apaterno,amaterno) LIKE '%".$search."%' OR `nombre` LIKE '%".$search."%' ESCAPE '!' OR `apaterno` LIKE '%".$search."%' ESCAPE '!' OR `amaterno` LIKE '%".$search."%' ESCAPE '!' OR `tipo` LIKE '%".$search."%' ESCAPE '!' OR `rfc` LIKE '%".$search."%' ESCAPE '!' OR `curp` LIKE '%".$search."%' ESCAPE '!' OR `nacionalidad` LIKE '%".$search."%' ESCAPE '!' OR `actividad` LIKE '%".$search."%' ESCAPE '!') ORDER BY ".$col." ".$dir." ".$limits." "; //ORDER BY `nombre` LIMIT 50
        $query = $this->db->query($query1);
        if($query->num_rows()>0){
                return $query->result();
        }
        else{
            return null;
        }
    }
    public function search_persons_count($search, $id_entidad){
      $this->db->where("tipo","LPB");
  	 	$query = $this->db->like('id',$search)
		  ->or_like('nombre',$search)
		  ->or_like('apaterno',$search)
		  ->or_like('amaterno',$search)
		  ->or_like('rfc',$search)
		  ->or_like('tipo',$search)
      ->or_like('curp',$search)
      ->or_like('actividad',$search)
      ->or_like('nacionalidad',$search)
		  ->get('cat_lists');
	    return $query->num_rows();
	  }
    public function new_Person($data){
      $this->db->insert('cat_lists', $data);
      $result = ($this->db->affected_rows() > 0) ? true : false;
      return $result;
    }
    public function people_in_entity_lists($data = null){
		    if (empty($data)){
			         return  false;
		      }
		    $total = 0;
		    $where = array(
			       'nombre' => $data['nombre'],
			       'apaterno' => $data['apaterno'],
			       'amaterno' => $data['amaterno'],
			       'id_entidad' => $data['id_entidad'],
		     );
		    $this->db->where($where);

		   if(!empty($data['curp'])){
			   $this->db->where('curp',$data['curp']);
	     }

		   if(!empty($data['rfc'])){
			   $this->db->where('rfc',$data['rfc']);
		   }

       $query = $this->db->get('cat_lists');
       $total = $query->num_rows();
       if($total == 0){
			      $this->db->insert('cat_lists', $data);
		   }
		   $result = ($this->db->affected_rows() > 0) ? true : false;
       return $result;
	  }
    public function edit_Person($id,$data){
      $this->db->where('id',$id);
      $this->db->update('cat_lists',$data);
      $result = ($this->db->affected_rows() > 0) ? true : false;
      return $result;
    }
    public function delete_person($id){
      $this->db->where('id',$id);
      $this->db->update('cat_lists',['status' => 'delete']);
      $result = ($this->db->affected_rows() > 0) ? true : false;
      return $result;
    }
    /*Contenido de las Listas*/

      public function delete_personF($id){
        $this->db->where('id',$id);
        $this->db->delete('cat_lists');
        $result = ($this->db->affected_rows() > 0) ? true : false;
        return $result;
      }


      /*Contenido para ocultos*/
      public function ver_bloqueados(){
          $entidad=$this->session->userdata('entidad');
          return $this->db->get_where('cat_lists',array('status' => 'delete','id_entidad'=>$entidad))->result_array();
      }

      public function recover_person($id){
        $this->db->where('id',$id);
        $this->db->update('cat_lists',['status' => 'active']);
        $result = ($this->db->affected_rows() > 0) ? true : false;
        return $result;
      }


      /*Cargar registros historico*/
      public function moverHistorico($pertenece = "",$tipo=""){
        $mover = "
        INSERT INTO historico_listas
        SELECT * FROM cat_lists
        WHERE pertenece = '".$pertenece."' AND tipo='".$tipo."';";
        $query = $this->db->query($mover);
      }
      public function eliminarHistorio($pertenece = "",$tipo=""){
        $eliminar = "
        DELETE FROM cat_lists
        WHERE pertenece = '".$pertenece."' AND tipo='".$tipo."';";
        $query = $this->db->query($eliminar);
        }
      public function insertHistorico($nombre,$apaterno="",$amaterno="",$tipo, $pertenece=""){
        $this->nombre = $nombre;
        $this->apaterno   = $apaterno;
        $this->amaterno    =$amaterno;
        $this->pertenece    = $pertenece;
        $this->tipo    = $tipo;
        $this->status    = 'active';
        $this->created_at=date("Y-m-d H:i:s");
        $this->db->insert('cat_lists', $this);

      }
      public function editListaH($id,$linea){
        $data = array(
        'date' => date("Y-m-d H:i:s"),
        'numero'  => $linea
        );
        $this->db->where('id',$id);
        $this->db->update('cat_listas',$data);
        $result = ($this->db->affected_rows() > 0) ? true : false;
        return $result;
      }

      /*69B*/

      //ya|
      public function editarDesvirtuado($ds,$des){
        $fecha=date('Y-m-d H:i:s');
        $query1="";
        $i=0;
        for($i;$i<$ds;$i++){
          $rfc=$des[$i][0];
          $date = str_replace('/', '-', $des[$i][1]);
          $pubSat=date('Y-m-d', strtotime($date));
          $nofecha= $des[$i][2];
          $date2 = str_replace('/', '-', $des[$i][3]);
          $dor=date('Y-m-d', strtotime($date2));

          $query1="
          UPDATE cat_lists SET pertenece='SAT',tipo='69B',
          situacion_del_contribuyente='DESVIRTUADO',
          publicacion_pagina_sat_desvirtuados='".$pubSat."',
          numero_fecha_oficio_global_contribuyentes_desvirtuaron='".$nofecha."',
          publicacion_dof_desvirtuados='".$dor."',status='active',updated_at='".$fecha."' WHERE rfc='".$rfc."';";
          $this->db->query($query1);
        }
      }
      //ya
      public function editarDefinitivo($df,$def){

        $fecha=date('Y-m-d H:i:s');
        $query1="";
        $i=0;
        for($i;$i<$df;$i++){
          $rfc=$def[$i][0];
          $noFechaG=$def[$i][1];
          $date = str_replace('/', '-', $def[$i][2]);
          $satDef=date('Y-m-d', strtotime($date));
          $date2 = str_replace('/', '-', $def[$i][3]);
          $DOF=date('Y-m-d', strtotime($date2));

          $query1="
          UPDATE cat_lists SET pertenece='SAT',tipo='69B',
          situacion_del_contribuyente ='DEFINITIVO' ,
          numero_y_fecha_de_oficio_global_de_definitivos='".$noFechaG."',
          publicacion_pagina_sat_definitivos='".$satDef."',
          publicacion_dof_definitivos='".$DOF."',status='active',updated_at='".$fecha."' WHERE rfc='".$rfc."';";
          $this->db->query($query1);
        }
      }

      public function editarFavorable($sf,$senf){
        $fecha=date('Y-m-d H:i:s');
        $query1="";
        $i=0;
        for($i;$i<$sf;$i++){
          $dst=0; $mst=0; $yst=0;
          $ddf=0; $mdf=0; $ydf=0;
          $rfc=$senf[$i][0];
          $nofecha=$senf[$i][1];
          //fecha del sat
          $porciones = explode("/", $senf[$i][2]);
          if(strlen($porciones[0])==1){
            $dst="0".$porciones[0];
          }
          else{
            $dst=$porciones[0];
          }
          if(empty($porciones[1])){
            $mst="01";
          }
          else{
            $mst= $porciones[1];
          }

          if(empty($porciones[2])){
            $yst="2020";
          }
          else{
            $yst="20".$porciones[2];
          }

          $sat=$yst."-".$mst."-".$dst;
          //dof
          $porciones1 = explode("/", $senf[$i][3]);
          if(strlen($porciones1[0])==1){
            $ddf="0".$porciones1[0];
          }
          else{
            $ddf=$porciones1[0];
          }

          if(empty($porciones1[1])){
            $mdf="01";
          }
          else{
            $mdf= $porciones1[1];
          }
          if(empty($porciones1[2])){
            $ydf="2020";
          }
          else{
            $ydf="20".$porciones1[2];
          }
          $dof=$ydf."-".$mdf."-".$ddf;

          $query1="
          UPDATE cat_lists SET pertenece='SAT',tipo='69B',
          situacion_del_contribuyente ='SENTENCIA FAVORABLE' ,
          numero_y_fecha_de_oficio_global_de_sentencia_favorable='".$nofecha."',
          publicacion_pagina_sat_sentencia_favorable='".$sat."',
          publicacion_dof_sentencia_favorable='".$dof."',
          status='active',updated_at='".$fecha."' WHERE rfc='".$rfc."';";
          $this->db->query($query1);
          }
      }
      //ya
      public function nuevoPresuntoM($pm,$preM){
        $fecha=date('Y-m-d H:i:s');
        $query1="";
        $i=0;
        for($i;$i<$pm;$i++){
          $rfc=$preM[$i][0];
          $nombre=$preM[$i][1];
          $noFechaP=$preM[$i][2];

          $date = str_replace('/', '-', $preM[$i][3]);
          $satP=date('Y-m-d', strtotime($date));

          $date2 = str_replace('/', '-', $preM[$i][4]);
          $DOF=date('Y-m-d', strtotime($date2));

          $query1="
          INSERT INTO cat_lists(nombre,rfc,pertenece,
          tipo,situacion_del_contribuyente,
          numero_y_fecha_de_oficio_global_de_presuncion,
          publicacion_pagina_sat_presuntos, publicacion_dof_presuntos,  status, created_at)
          VALUES ('".$nombre."','".$rfc."','SAT','69B','PRESUNTO','".$noFechaP."','".$satP."','".$DOF."','active','".$fecha."');";
          $this->db->query($query1);
        }
      }
      //ya
      public function nuevoPresuntoF($pf,$preF){
        $fecha=date('Y-m-d H:i:s');
        $query1="";
        $i=0;
        for($i;$i<$pf;$i++){
          $nombre=$preF[$i][0];
          $apaterno=$preF[$i][1];
          $amaterno=$preF[$i][2];
          $rfc=$preF[$i][3];
          $noFechaP=$preF[$i][4];

          $date = str_replace('/', '-', $preF[$i][5]);
          $satP=date('Y-m-d', strtotime($date));

          $date2 = str_replace('/', '-', $preF[$i][6]);
          $DOF=date('Y-m-d', strtotime($date2));

          $query1="
          INSERT INTO cat_lists(nombre,apaterno,amaterno,rfc,pertenece,
          tipo,situacion_del_contribuyente,
          numero_y_fecha_de_oficio_global_de_presuncion,
          publicacion_pagina_sat_presuntos, publicacion_dof_presuntos,  status, created_at)
          VALUES ('".$nombre."','".$apaterno."','".$amaterno."','".$rfc."','SAT','69B','PRESUNTO','".$noFechaP."','".$satP."','".$DOF."','active','".$fecha."');";
          $this->db->query($query1);
        }
      }

      //optener el maxivo umero de las listas

      public function get_totalcontenido($clave){
        $query = $this->db->query("SELECT numero from cat_listas WHERE clave_pertenece='".$clave."'");
  			$row = $query->row();
  			return $row->numero;
      }


      /**CI**/

      //Mover a historico
      public function moverHistoricoCI(){
        $mover = "
        INSERT INTO historico_listas
        SELECT * FROM cat_lists
        WHERE actividad='CONTRIBUYENTE INCUMPLIDO' OR tipo='CI';";
        $query = $this->db->query($mover);
      }
      public function eliminarHistorioCI(){
        $eliminar = "
        DELETE FROM cat_lists
        WHERE tipo='CI';";
        $query = $this->db->query($eliminar);
        }

        public function insertCi($datacCon21){
            $this->db->insert_batch('cat_lists', $datacCon21);
            $result = ($this->db->affected_rows() > 0) ? true : false;
           return $result;
         }

         public function get_paises()
       	{
       		$query = $this->db->get('cat_paises');
               return $query->result();
       	}

        public function get_pais($country){
              return $this->db->get_where('cat_paises',array('pais' => $country))->result_array();

        }

      //elimnar de tabla principal


}


/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */
