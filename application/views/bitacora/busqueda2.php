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
                            <h2 class="text-shadow text-primary">Busquedas de: <?= $usuario=$this->session->userdata('empresa'); ?></h2>

                        </div>
                        <br>


                        <div class="content">



                          <div class="table-responsive">
                              <table  data-order='[[ 2, "desc" ]]' class="table table-bordered" id="datatable-expedientes">
                                  <thead>
                                      <tr>
                                        <th>Nombre /Razon social</th>
                                        <th>Fecha de busqueda</th>
                                        <th>No. de resultados</th>
                                        <th>Listas en las que aparecio</th>
                                        <th>Nueva fecha de busqueda</th>
                                        <th>No. de resultados</th>
                                        <th>Listas en las que aparecio</th>
                                        <th>Editar</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php echo $historial ?>
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

<div class="modal fade" id="edit_fuente" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h3>Eliminar</h3>
         </div>
         <div class="modal-body">
					 <form id="formEditUser" method="post" action="<?= base_url('historial/eliminar') ?>">
						 		 <input type="text" name="idE" id="idE" value="" hidden/>
                 <h5>Desea eliminar este nombre de su historial de seguimiento, si lo hace no podra realizar su seguimiento pero no quedara eliminado de su bitacora de busquedas </h5>


                 <br><br><br>
                 <button type="submit"  class="btn btn-success">Eliminar</button>
                 <button type="button"  class="btn btn-success">Cancelar</button>
           </form>
        </div>
      </div>
   </div>
</div>


<script>


   $(document).on("click", ".open-Modal", function () {
      var myID = $(this).data('id');
      $(".modal-body #idE").val( myID );


   });

</script>
