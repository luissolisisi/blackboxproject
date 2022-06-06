<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="UBCubo">
	<link rel="shortcut icon" href="<?=base_url('assets/images/favicon.png')?>">

	<title>ProListas</title>

	<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/css?family=Raleway:300,200,100" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/lib/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">


	<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->

<!--<link href="https://use.fontawesome.com/releases/v5.3.0/css/all.css" rel="stylesheet">  AL se actualiza la versión -->
	<link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet"> <!-- AL se actualiza la versión -->



	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/jquery.nanoscroller/css/nanoscroller.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/bootstrap.switch/css/bootstrap3/bootstrap-switch.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/jquery.niftymodals/css/component.min.css')?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/jquery.datatables/plugins/bootstrap/3/dataTables.bootstrap.css')?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css')?>"/>

	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/jquery.select2/select2.css')?>">
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


	<!-- <script type="text/javascript">
		window.smartlook||(function(d) {
			var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
			var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
			c.charset='utf-8';c.src='//rec.smartlook.com/recorder.js';h.appendChild(c);
		})(document);
		smartlook('init', 'de1ead486199ed2d9d01552d49eb97cb67c6f0d8');
	</script> -->

</head>

<body>
<?php menu_arriba(); ?>

<div id="cl-wrapper">
	<div class="cl-sidebar">
		<!-- Sidebar Menu -->
		<?php $this->load->view('menu_left');?>
	</div>

	<div class="container-fluid" id="pcont">
		<div class="cl-mcont">
			<!-- Content -->
			<div class="row">
				<div class="col-md-12">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="block-flat">
						<div class="header">
							<h2><?= $title?></h2>
						</div>
						<div class="content">
							<?php echo $content ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





<script type="text/javascript" src="<?= base_url('assets/lib/jquery.nanoscroller/javascripts/jquery.nanoscroller.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/cleanzone.js')?>"></script>
<script src="<?=base_url('assets/lib/bootstrap/dist/js/bootstrap.min.js')?>"></script>

<script src="<?=base_url('assets/lib/jquery.niftymodals/js/jquery.modalEffects.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.crop/js/jquery.Jcrop.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.sparkline/jquery.sparkline.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery-ui/jquery-ui.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.upload/js/jquery.iframe-transport.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.upload/js/jquery.fileupload.js')?>" type="text/javascript"></script>

<!-- <script src="<?=base_url('assets/js/page-profile.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/js/page-charts.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.easypiechart/jquery.easypiechart.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.flot/jquery.flot.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.flot/jquery.flot.pie.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.flot/jquery.flot.resize.js')?>" type="text/javascript"></script>  -->

<script src="<?=base_url('assets/lib/jquery.datatables/js/jquery.dataTables.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.datatables/plugins/bootstrap/3/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<!--<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>-->
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<!-- </datatable> -->
<script src="<?=base_url('assets/js/page-data-tables.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.select2/select2.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/bootstrap.slider/js/bootstrap-slider.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.nestable/jquery.nestable.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/bootstrap.switch/js/bootstrap-switch.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/bootstrap.datetimepicker/js/locales/bootstrap-datetimepicker.es.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/jquery.icheck/icheck.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/moment.js/min/moment.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/lib/bootstrap.daterangepicker/daterangepicker.js')?>" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url('assets/js/page-form-elements.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/lib/dropzone/dist/dropzone.js')?>"></script>
<script src="<?=base_url('assets/lib/jquery.gritter/js/jquery.gritter.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/js/page-ui-notifications.js')?>" type="text/javascript"></script>

<script src="<?= base_url("assets/lib/jquery-number/jquery.number.min.js") ?>"></script>
<script src="<?=base_url('assets/js/propld.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/js/validacion.js')?>" type="text/javascript"></script>
<!-- <script src="<?=base_url('assets/js/page-data-table_row.js')?>" type="text/javascript"></script> -->



