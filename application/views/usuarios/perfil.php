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
                            <h2 class="text-shadow text-primary">Mi Perfil
                            </h2>
                        </div>
                        <div class="content">
                          <div data-step="1" class="step-pane active">
                            	<div style="color:#FF0000; text-align: center; font-weight: bold;"><?php echo $this->session->flashdata('message');?></div>
                            <form action="<?= base_url('usuarios/changePwd') ?>" method="post" class="form-horizontal group-border-dashed">
                              <input id="id" name="id" type="text" class="form-control" value="<?php echo $id;?>"/>
                              <div class="form-group" >
                                <label class="col-sm-3 control-label">Nombre(s)</label>
                                <div class="col-sm-6">
                                  <input id="nombre" type="text" class="form-control" value="<?php echo $name;?>" disabled=true>
                                </div>
                              </div>
                              <div class="form-group" >
                                <label class="col-sm-3 control-label">Apellidos</label>
                                <div class="col-sm-6">
                                  <input id="apellidos" type="text"  value="<?php echo $lastname;?>" class="form-control"  disabled=true>
                                </div>
                              </div>
                              <div class="form-group" >
                                <label class="col-sm-3 control-label">E-Mail</label>
                                <div class="col-sm-6">
                                  <input id="email" type="text"  value="<?php echo $email;?>" class="form-control"  disabled=true>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Roll</label>
                                <div class="col-sm-6">
                                  <input  type="text"  value="<?php echo $roll;?>" class="form-control" disabled=true>
                                </div>
                              </div>

                              <div class="form-group" id="pN">
                                <label class="col-sm-3 control-label">Nueva Contraseña</label>
                                <div class="col-sm-6">
                                  <input name="pN" type="password" placeholder="Ingrese Contraseña" class="form-control">
                                </div>
                              </div>
                              <div class="form-group" id="pNC" >
                                <label class="col-sm-3 control-label">Verificar Contraseña</label>
                                <div class="col-sm-6">
                                  <input name="pNV" type="password" placeholder="Ingrese Contraseña denuevo" class="form-control">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                  <button class="btn btn-default"><a href="<?=base_url('listas/busqueda');?>">Volver</a></button>
                                  <button  type="submit"  class="btn btn-primary wizard-next" >Guardar</button>
                                </div>
                              </div>
                            </form>
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

<script >
$(document).ready(function() {
   $('#id').hide();
});


</script>
