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
                            <h2 class="text-shadow text-primary">Usuarios de: <?= $usuario=$this->session->userdata('empresa'); ?>
                            </h2>
                        </div>
                        <div class="content">
                          <button onclick="showNew()" class="btn btn-primary">Nuevo Usuario</button>

                            <div class="table-responsive">
                                <table  data-order='[[ 2, "desc" ]]' class="table table-bordered" id="datatable-expedientes">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Roll</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuarios as $usuario): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $usuario['id']; ?></td>
                                            <td><?php echo $usuario['name']." ".$usuario['lastname']; ?></td>
                                            <td><?php echo $usuario['email']; ?></td>
                                            <td><?php echo $usuario['status']; ?></td>
                                            <td>
                                              <?php
                                                switch ($usuario['roll']) {
                                                  case '1':
                                                    echo "Super Usuario";
                                                  break;
                                                  case '2':
                                                      echo "Administrador";
                                                  break;
                                                  case '3':
                                                    echo "Operativo";
                                                  break;
                                                }
                                              ?>
                                            </td>
                                            <td class="center">
                                              <a data-toggle="modal" data-id="<?php echo $usuario['id']; ?>" data-n="<?php echo $usuario['name']; ?>" data-l="<?php echo $usuario['lastname']; ?>" data-m="<?php echo $usuario['email'];?>" class="open-Modal btn btn-primary" href="#edit_user"><i class="fas fa-pencil-alt"></i></a>
                                              <a data-toggle="modal" data-id="<?php echo $usuario['id']; ?>" class="open-Modal btn btn-primary" href="#delete_user"><i class="fas fa-trash-alt"></i></a>

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
<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Nuevo Usuario</h3>
     </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('usuarios/new_user') ?>">
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                </div>


                <div class="form-group">
                    <label>Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="text" class="form-control" id="pwd" name="pwd" required>
                </div>
                <div class="form-group">
                    <label>Roll</label> <div class="tooltip2"><i class="far fa-question-circle"></i>
                      <span class="tooltiptext2">
                        1. SuperUsuario -Control total en el sistema<br>
                        2. Administrador -Busquedas y dar de alta usuarios<br>
                        3. Operativo -Solo puede realizar busquedas
                      </span>
                    </div>
                    <select id="roll" name="roll" class="form-control" required>
                            <option value="-"> - </option>
                            <option value="1">SuperUsuario</option>
                            <option value="2">Administrador</option>
                            <option value="3">Operativo</option>
                    </select>
                </div>
                <button type="submit"  class="btn btn-success">Guardar</button>
          </form>
     </div>
      </div>
   </div>
</div>

<div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Eliminar Usuario</h3>
     </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('usuarios/delete_user') ?>">

                <input type="text" name="id" id="id" value="" hidden/>

                 <h4>¿Realmente desea elimiar a usuario? </h4> <br>

                <button type="submit"  class="btn btn-success" >Eliminar</button>
          </form>
     </div>
      </div>
   </div>
</div>

<div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Editar Usuario</h3>
     </div>
         <div class="modal-body">
          <form id="formNewUser" method="post" action="<?= base_url('usuarios/edit_user') ?>">
              <input type="text" name="idE" id="idE" value="" hidden/>
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" class="form-control" id="nombreE" name="nombreE" required>
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" id="apellidosE" name="apellidosE" required>
                </div>
                <div class="form-group">
                    <label>Correo Electronico</label>
                    <input type="email" class="form-control" id="emailE" name="emailE" required>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="text" class="form-control" id="pwdE" name="pwdE" required>
                </div>

                <button type="submit"  class="btn btn-success">Guardar</button>
          </form>
     </div>
      </div>
   </div>
</div>



<script>

  function showNew() {
    $("#newUser").modal("show");
   }

   $(document).on("click", ".open-Modal", function () {
      var myID = $(this).data('id');
      var name = $(this).data('n');
      var lastname = $(this).data('l');
      var email = $(this).data('m');
      $(".modal-body #id").val( myID );
      $(".modal-body #idE").val( myID );
      $(".modal-body #nombreE").val( name );
      $(".modal-body #apellidosE").val( lastname );
      $(".modal-body #emailE").val( email );


   });

</script>
