$(document).ready(function () {




});

$(document).on('click', '#btn-close-delete-customer', function () {
    $("#mod-success2").modal('hide');
    $("#causa_delete").val('');
    $("#customer_id").val('');
});

$(document).on('click', '.btn-open-delete-cus', function () {
    var id = $(this).attr("data-id");
    $("#customer_id").val(id);
    //console.log(id);
});

//star delete logical customer

$(document).on('click', '#btn-sucess-delete-customer', function () {
    var id = $("#customer_id").val();
    var causa_delete = $("#causa_delete").val();
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var estado = $("#estado").val();
    if (causa_delete == '') {
        $("#message-causa").show();
    } else {
        $("#customers_table").dataTable().fnDestroy();
        var data = {id: id,
            causa_delete: causa_delete
        }
        $.ajax({
            url: 'delete_customer',
            type: 'post',
            data: data,
            success: function (data) {
                $("#mod-success2").modal('hide');


                if (estado == 'all') {
                    buildTable(csrf_token_name, csrf_hash);
                } else if (estado == 'inac') {
                    buildTableCustomersInac(csrf_token_name, csrf_hash);
                } else if (estado == 'act') {
                    buildTableCustomersActive(csrf_token_name, csrf_hash);
                }



            },
        })
    }


});
//end delete logical customer

//star build table customers for ajax

function buildTable(csrf_token_name, csrf_hash) {
    var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';
    //var buttons_d = {"buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5']};
    var data = new Object();
    data[csrf_token_name] = csrf_hash;

    $('#customers_table').DataTable({
        "language": {"url": langTabl},
        "lengthMenu": [[50, 100, ''], [50, 100, "Todos"]],
        "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
        "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "customers_all",
            "dataType": "json",
            "type": "POST",
            "data": data,
        },
        "columns": [
            {"data": "orden"},
            {"data": "tipo"},
            {"data": "no_cliente"},
            {"data": "nombre"},
            {"data": "rfc"},
            {"data": "created_at"},
            {"data": "riesgo"},
            {"data": "status"},
            {"data": "id"},
        ]
    });

}
//end build table customers for ajax


//star bild table customers inac for ajax
function buildTableCustomersInac(csrf_token_name, csrf_hash) {
    var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';
    //var buttons_d = {"buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5']};
    var data = new Object();
    data[csrf_token_name] = csrf_hash;

    $('#customers_table').DataTable({
        "language": {"url": langTabl},
        "lengthMenu": [[50, 100, ''], [50, 100, "Todos"]],
        "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
        "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "customers_inactive",
            "dataType": "json",
            "type": "POST",
            "data": data
        },
        "columns": [
            {"data": "orden"},
            {"data": "tipo"},
            {"data": "no_cliente"},
            {"data": "nombre"},
            {"data": "rfc"},
            {"data": "created_at"},
            {"data": "riesgo"},
            {"data": "estado"},
            {"data": "id"},
        ]
    });

}
//end bild table customers inac for ajax


//star bild table customers active for ajax
function buildTableCustomersActive(csrf_token_name, csrf_hash) {
    var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';
    //var buttons_d = {"buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5']};
    var data = new Object();
    data[csrf_token_name] = csrf_hash;

    $('#customers_table').DataTable({
        "language": {"url": langTabl},
        "lengthMenu": [[50, 100, ''], [50, 100, "Todos"]],
        "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
        "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "customers_active",
            "dataType": "json",
            "type": "POST",
            "data": data
        },
        "columns": [
            {"data": "orden"},
            {"data": "tipo"},
            {"data": "no_cliente"},
            {"data": "nombre"},
            {"data": "rfc"},
            {"data": "created_at"},
            {"data": "riesgo"},
            {"data": "estado"},
            {"data": "id"},
        ]
    });
}
//end bild table customers active for ajax

//star delete credits
$(document).on('click', '.btn-open-delete-credits', function () {
    var id = $(this).attr("data-id");
    $("#expediente").val(id);
    console.log(id);
});
//end delete credits

//star delete credits close
$(document).on('click', '#btn-close-delete-credits', function () {
    $("#mod-success-credits").modal('hide');
    $("#causa_delete").val('');
    $("#id_expediente").val('');
});
//end delete credits close