<script type="text/javascript">
	$(document).ready(function() {

		//initialize the javascript
		App.init();
		App.dataTables();
		App.formElements();
		$('.md-trigger').modalEffects();

		$("#show-pass").mousedown(function() {
			$("#password").removeAttr('type');
			$("#show-pass").addClass('fa-eye-slash').removeClass('fa-eye');
		});
		$("#show-pass").mouseup(function() {
			$("#password").attr('type', 'password');
			$("#show-pass").addClass('fa-eye').removeClass('fa-eye-slash');
		});

////////////eventos de alta usuario///////////////
		$("#frmusuario").submit(function(e) {
			e.preventDefault();
			var str = window.location.href;

			var formulario=$("#frmusuario").serialize();
				$.ajax({
					type: "post",
					url: "<?= base_url('usuario/insert_usuario_pld') ?>",
					data: formulario,
					success: function() {
							window.location.href="<?=base_url('usuario/mostrar_pagina_usuarios') ?>";
					}
				});
		});

		////////////eventos de expedientes///////////////
		$("#frminformacion").submit(function(e) {
			e.preventDefault();
			var str = window.location.href;

			var formulario=$("#frminformacion").serialize();
				$.ajax({
					type: "post",
					url: "<?= base_url('customers/insert_customer') ?>",
					data: formulario,
					success: function(resp)
					{
							window.location.href="<?=base_url('customers/get_customers_all') ?>";
							//console.log(resp);
					}
				});
		});

		$("#frminformacion_additional").submit(function(e) {
			e.preventDefault();
			var str = window.location.href;

			var formulario = $(this).serialize();
				$.ajax({
					type: "post",
					url: "<?= base_url('customers/insert_customer_additional') ?>",
					data: formulario,
					success: function(respuesta) {
							//console.log(respuesta);
							window.location.href=document.referrer;
					}
				});
		});
                //empleados
		$("#expempleados").submit(function(e) {
			e.preventDefault();
			var str = window.location.href;

			var formulario=$("#expempleados").serialize();
				$.ajax({
					type: "post",
					url: "get_insert_Formularios_empleados",
					data: formulario,
					success: function() {
						if(str.includes("get_form_datos_adicionales") || str.includes("get_Formulario_update_empleados"))
							window.location.href=document.referrer;
						else
							window.location.href="<?=base_url('expediente_empleados/mostrar_pagina_expedientes_empleados') ?>";
					}
				});


		});

		$(document).on('click','#editarEmpleado',function(){
			var id= $(this).attr('data-id');
			var persona=$(this).attr('data-persona');
			var action =$(this).attr('data-edit');
			params={};
			console.log(params.id=id);
			console.log(params.persona=persona);
			console.log(params.action=action);
			window.location.href="<?= base_url('expediente_empleados/get_Formulario_update_empleados');?>?persona="+persona+"&id="+id+"&action="+action;

		});

		$(document).on('click','.deleteEmpleado',function(e) {
		e.preventDefault();
		var id = $(this).data('id');

		if (confirm("¿Desea eliminar este expediente de empleado?")) {
			$.ajax({
				type:"post",
				dataType: 'json',
				url: "eliminar_empleado",
				data: "numero=" + id,
				success: function() {
					location.reload(true);
				}
			});
		}
	});


		/*$(document).on('click','#pdf',function(e) {
			e.preventDefault();
			var id = $(this).attr('data-pdf');
			var persona = $(this).attr('data-persona');

			var action = $(this).attr('data-edit');
			params={};
			console.log(params.id=id);
			console.log(params.persona=persona);
			console.log(params.action=action);
			$.post('get_Formulario_pdf', params, function(data) {
				$('#validacion').html(data);
				$('#mod-success').modal({ show: true });
			});

		});*/

		$(document).on('click','#new',function(){
			var persona=$(this).attr('data-persona');
			var action =$(this).attr('data-new');
			params={};
			params.persona=persona;
			window.location.href="<?= base_url('expediente/get_Formulario_nuevo');?>?persona="+persona;

		});
		$(document).on('click','#newEmpleados',function(){
			var persona=$(this).attr('data-persona');
			var action =$(this).attr('data-new');
			params={};
			params.persona=persona;
			window.location.href="<?= base_url('expediente/get_Formulario_nuevo_empleados');?>?persona="+persona;

		});

		$(document).on('click','#new_moral',function(){
			var persona=$(this).attr('data-persona');
			var action =$(this).attr('data-new');
			params={};
			params.persona=persona;
			window.location.href="<?= base_url('expediente/get_Formulario_nuevo');?>?persona="+persona;

		});

		$(document).on('click','#new_fideicomiso',function(){
			var persona=$(this).attr('data-persona');
			var action =$(this).attr('data-new');
			params={};
			params.persona=persona;
			window.location.href="<?= base_url('fideicomiso');?>";
		});

		///////////////fin de eventos expedientes////////////////
		//////////////Eventos Clientes CREDITO//////////////////////////
		$(document).on('click','#id_credito',function(){
			var id= $(this).attr('data-id');
			var url='../clientes/mostrar_agrupacion_creditos?v='.concat(id);
			document.location=(url);
		});

		$("#form-creditos").submit(function(e) {
			e.preventDefault();
			var formulario = $("#form-creditos").serialize();

			$.ajax({
				type: "post",
				url: "<?= base_url('clientes/get_Insert_credito') ?>",
				data: formulario,
				success: function() {

					window.history.back();

				}
			});

		});

		$("#form-creditos-alesa").submit(function(e) {
			e.preventDefault();
			var formulario = $("#form-creditos-alesa").serialize();

			$.ajax({
				type: "post",
				url: "<?= base_url('contracts/get_Insert_credito_alesa') ?>",
				data: formulario,
				success: function() {

					window.history.back();

				}
			});

		});

		$(document).on('click','#id_credito_detalle',function(){
			var id= $(this).attr('data-id');
			var id_exp= $(this).attr('data-exp');
			var url='mostrar_detalle_credito?v='+id_exp+'&v2='+id;
			document.location=(url);
		});

		$(document).on('click','#editar_credito',function(){
			var id_credito= $(this).attr('data-idcredito');
			params={};
			console.log(params.id_credito=id_credito);
			$('#creditos').load('get_Formulario_credito_consulta', params);
		});

		//////////////EVENTO DE MOVIMIENTOS/////////

		$("#movimiento").submit(function(e) {
			e.preventDefault();
			var $this = $(this);
			$this.find(':input[type=submit]').prop('disabled', true);
			$.ajax({
				url: '<?= base_url('contracts/operation') ?>',
				type: 'POST',
				dataType: 'json',
				data: $this.serialize(),
			})
			.done(function(response) {
				if (response.response) {
					$('#response_title').text("¡Éxito!");
					$('#response_message').text(response.message);
				}
				else {
					$('#response_class').removeClass('success').addClass('danger');
					$('#response_icon').removeClass('fa-check').addClass('fa-times');
					$('#response_title').text("Algo salío mal!");
					$('#response_message').text(response.message);
				}
				$('#mod-success_mov').modal({ show: true });
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});

		$("#deposito").submit(function(e) {
			e.preventDefault();
			var $this = $(this);
			$this.find(':input[type=submit]').prop('disabled', true);
			$.ajax({
				url: '<?= base_url('contracts/deposito') ?>',
				type: 'POST',
				dataType: 'json',
				data: $this.serialize(),
			})
			.done(function(response) {
				if (response.response) {
					$('#response_title').text("¡Éxito!");
					$('#response_message').text(response.message);
				}
				else {
					$('#response_class').removeClass('success').addClass('danger');
					$('#response_icon').removeClass('fa-check').addClass('fa-times');
					$('#response_title').text("Algo salío mal!");
					$('#response_message').text(response.message);
				}
				$('#mod-success_mov').modal({ show: true });
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});

		// Eventos para agregar a listas
		$(document).on('click','#agregar_pers',function(){
			var url='agregar_a_listas';
			document.location=(url);
		});

		$(document).on('click','#reg_pag',function(){
			var url='lista_negra';
			document.location=(url);
		});

	});


	/////////////////alertas////////////
	$(document).on('click','#alertas',function(){
		var id=$(this).attr('data-id');
		params={};
		console.log(params.id=id);
		$('#alertas_contenido').load('get_Formulario_alertas', params,function(){
		})
	});
	$("#form-alertas").submit(function(e) {
		e.preventDefault();
		var formulario=$("#form-alertas").serialize();
		$.ajax({
			type:"post",
			url: "get_Update_alerta",
			data: formulario,
			success: function() {
				location.reload(true);
			}
		});

	});

	$(document).on('click','.alertas2', function() {
		var id = $(this).attr('data-id');
		params={};
		params.id = id;
		$('#alertas_contenido').load('../clientes/get_Formulario_alertas', params,function(data){
			console.log("alert");
			console.log(data);
		})
	});

	$("#answer_alerts").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var formdata = false;
		if (window.FormData) {
			formdata = new FormData(form[0]);
		}
		$.ajax({
			url: "<?= base_url('clientes/get_Update_alerta') ?>",
			type:"POST",
			dataType: 'json',
			data: formdata ? formdata : form.serialize(),
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			success: function(response) {
				if (response.respuesta) {
					location.reload(true);
				}

			}
		});
	});

	$(document).on('click','#alertas_pld',function() {
		var id = $(this).attr('data-id');
		var no_credito = $(this).attr('data-credito');
		var folio = $(this).attr('data-folio');
		var url = 'generate_report?v='+id+'&v2='+no_credito+'&f='+folio;
		document.location = (url);
	});

	$(document).on('click','#udis',function(){
		var id=$(this).attr('data-id');
		console.log('mike');
		params={};
		console.log(params.id=id);
		$('#udis_formulario').load('get_Udisformulario', params,function(){
		})
	})
	$(document).on('click','#USD',function(){
		var id=$(this).attr('data-id');
		params={};
		console.log(params.id=id);
		$('#usd_formulario').load('get_USDformulario', params,function(){
		})
	})
	$("#form-udis").submit(function(e) {
		e.preventDefault();
		var formulario=$("#form-udis").serialize();
		$.ajax({
			type:"post",
			url: "get_Datosformularioudis",
			data: formulario,
			success: function() {
				location.reload(true);
			}
		});
	});
	$("#form-USD").submit(function(e) {
		e.preventDefault();
		var formulario=$("#form-USD").serialize();
		$.ajax({
			type:"post",
			url: "get_DatosformularioUSD",
			data: formulario,
			success: function() {
				location.reload(true);
			}
		});
	});
	$("#form-buzon").submit(function(e) {
		e.preventDefault();
		var formulario=$("#form-buzon").serialize();
		$.ajax({
			type:"post",
			dataType: 'json',
			url: "alerta_buzon",
			data: formulario,
			success: function(response) {
				if (response.respuesta) {
					alert("Mensaje enviado al Oficial de Cumplimiento");
					location.reload(true);
				}
			}
		});
	});
	$(document).on('click','#autorizar',function(){
		var id = $(this).attr('data-id');
		var persona = $(this).attr('data-persona');
		var action = $(this).attr('data-edit');
		params = {};
		params.id = id;
		params.persona = persona;
		params.action = action;
		$('#body-autorizacion').load('get_customer_authorization', params);
	});

	$("#form-autorizacion").submit(function(e) {
		e.preventDefault();
		var form = $("#form-autorizacion").serialize();
		$.ajax({
			type: "post",
			url: "insert_autorizacion",
			data: form,
			success: function() {
				location.reload(true);
			}
		});
	});

	/////////////////avisos////////////
	$(document).on('click','#avisos',function(){
		var id=$(this).attr('data-id');
		params={};
		console.log(params.id=id);
		$('#avisos_contenido').load('notices/get_Formulario_avisos', params);
	});
	$("#form-avisos").submit(function(e) {
		e.preventDefault();
		var formulario=$("#form-avisos").serialize();
		$.ajax({
			type:"post",
			url: "notices/get_Update_avisos",
			data: formulario,
			success: function() {
				location.reload(true);
			}
		});

	});

	////////////////////agregar personas
	$(document).on('click','#dd_lista_negra',function(){
		var id=$(this).attr('data-id');
		params={};
		console.log(params.id=id);
		$('#alistN').load('listaNegra/Cargar_Persona_ListN', params,function(){
		})
	});
	$("#add_lista_negra").submit(function(e) {
		e.preventDefault();
		var formulario=$("#add_lista_negra").serialize();
		$.ajax({
			type:"post",
			url: "Cargar_Persona_ListN",
			data: formulario,
			success: function() {
				location.reload(true);
				//alert("agregado");
			}
		});
	});

	/*$(document).on('click','.delete-movimiento',function(e) {
		e.preventDefault();
		//alert('Hola mundo!');
		var movimiento = $(this).data('nomov');

		if (confirm("¿Desea eliminar este movimiento?")) {
			$.ajax({
				type:"post",
				dataType: 'json',
				url: "../../eliminar_movimiento",
				data: "movimiento=" + movimiento,
				success: function() {
					location.reload(true);
			}
		});
		}
	});*/

	$(document).on('click','.delete-deposito',function(e) {
		e.preventDefault();
		var movimiento = $(this).data('nomov');

		if (confirm("¿Desea eliminar este deposito?")) {
			$.ajax({
				type:"post",
				dataType: 'json',
				url: "../../eliminar_deposito",
				data: "movimiento=" + movimiento,
				success: function() {
					location.reload(true);
			}
		});
		}
	});

	// Nuevo tipo de cargo
	$('#nuevo_cargo').click( function() {

	    var action = $(this).attr('data-new');
	    params = {};
	    $('#form-primary-tipos-cargo .modal-body').load('get_nuevo_tipo_cargo', params, function() {
	        console.log("Nuevo tipo de cargo");
	    });
	});

	$("#form-tipo-cargo").submit(function(e) {
	    e.preventDefault();
	    var formulario_producto = $("#form-tipo-cargo").serializeArray();
	    console.log('Form Tipos de Cargo');
	    $.ajax({
	        type: "post",
	        dataType: 'json',
	        url: "get_Insert_Nuevo_Tipo_Cargo",
	        data: formulario_producto,
	        success: function(response) {
	            $(".md-modal").css("display", "none");
				$(".md-overlay").css("display", "none");
	            // Validar mensaje de error
	            if(response.respuesta == false)
	            {
	                alert(response.mensaje);
	            }
	            else
	            {
	                alert(response.mensaje);
	                location.reload(true);
	            }
	        },
	        error:function(){
	            alert('Error general del sistema, intente mas tarde.');
	        }
	    });

	});

	$(document).on("click",".edit_tipo_cargo", function(e) {

	    var id = $(this).attr("data-id");
	    var action =$(this).attr("data-edit");
	    params={};
	    console.log(params.id = id);
	    console.log(params.action = action);
	    $('#mb-cargo').load('get_update_tipo_cargo', params, function(){
	        console.log("editar" + " " + id);
	    })
	});

	$(document).on('click','.delete-tipoCargo',function(e) {
		e.preventDefault();
		var idTC = $(this).data('id');

		if (confirm("¿Desea eliminar este tipo de cargo?")) {
			$.ajax({
				type:"post",
				dataType: 'json',
				url: "eliminar_tipoCargo",
				data: "numero=" + idTC,
				success: function() {
					location.reload(true);
				}
			});
		}
	});

	$(document).on("click",".edit_saldos", function(e) {

	    var id = $(this).attr("data-id");
	    var action =$(this).attr("data-edit");
	    params={};
	    console.log(params.id = id);
	    console.log(params.action = action);
	    $('#mb-saldos').load('../../get_update_saldos', params, function(){
	        console.log("editar" + " " + id);
	    })
	});

	$("#form-saldos").submit(function(e) {
	    e.preventDefault();
	    var formulario_saldos = $("#form-saldos").serializeArray();
	    $.ajax({
	        type: "post",
	        dataType: 'json',
	        url: "../../actualiza_saldos",
	        data: formulario_saldos,
	        success: function(response) {
	            $(".md-modal").css("display", "none");
				$(".md-overlay").css("display", "none");
	            if(response.respuesta == false){
	            	alert(response.mensaje);
	            }else{
	            	alert(response.mensaje);
	            	location.reload(true);
	            }
	        },
	        error:function(){
	            alert('Error general del sistema, intente mas tarde.');
	        }
	    });

	});
</script>
</body>
</html>
