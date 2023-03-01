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
                            <h2 class="text-shadow text-primary">Fuentes de información de: <?= $usuario=$this->session->userdata('empresa'); ?></h2>

                        </div>
                        <br>


                        <div class="content">

                          <button onclick="showNew()" class="btn btn-primary">Nueva fuente</button>

                          <div class="table-responsive">
                              <table  data-order='[[ 2, "desc" ]]' class="table table-bordered" id="datatable-expedientes">
                                  <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Clave</th>
                                        <th>Nombre</th>
                                        <th>URL</th>
																				<th>Fecha de creacion</th>
                                        <th></th>
                                        <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $date2=date("Y-m-d");
                                       foreach ($fuentes as $fuente): ?>
                                      <tr class="odd gradeX">
                                          <td><?php echo $fuente['id']; ?></td>
                                          <td><?php echo $fuente['clave'];  ?></td>
                                          <td><?php echo $fuente['nombre'];?></td>
                                          <td><?php echo $fuente['url']; ?></td>
                                          <td><?php echo $fuente['created_at']; ?></td>

                                          <td class="center">
                                            <a data-toggle="modal"
                                              data-id="<?php echo $fuente['id']; ?>"
                                              data-c="<?php echo $fuente['clave']; ?>"
                                              data-n="<?php echo $fuente['nombre']; ?>"
                                              data-u="<?php echo $fuente['url']; ?>"
                                            	class="open-Modal btn btn-primary" href="#edit_fuente">
                                              <i class="fas fa-pencil-alt"></i>
                                            </a>
                                          </td>
                                          <td class="center">
                                            <a data-toggle="modal" data-id="<?php echo $fuente['id']; ?>"
                                              class="open-Modal btn btn-primary" href="#delete_fuente">
                                              <i class="fas fa-trash-alt"></i>
                                            </a>
                                          </td>
                                          </tr>
                                      <?php endforeach; ?>
                                  </tbody>
                              </table>
                          </div>

                        </div>
                    </div>
                </div>
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
<div class="modal fade" id="newfuente" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3>Nueva fuente</h3>
         </div>
         <div class="modal-body">
          <form id="formNewFuente" method="post" action="<?= base_url('fuentes/new_fuente') ?>">

                <div class="form-group">
                    <label>Clave</label>
                    <input type="text" class="form-control" id="clave" name="clave" required>
                </div>
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label>URL</label>
                    <input type="text" class="form-control" id="url" name="url" required>
                </div>

                <button type="submit"  class="btn btn-success">Guardar</button>
          </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="delete_fuente" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Eliminar</h3>
         </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('fuentes/delete_Fuente') ?>">
                <input type="text" name="id" id="id" value="" hidden/>
                <h4>¿Realmente desea eliminar esta fuente de información ? </h4> <br>
                <button type="submit"  class="btn btn-success" >Eliminar</button>
          </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="edit_fuente" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h3>Editar fuente de información</h3>
         </div>
         <div class="modal-body">
					 <form id="formEditUser" method="post" action="<?= base_url('fuentes/edit_fuente') ?>">
						 		 <input type="text" name="idE" id="idE" value="" hidden/>
                 <div class="form-group">
                     <label>Clave</label>
                     <input type="text" class="form-control" id="claveE" name="claveE" required>
                 </div>
                 <div class="form-group">
                     <label>Nombre</label>
                     <input type="text" class="form-control" id="nombreE" name="nombreE" required>
                 </div>

                 <div class="form-group">
                     <label>URL</label>
                     <input type="text" class="form-control" id="urlE" name="urlE" required>
                 </div>

                 <button type="submit"  class="btn btn-success">Guardar</button>
           </form>
        </div>
      </div>
   </div>
</div>



<script>

  function showNew() {
    $("#newfuente").modal("show");
  }

   $(document).on("click", ".open-Modal", function () {
      var myID = $(this).data('id');
      var clave = $(this).data('c');
      var nombre = $(this).data('n');
      var url = $(this).data('u');

      $(".modal-body #id").val( myID );
      $(".modal-body #idE").val( myID );
      $(".modal-body #claveE").val( clave );
      $(".modal-body #nombreE").val( nombre );
      $(".modal-body #urlE").val( url );

   });

</script>