//star success delete credits
$(document).on('click', '#btn-sucess-delete-credits', function () {
    console.log('entrando a funcion de borrado de creditos');
    var id = $("#expediente").val();
    var causa_delete = $("#causa_delete").val();
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    if (causa_delete == '') {
        $("#message-causa").show();
    } else {
        $("#creditos_table").dataTable().fnDestroy();
        var data = {id_expediente: id,
            causa_delete: causa_delete
        }
        $.ajax({
            url: 'delete_credits_customer',
            type: 'post',
            data: data,
            success: function (data) {

                $("#mod-success-credits").modal('hide');

                buildTableCredits(csrf_token_name, csrf_hash);



            },
        })
    }


});
//end success delete credits

//star build table credits
function buildTableCredits(csrf_token_name, csrf_hash) {
    var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';

    var data = new Object();
    data[csrf_token_name] = csrf_hash;

    $('#creditos_table').DataTable({
        "language": {"url": langTabl},
        "lengthMenu": [[10, 25, 50, 100, ''], [10, 25, 50, 100, "Todos"]],
        "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
        "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "contracts_all",
            "dataType": "json",
            "type": "POST",
            "data": data,
        },
        "columns": [
            {"data": "orden"},
            {"data": "tipo"},
            {"data": "nombre"},
            {"data": "no_credito"},
            {"data": "estatus"},
            {"data": "estado"},
        ]
    });
}
//end build table credits

//start cheked checkbox son´s menu left
$(document).on('click', '.check-padre', function () {
    //console.log('function');
    var id = $(this).attr("data-id");
    if ($(this).is(':checked')) {
        $('.check-hijo-' + id).prop('checked', true);
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        $('.check-hijo-' + id).prop('checked', false);
    }
});
//end cheked checkbox son´s menu left

//start cheked checkbox son´s menu up
$(document).on('click', '.check-padre-up', function () {
    //console.log('function_b');
    var id = $(this).attr("data-id");
    if ($(this).is(':checked')) {
        $('.check-hijo-up-' + id).prop('checked', true);

    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        $('.check-hijo-up-' + id).prop('checked', false);
    }
});
//end cheked checkbox son´s menu up

//start cheked checkbox grandchildren menu up
$(document).on('click', '.check-b-up', function () {
    //console.log('nietos');
    var id = $(this).attr("data-id");
    var id_father = $(this).attr("data-pri");

    if ($(this).is(':checked')) {
        $('.check-hijo-up-b-' + id_father + id).prop('checked', true);
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        $('.check-hijo-up-b-' + id_father + id).prop('checked', false);
    }
});
//end cheked checkbox grandchildren menu up

//start add form sub criterio clientes
function addFormAddSubcriterio(id) {
    var newHtml = '<li>' +
            '<label>' +
            '<div class="col-sm-6">' +
            '<input type="text" id="sub-cri-' + id + '" class="form-control" placeholder="Criterio" >' +
            '</div><div class="col-sm-3">' +
            '<input type="text" id="sub-riesgo-' + id + '" class="form-control " placeholder="Riesgo" >' +
            '</div>' +
            '<div class="col-sm-3">' +
            '<button type="button" class="btn btn-primary addSubCriterio" data-father="' + id + '">Guardar</button>' +
            '</div>' +
            '</label>' +
            '</li>';

    $("#ul-" + id).append(newHtml);
    $("#" + id).attr('onclick', '');
}
//end add form sub criterio clientes

//start action edit subcriterio clientes
$(document).on('click', '.editSubCriterio', function () {
    alert('¿Esta seguro que desea editar el criterio?');
    var id_father = $(this).attr("data-father");
    var id_son = $(this).attr("data-son");
    var sub_criterio = $("#subcri-" + id_father + "-" + id_son).val();
    var riesgo = $("#riesgo-" + id_father + "-" + id_son).val();
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['id'] = id_son;
    data['sub_criterio'] = sub_criterio;
    data['riesgo'] = riesgo;


    $.ajax({
        url: 'updatesubcriterio',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    $("#messa-god-" + id_father + "-" + id_son).show();
                    //getcriteriosclientes();
                    setTimeout(function () {
                        //$("#messa-god-"+id_father+"-"+id_son).fadeOut(1500);
                        $("#list-clientes").load("getcriteriosclientes");
                        //$("#seleccion").load("getvaluemclientes");
                        //buildTableRiesgoFactorClientes()
                    }, 3000);
                    break;
                case 500:

                    $("#messa-fail-" + id_father + "-" + id_son).show();
                    //getcriteriosclientes();
                    setTimeout(function () {
                        $("#messa-fail-" + id_father + "-" + id_son).fadeOut(1500);
                    }, 3000);
                    break;
                default:
                    break;
            }


        },
    });
});
//end action edit subcriterio clientes

