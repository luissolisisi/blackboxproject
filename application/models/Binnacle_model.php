<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');


class Binnacle_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

      /*Visalizar Bitacota*/
      public function all_moves($limit,$start,$col,$dir){


        $id=$this->session->userdata('id');

        $query1 = "SET @numero := 0, @type := NULL";
        $this->db->query($query1);
        $this->db->select("l.id as id,CONCAT (ac.name,' ',ac.lastname) AS name,l.ip as ip, l.date as date, l.seccion as seccion, l.accion as accion,l.detalles as detalles");
        $this->db->select("@numero:=@numero+1 AS 'orden'");
        $this->db->from('access_listas AS ac, listas_binnacle AS l');
        $this->db->where('l.id_usuario=ac.id');
        $this->db->where ('l.id_usuario',$id);
        $this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
          /*$query1 = "SET @numero := 0, @type := NULL";
          $this->db->query($query1);
          $this->db->select('*');
          $this->db->select("@numero:=@numero+1 AS 'orden'");
          $this->db->from('listas_binnacle');
          $this->db->limit($limit,$start);
          $this->db->order_by($col,$dir);*/
          $query = $this->db->get();
          if($query->num_rows()>0){
              return $query->result();
          }
          return null;
      }
      public function all_count_move(){
        $this->db->SELECT('id');
  		  $query  = $this->db->GET('listas_binnacle');
        return $query->num_rows();
      }

      /* login */
      public function bit_login($usuario) {
        $this->id_usuario  =  $usuario;
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Login';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Inicio Sesion';
        $this->detalles    = 'Se ingreso al sistema';
        $this->id_entidad = $this->session->userdata('entidad');

        $this->db->insert('listas_binnacle', $this);
      }
      public function bit_cerrar($id){
        $this->id_usuario  =  $id;
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Login';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Cerra Sesion';
       $this->detalles    = 'Salio del sistema';
       $this->id_entidad = $this->session->userdata('entidad');
       $this->db->insert('listas_binnacle', $this);
      }

      /* Usuarios */
      public function bit_deleteUser($usuario){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Usuarios';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Eliminar usuarios';
        $this->detalles    = 'Elimino al usuario '.$usuario;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);
      }
      public function bit_newUser($name){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Usuarios';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Nuevo usuarios';
        $this->detalles    = 'Ingreso al usuario '.$name;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);

      }
      public function bit_editUser($usuario){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Usuarios';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Editar usuarios';
        $this->detalles    = 'Edito al usuario '.$usuario;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);
      }
      public function bit_changePWD($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Perfil';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Cambiar contraseña';
        $this->detalles    = 'El usuario '.$id. ' cambio su contraseña';
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);
      }

      /*Contenido de lista*/
      public function bit_contenidoDelete($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Contenido Listas';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Eliminar';
        $this->detalles    = 'Se elimino al usuario con id '.$id;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);

      }
      public function bit_contenidoEdit($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Contenido Listas';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Edicion';
        $this->detalles    = 'Se edito la info del usuario con id '.$id;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);
      }

      /*Contenido Oculto*/
      public function bit_restorePerson($id){
        $this->id_usuario = $this->session->userdata('id');
       $this->ip    = $this->input->ip_address();
       $this->seccion    ='Contenido Eliminado';
       $this->date    = date("Y-m-d H:i:s");
       $this->accion    = 'Restaurar usuario';
       $this->detalles    = 'Se restauro al usuario con '.$id;
       $this->id_entidad = $this->session->userdata('entidad');
       $this->db->insert('listas_binnacle', $this);
      }

      /*Agregar a Listas */
      public function bit_deleteLista($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Listas';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Eliminar Listas';
        $this->detalles    = 'Se elimino la lista'.$id;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);


      }
      public function bit_newLista($nombre){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Listas';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Agregar a las Listas';
        $this->detalles    = 'Se ingreso la lista: '.$nombre;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);

      }
      public function bit_editLista($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Listas';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Se edito las listas';
        $this->detalles    = 'Se edito la lista con id: '.$id;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);

      }
      public function bit_actualizarLista($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Listas';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Actualización';
        $this->detalles    = 'Se contenido de la lista con id: '.$id;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);
      }

      /*Agregar Persona*/

      public function bit_deletePersona($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Agregar Persona';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Eliminar Persona';
        $this->detalles    = 'Se elimino a la persona con id: '.$id;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);

      }
      public function bit_newPersona($nombre){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Agregar Persona';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Nueva persona';
        $this->detalles    = 'Se ingreso a la persona de nombre: '.$nombre;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);
      }
      public function bit_editPerson($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Agregar Persona';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Editar Persona';
        $this->detalles    = 'Se edito a la persona con el id: '.$id;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);
      }

      /*Buscar*/
      public function buscar_personas($nombre, $tipo, $detalles1,$numeroC100="",$num="",$consultas,$listas){
        $detalles="";
        if($tipo=='Busqueda masiva'){
          $detalles='Se ha buscado a la persona de nombre: '.$nombre.' mediante la opcion de busqueda masiva';
        }else{
          $detalles='Se ha buscado a la persona de nombre: '.$nombre. ' mediante: '.$detalles1.' se encontraron  un total de '.$num.' resultados de los cuales '.$numeroC100.' eran 100% coincidentes';
        }
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Buscar';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = $tipo;
        $this->detalles    = $detalles;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->busqueda = $consultas;
        $this->nombre = $nombre;
        $this->tipo_busqueda=$detalles1;
        $this->lista=$listas;
        $this->no_resultados=$num;
        $this->seguimiento=0;
        $this->db->insert('listas_binnacle', $this);
      }
      public function buscar_personasAPI($nombre, $tipo, $detalles,$numeroC100="",$num="",$id_entidad,$listas,$entidad=""){


        $this->id_usuario = $id_entidad;
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Buscar API';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = $tipo;
        $this->detalles    = 'Se ha buscado a la persona de nombre: '.$nombre. ' mediante: '.$detalles.' se encontraron  un total de '.$num.' resultados';
        $this->id_entidad =$entidad;
        $this->busqueda = 1;
        $this->nombre = $nombre;
        $this->tipo_busqueda=$detalles;
        $this->lista=$listas;
        $this->no_resultados=$num;
        $this->db->insert('listas_binnacle', $this);
      }

      /*Historial*/

      public function updateListas($historico, $tipoL){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Listas';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Actualizacion de registros en lista';
        $this->detalles    = 'Se ha actualizado la lista: '.$tipoL. ' mediante la opcion : '.$historico;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);

      }

      /*Fuentes de información*/
      public function bit_newFuente($nombre){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Fuente de información';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Agregar fuente';
        $this->detalles    = 'Se ingreso la fuente: '.$nombre;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);

      }
      public function bit_editFuente($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Fuente de información';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Edición de Fuente';
        $this->detalles    = 'Se edito la fuente con id: '.$id;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);

      }
      public function bit_deleteFuente($id){
        $this->id_usuario = $this->session->userdata('id');
        $this->ip    = $this->input->ip_address();
        $this->seccion    ='Fuente de información';
        $this->date    = date("Y-m-d H:i:s");
        $this->accion    = 'Eliminar Fuentes';
        $this->detalles    = 'Se elimino la fuente: '.$id;
        $this->id_entidad = $this->session->userdata('entidad');
        $this->db->insert('listas_binnacle', $this);


      }

      public function getID($api){

        $query = $this->db->query("SELECT a.user_id AS id from propld_access.`keys` AS a WHERE a.`key`='".$api."'");
  			$row = $query->row();
  			return $row->id;



      }


}
