$(document).ready(function() {
	//initialize the javascript
	App.init();
	App.dataTables();
	$('.md-trigger').modalEffects();

	$("#show-pass").mousedown(function() {
		$("#password").removeAttr('type');
		$("#show-pass").addClass('fa-eye-slash').removeClass('fa-eye');
	});
	$("#show-pass").mouseup(function() {
		$("#password").attr('type', 'password');
		$("#show-pass").addClass('fa-eye').removeClass('fa-eye-slash');
	});
	
	////////////eventos de expedientes///////////////
	$("#frminformacion").submit(function(e) {
		e.preventDefault();
		var str = window.location.href;
		var formulario=$("#frminformacion").serialize();
		$.ajax({
			type: "post",
			url: "get_Insert_formularios",
			data: formulario,
			success: function() {
				if(str.includes("get_form_datos_adicionales") || str.includes("get_Formulario_update"))
					window.location.href=document.referrer;
				else
					window.location.href = base_url + "expediente/mostrar_pagina_expedientes";
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
					window.location.href = base_url + "expediente_empleados/mostrar_pagina_expedientes_empleados";
			}
		});
	});

	$(document).on('click','#editar',function(){
		var id= $(this).attr('data-id');
		var persona=$(this).attr('data-persona');
		var action =$(this).attr('data-edit');
		params={};
		console.log(params.id=id);
		console.log(params.persona=persona);
		console.log(params.action=action);
		window.location.href = base_url + "expediente/get_Formulario_update?persona="+persona+"&id="+id+"&action="+action;
	});
	$(document).on('click','#editarEmpleado', function() {
		var id= $(this).attr('data-id');
		var persona=$(this).attr('data-persona');
		var action =$(this).attr('data-edit');
		params={};
		console.log(params.id=id);
		console.log(params.persona=persona);
		console.log(params.action=action);
		window.location.href = base_url + "expediente_empleados/get_Formulario_update_empleados?persona="+persona+"&id="+id+"&action="+action;

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
		window.location.href = base_url + "expediente/get_Formulario_nuevo?persona="+persona;
	});
	
	$(document).on('click','#newEmpleados',function(){
		var persona=$(this).attr('data-persona');
		var action =$(this).attr('data-new');
		params={};
		params.persona=persona;
		window.location.href = base_url + "expediente/get_Formulario_nuevo_empleados?persona="+persona;
	});

	$(document).on('click','#new_moral',function(){
		var persona=$(this).attr('data-persona');
		var action =$(this).attr('data-new');
		params={};
		params.persona=persona;
		window.location.href = base_url + "expediente/get_Formulario_nuevo?persona="+persona;
	});

	$(document).on('click','#new_fideicomiso',function(){
		var persona=$(this).attr('data-persona');
		var action =$(this).attr('data-new');
		params={};
		params.persona=persona;
		window.location.href = base_url + "fideicomiso";
	});

	//Eventos Clientes CREDITO
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
			url: base_url + "clientes/get_Insert_credito",
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
	})

	$(document).on('click','#id_credito_detalle2',function(){
		var id= $(this).attr('data-id');
		var id_exp= $(this).attr('data-exp');
		var url='../clientes/mostrar_detalle_credito?v='+id_exp+'&v2='+id;
		document.location=(url);
	});

	$(document).on('click','#editar_credito',function(){
		var id_credito= $(this).attr('data-idcredito');
		params={};
		console.log(params.id_credito=id_credito);
		$('#creditos').load('get_Formulario_credito_consulta', params);
	});
	
	//////////////EVENTO DE MOVIMIENTOS
	$(document).on('click','#movimiento',function(){
		var id_movimiento=$(this).attr('data-nomov');
		var no_credito=$(this).attr('data-credito');
		params={};
		params.id_movimiento=id_movimiento;
		params.no_credito=no_credito;
		$('#movimientos').load('get_Formulario_movimientos', params);
	});

	$(document).on('click','.editmov',function() {
		var id_movimiento = $(this).attr('data-nomov');
		var no_credito = $(this).attr('data-credito');
		params={};
		params.id_movimiento = id_movimiento;
		params.no_credito = no_credito;
		$('#movimientos').load('get_Formulario_movimientos', params);
	});

	$("#movimiento").submit(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.find(':input[type=submit]').prop('disabled', true);
		$.ajax({
			url: base_url + "contracts/operation",
			type: 'POST',
			dataType: 'json',
			data: $this.serialize(),
		})
		.done(function(response) {
			if (response.response) {					
				$('#response_title').text("Exito!");
				$('#response_message').text(response.message);
			}
			else {
				$('#response_class').removeClass('success').addClass('danger');
				$('#response_icon').removeClass('fa-check').addClass('fa-times');
				$('#response_title').text("Algo salío mal!");
				$('#response_message').text(response.message);
			}
			$('#mod-success').modal({ show: true });
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

	// Eventos para agregar a listas
	$(document).on('click','#agregar_pers', function() {
		var url='agregar_a_listas';
		document.location=(url);
	});

	$(document).on('click','#reg_pag', function() {
		var url='lista_negra';
		document.location=(url);
	});

});

	// Alerts
	$(document).on('click','#alertas',function(){
		var id=$(this).attr('data-id');
		params = {};
		console.log(params.id = id);
		$('#alertas_contenido').load('get_Formulario_alertas', params, function(){
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

	$("#form-alertas2").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var formdata = false;
		if (window.FormData) {
			formdata = new FormData(form[0]);
		}
		//var formulario=$("#form-alertas2").serialize();
		$.ajax({
			url: base_url + "clientes/get_Update_alerta",
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

	$(document).on('click','#alertas_pld', function() {
		var id = $(this).attr('data-id');
		var no_credito = $(this).attr('data-credito');
		var url = 'pagina_pld_consulta?v='+id+'&v2='+no_credito;
		document.location = (url);
	});

	$(document).on('click','#alertas_pld_24', function() {
		var id_alaerta=$(this).attr('data-id');
		var expediente=$(this).attr('data-expediente');
		var url='pagina_pld_consulta24?v1='+id_alaerta+'&v2='+expediente;
		document.location=(url);
	});

	$(document).on('click','#udis', function() {
		var id=$(this).attr('data-id');
		console.log('mike');
		params={};
		console.log(params.id=id);
		$('#udis_formulario').load('get_Udisformulario', params, function() {
		})
	})
	$(document).on('click','#USD', function(){
		var id=$(this).attr('data-id');
		params={};
		console.log(params.id=id);
		$('#usd_formulario').load('get_USDformulario', params, function() {
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
			url: "alerta_buzon",
			data: formulario,
			success: function() {
				document.forms['form-buzon'].reset();
			}
		});
	});
	
	$(document).on('click','#autorizar',function() {
		var id = $(this).attr('data-id');
		var persona = $(this).attr('data-persona');
		var action = $(this).attr('data-edit');
		params = {};
		params.id = id;
		params.persona = persona;
		params.action = action;
		$('#body-autorizacion').load('get_Formulario_update_autorizar', params, function() {

		});
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
	$(document).on('click','#avisos', function() {
		var id=$(this).attr('data-id');
		params={};
		console.log(params.id=id);
		$('#avisos_contenido').load('avisos/get_Formulario_avisos', params, function() {
		})
	});
	$("#form-avisos").submit(function(e) {
		e.preventDefault();
		var formulario=$("#form-avisos").serialize();
		$.ajax({
			type:"post",
			url: "avisos/get_Update_avisos",
			data: formulario,
			success: function() {
				location.reload(true);
			}
		});

	});

	//agregar personas
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

	$(document).on('click','.delete-movimiento',function(e) {
		e.preventDefault();
		var movimiento = $(this).data('nomov');

		if (confirm("¿Desea eliminar este movimiento?")) {
			$.ajax({
				type:"post",
				dataType: 'json',
				url: "eliminar_movimiento",
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