//start action delete subcriterio clientes
$(document).on('click', '.deleteSubCriterio', function () {
    alert('¿Esta seguro que desea desactivar este subcriterio?');
    var id_father = $(this).attr("data-father");
    var id_son = $(this).attr("data-son");
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['id'] = id_son;



    $.ajax({
        url: 'desactivesubcriterio',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    //$("#messa-god-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();

                    //$("#messa-god-"+id_father+"-"+id_son).fadeOut(1500);
                    $("#list-clientes").load("getcriteriosclientes");
                    //$("#seleccion").load("getvaluemclientes");
                    //buildTableRiesgoFactorClientes()
                    break;
                case 500:

                    //$("#messa-fail-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();

                    $("#messa-fail-" + id_father + "-" + id_son).fadeOut(1500);

                    break;
                default:
                    break;
            }


        },
    });
});
//end action delete subcriterio clientes

//start action add subcriterio clientes
$(document).on('click', '.addSubCriterio', function () {
    //alert('¿Esta seguro que desea desactivar este subcriterio?');
    var id_father = $(this).attr("data-father");

    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var sub_criterio = $("#sub-cri-" + id_father).val();
    var riesgo = $("#sub-riesgo-" + id_father).val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['sub_criterio'] = sub_criterio;
    data['riesgo'] = riesgo;



    $.ajax({
        url: 'addsubcriterioclientes',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    //$("#messa-god-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();

                    //$("#messa-god-"+id_father+"-"+id_son).fadeOut(1500);
                    $("#list-clientes").load("getcriteriosclientes");
                    //$("#seleccion").load("getvaluemclientes");
                    //buildTableRiesgoFactorClientes()
                    break;
                case 500:

                    //$("#messa-fail-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();
                    alert(data.text);
                    //$("#messa-fail-"+id_father+"-"+id_son).fadeOut(1500);

                    break;
                default:
                    break;
            }


        },
    });
});
//end action add add subcriterio clientes

//start submit form subcriterio clientes
$("#addFormCriterio").submit(function (event) {
    event.preventDefault();
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url: "addcriterioclientes",
        type: request_method,
        data: form_data,
        success: function (data) {
            console.log("succes");


            switch (data.status) {
                case 200:

                    $("#closeModal").trigger({type: "click"});
                    getcriteriosclientes();
                    //buildTableRiesgoFactorClientes()

                    break;
                case 500:
                    alert('Imposible guardar el registro');
                    break;
                default:
                    break;
            }

        },
    }).done(function (response) {
    });
});
//end submit action form subcriterio clientes

//start action delete criterio clientes
$(document).on('click', '.btnDeleteCriterio', function () {
    alert('¿Esta seguro que desea desactivar este criterio?');
    var id = $(this).attr("id");
    var data = new Object();

    data['id'] = id;

    $.ajax({
        url: 'deletecriterioclientes',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    $("#list-clientes").load("getcriteriosclientes");
                    // $("#seleccion").load("getvaluemclientes");
                    //buildTableRiesgoFactorClientes()
                    break;
                case 500:

                    alert(data.text);
                    break;
                default:
                    break;
            }


        },
    });
});
//end action delete criterio clientes

//start action edit criterio clientes
$(document).on('click', '.btnEditCriterio', function () {
    alert('¿Esta seguro que desea editar este criterio?');
    var id = $(this).attr("id");
    var criterio = $("#criterio-" + id).val();
    var ponderacion = $("#ponderacion-" + id).val();
    var aplica = $("#aplica-" + id).val();
    var data = new Object();

    data['id'] = id;
    data['criterio'] = criterio;
    data['ponderacion'] = ponderacion;
    data['aplica'] = aplica;

    $.ajax({
        url: 'updatecriterioclientes',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    $("#list-clientes").load("getcriteriosclientes");
                    //$("#seleccion").load("getvaluemclientes");
                    //buildTableRiesgoFactorClientes()
                    break;
                case 500:

                    alert(data.text);
                    break;
                default:
                    break;
            }


        },
    });
});
//end action edit criterio clientes


$(document).on('click', '.btnAddValueClientes', function () {

    var id_father = $(this).attr("data-father");
    var id_son = $(this).attr("data-son");
    var data = new Object();

    data['id_father'] = id_father;
    data['id_son'] = id_son;


    $.ajax({
        url: 'addvaluemclientes',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    $("#seleccion").load("getvaluemclientes");
                    buildTableRiesgoFactorClientes()
                    break;
                case 500:

                    alert(data.text);
                    break;
                default:
                    break;
            }


        },
    });
});

