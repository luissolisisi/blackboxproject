$(document).ready(function() {



$('.md-trigger').modalEffects();
function ocultarModal()
{
    $(".md-modal").css("display", "none");
    $(".md-overlay").css("display", "none");
}
// Pagina Apoderado Legal o Aval

$(document).on('click','#bapoderado',function() {
    var id= $(this).attr('data-id');
    var id_per= $(this).attr('data-persona');
    var url='mostrar_pagina_datos_adicionales?v='+id_per+'&v2='+id;
    document.location=(url);
});

// Crea Directorio para subir los documentos
$(".crear").on("click", function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    
    var nombre = $(this).data('nombre');
    var cliente = $(this).data('cliente');
    

    $.ajax({
        type: "post",
        dataType: 'json',
        url: "subir_archivos",
        data: "id=" + id + "&cliente=" + cliente + "&n=" + nombre,
        success: function(respuesta) {

            if (respuesta.mensaje == "CREADO") {
                alert("El directorio ha sido creado correctamente, da clic de nuevo para subir los documentos.");
            }
            else if (respuesta.mensaje == "EXISTE") {
                
                var url='listado_documentos_digitales?id=' + id + '&c=' + cliente + '&n=' + nombre;
                document.location=(url);
            }
        },
        error:function(jqxhr, status, error) {
            console.log(error);
        },
        complete: function() {
            console.log("Complete");
        }
    });
});

// Crea Directorio para subir los documentos por creditos
$(".crear-credito").on("click", function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    var nombre = "MIGUEL ANGEL RIVERA ROSETE";
    var cliente = $(this).data('cliente');
    var credito = $(this).data('credito');
    var expediente = $(this).data('expediente');

    $.ajax({
        type: "post",
        dataType: 'json',
        url: "../../expediente/subir_archivos_creditos",
        data: "id=" + id + "&cliente=" + cliente + "&e=" + expediente + "&credito=" + credito,
        success: function(respuesta) {

            if (respuesta.mensaje == "CREADO") {
                alert("El directorio ha sido creado correctamente, da clic de nuevo para subir los documentos.");
            }
            else if (respuesta.mensaje == "EXISTE") {
                
                var url='../../expediente/documentos_digitales_creditos?id=' + id + '&c=' + cliente + '&e=' + expediente + "&credito=" + credito;
                document.location=(url);
            }
        },
        error:function(jqxhr, status, error) {
            console.log(error);
        },
        complete: function() {
            console.log("Complete");
        }
    });
});

// Dropzone


Dropzone.autoDiscover = false;
$("#my-awesome-dropzone").dropzone({
    url: "mover_documentos",
    addRemoveLinks: false,
    maxFileSize: 10485760,
    dictResponseError: "Ha ocurrido un error en el servidor.",
    acceptedFiles: '.jpeg,.jpg,.png,.JPEG,.JPG,.PNG,application/pdf',
    success: function(file)
    {
        if(file.status == "success")
        {
            alert("El archivo " + file.name + " ha subido correctamente.");
            location.reload(true);
        }        
    },
    error: function(file)
    {
        alert("Error subiendo el archivo " + file.name);
    },
    
    removedfile: function(file, serverFileName)
    {
        var name = file.name;
        $.ajax({
            type: "POST",
            url: "mover_documentos?delete=true",
            data: "filename="+name,
            success: function(data)
            {
                var json = JSON.parse(data);
                if(json.res == true)
                {
                    var element;
                    (element = file.previewElement) != null ? 
                    element.parentNode.removeChild(file.previewElement) : 
                    false;
                    alert("El elemento fué eliminado: " + name); 
                }
            }
        });
    }
});

// Dropzone de creditos
$("#my-awesome-dropzonec").dropzone({
    url: "mover_documentos_creditos",
    addRemoveLinks: false,
    maxFileSize: 10485760,
    dictResponseError: "Ha ocurrido un error en el servidor.",
    acceptedFiles: '.jpeg,.jpg,.png,.JPEG,.JPG,.PNG,application/pdf',
    success: function(file)
    {
        if(file.status == "success")
        {
            alert("El archivo " + file.name + " ha subido correctamente.");
            location.reload(true);
        }        
    },
    error: function(file)
    {
        alert("Error subiendo el archivo " + file.name);
    },
    
    removedfile: function(file, serverFileName)
    {
        var name = file.name;
        $.ajax({
            type: "POST",
            url: "mover_documentos_creditos?delete=true",
            data: "filename="+name,
            success: function(data)
            {
                var json = JSON.parse(data);
                if(json.res == true)
                {
                    var element;
                    (element = file.previewElement) != null ? 
                    element.parentNode.removeChild(file.previewElement) : 
                    false;
                    alert("El elemento fué eliminado: " + name); 
                }
            }
        });
    }
});

