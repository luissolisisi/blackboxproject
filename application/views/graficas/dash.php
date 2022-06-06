<?php
    //nacionales
    $nL="";
    foreach ($nacionales as $nacional):
      $nL=$nL."['".$nacional['clave_pertenece']."',".$nacional['numero']."],";
    endforeach;
    //america
    $in="";
    foreach ($internacionales as $internacional):
      $in=$in."['".$internacional['continente']."',".$internacional['numero']."],";
    endforeach;
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
                    </div>

                    <div class="container-fluid">
                        <div class="cl-mcont">
                            <div class="row dash-cols"> <!--America  Nacionales, europa-->
                                <div class="col-sm-6 col-md-6">
                                    <div class="block-flat pie-widget">
                                        <div class="content no-padding">
                                            <div class="row">
                                              <div class="col-sm-12">
                                                        <div id="nacionales"></div>
                                              </div>

                                            </div>

                                        </div>

                                    </div>
                                </div> <!--nacionales--><!--nacionales-->
                                <div class="col-sm-6 col-md-6">
                                    <div class="block-flat pie-widget">
                                        <div class="content no-padding">
                                            <div class="row">
                                              <div class="col-sm-12">
                                                  <div id="internacional"></div>
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

Highcharts.chart('nacionales', {
  chart: {
     plotBackgroundColor: null,
     plotBorderWidth: null,
     plotShadow: false,
     type: 'pie'
  },
  title: {
     text: 'Nacionales'
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
    data: [<?php echo $nL;?>]
  }],
  credits: {
      enabled: false
  }
});
Highcharts.chart('internacional', {
  chart: {
     plotBackgroundColor: null,
     plotBorderWidth: null,
     plotShadow: false,
     type: 'pie'
  },
  title: {
     text: 'Internacionales'
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
    data: [<?php echo $in;?>]
  }],
  credits: {
      enabled: false
  }
});
</script>