//start function get criterios clientes and build list
function getcriteriosclientes() {
    //console.log('actualizar matriz');
    $.ajax({
        url: 'getcriteriosclientes',
        type: 'post',
        success: function (data) {

            $("#list-clientes").html(data);
        },
    });
}
//end function get criterios clientes and build list

function buildTableRiesgoFactorClientes() {
    var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();
    data[csrf_token_name] = csrf_hash;

    $('#riesgo_factor_m_clientes_table').DataTable({
        "language": {"url": langTabl},
        "lengthMenu": [[10, 25, 50, 100, ''], [10, 25, 50, 100, "Todos"]],
        "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
        "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "getfactorriesgomclientes",
            "dataType": "json",
            "type": "POST",
            "data": data,
        },
        "columns": [
            {"data": "criterio"},
            {"data": "sub_criterio"},
            {"data": "riesgo"},
            {"data": "total"},
            {"data": "puntuaje"},
            {"data": "ponderacion"},
        ]
    });
}

//start submit form recover pass
$("#formulario_recover_pass").submit(function (event) {
    event.preventDefault();
    var url = $(this).attr("action");
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url: url,
        type: request_method,
        data: form_data,
        success: function (data) {
            console.log(data.status);


            switch (data.status) {
                case 200:
                    $("#message_yes_email").show();
                    $("#message-yes").text(data.text);
                    break;
                case 500:
                    $("#message_no_email").show();
                    $("#message-no").text(data.text);
                    break;
                default:
                    break;
            }

        },
    }).done(function (response) {
    });
});
//end submit form recover pass

$("#addFormCriterio_j").submit(function (event) {
    event.preventDefault();
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url: "insertcriteriojurisdicciones",
        type: request_method,
        data: form_data,
        success: function (data) {
            //console.log("succes");


            switch (data.status) {
                case 200:

                    $("#closeModal_j").trigger({type: "click"});
                    getcriteriosjurisdicciones();
                    break;
                case 500:
                    alert('Imposible guardar el registro');
                    break;
                default:
                    break;
            }

        },
    }).done(function (response) {
    });
});

