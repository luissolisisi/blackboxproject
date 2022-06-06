
<style>
    ul{
        list-style-type: none;
    }
    li{
        padding: 7px;
    }
    li:nth-child(even) {
        background-color: #f2f2f2;
    }
    hr{
      border: 1px solid #D1D1D1;
      margin: 30px 0;
    }
    .titulo{
        text-align: center;
    }
    table {
        width: 80%;
        margin: 0 auto;
    }
    table, th, td {
        border: 1px solid black;
    }
</style>

<br>
<h3 class="titulo">Búsqueda en listas</h3>
<div id="infoBusq">La búsqueda fue realizada por:
 <?php
 $CI =& get_instance();
 $nombre1=$CI->session->userdata('name').' '.$CI->session->userdata('lastname');
 echo strtoupper($nombre1);?>
 de la empresa <?php
 $CI =& get_instance();
 $empresa=$CI->session->userdata('empresa');
 echo strtoupper($empresa);?>
 en la fecha:
 <?php
 $time = time();
 echo date("d-m-Y (H:i:s)", $time).' '.$nombre;
 ?>
</div>
<?php  //AL $nombre = str_replace(' ', '%20', $nombre) ?>
<!--NOMBRE COMPLETO SIGLAS-->
<?php if($datos != '-'){ ?>
<br>
<table>
  <tr>
    <th>Nombre</th>
    <th>Apellido Paterno</th>
    <th>Apellido Materno</th>
    <th>Listas</th>
    <th>Estatus</th>

  </tr>
  <?= $datos?>
</table>
<?php } ?>

<div id="infoFuentes">
  <H4 class="tituloFuentes titulo">LA BÚSQUEDA SE REALIZÓ EN LAS SIGUIENTES FUENTES: </H4>

  <ul>
    <h3>Listas Nacionales</h3>
    <li>Secretaria de Hacienda y Crédito Público (SHCP)</li>
    <li>Servicio de Administración Tributaria (SAT)</li>
    <li>Procuraduría General de la República (PGR)</li>
    <li>Instituto Nacional de Transparencia, Acceso a la información y Protección de Datos Personales (INAI)</li>
    <li>Portal de Transparencia: Directorio de Gobiernos Estatales </li>
    <li>Sistema Nacional de Información Municipal (SNIM)</li>
    <li>Instituto Nacional para el Federalismo y Desarrollo Municipal (INAFED) </li>
    <li>Listas de personas politicamente expuestas (PEP)(www.gob.mx)</li>
    <hr>
    <h3>Listas Internacionales</h3>
    <li>Office of Foreign Assets Control (OFAC)</li>
    <li>Organización Internacional de Policía Criminal (INTERPOL)</li>
    <li>United States Departament of the Treasury (TREAS)</li>
    <li>Federal Bureau of Investigation (FBI)</li>
    <li>Bureau of Industry and Security (BIS)</li>
    <li>United States Departament of Justice (DOJ)</li>
    <li>Organized Crime and Drug Enforcement Task Force (OCDETF)</li>
    <li>Drug Enforcement Administration (DEA)</li>
    <li>Inmigration and Customs Enforcement (ICE)</li>
    <li>Directorate of Defense Trade Controls (DDTC)</li>
    <li>Listas negras</li>
  </ul>
</div>
