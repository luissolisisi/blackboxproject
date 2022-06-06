<div id="cl-wrapper">
    <div class="cl-sidebar">
        <!-- Sidebar Menu -->
        <?php $this->load->view('menu_left'); ?>
    </div>

    <div class="container-fluid" id="pcont">
        <div class="cl-mcont">

            <!-- Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="block-flat">
                        <div class="header">
                            <h2 class="text-shadow text-primary">Contenido de las listas de: <?= $usuario=$this->session->userdata('empresa'); ?>
                            </h2>
                        </div>
                        <div class="content">
                          <div class="table-responsive">
                            <table  data-order='[[ 2, "asc" ]]'  class="no-border blue" id="list_blocked">
                              <thead>
                                <tr>
                                  <th>Nombre</th>
                                  <th>RFC</th>
                                  <th>CURP</th>
                                  <th>Nacionalidad</th>
                                  <th>Actividad</th>
                                  <th>Fecha</th>
                                  <th>Estatus</th>
                                  <th>Tipo</th>
                                  <th>Acciones</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                    </div>
                </div>

                <!-- Nifty Modal -->
                <div class="md-overlay"> </div>
            </div>
            <!-- /.modal-->
            <!-- Modal-->
            <div id="mod-success" tabindex="-1" role="dialog" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <div id="validacion" style="text-align:left;font-size:14px;"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-warning">Aceptar</button>
                        </div>
                    </div>
                    <!-- /.modal-content-->
                </div>
                <!-- /.modal-dialog-->
            </div>
        </div>
    </div>
</div>


<div class="md-overlay"></div>

<div class="modal fade" id="deleteL_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Logico</h3>
     </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('listas/deleteL_contenido') ?>">

                <input type="text" name="id" id="id" value="" hidden/>

                 <h4>¿Realmente desea realizar el borrado Logico de esta persona? </h4> <br>

                <button type="submit"  class="btn btn-success" >Eliminar</button>
          </form>
     </div>
      </div>
   </div>
</div>

