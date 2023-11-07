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
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="block-flat">
                        <div class="header">
                            <h2>Concentrado de Clientes en Moffin</h2>
                        </div>
                        <div class="content">
                            <div class="table-responsive">
                                <table  data-order='[[ 2, "asc" ]]'  class="no-border blue " id="customers_table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>					
                                            <th>Tipo</th>
                                            <th>RFC</th>
                                            <th>CURP</th>
                                            <th>Email</th>
                                            <th style="width: 80px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($customers as $c): ?>
                                        <?php $id = $c['id'] ?>    
                                        <tr>
                                            <td><?php echo $c['name'] ?></td>
                                            <td><?php echo $c['accountType'] ?></td>
                                            <td><?php echo $c['rfc'] ?></td>
                                            <td><?php echo $c['curp'] ?></td>
                                            <td><?php echo $c['email'] ?></td>
                                            <td><a href="<?php echo base_url('muffin/profile_cliente_muffin/'.$id)?>"><i class="fas fa-folder-open"></i></a></td>
                                        </tr>    

                                        <?php endforeach; ?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

