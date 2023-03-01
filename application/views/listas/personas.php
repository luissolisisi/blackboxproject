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
							<h2>Personas bloqueadas de <?php echo $this->session->userdata('empresa');?></h2>
						</div>
						<div class="content">
              <button onclick="showNew()" class="btn btn-primary">Agregar Persona</button>
              <button  onclick="showCarga()" class="btn btn-primary">Carga Masiva</button>
                            <input type="hidden" name="csrf_token_name" id="csrf_token_name" value="<?php echo $this->security->get_csrf_token_name(); ?>">
                            <input type="hidden" name="csrf_hash" id="csrf_hash" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<br><br>
							  <a href="<?= base_url('listas/downloadsU') ?>" target="_blank">Descargar excel muestra (Carga Masiva)</a>
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
			</div>
		</div>
	</div>

</div>
<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog" style="width: 70%">
        <form id="add_person" method="post" action="<?= base_url('listas/add_person') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Añadir Persona</h3>
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
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                </div>
                                <div class="form-group">
                                    <label>Apellido paterno</label>
                                    <input type="text" id="apaterno" class="form-control" name="apaterno">
                                </div>
                                <div class="form-group">
                                    <label>Apellido materno</label>
                                    <input type="text" id="amaterno"  class="form-control" name="amaterno">
                                </div>
                                <div class="form-group">
                                    <label>RFC</label>
                                    <input type="text" id="rfc" class="form-control" name="rfc">
                                </div>
                                <div class="form-group">
                                    <label>Situación del contribuyente <span class="text-danger"> * </span></label>
                                    <select id="situacion_del_contribuyente" name="situacion_del_contribuyente" class="form-control">
                                        <option value="-"> - </option>
                                        <option value="PRESUNTO">PRESUNTO</option>
                                        <option value="DEFINITIVO">DEFINITIVO</option>
                                        <option value="DESVIRTUADO">DESVIRTUADO</option>
                                        <option value="SENTENCIA FAVORABLE">SENTENCIA FAVORABLE</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Publicación página SAT presunto</label>
                                    <input type="date" id="publicacion_pagina_sat_presuntos"  name="publicacion_pagina_sat_presuntos" parsley-trigger="change"  placeholder="Publicación página SAT presunto" class="form-control"  >
                                </div>
                                <div class="form-group">
                                    <label>Número y fecha oficio global contribuyente desvirtuaron</label>
                                    <input id="numero_fecha_oficio_global_contribuyentes_desvirtuaron"  name="numero_fecha_oficio_global_contribuyentes_desvirtuaron" parsley-trigger="change"  placeholder="Ej: 500-05-2017-2532 de fecha 06 de marzo de 2017" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Número y fecha oficio global contribuyente definitivos</label>
                                    <input  id="numero_y_fecha_de_oficio_global_de_definitivos"  name="numero_y_fecha_de_oficio_global_de_definitivos" parsley-trigger="change"  placeholder="500-05-2018-32751 de fecha 23 de noviembre de 2018" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación DOF definitivos </label>
                                    <input type="date" id="publicacion_dof_definitivos" name="publicacion_dof_definitivos" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación página SAT sentencia favorable </label>
                                    <input type="date" id="publicacion_pagina_sat_sentencia_favorable" name="publicacion_pagina_sat_sentencia_favorable" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Número de oficio personas bloqueadas </label>
                                    <input id="numero_oficio_personas_bloqueadas"  name="numero_oficio_personas_bloqueadas" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Comentarios</label>
                                    <textarea rows="3" id="observaciones" class="form-control" name="observaciones"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>CURP</label>
                                    <input type="text" id="curp"  class="form-control" name="curp">
                                </div>
                                <div class="form-group">
                                    <label>Nacionalidad</label>
                                    <input type="text" id="nacionalidad" class="form-control" name="nacionalidad">
                                </div>
                                <div class="form-group">
                                    <label>Actividad</label>
                                    <input type="text" id="actividad" class="form-control" name="actividad">
                                </div>
                                <div class="form-group">
                                    <label>Domicilio</label>
                                    <input type="text" id="domicilio" class="form-control" name="domicilio">
                                </div>
                                <div class="form-group">
                                    <label>Número y fecha global de presunción</label>
                                    <input id="numero_y_fecha_de_oficio_global_de_presuncion" name="numero_y_fecha_de_oficio_global_de_presuncion" parsley-trigger="change"  placeholder="Ej: 500-05-2015-10122 de fecha 31 de marzo de 2015" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Publicación DOF presuntos</label>
                                    <input type="date" id="publicacion_dof_presuntos" name="publicacion_dof_presuntos" parsley-trigger="change"  placeholder="Publicación DOF presuntos" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Publicación página SAT desvirtuados</label>
                                    <input type="date" id="publicacion_pagina_sat_desvirtuados" name="publicacion_pagina_sat_desvirtuados" parsley-trigger="change"  placeholder="Publicación pagina SAT desvirtuados" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Publicación DOF Desvirtuados</label>
                                    <input type="date" id="publicacion_dof_desvirtuados"  name="publicacion_dof_desvirtuados" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación página SAT definitivos </label>
                                    <input type="date" id="publicacion_pagina_sat_definitivos" name="publicacion_pagina_sat_definitivos" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Número y fecha de oficio global de sentencia favorable </label>
                                    <input id="numero_y_fecha_de_oficio_global_de_sentencia_favorable" name="numero_y_fecha_de_oficio_global_de_sentencia_favorable" parsley-trigger="change"  placeholder="500-05-2018-5912 de fecha 09 de febrero de 2018" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label> Publicación DOF sentencia favorable </label>
                                    <input type="date" id="publicacion_dof_sentencia_favorable" name="publicacion_dof_sentencia_favorable" parsley-trigger="change"  placeholder="" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Tipo de Lista</label>
                                    <select name="tipo_lista" class="form-control" required autocomplete="on">
                                      <?php foreach ($listas as $lista):
                                         echo "<option value='". $lista['clave_pertenece']."'>".$lista['nombre']." (".$lista['clave_pertenece'].")</option>";
                                      endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                    <button type="submit"  class="btn btn-success">Crear</button>

            </div>
        </form>
        <!-- /.modal-content-->
    </div>
