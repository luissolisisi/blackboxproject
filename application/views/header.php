<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Sistema automatizado para dar cumplimiento a las obligaciones actuales de reporte de Prevención de Lavado de Dinero">
	<meta name="keywords" content="Prevención de lavado de dinero, PLD, Sistema automatizado, SOFOM, Condusef, iprofi, PLD/FT, SITI, Operaciones Relevantes, Operaciones Inusuales, Operaciones Preocupantes, CNBV, PEP, LISTAS NEGRAS Y DE PERSONAS POLÍTICAMENTE EXPUESTAS, Sociedad Financiera de Objeto Múltiple, Auditoría">
	<meta name="author" content="UBCubo">
	<link rel="shortcut icon" href="<?=base_url('assets/images/favicon.png')?>">

	<title>Pro Listas</title>

	<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/css?family=Raleway:300,200,100" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/lib/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">


	<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->

	 <!-- <link href="https://use.fontawesome.com/releases/v5.3.0/css/all.css" rel="stylesheet"> AL se actualiza la versión -->
	 <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet">


	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/jquery.nanoscroller/css/nanoscroller.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/bootstrap.switch/css/bootstrap3/bootstrap-switch.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/jquery.niftymodals/css/component.min.css')?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/jquery.datatables/plugins/bootstrap/3/dataTables.bootstrap.css')?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css')?>"/>

	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/jquery.select2/select2.css')?>">
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> -->

	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/jquery.icheck/skins/square/blue.css')?>">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.min.css"/>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css"/>
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/lib/dropzone/dist/dropzone.css')?>">
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/custom.css')?>">
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/noCoincidenciasPDF.css')?>">
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/carga.css')?>">
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/listas.css')?>">
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/documento.css')?>">
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/imgpicker.css')?>">
	<link type="text/css" rel="stylesheet" href="<?=base_url('assets/lib/jquery.timeline/css/component.css')?>">
	<script type="text/javascript" src="<?= base_url('assets/lib/jquery/jquery.min.js')?>"></script>
	<script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="jquery.tablesorter.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.8.0/sweetalert2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.8.0/sweetalert2.min.js"></script>

	<!-- <script type="text/javascript">
		window.smartlook||(function(d) {
			var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
			var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
			c.charset='utf-8';c.src='//rec.smartlook.com/recorder.js';h.appendChild(c);
		})(document);
		smartlook('init', 'de1ead486199ed2d9d01552d49eb97cb67c6f0d8');
	</script> -->
