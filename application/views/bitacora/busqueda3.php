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
                                        <th>Rebusqueda</th>
                                        <th>Eliminar</th>
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
           </form>
        </div>
      </div>
   </div>
</div>
<div class="modal fade" id="busqueda_nueva" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h3>Rebusqueda</h3>
         </div>
         <div class="modal-body">
					 <!--<form id="formBusqueda" method="post" action="<?= base_url('historial/busqueda') ?>">-->
             <div class="form-group">
                 <label>Nombre a buscar</label>
                 <input type="text" name="nombre_busqueda" id="nombre_busqueda" disabled/>
                 <button type="submit" id="btn" class="btn btn-success">Buscar</button>
                 <br><br><br>
                 <div id="respuesta"></div>

             </div>

           <!--</form>-->
        </div>
      </div>
   </div>
</div>

<script type="text/javascript">
function showNew() {

    $("#respuesta").empty();
}
    $(document).ready(function(){
          $('#bus').click(function(){
            $("#respuesta").empty();
          });


        $('#btn').click(function(){
          //$("#respuesta").empty();
            var nombre=$('#nombre_busqueda').val();
              $(".modal-body #nombre_busqueda2").val( nombre );
              $(".modal-body #respuesta").val( nombre );
               $("#respuesta").empty();
            //  $(".modal-body #respuesta").val( nombre2 );
            $.ajax({
                  url: '<?= base_url('historial/buscar') ?>',
                  type: 'POST',
                  dataType: 'html',
                  data: {id:nombre},
            })
            .done(function(response) {
                $("#respuesta").append(response);
                })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

        });

      });

</script>

<script>

   $(document).on("click", ".open-Modal", function () {
      var myID = $(this).data('id');
      var nombre = $(this).data('nombre');
      $(".modal-body #idE").val( myID );
      $(".modal-body #nombre_busqueda").val( nombre );


   });
   $(document).on('click', '#print_result', function() {
         name    = 'Busqueda de seguimiento';
         estatus = '';
         datos   = $("#datos").val();
         var data = new FormData();
         data.append('name', name);
         data.append('estatus', estatus);
         data.append('datos', datos);
         var xhr = new XMLHttpRequest();
         xhr.open('POST', "<?= base_url('busqueda/print_result3') ?>", true);
         xhr.responseType = 'blob';

         xhr.onload = function(e) {
           if (this.status == 200) {
             var blob = new Blob([this.response], {type: 'application/pdf'});
             var link = document.createElement('a');
             link.href = window.URL.createObjectURL(blob);
             link.download = name+".pdf";
             link.click();
           }
         };

         xhr.send(data);

     });
</script>
