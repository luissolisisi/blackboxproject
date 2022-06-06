<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');


class Historial_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    public function get_consultas(){
      $print="";
      $valoresBusqueda; //array
      $valorA=0; //valor incial del array
       $idEntidad=$this->session->userdata('entidad');
       //$sql1 = "select * from listas_binnacle where id_entidad='" .$idEntidad."' and busqueda='1'";
       $search = "
            select date,nombre, no_resultados,lista, id  from listas_binnacle where id_entidad='" .$idEntidad."' and busqueda='1' and seguimiento=0;";
       //$result1 = $this->db->query($sql1);
       $query = $this->db->query($search);
       //$result = $this->db->query($search);
       //$followingdata = $result->fetch_assoc();
       foreach ($query->result_array() as $row) {
          $valoresBusqueda[$valorA][1]=$row['date'];
         $valoresBusqueda[$valorA][0]=$row['nombre'];
         $valoresBusqueda[$valorA][2]=$row['no_resultados'];
         $valoresBusqueda[$valorA][3]=$row['lista'];
         $valoresBusqueda[$valorA][4]=date('Y-m-d');
         $nombre=$row['nombre'];
         $sql2 = "SELECT tipo FROM cat_lists WHERE CONCAT(nombre,' ',apaterno,' ',amaterno) LIKE '%".$nombre."%'";
         $result2 = $this->db->query($sql2);
         $noRes=0;
         $tipo="";
         foreach ($result2->result_array() as $row2) {
           $noRes++;
           $tipo= $tipo." ".$row2['tipo'];
         }
           $valoresBusqueda[$valorA][5]=$noRes;
           $valoresBusqueda[$valorA][6]=$tipo;
           $valoresBusqueda[$valorA][7]=$row['id'];
           $valorA++;
       }

       for($i=0; $i<$valorA;$i++){
         $print .= "<tr>";
         $print .= "<td>".$valoresBusqueda[$i][0]."</td>";
         $print .= "<td>".$valoresBusqueda[$i][1]."</td>";
         $print .= "<td>".$valoresBusqueda[$i][2]."</td>";
         $print .= "<td>".$valoresBusqueda[$i][3]."</td>";
         $print .= "<td>".$valoresBusqueda[$i][4]."</td>";
         $print .= "<td>".$valoresBusqueda[$i][5]."</td>";
         $print .= "<td>".$valoresBusqueda[$i][6]."</td>";
         $print .= "<td>
           <a data-toggle='modal'
             data-id='".$valoresBusqueda[$i][7]."'
             class='open-Modal btn btn-primary' href='#edit_fuente'>
             <i class='fas fa-pencil-alt'></i>
           </a>
         </td>";

         $print .= "</tr>";
       }
       return $print;

    }

    public function get_consultas2(){
      $print="";
      $valoresBusqueda; //array
      $valorA=0; //valor incial del array
       $idEntidad=$this->session->userdata('entidad');
         $id=$this->session->userdata('id');
       //$sql1 = "select * from listas_binnacle where id_entidad='" .$idEntidad."' and busqueda='1'";
       $search = "
            select date,nombre, no_resultados,lista, id  from listas_binnacle where id_usuario='" .$id."' and busqueda='1' and seguimiento=0;";
       //$result1 = $this->db->query($sql1);
       $query = $this->db->query($search);
       //$result = $this->db->query($search);
       //$followingdata = $result->fetch_assoc();
       foreach ($query->result_array() as $row) {
          $valoresBusqueda[$valorA][1]=$row['date'];
         $valoresBusqueda[$valorA][0]=$row['nombre'];
         $valoresBusqueda[$valorA][2]=$row['no_resultados'];
         $valoresBusqueda[$valorA][3]=$row['lista'];
         $valoresBusqueda[$valorA][4]=$row['id'];
           $valorA++;
       }

       for($i=0; $i<$valorA;$i++){
         $print .= "<tr>";
         $print .= "<td>".$valoresBusqueda[$i][0]."</td>";
         $print .= "<td>".$valoresBusqueda[$i][1]."</td>";
         $print .= "<td>".$valoresBusqueda[$i][2]."</td>";
         $print .= "<td>".$valoresBusqueda[$i][3]."</td>";
         /*$print .= "<td>
           <a data-toggle='modal'
             data-nombre='".$valoresBusqueda[$i][0]."'
             class='open-Modal btn btn-primary' id='bus' href='#busqueda_nueva'>
             <i class='fas fa-pencil-alt'></i>
           </a>
         </td>";*/
          $print .= "<td><button onclick='showNew()' type='button' id='bus' ><a data-toggle='modal'
           data-nombre='".$valoresBusqueda[$i][0]."'
           class='open-Modal btn btn-primary' id='bus' href='#busqueda_nueva'>
           <i class='fas fa-pencil-alt'></i>
         </a></button></td>";
         $print .= "<td>
           <a data-toggle='modal'
             data-id='".$valoresBusqueda[$i][4]."'
             class='open-Modal btn btn-primary' href='#edit_fuente'>
             <i class='fas fa-pencil-alt'></i>
           </a>
         </td>";

         $print .= "</tr>";
       }
       return $print;

    }

    public function busqueda($nombre){

      $sql2 = "SELECT nombre, apaterno, amaterno, tipo, pertenece, actividad,status FROM cat_lists WHERE CONCAT(nombre,' ',apaterno,' ',amaterno) LIKE '%".$nombre."%'";
      $result = $this->db->query($sql2);
      return $result->result();
     }
    public function delete_seguimiento($id){
      $this->db->where('id',$id);
      $this->db->update('listas_binnacle',['seguimiento' => 1]);
      $result = ($this->db->affected_rows() > 0) ? true : false;
      return $result;
    }

}


/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */
