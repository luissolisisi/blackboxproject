<?php
    //busquedas
    $disponibles=2000-$totalRegistros;
    $bus="['Realizadas',".$totalRegistros."],['Disponibles',".$disponibles."]";
    //USUAIRIOS
    $disponiblesU=15-$totalU;
    $us="['Registrados',".$totalU."],['Disponibles',".$disponiblesU."]";
    //universales
    $un="";
    foreach ($universales as $universal):
      $un=$un."['".$universal['clave_pertenece']."',".$universal['numero']."],";
    endforeach;
    //Paises
    $otros="['Nacionales',".$nac1."],['EE.UU.',".$usn."],['Todos los continentes',".$otros."]";
?>

<div id="cl-wrapper">
    <div class="cl-sidebar">
        <?php $this->load->view('menu_left'); ?>
    </div>
    <div class="container-fluid" id="pcont">
        <div class="cl-mcont">
            <div class="row">
                <div class="col-md-12">
                    <div class="header">
                        <h2 class="text-shadow text-primary">¡Bienvenido!</h2>
                        <h4 class="text-shadow text-primary">Mis estadisticos</h4>
                    </div>

                    <div class="container-fluid">
                        <div class="cl-mcont">
                            <div class="row dash-cols">
                                <div class="col-sm-6 col-md-6"><!--Busquedas-->
                                    <div class="block-flat pie-widget">
                                        <div class="content no-padding">
                                            <div class="row">
                                              <div class="col-sm-12">
                                                        <div id="busquedas"></div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!--nacionales--><!--nacionales-->
                                <div class="col-sm-6 col-md-6"><!--Paises-->
                                    <div class="block-flat pie-widget">
                                        <div class="content no-padding">
                                            <div class="row">
                                              <div class="col-sm-12">
                                                  <div id="usuarios"></div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--America-->
                            </div>
                            <div class="row dash-cols">
                                <div class="col-sm-6 col-md-6"><!--Alistas ofac y ONY-->
                                    <div class="block-flat pie-widget">
                                        <div class="content no-padding">
                                            <div class="row">
                                              <div class="col-sm-12">
                                                        <div id="listas"></div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!--nacionales--><!--nacionales-->
                                <div class="col-sm-6 col-md-6"><!--uSUARIOS-->
                                    <div class="block-flat pie-widget">
                                        <div class="content no-padding">
                                            <div class="row">
                                              <div class="col-sm-12">
                                                  <div id="paises"></div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--America-->
                            </div>
                        </div>
                    </div>

                </div>
                <div class="md-overlay">
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

Highcharts.chart('busquedas', {
  chart: {
     plotBackgroundColor: null,
     plotBorderWidth: null,
     plotShadow: false,
     type: 'pie'
  },
  title: {
     text: 'Busquedas'
   },
  tooltip: {
     pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
   },
  plotOptions: {
     pie: {
         allowPointSelect: true,
         cursor: 'pointer',
         dataLabels: {
             enabled: false
         },
         showInLegend: true
     }
   },
  series: [{
    type: 'pie',
    name: '%',
    data: [<?php echo $bus;?>]
  }],
  credits: {
      enabled: false
  }
});
Highcharts.chart('listas', {
  chart: {
     plotBackgroundColor: null,
     plotBorderWidth: null,
     plotShadow: false,
     type: 'pie'
  },
  title: {
     text: 'Listas Universales'
   },
  tooltip: {
     pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
   },
  plotOptions: {
     pie: {
         allowPointSelect: true,
         cursor: 'pointer',
         dataLabels: {
             enabled: false
         },
         showInLegend: true
     }
   },
  series: [{
    type: 'pie',
    name: '',
    data: [<?php echo $un;?>]
  }],
  credits: {
      enabled: false
  }
});
Highcharts.chart('paises', {
  chart: {
     plotBackgroundColor: null,
     plotBorderWidth: null,
     plotShadow: false,
     type: 'pie'
  },
  title: {
     text: 'Paises'
   },
  tooltip: {
     pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
   },
  plotOptions: {
     pie: {
         allowPointSelect: true,
         cursor: 'pointer',
         dataLabels: {
             enabled: false
         },
         showInLegend: true
     }
   },
  series: [{
    type: 'pie',
    name: '%',
    data: [<?php echo $otros;?>]
  }],
  credits: {
      enabled: false
  }
});
Highcharts.chart('usuarios', {
  chart: {
     plotBackgroundColor: null,
     plotBorderWidth: null,
     plotShadow: false,
     type: 'pie'
  },
  title: {
     text: 'Usuarios'
   },
  tooltip: {
     pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
   },
  plotOptions: {
     pie: {
         allowPointSelect: true,
         cursor: 'pointer',
         dataLabels: {
             enabled: false
         },
         showInLegend: true
     }
   },
  series: [{
    type: 'pie',
    name: '',
    data: [<?php echo $us;?>]
  }],
  credits: {
      enabled: false
  }
});

</script>