<div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog" style="width: 70%">
        <form id="edit_user" method="post" action="<?= base_url('listas/edit_contenido') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Editar</h3>
                </div>
                <div class="modal-body form">
                    <div class="row">
                        <div class="col-sm-12">
                            <p id="message-error" style="color:red;display: none"><i class="fas fa-times-circle"></i> Error al procesar información.</p>
                            <p id="message-ok" style="color:green;display: none"><i class="fas fa-check-circle"></i> Se ha actualizado la información.</p>
                            <div class="col-sm-6">
                                  <input type="text" name="idE" id="idE" value="" hidden/>
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" class="form-control" id="nombreE" name="nombreE">
                                </div>
                                <div class="form-group">
                                    <label>Apellido paterno</label>
                                    <input type="text" id="apaternoE" class="form-control" name="apaternoE">
                                </div>
                                <div class="form-group">
                                    <label>Apellido materno</label>
                                    <input type="text" id="amaternoE"  class="form-control" name="amaternoE">
                                </div>
                                <div class="form-group">
                                    <label>RFC</label>
                                    <input type="text" id="rfcE" class="form-control" name="rfcE">
                                </div>
                                <div class="form-group">
                                    <label>Situación del contribuyente <span class="text-danger"> * </span></label>
                                    <select id="situacion_del_contribuyenteE" name="situacion_del_contribuyenteE" class="form-control">
                                        <option value="-"> - </option>
                                        <option value="PRESUNTO">PRESUNTO</option>
                                        <option value="DEFINITIVO">DEFINITIVO</option>
                                        <option value="DESVIRTUADO">DESVIRTUADO</option>
                                        <option value="SENTENCIA FAVORABLE">SENTENCIA FAVORABLE</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Publicación página SAT presunto</label>
                                    <input type="date" id="publicacion_pagina_sat_presuntosE"  name="publicacion_pagina_sat_presuntosE" parsley-trigger="change"  placeholder="Publicación página SAT presunto" class="form-control"  >
                                </div>
                                <div class="form-group">
                                    <label>Número y fecha oficio global contribuyente desvirtuaron</label>
                                    <input id="numero_fecha_oficio_global_contribuyentes_desvirtuaronE"  name="numero_fecha_oficio_global_contribuyentes_desvirtuaronE" parsley-trigger="change"  placeholder="Ej: 500-05-2017-2532 de fecha 06 de marzo de 2017" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Número y fecha oficio global contribuyente definitivos</label>
                                    <input  id="numero_y_fecha_de_oficio_global_de_definitivosE"  name="numero_y_fecha_de_oficio_global_de_definitivosE" parsley-trigger="change"  placeholder="500-05-2018-32751 de fecha 23 de noviembre de 2018" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación DOF definitivos </label>
                                    <input type="date" id="publicacion_dof_definitivosE" name="publicacion_dof_definitivosE" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación página SAT sentencia favorable </label>
                                    <input type="date" id="publicacion_pagina_sat_sentencia_favorableE" name="publicacion_pagina_sat_sentencia_favorableE" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Número de oficio personas bloqueadas </label>
                                    <input id="numero_oficio_personas_bloqueadasE"  name="numero_oficio_personas_bloqueadasE" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Comentarios</label>
                                    <textarea rows="3" id="observacionesE" class="form-control" name="observacionesE"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>CURP</label>
                                    <input type="text" id="curpE"  class="form-control" name="curpE">
                                </div>
                                <div class="form-group">
                                    <label>Nacionalidad</label>
                                    <input type="text" id="nacionalidadE" class="form-control" name="nacionalidadE">
                                </div>
                                <div class="form-group">
                                    <label>Actividad</label>
                                    <input type="text" id="actividadE" class="form-control" name="actividadE">
                                </div>
                                <div class="form-group">
                                    <label>Domicilio</label>
                                    <input type="text" id="domicilioE" class="form-control" name="domicilioE">
                                    <input id="id" type="hidden" name="id">
                                </div>
                                <div class="form-group">
                                    <label>Número y fecha global de presunción</label>
                                    <input id="numero_y_fecha_de_oficio_global_de_presuncionE" name="numero_y_fecha_de_oficio_global_de_presuncionE" parsley-trigger="change"  placeholder="Ej: 500-05-2015-10122 de fecha 31 de marzo de 2015" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Publicación DOF presuntos</label>
                                    <input type="date" id="publicacion_dof_presuntosE" name="publicacion_dof_presuntosE" parsley-trigger="change"  placeholder="Publicación DOF presuntos" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Publicación página SAT desvirtuados</label>
                                    <input type="date" id="publicacion_pagina_sat_desvirtuadosE" name="publicacion_pagina_sat_desvirtuadosE" parsley-trigger="change"  placeholder="Publicación pagina SAT desvirtuados" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Publicación DOF Desvirtuados</label>
                                    <input type="date" id="publicacion_dof_desvirtuadosE"  name="publicacion_dof_desvirtuadosE" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación página SAT definitivos </label>
                                    <input type="date" id="publicacion_pagina_sat_definitivosE" name="publicacion_pagina_sat_definitivosE" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Número y fecha de oficio global de sentencia favorable </label>
                                    <input id="numero_y_fecha_de_oficio_global_de_sentencia_favorableE" name="numero_y_fecha_de_oficio_global_de_sentencia_favorableE" parsley-trigger="change"  placeholder="500-05-2018-5912 de fecha 09 de febrero de 2018" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación DOF sentencia favorable </label>
                                    <input type="date" id="publicacion_dof_sentencia_favorableE" name="publicacion_dof_sentencia_favorableE" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                    <button type="submit"  class="btn btn-success">Editar</button>

            </div>
        </form>
        <!-- /.modal-content-->
    </div>
</div>