$(document).on('click', '.addSubCriterioJus', function () {
    //alert('¿Esta seguro que desea desactivar este subcriterio?');
    var id_father = $(this).attr("data-father");

    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var sub_criterio = $("#sub-cri-" + id_father).val();
    var riesgo = $("#sub-riesgo-" + id_father).val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['sub_criterio'] = sub_criterio;
    data['riesgo'] = riesgo;



    $.ajax({
        url: 'insertsubcriteriojurisdicciones',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriteriosjurisdicciones();
                    break;
                case 500:

                    //$("#messa-fail-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();
                    alert(data.text);
                    //$("#messa-fail-"+id_father+"-"+id_son).fadeOut(1500);

                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.editSubCriterioJuris', function () {
    alert('¿Esta seguro que desea editar el subcriterio?');
    var id_father = $(this).attr("data-father");
    var id_son = $(this).attr("data-son");
    var sub_criterio = $("#subcri-" + id_father + "-" + id_son).val();
    var riesgo = $("#riesgo-" + id_father + "-" + id_son).val();
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['id'] = id_son;
    data['sub_criterio'] = sub_criterio;
    data['riesgo'] = riesgo;


    $.ajax({
        url: 'updatesubcriteriojurisdicciones',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    $("#messa-god-" + id_father + "-" + id_son).show();
                    //getcriteriosclientes();
                    setTimeout(function () {
                        //$("#messa-god-"+id_father+"-"+id_son).fadeOut(1500);
                        getcriteriosjurisdicciones()
                    }, 3000);
                    break;
                case 500:

                    $("#messa-fail-" + id_father + "-" + id_son).show();
                    //getcriteriosclientes();

                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.deleteSubCriterioJuris', function () {
    alert('¿Esta seguro que desea desactivar este subcriterio?');
    var id_father = $(this).attr("data-father");
    var id_son = $(this).attr("data-son");
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['id'] = id_son;



    $.ajax({
        url: 'desactivesubcriteriojurisdicciones',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriteriosjurisdicciones();
                    break;
                case 500:

                    //$("#messa-fail-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();

                    $("#messa-fail-" + id_father + "-" + id_son).fadeOut(1500);

                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.btnDeleteCriterioJuris', function () {
    alert('¿Esta seguro que desea desactivar este criterio?');
    var id = $(this).attr("id");
    var data = new Object();

    data['id'] = id;

    $.ajax({
        url: 'deletecriteriojurisdicciones',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriteriosjurisdicciones();
                    break;
                case 500:

                    alert(data.text);
                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.btnEditCriterioJuris', function () {
    alert('¿Esta seguro que desea editar este criterio?');
    var id = $(this).attr("id");
    var criterio = $("#criterio-" + id).val();
    var ponderacion = $("#ponderacion-" + id).val();
    var aplica = $("#aplica-" + id).val();
    var data = new Object();

    data['id'] = id;
    data['criterio'] = criterio;
    data['ponderacion'] = ponderacion;
    data['aplica'] = aplica;

    $.ajax({
        url: 'updatecriteriojurisdicciones',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriteriosjurisdicciones();
                    break;
                case 500:

                    alert(data.text);
                    break;
                default:
                    break;
            }


        },
    });
});


function getcriteriosjurisdicciones() {
    //console.log('actualizar matriz');
    $.ajax({
        url: 'getcriteriosjurisdicciones',
        type: 'post',
        success: function (data) {

            $("#list-jurisdicciones").html(data);
        },
    });
}

function addFormAddSubcriterioJust(id) {
    var newHtml = '<li>' +
            '<label>' +
            '<div class="col-sm-6">' +
            '<input type="text" id="sub-cri-' + id + '" class="form-control" placeholder="Criterio" >' +
            '</div><div class="col-sm-3">' +
            '<input type="text" id="sub-riesgo-' + id + '" class="form-control " placeholder="Riesgo" >' +
            '</div>' +
            '<div class="col-sm-3">' +
            '<button type="button" class="btn btn-primary addSubCriterioJus" data-father="' + id + '">Guardar</button>' +
            '</div>' +
            '</label>' +
            '</li>';

    $("#ul-" + id).append(newHtml);
    $("#" + id).attr('onclick', '');
}

$("#addFormCriterio_p").submit(function (event) {
    event.preventDefault();
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url: "insertcriterioproductos",
        type: request_method,
        data: form_data,
        success: function (data) {
            //console.log("succes");


            switch (data.status) {
                case 200:

                    $("#closeModal_j").trigger({type: "click"});
                    getcriteriosproductos();
                    break;
                case 500:
                    alert('Imposible guardar el registro');
                    break;
                default:
                    break;
            }

        },
    }).done(function (response) {
    });
});

$(document).on('click', '.btnEditCriterioProd', function () {
    alert('¿Esta seguro que desea editar este criterio?');
    var id = $(this).attr("id");
    var criterio = $("#criterio-" + id).val();
    var ponderacion = $("#ponderacion-" + id).val();
    var aplica = $("#aplica-" + id).val();
    var data = new Object();

    data['id'] = id;
    data['criterio'] = criterio;
    data['ponderacion'] = ponderacion;
    data['aplica'] = aplica;

    $.ajax({
        url: 'updatecriterioproductos',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriteriosproductos();
                    break;
                case 500:

                    alert(data.text);
                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.btnDeleteCriterioProd', function () {
    alert('¿Esta seguro que desea desactivar este criterio?');
    var id = $(this).attr("id");
    var data = new Object();

    data['id'] = id;

    $.ajax({
        url: 'deletecriterioproductos',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriteriosproductos();
                    break;
                case 500:

                    alert(data.text);
                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.addSubCriterioProd', function () {
    //alert('¿Esta seguro que desea desactivar este subcriterio?');
    var id_father = $(this).attr("data-father");

    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var sub_criterio = $("#sub-cri-" + id_father).val();
    var riesgo = $("#sub-riesgo-" + id_father).val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['sub_criterio'] = sub_criterio;
    data['riesgo'] = riesgo;



    $.ajax({
        url: 'insertsubcriterioproductos',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriteriosproductos();
                    break;
                case 500:

                    //$("#messa-fail-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();
                    alert(data.text);
                    //$("#messa-fail-"+id_father+"-"+id_son).fadeOut(1500);

                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.editSubCriterioProd', function () {
    alert('¿Esta seguro que desea editar el subcriterio?');
    var id_father = $(this).attr("data-father");
    var id_son = $(this).attr("data-son");
    var sub_criterio = $("#subcri-" + id_father + "-" + id_son).val();
    var riesgo = $("#riesgo-" + id_father + "-" + id_son).val();
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['id'] = id_son;
    data['sub_criterio'] = sub_criterio;
    data['riesgo'] = riesgo;


    $.ajax({
        url: 'updatesubcriterioproductos',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    $("#messa-god-" + id_father + "-" + id_son).show();
                    //getcriteriosclientes();
                    setTimeout(function () {
                        //$("#messa-god-"+id_father+"-"+id_son).fadeOut(1500);
                        getcriteriosproductos();
                    }, 3000);
                    break;
                case 500:

                    $("#messa-fail-" + id_father + "-" + id_son).show();
                    //getcriteriosclientes();

                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.deleteSubCriterioProd', function () {
    alert('¿Esta seguro que desea desactivar este subcriterio?');
    var id_father = $(this).attr("data-father");
    var id_son = $(this).attr("data-son");
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['id'] = id_son;



    $.ajax({
        url: 'desactivesubcriterioproductos',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriteriosproductos();
                    break;
                case 500:

                    //$("#messa-fail-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();

                    $("#messa-fail-" + id_father + "-" + id_son).fadeOut(1500);

                    break;
                default:
                    break;
            }


        },
    });
});

function addFormAddSubcriterioProd(id) {
    var newHtml = '<li>' +
            '<label>' +
            '<div class="col-sm-6">' +
            '<input type="text" id="sub-cri-' + id + '" class="form-control" placeholder="Criterio" >' +
            '</div><div class="col-sm-3">' +
            '<input type="text" id="sub-riesgo-' + id + '" class="form-control " placeholder="Riesgo" >' +
            '</div>' +
            '<div class="col-sm-3">' +
            '<button type="button" class="btn btn-primary addSubCriterioProd" data-father="' + id + '">Guardar</button>' +
            '</div>' +
            '</label>' +
            '</li>';

    $("#ul-" + id).append(newHtml);
    $("#" + id).attr('onclick', '');
}

function getcriteriosproductos() {
    //console.log('actualizar matriz');
    $.ajax({
        url: 'getcriteriosproductos',
        type: 'post',
        success: function (data) {

            $("#list-productos").html(data);
        },
    });
}

$("#addFormCriterio_c").submit(function (event) {
    event.preventDefault();
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url: "insertcriteriocanales",
        type: request_method,
        data: form_data,
        success: function (data) {
            //console.log("succes");


            switch (data.status) {
                case 200:

                    $("#closeModal_j").trigger({type: "click"});
                    getcriterioscanales();
                    break;
                case 500:
                    alert('Imposible guardar el registro');
                    break;
                default:
                    break;
            }

        },
    }).done(function (response) {
    });
});

$(document).on('click', '.btnEditCriterioCanal', function () {
    alert('¿Esta seguro que desea editar este criterio?');
    var id = $(this).attr("id");
    var criterio = $("#criterio-" + id).val();
    var ponderacion = $("#ponderacion-" + id).val();
    var aplica = $("#aplica-" + id).val();
    var data = new Object();

    data['id'] = id;
    data['criterio'] = criterio;
    data['ponderacion'] = ponderacion;
    data['aplica'] = aplica;

    $.ajax({
        url: 'updatecriteriocanales',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriterioscanales();
                    break;
                case 500:

                    alert(data.text);
                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.btnDeleteCriterioCanal', function () {
    alert('¿Esta seguro que desea desactivar este criterio?');
    var id = $(this).attr("id");
    var data = new Object();

    data['id'] = id;

    $.ajax({
        url: 'deletecriteriocanales',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriterioscanales();
                    break;
                case 500:

                    alert(data.text);
                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.addSubCriterioCanal', function () {
    //alert('¿Esta seguro que desea desactivar este subcriterio?');
    var id_father = $(this).attr("data-father");

    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var sub_criterio = $("#sub-cri-" + id_father).val();
    var riesgo = $("#sub-riesgo-" + id_father).val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['sub_criterio'] = sub_criterio;
    data['riesgo'] = riesgo;



    $.ajax({
        url: 'insertsubcriteriocanales',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriterioscanales();
                    break;
                case 500:

                    //$("#messa-fail-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();
                    alert(data.text);
                    //$("#messa-fail-"+id_father+"-"+id_son).fadeOut(1500);

                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.editSubCriterioCanal', function () {
    alert('¿Esta seguro que desea editar el subcriterio?');
    var id_father = $(this).attr("data-father");
    var id_son = $(this).attr("data-son");
    var sub_criterio = $("#subcri-" + id_father + "-" + id_son).val();
    var riesgo = $("#riesgo-" + id_father + "-" + id_son).val();
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['id'] = id_son;
    data['sub_criterio'] = sub_criterio;
    data['riesgo'] = riesgo;


    $.ajax({
        url: 'updatesubcriteriocanales',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    $("#messa-god-" + id_father + "-" + id_son).show();
                    //getcriteriosclientes();
                    setTimeout(function () {
                        //$("#messa-god-"+id_father+"-"+id_son).fadeOut(1500);
                        getcriterioscanales();
                    }, 3000);
                    break;
                case 500:

                    $("#messa-fail-" + id_father + "-" + id_son).show();
                    //getcriteriosclientes();

                    break;
                default:
                    break;
            }


        },
    });
});

$(document).on('click', '.deleteSubCriterioCanal', function () {
    alert('¿Esta seguro que desea desactivar este subcriterio?');
    var id_father = $(this).attr("data-father");
    var id_son = $(this).attr("data-son");
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();

    data[csrf_token_name] = csrf_hash;
    data['id_father'] = id_father;
    data['id'] = id_son;



    $.ajax({
        url: 'desactivesubcriteriocanales',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");

            switch (data.status) {
                case 200:

                    getcriterioscanales();
                    break;
                case 500:

                    //$("#messa-fail-"+id_father+"-"+id_son).show();
                    //getcriteriosclientes();

                    $("#messa-fail-" + id_father + "-" + id_son).fadeOut(1500);

                    break;
                default:
                    break;
            }


        },
    });
});


function addFormAddSubcriterioCanal(id) {
    var newHtml = '<li>' +
            '<label>' +
            '<div class="col-sm-6">' +
            '<input type="text" id="sub-cri-' + id + '" class="form-control" placeholder="Criterio" >' +
            '</div><div class="col-sm-3">' +
            '<input type="text" id="sub-riesgo-' + id + '" class="form-control " placeholder="Riesgo" >' +
            '</div>' +
            '<div class="col-sm-3">' +
            '<button type="button" class="btn btn-primary addSubCriterioCanal" data-father="' + id + '">Guardar</button>' +
            '</div>' +
            '</label>' +
            '</li>';

    $("#ul-" + id).append(newHtml);

    $("#" + id).attr('onclick', '');
}

function getcriterioscanales() {
    //console.log('actualizar matriz');
    $.ajax({
        url: 'getcriterioscanales',
        type: 'post',
        success: function (data) {

            $("#list-canales").html(data);
        },
    });
}

$("#formAddExecSearchList").submit(function (event) {
    event.preventDefault();
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url: "insertperiodexelistsearch",
        type: request_method,
        data: form_data,
        success: function (data) {
            switch (data.status) {
                case 200:

                    alert("Se guardo el registro correctamente");
                    $("#messge-config").text(data.text);
                    
                    break;
                case 500:
                    alert('No se guardo el registro correctamente');
                    break;
                default:
                    break;
            }

        },
    }).done(function (response) {
    });
});

function toggletr(nameclass){
    console.log('toogle');
    $(nameclass).slideToggle("slow");
}

$('#form-oi').on('submit', function(e){
   var $form = $(this);
   if ( $.fn.dataTable.isDataTable( '#datatable-oi' ) ) {
    table = $('#datatable-oi').DataTable();
}
else {
    table = $('#datatable-oi').DataTable( {
        paging: false
    } );
}
   
   // Iterate over all checkboxes in the table
   table.$('input[type="checkbox"]').each(function(){
      // If checkbox doesn't exist in DOM
      if(!$.contains(document, this)){
         // If checkbox is checked
         if(this.checked){
            // Create a hidden element 
            $form.append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', this.name)
                  .val(this.value)
            );
         }
      } 
   });    
 }); 
   
   $(document).on('click', '.btn-edit-person', function () {
       
       $('#edit-person-lpb').modal('show');
    
    var data = new Object();

    data['id'] = this.id;



    $.ajax({
        url: 'get_person_informaton_in_list',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");
            //console.log(data);
            switch (data.status) {
                case 200:

                    $('#nombre').val(data.person.nombre);
                    $('#apaterno').val(data.person.apaterno);
                    $('#amaterno').val(data.person.amaterno);
                    $('#rfc').val(data.person.rfc);
                    $('#curp').val(data.person.curp);
                    $('#nacionalidad').val(data.person.nacionalidad);
                    $('#actividad').val(data.person.actividad);
                    //$('#no_folio').val(data.person.no_folio);
                    $('#domicilio').val(data.person.domicilio);
                    $('#id').val(data.person.id);
                    $('#observaciones').val(data.person.observaciones);

                    $('#situacion_del_contribuyente').val(data.person.situacion_del_contribuyente);
                    $('#numero_y_fecha_de_oficio_global_de_presuncion').val(data.person.numero_y_fecha_de_oficio_global_de_presuncion);
                    $('#publicacion_pagina_sat_presuntos').val(data.person.publicacion_pagina_sat_presuntos);
                    $('#publicacion_dof_presuntos').val(data.person.publicacion_dof_presuntos);
                    $('#publicacion_pagina_sat_desvirtuados').val(data.person.publicacion_pagina_sat_desvirtuados);
                    $('#numero_fecha_oficio_global_contribuyentes_desvirtuaron').val(data.person.numero_fecha_oficio_global_contribuyentes_desvirtuaron);
                    $('#publicacion_dof_desvirtuados').val(data.person.publicacion_dof_desvirtuados);
                    $('#numero_y_fecha_de_oficio_global_de_definitivos').val(data.person.numero_y_fecha_de_oficio_global_de_definitivos);
                    $('#publicacion_pagina_sat_definitivos').val(data.person.publicacion_pagina_sat_definitivos);
                    $('#publicacion_dof_definitivos').val(data.person.publicacion_dof_definitivos);
                    $('#numero_y_fecha_de_oficio_global_de_sentencia_favorable').val(data.person.numero_y_fecha_de_oficio_global_de_sentencia_favorable);
                    $('#publicacion_pagina_sat_sentencia_favorable').val(data.person.publicacion_pagina_sat_sentencia_favorable);
                    $('#publicacion_dof_sentencia_favorable').val(data.person.publicacion_dof_sentencia_favorable);
                    $('#numero_oficio_personas_bloqueadas').val(data.person.numero_oficio_personas_bloqueadas);
                    
                    break;
                case 500:
                    $('#message-error').show();
                    $('#message-error').fadeOut(2000);

                    break;
                default:
                    break;
            }


        },
    });
});

$("#formEditPerson").submit(function (event) {
    event.preventDefault();
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url: "edit_person_in_list",
        type: request_method,
        data: form_data,
        success: function (data) {
            switch (data.status) {
                case 200:
                    $("#list_blocked").dataTable().fnDestroy();
                    $('#message-ok').show();
                    $('#message-ok').fadeOut(2000);
                    $('#edit-person-lpb').modal('hide');
                     
                    buildTableLPB();
                    
                    break;
                case 500:
                    $('#message-error').fadeOut(2000);
                    break;
                default:
                    break;
            }

        },
    }).done(function (response) {
    });
});

function buildTableLPB() {
    var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';
    var csrf_token_name = $("#csrf_token_name").val();
    var csrf_hash = $("#csrf_hash").val();
    var data = new Object();
    data[csrf_token_name] = csrf_hash;

    $('#list_blocked').DataTable({
        "language": {"url": langTabl},
        "lengthMenu": [[10, 25, 50, 100, ''], [10, 25, 50, 100, "Todos"]],
        "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
        "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "get_list_persons_blocked",
            "dataType": "json",
            "type": "POST",
            "data": data,
        },
        "columns": [
		    	    { "data": "nombre" },
		    	    { "data": "rfc" },
		    	    { "data": "curp" },
		        	{ "data": "nacionalidad" },
		          	{ "data": "actividad" },
		          	{ "data": "fecha" },
		          	{ "data": "status" },
		          	{ "data": "no_folio" },
		          	{ "data": "id" },
		       	]
    });
}

 $(document).on('click', '#suc-delete', function () {
       
       
       var causa = $('#causa').val();
       var id = $('#id_list').val();
       
       if(causa === ''){
           $('#message-fail-causa').show();
           $('#message-fail-causa').fadeOut(2000);
       }else{
        
        var data = new Object();

        data['id'] = id;
        data['causa'] = causa;



        $.ajax({
            url: 'delete_person_in_list',
            type: 'post',
            data: data,
            success: function (data) {
                //alert("Hello! I am an alert box!!");
                //console.log(data);
                switch (data.status) {
                    case 200:
                        $("#list_blocked").dataTable().fnDestroy();
                        
                        $('#delete-person-lpb').modal('hide');

                        buildTableLPB();
                        break;
                    case 500:
                        $('#message-error').show();
                        $('#message-error').fadeOut(2000);

                        break;
                    default:
                        break;
                }


            },
        });
   }


});


$(document).on('click', '.btn-delete-person', function () {
       
       $('#delete-person-lpb').modal('show');
    
    var data = new Object();

    data['id'] = this.id;



    $.ajax({
        url: 'get_person_informaton_in_list',
        type: 'post',
        data: data,
        success: function (data) {
            //alert("Hello! I am an alert box!!");
            //console.log(data);
            switch (data.status) {
                case 200:

                    
                    $('#id_list').val(data.person.id);
                    
                    
                    break;
                case 500:
                    $('#message-error').show();
                    $('#message-error').fadeOut(2000);

                    break;
                default:
                    break;
            }


        },
    });
});