// Carga Formulario para agregar datos adicionales

$(document).on('click','#agregardatoadf',function(){
    var persona = $(this).attr('data-persona');
    var action = $(this).attr('data-new');
    var table = $(this).attr('data-table');
    var idexpediente = $(this).attr('data-idexpediente');
    params={};
    params.persona = persona;
    params.table = table;
    params.idexpediente = idexpediente;
     window.location.href="get_form_datos_adicionales?persona="+persona+"&idexpediente="+idexpediente;
    //$('#datosadicionales').load('get_form_datos_adicionales', params,function(data){
        
    //})
});
$(document).on('click','#agregardatoadm',function(){
    var persona=$(this).attr('data-persona');
    var action =$(this).attr('data-new');
    var table = $(this).attr('data-table');
    var idexpediente = $(this).attr('data-idexpediente');
    params={};
    params.persona=persona;
    params.table = table;
    params.idexpediente = idexpediente;
    window.location.href="get_form_datos_adicionales?persona="+persona+"&idexpediente="+idexpediente;
    //$('#datosadicionales').load('get_form_datos_adicionales', params,function(){

    //})  
});

// Evento de submit datos adicionales

$("#frmdatosadicionales").on("submit", function(e) {
    e.preventDefault();
    var form = $(this);
   
    var str=window.location.href;
    var bandera=false;
    var genero=$('#GENERO');
    var paterno =$("#T2");
    var materno=$("#T3");
    var nombre=$("#T1");
    var fechaNacimiento=$("#T12");
    var rfc=$("#T19");
    var actividad=$("#T16");
    var texto="<ul>";

    var calle=$("#T4");
    var delegacion=$("#T9");
    var ciudad=$("#T10");
    var telefono=$("#T17");
    var paisorigen=$("#T30");

    // 10 t16 t17 
    if(!str.includes("MORAL")){
        if(!genero.is(':checked')||!genero2.is(':checked')){
            bandera=false;
            texto=texto+"<li>El <strong>campo genero</strong> es obligatorio</li>";
        } else{
            bndera=true;
        }
    }
    
    if(paterno.val()!=undefined){
        if(!vLongitud(paterno,"Ingrese de 3 a 30 caracteres",3,30) || !vConsecutivos(paterno,"Ingrese un apellido valido")){
            bandera=false;
            texto=texto+"<li>El <strong>campo apellido paterno</strong> es obligatorio</li>";
        }else{
            bandera=true;
        }


        if(!vLongitud(materno,"Ingrese de 3 a 30 caracteres",3,30) || !vConsecutivos(materno,"Ingrese un apellido valido")){
            bandera=false;
            texto=texto+"<li>El <strong>campo apellido materno</strong> es obligatorio</li>";
        }else{
            bandera=true;
        }
    }

    if(!vLongitud(nombre,"Ingrese de 3 a 30 caracteres",3,30) || !vConsecutivos(nombre,"Ingrese un nombre valido")){
        bandera=false;
        texto=texto+"<li>El <strong>campo nombre o razón social</strong> es obligatorio</li>";
    }else{
        bandera=true;
    }

    if(!vLongitud(rfc,"Ingrese 13 caracteres",13,13) || !vExpresion(rfc,/^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))\.?$/,"Ingrese un RFC valido")){
        bandera=false;
        texto=texto+"<li>Ingrese un  <strong>RFC</strong> valido</li>";
    }else{
        bandera=true;
    }

    if(!vLongitud(actividad,"Ingrese de 3 a 30 caracteres",3,40)){
        bandera=false;
        texto=texto+"<li>El <strong>campo actividad</strong> es obligatorio</li>";
    }else{
        bandera=true;
    }


    if(!vLongitud(calle,"Ingrese de 3 a 30 caracteres",3,30)){
        bandera=false;
        texto=texto+"<li>El <strong>campo calle</strong> es obligatorio</li>";
    }else{
        bandera=true;
    }

    if(!vLongitud(delegacion,"Ingrese de 3 a 30 caracteres",3,30)){
        bandera=false;
        texto=texto+"<li>El <strong>delegacion</strong> es obligatorio</li>";
    }else{
        bandera=true;
    }

    if(!vLongitud(ciudad,"Ingrese de 3 a 30 caracteres",3,30)){
        bandera=false;
        texto=texto+"<li>El <strong>ciudad</strong> es obligatorio</li>";
    }else{
        bandera=true;
    }

    if(!vLongitud(telefono,"Ingrese de 3 a 30 caracteres",7,12)){
        bandera=false;
        texto=texto+"<li>El <strong>telefono</strong> es obligatorio</li>";
    }else{
        bandera=true;
    }

    
    



    texto=texto+"</ul>";
    if(texto=='<ul></ul>'){
    
        var formulario = $("#frmdatosadicionales").serializeArray();
        $.ajax({
            type: "post",
            url: "get_Insert_formularios",
            data: formulario,
            success: function() {            
                ocultarModal();
               var str=window.location.href;
                if(str.includes("get_form_datos_adicionales") || str.includes("get_Formulario_update"))
                    window.location.href=document.referrer;
                else
                    window.location.href="<?=base_url('expediente/mostrar_pagina_expedientes') ?>";
            },
            error: function(jqxhr, status, error){
                console.log(error);
            }
        });
    }else{
        $('#validacion').html(texto);
        $('#mod-warning').modal({ show: true });
        
    }
    
});