</div>
<div class="modal fade" id="carga_masiva" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3>Carga Masiva</h3>
        </div>
				<div class="alert alert-info">
						 <i class="fa fa-info-circle sign"></i><strong>¡Info!</strong> La carga masiva se realiza en documento de hoja de calculo (Excel)
				</div>
				 <br> <br>
					 <form  method="POST" action="<?= base_url('listas/upload_files_to_excel') ?>" enctype="multipart/form-data"> <!-- Carga_lista_negra -->
						 <input name="archivo" id="file-0a" class="file" type="file" multiple data-min-file-count="1" data-show-preview="false" data-allowed-file-extensions='["*"]' data-show-upload="false" accept="*"><br>
						 <button type="submit" class="btn btn-primary">Cargar</button>

					 </form>
      </div>
   </div>
</div>

<div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Eliminar</h3>
     </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('listas/delete_person') ?>">

                <input type="text" name="id" id="id" value="" hidden/>

                 <h4>¿Realmente desea eliminar persona de la lista? </h4> <br>

                <button type="submit"  class="btn btn-success" >Eliminar</button>
          </form>
     </div>
      </div>
   </div>
</div>

<div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog" style="width: 70%">
        <form id="edit_user" method="post" action="<?= base_url('listas/edit_person') ?>">
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


<script>
  function showNew() {
    $("#newUser").modal("show");
  }
  function showCarga() {
   $("#carga_masiva").modal("show");
  }
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
  });
  var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';
	var buttons = {"buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5']};

  $(document).ready(function(){

    	$('#list_blocked').dataTable({
        	"language": { "url": langTabl },
			"lengthMenu": [[50, 100, ''], [50, 100, "Todos"]],
			"dom": '<"top"B><"clear">lf<"bottom"Trtip>',buttons,
            "processing": true,
            "serverSide": true,
            "ajax":{
            	"url": "<?php echo base_url('listas/get_list_persons') ?>",
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
