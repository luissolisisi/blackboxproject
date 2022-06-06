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
                            <h2 class="text-shadow text-primary">Listas de: <?= $usuario=$this->session->userdata('empresa'); ?></h2>

                        </div>
                        <br>
                        <div class="butpro butstyle flat">
                                <div class="sub">
                                         <h2>Total de listas</h2><span><?php echo $total = number_format($totalListas);?></span>
                                </div>
                        </div>
                        <div class="butpro butstyle flat">
                                <div class="sub">
                                         <h2>Total de personas</h2><span><?php  echo $total = number_format($totalRegistros);?></span>
                                </div>
                        </div>
                        <div class="content">

                          <button onclick="showNew()" class="btn btn-primary">Nueva Lista</button>

                          <div class="table-responsive">
                              <table  data-order='[[ 2, "desc" ]]' class="table table-bordered" id="datatable-expedientes">
                                  <thead>
                                      <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th>País</th>
                                        <th>Siglas</th>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Número de registros</th>
                                        <th>Días desde la última actualización</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $date2=date("Y-m-d");
                                       foreach ($listas as $lista): ?>
                                      <tr class="odd gradeX">
                                          <td> <?php echo $lista['id']; ?></td>
                                          <td> <?php $color=$lista['tipo_lista'];
                                                    switch ($color) {
                                                      case 0:
                                                      ?>
                                                          <i class="fas fa-bookmark"style="color:#FB1203;"></i>
                                                      <?php
                                                      break;

                                                      case 1:
                                                      ?>
                                                          <i class="fas fa-bookmark"style="color:#04BF0D;"></i>
                                                      <?php
                                                      break;
                                                      case 2:
                                                      ?>
                                                          <i class="fas fa-bookmark"style="color:#F7FB03;"></i>
                                                      <?php
                                                      break;

                                                      default:
                                                      ?>
                                                          <i class="fas fa-bookmark"style="color:#04BF0D;"></i>
                                                      <?php
                                                        break;
                                                    }
                                                    ?>
                                          </td>
                                          <td><?php echo $lista['pais'];  ?></td>
                                          <td><?php echo $lista['clave_pertenece'];?></td>
                                          <td><?php echo $lista['nombre']; ?></td>
                                          <td><?php echo $fecha=$lista['date']; ?></td>
                                          <td><?php echo $lista['numero']; ?></td>
                                          <td><?php
                                            $dias = (strtotime($fecha)-strtotime($date2))/86400;
                                            echo $dias = abs($dias); $dias = floor($dias);
                                            ?>
                                          </td>
                                          <td class="center">
                                            <a data-toggle="modal"
                                              data-id="<?php echo $lista['id']; ?>"
                                              data-t="<?php echo $lista['clave_tipo']; ?>"
                                              data-p="<?php echo $lista['clave_pertenece']; ?>"
                                              data-n="<?php echo $lista['nombre']; ?>"
                                              data-f="<?php echo $lista['liga']; ?>"
                                              class="open-Modal btn btn-primary" href="#edit_list">
                                              <i class="fas fa-pencil-alt"></i>
                                            </a>
                                          </td>
                                          <td class="center">
                                            <a data-toggle="modal" data-id="<?php echo $lista['id']; ?>"
                                              class="open-Modal btn btn-primary" href="#delete_list">
                                              <i class="fas fa-trash-alt"></i>
                                            </a>
                                          </td>
                                          <td class="center">
                                            <?php
                                              $idEntidad=$this->session->userdata('entidad');
                                                if($idEntidad==1500){
                                                  echo"<a data-toggle='modal' data-id='".$lista['id']."'
                                                    data-p='".$lista['clave_pertenece']."'
                                                    class='open-Modal btn btn-primary' href='#actualizar_contenido'>
                                                    <i class='fas fa-cloud-download-alt'></i>
                                                  </a>";
                                              }else{}
                                             ?>


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
<div class="modal fade" id="newlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3>Nueva Lista</h3>
         </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('listas/new_lista') ?>">
                <!--<div class="form-group">
                    <label>Tipo de lista</label>
                    <input type="text" class="form-control" id="clave_tipo" name="clave_tipo" required>
                </div>-->
                <div class="form-group">
                    <label>Clave</label>
                    <input type="text" class="form-control" id="clave_pertenece" name="clave_pertenece" required>
                </div>
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label>Fuente de la lista</label>
                    <input type="text" class="form-control" id="fuente" name="fuente" required>
                </div>

                <div class="form-group">
                    <label>Tipo de lista</label>
                    <select id="tipo_color" name="tipo_color" class="form-control" required>
                            <option value="-"> - </option>
                            <option value="0">Negra</option>
                            <option value="1">Gris</option>
                    </select>
                </div>
                <button type="submit"  class="btn btn-success">Guardar</button>
          </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="delete_list" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Eliminar lista</h3>
         </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('listas/delete_Lista') ?>">
                <input type="text" name="id" id="id" value="" hidden/>
                <h4>¿Realmente desea eliminar esta lista? </h4> <br>
                <button type="submit"  class="btn btn-success" >Eliminar</button>
          </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="edit_list" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h3>Editar Lista</h3>
         </div>
         <div class="modal-body">
					 <form id="formEditUser" method="post" action="<?= base_url('listas/edit_lista') ?>">
						 		 <input type="text" name="idE" id="idE" value="" hidden/>
                 <div class="form-group">
                     <label>Tipo de lista</label>
                     <input type="text" class="form-control" id="clave_tipoE" name="clave_tipoE" required>
                 </div>
                 <div class="form-group">
                     <label>Clave</label>
                     <input type="text" class="form-control" id="clave_perteneceE" name="clave_perteneceE" required>
                 </div>
                 <div class="form-group">
                     <label>Nombre</label>
                     <input type="text" class="form-control" id="nombreE" name="nombreE" required>
                 </div>

                 <div class="form-group">
                     <label>Fuente de la lista</label>
                     <input type="text" class="form-control" id="fuenteE" name="fuenteE" required>
                 </div>

                 <button type="submit"  class="btn btn-success">Guardar</button>
           </form>
        </div>
      </div>
   </div>