// Edito los datos adicionales

$(document).on('click','.editarda',function() {
    var id = $(this).attr('data-id');
    var idexpediente = $(this).attr('data-idexpediente');
    var persona=$(this).attr('data-persona');
    var action =$(this).attr('data-edit');
    var table = $(this).attr('data-table');
    params={};
    console.log(params.id=id);
    console.log(params.persona=persona);
    console.log(params.action=action);
    params.table = table;
    params.idexpediente = idexpediente;
    window.location.href="get_Formulario_update?persona="+persona+"&idexpediente="+idexpediente+"&table="+table+"&id="+id+"&action="+action;
    //$('#datosadicionales').load('get_Formulario_update', params,function(){
     
    //})  
});

$(document).on('click','.adicionalpdf',function() {
    var id = $(this).attr('data-pdf');
    var idexpediente = $(this).attr('data-idexpediente');
    var persona=$(this).attr('data-persona');
    var action =$(this).attr('data-edit');
    var table = $(this).attr('data-table');
    params={};
    console.log(params.id=id);
    console.log(params.persona=persona);
    console.log(params.action=action);
    params.table = table;
    params.idexpediente = idexpediente;
    $('#datosadicionales').load('get_Formulario_pdf', params,function(){
     
    })  
});


// Guardar Datos Generales
$("#form-datos").submit(function(e) {
    e.preventDefault();
    form_datos = $(this).serializeArray();
    console.log('Form Datos Generales activado');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_insert_datos_generales",
        data: form_datos,
        success: function(response) {
            if(response.respuesta == true){
                alert("Datos guardados correctamente");
            } else {
                alert("Hubo un error al guardar, intenta mas tarde.");
            }
        },
        error: function(jqxhr, status, error) {
            console.log('Hubo un error al guardar, intenta mas tarde.!');
            console.log(error);
        },
        complete: function() {
            console.log("Ajax realizado complete");
        }   


    });
});

