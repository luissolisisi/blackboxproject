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
                            <h2 class="text-shadow text-primary">Contenido eliminado de: <?= $usuario=$this->session->userdata('empresa'); ?>
                            </h2>
                        </div>
                        <div class="content">
                            <div class="table-responsive">
                                <table  data-order='[[ 2, "desc" ]]' class="table table-bordered" id="datatable-expedientes">
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
																						<th>Restaurar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($personas as $persona): ?>
                                        <tr class="odd gradeX">
                                            <td>
                                              <a data-toggle="modal"
                                              data-nyfdogdp= "<?php echo $persona['numero_y_fecha_de_oficio_global_de_presuncion']; ?>"
                                              data-nyfdogdsf= "<?php echo $persona['numero_y_fecha_de_oficio_global_de_sentencia_favorable'];?>"
                                              data-n= "<?php echo $persona['nombre'];?>"
                                              data-p= "<?php echo $persona['apaterno'];?>"
                                              data-m= "<?php echo $persona['amaterno'];?>"
                                              data-rfc= "<?php echo $persona['rfc'];?>"
                                              data-curp= "<?php echo $persona['curp'];?>"
                                              data-act= "<?php echo $persona['actividad'];?>"
                                              data-dom= "<?php echo $persona['domicilio'];?>"
                                              data-na= "<?php echo $persona['nacionalidad'];?>"
                                              data-nfogcd= "<?php echo $persona['numero_fecha_oficio_global_contribuyentes_desvirtuaron'];?>"
                                              data-nyfdogdd= "<?php echo $persona['numero_y_fecha_de_oficio_global_de_definitivos'];?>"
                                              data-nopb= "<?php echo $persona['numero_oficio_personas_bloqueadas'];?>"
                                              data-obs= "<?php echo $persona['observaciones'];?>"
                                              data-sc="<?php echo $persona['situacion_del_contribuyente'];?>"
                                              data-ppsp="<?php echo $persona['publicacion_pagina_sat_presuntos'];?>"
                                              data-pdd="<?php echo $persona['publicacion_dof_definitivos'];?>"
                                              data-ppssf="<?php echo $persona['publicacion_pagina_sat_sentencia_favorable'];?>"
                                              data-pdp="<?php echo $persona['publicacion_dof_presuntos'];?>"
                                              data-ppsd="<?php echo $persona['publicacion_pagina_sat_desvirtuados'];?>"
                                              data-pddes="<?php echo $persona['publicacion_dof_desvirtuados'];?>"
                                              data-ppsdef="<?php echo $persona['publicacion_pagina_sat_definitivos'];?>"
                                              data-pdsf="<?php echo $persona['publicacion_dof_sentencia_favorable'];?>"
                                              data-tipo="<?php echo $persona['pertenece'];?>"
                                              class="open-Modal"
                                              href="#show_user">
                                              <?php echo $persona['nombre']." ".$persona['apaterno']." ".$persona['amaterno']; ?>
                                              </a>
                                            </td>
                                            <td><?php echo $persona['rfc']; ?></td>
                                            <td><?php echo $persona['curp']; ?></td>
                                            <td><?php echo $persona['nacionalidad']; ?></td>
                                            <td><?php echo $persona['actividad']; ?></td>
																						<td><?php echo $persona['fecha']; ?></td>
																						<td><?php echo $persona['status']; ?></td>
																						<td><?php echo $persona['tipo']; ?></td>
                                            <td class="center">
                                              <a data-toggle="modal" data-id="<?php echo $persona['id']; ?>" class="open-Modal btn btn-primary" href="#restore_user"><i class="fas fa-trash-restore"></i></a>

                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
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

        </div>
    </div>
</div>


<div class="md-overlay"></div>

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

<div class="modal fade" id="restore_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Restaurar Persona</h3>
     </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('listas/restore_person') ?>">

                <input type="text" name="id" id="id" value="" hidden/>

                 <h4>¿Realmente desesa restaurar esta persona, si lo hace podra visualizrlo en la listas principal y realizar acciones con ella? </h4> <br>

                <button type="submit"  class="btn btn-success" >Restaurar</button>
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

</script>