<div class="modal fade" id="show_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog" style="width: 70%">
        <form id="show_user">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Datos Generales</h3>
                </div>
                <div class="modal-body form">
                    <div class="row">
                        <div class="col-sm-12">
                            <p id="message-error" style="color:red;display: none"><i class="fas fa-times-circle"></i> Error al procesar información.</p>
                            <p id="message-ok" style="color:green;display: none"><i class="fas fa-check-circle"></i> Se ha actualizado la información.</p>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" class="form-control" id="nombreE" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Apellido paterno</label>
                                    <input type="text" id="apaternoE" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Apellido materno</label>
                                    <input type="text" id="amaternoE"  class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>RFC</label>
                                    <input type="text" id="rfcE" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Situación del contribuyente</label>
                                    <input type="text" class="form-control" id="situacion_del_contribuyenteE" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Publicación página SAT presunto</label>
                                    <input type="text" id="publicacion_pagina_sat_presuntosE"  disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Número y fecha oficio global contribuyente desvirtuaron</label>
                                    <input id="numero_fecha_oficio_global_contribuyentes_desvirtuaronE" class="form-control" disabled >
                                </div>
                                <div class="form-group">
                                    <label>Número y fecha oficio global contribuyente definitivos</label>
                                    <input  id="numero_y_fecha_de_oficio_global_de_definitivosE"  disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación DOF definitivos </label>
                                    <input type="text" id="publicacion_dof_definitivosE" disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación página SAT sentencia favorable </label>
                                    <input type="text" id="publicacion_pagina_sat_sentencia_favorableE" disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Número de oficio personas bloqueadas </label>
                                    <input id="numero_oficio_personas_bloqueadasE"  disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Comentarios</label>
                                    <textarea rows="3" id="observacionesE" class="form-control" disabled></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>CURP</label>
                                    <input type="text" id="curpE"  class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Nacionalidad</label>
                                    <input type="text" id="nacionalidadE" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Actividad</label>
                                    <input type="text" id="actividadE" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Domicilio</label>
                                    <input type="text" id="domicilioE" class="form-control" disabled>
                                    <input id="id" type="hidden" name="id">
                                </div>
                                <div class="form-group">
                                    <label>Número y fecha global de presunción</label>
                                    <input id="numero_y_fecha_de_oficio_global_de_presuncionE" disabled class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Publicación DOF presuntos</label>
                                    <input type="text" id="publicacion_dof_presuntosE" disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Publicación página SAT desvirtuados</label>
                                    <input type="date" id="publicacion_pagina_sat_desvirtuadosE" disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Publicación DOF Desvirtuados</label>
                                    <input type="date" id="publicacion_dof_desvirtuadosE" disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación página SAT definitivos </label>
                                    <input type="text" id="publicacion_pagina_sat_definitivosE" disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Número y fecha de oficio global de sentencia favorable </label>
                                    <input id="numero_y_fecha_de_oficio_global_de_sentencia_favorableE" disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación DOF sentencia favorable </label>
                                    <input type="text" id="publicacion_dof_sentencia_favorableE" disabled class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Tipo de lista a la que pertenece </label>
                                    <input type="text" id="tipo_lista" disabled class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>


            </div>
        </form>
        <!-- /.modal-content-->
    </div>
</div>

<div class="modal fade" id="deleteF_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Permanente</h3>
     </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('listas/deleteF_contenido') ?>">

                <input type="text" name="id" id="id" value="" hidden/>

                 <h4>¿Realmente desea realizar el borrado PERMANENTE de esta persona, una vez que se realice NO podra recuperarse el registro y la información asociada con este se vera afectada? </h4> <br>

                <button type="submit"  class="btn btn-success" >Eliminar</button>
          </form>
     </div>
      </div>
   </div>
</div>