// Nuevo Frecuencia de Pagos
$(document).on("click",'#new_frecuencia_pago', function(e) {
    
    var action =$(this).attr('data-new');
    params={};        
    $('#mb-frecuencia').load('get_nuevo_frecuencia_pago', params, function() {
        console.log("nuevo frecuencia pago");
    })
});
$(document).on("click",".editar_frecuencia_pago", function(e) {
    
    var id = $(this).attr("data-id");
    var action =$(this).attr("data-edit");
    params={};
    console.log(params.id = id);        
    console.log(params.action = action);
    $("#mb-frecuencia").load("get_update_frecuencia_pago", params, function(){
        console.log("editar" + " " + id);
    })
});
$(document).on("click",".editar_actividad", function(e) {
    var id = $(this).attr("data-id");
    var action =$(this).attr("data-edit");
    params={};
    console.log(params.id = id);        
    console.log(params.action = action);
    $("#mbactividad").load("get_update_actividad", params,function(){
        console.log("editar" + " " + id);
    });
});
// Nuevo producto
$(document).on("click",'#new_producto', function() {
    var action = $(this).attr('data-new');
    params = {};
    $('#form-primary-productos .modal-body').load('get_nuevo_producto', params, function() {
        console.log("Nuevo producto");
    })
});
$("#form-productos").submit(function(e) {
    e.preventDefault();
    var formulario_producto = $("#form-productos").serializeArray();
    console.log('Form Productos');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_Insert_Nuevo_Producto",
        data: formulario_producto,
        success: function(response) {
            ocultarModal();
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


$(document).on("click",".edit_producto", function(e) {
    
    var id = $(this).attr("data-id");
    var action =$(this).attr("data-edit");
    params={};
    console.log(params.id = id);
    console.log(params.action = action);
    $('#mb-productos').load('get_update_producto', params, function(){
        console.log("editar" + " " + id);
    })
});



// Nuevo Tipo Persona
$(document).on('click','#new_tipo_persona',function(){        
    var action =$(this).attr('data-new');
    params={};        
    $('.modal-body').load('get_nuevo_tipo_persona', params,function() {
        console.log("nuevo tipo persona");
    });  
});

$("#form-tipo-persona").submit(function(e) {
    e.preventDefault();
    var formulario_tipo_persona = $("#form-tipo-persona").serializeArray();
    console.log('Form tipo persona');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_insert_tipo_persona",
        data: formulario_tipo_persona,
        success: function(response) {
            ocultarModal();
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

$(document).on('click','.editar_tipo_persona',function() {
    var id = $(this).attr('data-id');       
    var action =$(this).attr('data-edit');
    params={};
    console.log(params.id = id);        
    console.log(params.action = action);
    $('#mb-tipo-persona').load('get_update_tipo_persona', params,function(){
        console.log("editar" + " " + id);
    });
});

// Editar Riesgo por Estados
$(document).on("click",".editar_estado", function(e) {
    
    var id = $(this).attr("data-id");
    var action =$(this).attr("data-edit");
    params={};
    console.log(params.id = id);        
    console.log(params.action = action);
    $("#mb-estado").load("get_update_estado", params);
});

// Editar Riesgo por Pais
$(document).on("click",".editpais", function() {
    
    var id = $(this).attr("data-id");
    var action =$(this).attr("data-edit");
    params={};
    params.id = id;        
    params.action = action;
    $("#mpaises").load("get_update_pais_access", params, function(){
        console.log("editar" + " " + id);
    })
});
// Nuevo Movimientos
$(document).on('click','#new_movimiento',function(){        
    var action =$(this).attr('data-new');
    params={};        
    $('.modal-body').load('get_nuevo_movimiento', params,function() {
        console.log("nuevo movimiento");
    }); 
});
$("#form-estado").submit(function(e) {
    e.preventDefault();
    var form_estado = $(this).serializeArray();
    console.log('Form estados');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_insert_estado",
        data: form_estado,
        success: function(response) {
            ocultarModal();
            
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
        error: function() {
            alert('Error general del sistema, intente mas tarde.');
        }
    });

});

$("#form-pais").submit(function(e) {
    e.preventDefault();
    var form_pais = $(this).serializeArray();
    console.log('Form paises');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_insert_pais",
        data: form_pais,
        success: function(response) {
            ocultarModal();
            
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
        error: function() {
            alert('Error general del sistema, intente mas tarde.');
        }
    });

});

$("#form-movimientos").submit(function(e) {
    e.preventDefault();
    var formulario_movimiento = $("#form-movimientos").serializeArray();
    console.log('Form movimiento');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_insert_movimiento",
        data: formulario_movimiento,
        success: function(response) {
            ocultarModal();
            
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

$(document).on('click','.editar_movimiento',function() {
    var id = $(this).attr('data-id');       
    var action =$(this).attr('data-edit');
    params={};
    console.log(params.id = id);        
    console.log(params.action = action);
    $('#mb-movimiento').load('get_update_movimiento', params,function(){
        console.log("editar" + " " + id);
    })
});


$("#form-frecuencia-pago").on("submit", function(e) {
    e.preventDefault();    
    
    var form = $(this);         
        
        var formulario_frecuencia_pago = $("#form-frecuencia-pago").serializeArray();
        console.log('Form frecuencia pago');

        $.ajax({            
            type: "post",
            dataType: 'json',
            url: "get_insert_frecuencia_pago",
            data: formulario_frecuencia_pago,
            success: function(response) {
                ocultarModal();
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



// Nuevo Transaccionalidad
$(document).on('click','#new_transaccionalidad',function(){        
    var action =$(this).attr('data-new');
    params={};        
    $('.modal-body').load('get_nuevo_transaccionalidad', params,function() {
        console.log("nuevo transaccionalidad");
    });  
});

$("#form-transaccionalidad").submit(function(e) {
    e.preventDefault();
    var formulario_transaccionalidad = $("#form-transaccionalidad").serializeArray();
    console.log('Form transaccionalidad');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_insert_transaccionalidad",    
        data: formulario_transaccionalidad,
        success: function(response) {
            ocultarModal();
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

$(document).on('click','.editar_transaccionalidad',function() {
    var id = $(this).attr('data-id');       
    var action =$(this).attr('data-edit');
    params={};
    console.log(params.id = id);        
    console.log(params.action = action);
    $('#mb-transaccionalidad').load('get_update_transaccionalidad', params,function(){
        console.log("editar" + " " + id);
    });
});

// Nuevo No personas
$(document).on('click','#new_nopersonas',function(){        
    var action =$(this).attr('data-new');
    params={};        
    $('#mbnopersonas').load('get_nuevo_nopersonas', params,function() {
        console.log("nuevo nopersonas");
    });  
});

var tblnopersonas = $('#datatable-nopersonas').DataTable();
$("#form-nopersonas").submit(function(e) {
    e.preventDefault();
    var formulario_nopersonas = $("#form-nopersonas").serializeArray();
    console.log('Form nopersonas');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_insert_nopersonas",
        data: formulario_nopersonas,
        success: function(response) {
            ocultarModal();
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

$(document).on('click','.editar_nopersonas',function() {
    var id = $(this).attr('data-id');       
    var action =$(this).attr('data-edit');
    params={};
    console.log(params.id = id);        
    console.log(params.action = action);
    $('#mb-nopersonas').load('get_update_nopersonas', params,function(){
        console.log("editar" + " " + id);
    });
});

// Nuevo Actividad
$(document).on('click','#new_actividad',function(){        
    var action =$(this).attr('data-new');
    params={};        
    $('.modal-body').load('get_nuevo_actividad', params,function() {
        console.log("nuevo actividad");
    }); 
});

$("#form-actividad").submit(function(e) {
    e.preventDefault();
    var formulario_actividad = $("#form-actividad").serializeArray();
    console.log('Form actividad');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_insert_actividad",
        cache: false,
        data: formulario_actividad,
        success: function(response) {
            ocultarModal();
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

// Guardar Cuestionario Fisica
$("#form_cuestionario").submit(function(e) {
    e.preventDefault();
    form_datos = $(this).serializeArray();
    
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "insertCuestionario",
        data: form_datos,
        success: function(response) {            
            if(response == true) {
                alert("Datos guardados correctamente");
            } else {
                alert("Hubo un error al guardar, intenta mas tarde.");
            }
        },
        error: function(jqxhr, status, error) {
            console.log('Hubo un error al guardar, intenta mas tarde.!');
            console.log(error);
        },
        complete: function() {
            console.log("Ajax realizado complete");
        }   


    });
});
// Guardar Formato Visita
$("#form_visita").submit(function(e) {
    e.preventDefault();
    form_datos = $(this).serializeArray();
    console.log('Form Visita activado');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "insertFormatoVisita",
        data: form_datos,
        success: function(response) {
            if(response == true) {
                alert("Datos guardados correctamente");
            } else {
                alert("Hubo un error al guardar, intenta mas tarde.");
            }
        },
        error: function(jqxhr, status, error) {
            console.log('Hubo un error al guardar, intenta mas tarde.!');
            console.log(error);
        },
        complete: function() {
            console.log("Ajax realizado complete");
        }   


    });
});

$(".list-alertas").on("click", function(e) {
    
    e.preventDefault();
    var id = $(this).data('id');   
    var url='listado_documentos_alertas?id=' + id;
    document.location=(url);
    
});

// Usuarios

$("#form-usuarios").submit(function(e) {
    e.preventDefault();
    var formulario_producto = $("#form-usuarios").serializeArray();
    console.log('Form Usuarios');
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "get_Insert_Nuevo_Producto",
        data: formulario_producto,
        success: function(response) {
            ocultarModal();
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

$(document).on("click",".edit_usuario", function(e) {
    
    var id = $(this).attr("data-id");
    var action =$(this).attr("data-edit");
    params={};
    console.log(params.id = id);
    console.log(params.action = action);
    $('#mb-productos').load('get_update_producto', params, function(){
        console.log("editar" + " " + id);
    })
});

// Nueva cuenta concentradora

/*
$("#form-cuentas").submit(function(e) {
    e.preventDefault();
    var formulario = $("#form-cuentas").serialize();    
    $.ajax({
        type: "post",
        dataType: 'json',
        url: "guardar_cuentas",
        data: formulario,

        success: function(response) {
            ocultarModal();
            // Validar mensaje de error
            if(response.respuesta == false) 
            {
                //alert(response.mensaje);
                $("#error").show();
                $( "#error" ).fadeOut(10000);
                 
            }
            else 
            {                    
                //alert(response.mensaje);
                $("#exito").show();
                $( "#exito" ).fadeOut(10000);
                       
            }
            location.reload();
        },
        error:function(){
            alert('Error general del sistema, intente mas tarde.');
                 location.reload(true);   
        } 
    });

});
*/
/*CARGAMOS EN EL DIV MB-CUENTAS LA INFOR´MACIÓN DE LA CUENTA*/
/*
$(document).on("click",".edit_cuenta", function(e) {   
    //SE OBTIENE EL ID DE LA CUENTA
    var banco = $(this).attr("data-banco");   
    //params EQUIVALE A POST
    params={};
    params.banco = banco;    

    $('#mb-cuentas').load('update_cuenta', params);



});
*/

/*
$(document).on("click",'#btnNuevaCuenta', function() {
    var action = $(this).attr('data-new');
    params = {};
    $('#form-primary-cuentas .modal-body').load('get_nueva_cuenta', params, function() {
        console.log("Nueva cuenta");
    })
});*/

$(document).on('click','.delete-cuenta',function(e) {
    e.preventDefault();
    var cuenta = $(this).data('id');         
        
    if (confirm("¿Desea eliminar esta cuenta?")) {          
        $.ajax({
            type:"post",
            dataType: 'json',
            url: "eliminar_cuenta",
            data: "cuenta=" + cuenta,
            success: function() {
                location.reload(true);  
            }
        });
    }
});


}); // Fin ready
var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';
/*var cdnSwf = '//cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf'; "dom": 'T<"clear">lBfrtip', */
var buttons = {"buttons": [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
    ]};

$('#datatable-expedientes').DataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[50, 100, -1], [50, 100, "Todos"]],
    dom: '<"top"B><"clear">lf<"bottom"Trtip>',
    buttons
});
$('#datatable-clientes').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
    buttons
});
$('#datatable-creditos').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
    buttons
});
$('#datatable-detallemov').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-alertas').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});
$('#tabla-productos').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
    buttons
});

$('#datatable-frecuencia').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-nopersonas').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});
$('#datatable-actividad').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[-1], ["Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-mmovimientos').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-estados').dataTable({
    "language": {
        "url": langTabl
    },
     "lengthMenu": [[10, 25, -1], [5, 10, 25, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});
$('#datatable-paises').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[-1], ["Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-oi').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-or').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
    buttons

});
$('#datatable-ip').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-24').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-buzon').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-agrup-cred').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});

$('#datatable-acum-mov').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});
$('#datatable-datos-adicionales').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-agrcreditos').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-depositos').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons

});
$('#datatable-autorizaciones').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});

$('#datatable-avisos-p').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});

$('#datatable-avisos-r').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});

$('#table-reporte-mensual, #table-reporte-semestral').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});

$('#datatable-mislistas').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});

$('#datatableFideicomisos').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});

$('#datatableTipoCargo').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
     buttons
});

$('#datatable-prospectos').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
    buttons
});

$('#admon-clientes').dataTable({
    "language": {
        "url": langTabl
    },
    "lengthMenu": [[50, -1], [50, "Todos"]],
    "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
    buttons
});