<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {



	public function __construct()
	{
		parent::__construct();
    $this->load->library('email');
}


   public function busqueda_mensual(){
     //$servername = "gt-servicios.com";
     $servername = "localhost";
     //$username = "ubcubo";
     $username = "root";
     //$password = "<7p`<zJ8d](!C&HU";
     $password = "root";
     //$dbname = $b['db_acc'];
     $dbname = "propld_access";
     $conn = mysqli_connect($servername, $username, $password, $dbname);
     // Check connection

     if (!$conn) {
         die("Connection failed: " . mysqli_connect_error());
     }
     else{

     }
     //obteer las entidades_prolistas
     $sql = "select * from entidades_prolistas;";
     $result = $conn->query($sql);
     while($row = mysqli_fetch_array($result)) {
       $valoresBusqueda; //array
       $valorA=0; //valor incial del array
       $idEntidad= $row['idEntidad'];
       $empresa= $row['empresa'];
       $correo= $row['correo_electronico'];
       $envio= $row['envio'];
       $dia= $row['dia_envio'];
       if($envio=='Y'){
         $hoy=date('d');
         if($hoy==$dia){
           $sql1 = "select * from listas_binnacle where id_entidad='" .$idEntidad."' and busqueda='1'";
           $result1 = $conn->query($sql1);
           while($row2 = mysqli_fetch_array($result1)) {

              $valoresBusqueda[$valorA][1]=$row2['date'];
              $valoresBusqueda[$valorA][0]=$row2['nombre'];
              $valoresBusqueda[$valorA][2]=$row2['no_resultados'];
              $valoresBusqueda[$valorA][3]=$row2['lista'];
              $valoresBusqueda[$valorA][4]=date('Y-m-d');
              $nombre=$row2['nombre'];
              $sql2 = "SELECT tipo FROM cat_lists WHERE CONCAT(nombre,' ',apaterno,' ',amaterno) LIKE '%".$nombre."%'";
              $result2 = $conn->query($sql2);
              $noRes=0;
              $tipo="";
              while($row2 = mysqli_fetch_array($result2)) {
                $noRes++;
                $tipo= $tipo." ".$row2['tipo'];
              }
              $valoresBusqueda[$valorA][5]=$noRes;
              $valoresBusqueda[$valorA][6]=$tipo;
              $valorA++;

           }
           $print= "<html><body>";
           $print = "<table>";
           $print .= "<tr>";
           $print .= "<td>Nombre /Razon social</td>";
           $print .= "<td>Fecha de busqueda</td>";
           $print .= "<td>No. de resultados</td>";
           $print .= "<td>Listas de aparicion</td>";
           $print .= "<td>Nueva fecha de busqueda</td>";
           $print .= "<td>No. de resultados</td>";
           $print .= "<td>Listas de aparecion</td>";
           $print .= "</tr>";
           for($i=0; $i<$valorA;$i++){
             $print .= "<tr>";
             $print .= "<td>".$valoresBusqueda[$i][0]."</td>";
             $print .= "<td>".$valoresBusqueda[$i][1]."</td>";
             $print .= "<td>".$valoresBusqueda[$i][2]."</td>";
             $print .= "<td>".$valoresBusqueda[$i][3]."</td>";
             $print .= "<td>".$valoresBusqueda[$i][4]."</td>";
             $print .= "<td>".$valoresBusqueda[$i][5]."</td>";
             $print .= "<td>".$valoresBusqueda[$i][6]."</td>";
             $print .= "</tr>";
           }
           $print .= "</table></body></html>";
           $mensaje=$print;

           $this->email->from('yescas.alejadra@ubcubo.com');
           $this->email->to($correo);
           $this->email->subject('Busqueda de clientes en las listas');
           $this->email->message($mensaje);
           $this->email->send();
         }

       }
      }
   }
  }