<script>

   $(document).on("click", ".open-Modal", function () {
      var myID = $(this).data('id');
			var name = $(this).data('n');
			var lpaterno = $(this).data('p');
			var lmaterno = $(this).data('m');
			var rfc = $(this).data('rfc');
			var curp = $(this).data('curp');
			var actividad = $(this).data('act');
			var domicilio = $(this).data('dom');
      var nacionalidad = $(this).data('na');
      var nfogcd    = $(this).data('nfogcd');
      var nyfdogdd  = $(this).data('nyfdogdd');
      var nopb      = $(this).data('nopb');
      var obs       = $(this).data('obs');
      var nyfdogdp  = $(this).data('nyfdogdp');
      var nyfdogdsf = $(this).data('nyfdogdsf');
      var sc = $(this).data('sc');
      var ppsp = $(this).data('ppsp');
      var pdd = $(this).data('pdd');
      var ppssf= $(this).data('ppssf');
      var pdp=$(this).data('pdp');
      var ppsd=$(this).data('ppsd');
      var pddes=$(this).data('pddes');
      var ppsdef=$(this).data('ppsdef');
      var pdsf=$(this).data('pdsf');
      var tipo=$(this).data('tipo');

			$(".modal-body #id").val( myID );
      $(".modal-body #idE").val( myID );

			$(".modal-body #nombreE").val( name );
      $(".modal-body #apaternoE").val( lpaterno );
      $(".modal-body #amaternoE").val( lmaterno );
			$(".modal-body #rfcE").val( rfc );
      $(".modal-body #curpE").val( curp );
			$(".modal-body #actividadE").val( actividad );
      $(".modal-body #domicilioE").val( domicilio );
      $(".modal-body #nacionalidadE").val( nacionalidad );
      $(".modal-body #numero_fecha_oficio_global_contribuyentes_desvirtuaronE").val(nfogcd);
      $(".modal-body #numero_y_fecha_de_oficio_global_de_definitivosE").val(nyfdogdd);
      $(".modal-body #numero_oficio_personas_bloqueadasE").val(nopb);
      $(".modal-body #observacionesE").val(obs);
      $(".modal-body #numero_y_fecha_de_oficio_global_de_presuncionE").val(nyfdogdp);
      $(".modal-body #numero_y_fecha_de_oficio_global_de_sentencia_favorableE").val(nyfdogdsf);
      $(".modal-body #situacion_del_contribuyenteE").val(sc);
      $(".modal-body #publicacion_pagina_sat_presuntosE").val(ppsp);
      $(".modal-body #publicacion_dof_definitivosE").val(pdd);
      $(".modal-body #publicacion_pagina_sat_sentencia_favorableE").val(ppssf);
      $(".modal-body #publicacion_dof_presuntosE").val(pdp);
      $(".modal-body #publicacion_pagina_sat_desvirtuadosE").val(ppsd);
      $(".modal-body #publicacion_dof_desvirtuadosE").val(pddes);
      $(".modal-body #publicacion_pagina_sat_definitivosE").val(ppsdef);
      $(".modal-body #publicacion_dof_sentencia_favorableE").val(pdsf);
      $(".modal-body #tipo_lista").val(tipo);
   });
   var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';
 	var buttons = {"buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5']};

   $(document).ready(function(){

     	$('#list_blocked').dataTable({
         	"language": { "url": langTabl },
 			"lengthMenu": [[50, 100, ''], [50, 100, "Todos"]],
 			"dom": '<"top"B><"clear">lf<"bottom"Trtip>', buttons,
             "processing": true,
             "serverSide": true,
             "ajax":{
             	"url": "<?php echo base_url('listas/get_contenido') ?>",
 		     	"dataType": "json",
 		     	"type": "POST",
 		     	"data":{ '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
 		    },
 		    "columns": [
 		    	    { "data": "nombre" },
 		    	    { "data": "rfc" },
 		    	    { "data": "curp" },
 		        	{ "data": "nacionalidad" },
 	          	{ "data": "actividad" },
 	          	{ "data": "fecha" },
            	{ "data": "status" },
              { "data": "tipo" },
 		          { "data": "id" },
 		       	]
 	    });
     });
</script>
