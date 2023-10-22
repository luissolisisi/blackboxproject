<div id="cl-wrapper">
    <div class="cl-sidebar">
        <!-- Sidebar Menu -->
        <?php $this->load->view('menu_left'); ?>
    </div>

    <div id="pcont" class="container-fluid">
        <div class="cl-mcont">
            <div class="row">
                <div class="col-sm-12">
                    <div class="block-flat profile-info">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="avatar"><img src="<?php echo base_url('assets/img/av.jpg') ?>" class="profile-avatar"></div>
                            </div>
                            <div class="col-sm-7">
                                <div class="personal">
                                    <h1 class="name"><?php echo $customer['firstName'] . ' ' . $customer['middleName'] . ' ' . $customer['firstLastName']. ' ' . $customer['secondLastName'] ?></h1>
                                    
                                    <p>
                                        <button data-modal="reply-ticket" class="btn btn-primary btn-flat btn-rad"><i class="fa fa-check"></i> Editar</button>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <table class="no-border no-strip skills">
                                    <tbody class="no-border-x no-border-y">
                                        <tr>
                                            <td style="width:45%;">Reglas KO</td>
                                            <td>
                                                <div class="progress">

                                                    
                                                </div>

                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="tab-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#infoCliente">Información</a></li>
                            <li><a data-toggle="tab" href="#matrizPerfilamiento">QUASH</a></li>
                            <!--li><a data-toggle="tab" href="#productRating">Calificación por producto</a></li-->
                            <!--li><a data-toggle="tab" href="#rulesKO">Reglas KO</a></li-->
                        </ul>
                        <div class="tab-content">
                            <div id="infoCliente" class="tab-pane active cont">
                                <table class="no-border no-strip information">
                                    <tbody class="no-border-x no-border-y">
                                        <tr>
                                            <td style="width:20%;" class="category"><strong>DATOS GENERALES</strong></td>
                                            <td>
                                                <table class="no-border no-strip skills">
                                                    <tbody class="no-border-x no-border-y">

                                                        <tr>
                                                            <td style="width:20%;"><b>Tipo de persona:</b></td>
                                                            <td><?php echo $customer['accountType'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>RFC:</b></td>
                                                            <td><?php echo $customer['rfc'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>CURP:</b></td>
                                                            <td><?php echo $customer['curp'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Nacionalidad:</b></td>
                                                            <td><?php echo $customer['nationality'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Fecha de nacimiento:</b></td>
                                                            <td><?php echo $customer['birthdate'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Email:</b></td>
                                                            <td><?php echo $customer['email'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Teléfono Movil:</b></td>
                                                            <td><?php echo $customer['phone'] ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="no-border no-strip information">
                                    <tbody class="no-border-x no-border-y">
                                        <tr>
                                            <td style="width:20%;" class="category"><strong>DOMICILIO</strong></td>
                                            <td>
                                                <table class="no-border no-strip skills">
                                                    <tbody class="no-border-x no-border-y">

                                                        <tr>
                                                            <td style="width:20%;"><b>Calle:</b></td>
                                                            <td><?php echo $customer['address'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Número exterior:</b></td>
                                                            <td><?php echo $customer['exteriorNumber'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Número interior:</b></td>
                                                            <td><?php echo $customer['interiorNumber'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Colonia:</b></td>
                                                            <td><?php echo $customer['neighborhood'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Municipio:</b></td>
                                                            <td><?php echo $customer['municipality'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>CP:</b></td>
                                                            <td><?php echo $customer['zipCode'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Pais:</b></td>
                                                            <td><?php echo $customer['country'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Estado:</b></td>
                                                            <td><?php echo $customer['state'] ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="matrizPerfilamiento" class="tab-pane cont">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="widget-title">Matriz de perfilamiento</h3>
                                        
                                    </div>
                                </div>
                            </div>
                            <div id="rulesKO" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="widget-title">Verificación de reglas de KO</h3>
                                        
                                    </div>
                                </div>
                            </div>
                            <div id="productRating" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="widget-title">Raiting</h3>
                                        
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<div class="md-overlay"></div>