</div>

<div class="modal fade" id="actualizar_contenido" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Actualizar Contenido</h3>
         </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('listas/updateListasCompletas') ?>">
                <input type="text" name="idH" id="idH" hidden/>
                <input type="text" name="clave_tipoH" id="clave_tipoH" hidden/>
                <h4>Para actualizar el contenido de lista seleccione la acción a realizar</h4> <br>
                  <div class="iradio_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                        <input type="radio" name="tipo" value="conHistorico" class="icheck" required style="position: absolute; opacity: 0;">
                  </div> Eliminar de la lista principal y guardar en historico registros anteriores
                  <br><br>
                  <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                        <input type="radio" name="tipo" value="sinHistorico"class="icheck" required style="position: absolute; opacity: 0;">
                  </div> Solo insertar los nuevos registros sin eliminar anteriores ni guardar el historico
                  <br> <br>
                <button style="width: 110px;margin-left: 50%;transform: translateX(-50%);" type="submit"  class="btn btn-success" >Actualizar</button>
          </form>
         </div>
      </div>
   </div>
</div>


<script>

  function showNew() {
    $("#newlist").modal("show");
  }

   $(document).on("click", ".open-Modal", function () {
      var myID = $(this).data('id');
      var clave_tipo = $(this).data('t');
      var clave_pertenece = $(this).data('p');
      var nombre = $(this).data('n');
      var fuente = $(this).data('f');

      $(".modal-body #id").val( myID );
      $(".modal-body #idE").val( myID );
      $(".modal-body #clave_tipoE").val( clave_tipo );
      $(".modal-body #clave_perteneceE").val( clave_pertenece );
      $(".modal-body #fuenteE").val( fuente );
      $(".modal-body #nombreE").val( nombre );
      $(".modal-body #clave_tipoH").val( clave_pertenece );
      $(".modal-body #idH").val( myID );

   });

</script>
