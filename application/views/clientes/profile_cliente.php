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
                                    <h1 class="name"><?php echo $customer[0]['nombre'] . ' ' . $customer[0]['apaterno'] . ' ' . $customer[0]['amaterno'] ?></h1>
                                    <p class="description"><?php echo $customer[0]['status'] ?></p>
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

                                                    <div style="width: 100%" class="progress-bar progress-bar-<?php echo ((int) $customer[0]['status_rules'] == 1) ? 'success' : 'danger' ?>"></div>
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
                            <li><a data-toggle="tab" href="#matrizPerfilamiento">Matriz pérfilamiento</a></li>
                            <li><a data-toggle="tab" href="#productRating">Calificación por producto</a></li>
                            <!--li><a data-toggle="tab" href="#rulesKO">Reglas KO</a></li-->
                        </ul>
                        <div class="tab-content">
                            <div id="infoCliente" class="tab-pane active cont">
                                <table class="no-border no-strip information">
                                    <tbody class="no-border-x no-border-y">
                                        <tr>
                                            <td style="width:20%;" class="category"><strong>DATOS</strong></td>
                                            <td>
                                                <table class="no-border no-strip skills">
                                                    <tbody class="no-border-x no-border-y">

                                                        <tr>
                                                            <td style="width:20%;"><b>Tipo de persona:</b></td>
                                                            <td><?php echo $customer[0]['tipo_persona'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>RFC:</b></td>
                                                            <td><?php echo $customer[0]['rfc'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>CURP:</b></td>
                                                            <td><?php echo $customer[0]['curp'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Edad:</b></td>
                                                            <td><?php echo $customer[0]['age'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Municipio:</b></td>
                                                            <td><?php echo $customer[0]['municipio'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Estado:</b></td>
                                                            <td><?php echo $customer[0]['estado'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:20%;"><b>Fuente de ingresos:</b></td>
                                                            <td><?php echo $customer[0]['fuente_ingresos'] ?></td>
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
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th><strong>Criterio</strong></th>
                                                    <th><strong>Valor</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Monto solicitado</td>
                                                    <td><?php echo $customer[0]['matrizPerfilamiento']->monto_solicitado ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Plazo</td>
                                                    <td><?php echo $customer[0]['matrizPerfilamiento']->plazos ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Plazo promedio</td>
                                                    <td><?php echo $customer[0]['matrizPerfilamiento']->plazo_promedio ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Monto promedio</td>
                                                    <td><?php echo $customer[0]['matrizPerfilamiento']->monto_promedio ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Créditos promedio</td>
                                                    <td><?php echo $customer[0]['matrizPerfilamiento']->credito_promedio ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Destino del crédito</td>
                                                    <td><?php echo $customer[0]['matrizPerfilamiento']->destino_credito ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="rulesKO" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="widget-title">Verificación de reglas de KO</h3>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Criterio</th>
                                                    <th>Regla</th>
                                                    <th>Valor</th>
                                                    <th>Cumple</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($customer[0]['rulesOk'] as $reglas): ?>
                                                    <tr>
                                                        <td><?php echo $reglas['criterio'] ?></td>
                                                        <td><?php echo $reglas['rule'] ?></td>
                                                        <td><?php echo $reglas['valor'] ?></td>
                                                        <?php if ((int) $reglas['caumple'] == 1): ?>
                                                            <td><span class="label label-success"><i class="fa fa-check"></i></span></td>
                                                        <?php else: ?>
                                                            <td><span class="label label-danger"><i class="fas fa-times"></i></span></td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="productRating" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="widget-title">Raiting</h3>
                                        <div id="accordion4" class="panel-group accordion accordion-semi">
                                            <div class="panel panel-default">
                                                <div class="panel-heading success">
                                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#p-1" class="collapsed"><i class="fa fa-angle-right"></i> Si cuento - pensionados<i class=" fa fa-check-circle " style="float:right "></i></a></h4>
                                                </div>
                                                <div id="p-1" class="panel-collapse collapse ">
                                                    <div class="panel-body">
                                                        <table class="no-border">
                                                            <thead class="no-border">
                                                                <tr>
                                                                    <th style="width:50%;">Criterio</th>
                                                                    <th>Valor</th>
                                                                    <th class="text-right">Aprobación</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="no-border-x">
                                                                <tr>
                                                                    <td>Edad</td>
                                                                    <td>35</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasMop99</td>
                                                                    <td>Si</td>
                                                                    <td class="text-right"><i class="fa fa-times"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasCV</td>
                                                                    <td>No</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading success">
                                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#p-2" class="collapsed"><i class="fa fa-angle-right"></i> Si cuento a la medida<i class=" fa fa-check-circle " style="float:right "></i></a></h4>
                                                </div>
                                                <div id="p-2" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <table class="no-border">
                                                            <thead class="no-border">
                                                                <tr>
                                                                    <th style="width:50%;">Criterio</th>
                                                                    <th>Valor</th>
                                                                    <th class="text-right">Aprobación</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="no-border-x">
                                                                <tr>
                                                                    <td>Edad</td>
                                                                    <td>35</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasMop99</td>
                                                                    <td>Si</td>
                                                                    <td class="text-right"><i class="fa fa-times"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasCV</td>
                                                                    <td>No</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading danger">
                                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#p-3" class="collapsed"><i class="fa fa-angle-right"></i> Si cuento - express<i class="fa fa-times-circle " style="float:right "></i></a></h4>
                                                </div>
                                                <div id="p-3" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <table class="no-border">
                                                            <thead class="no-border">
                                                                <tr>
                                                                    <th style="width:50%;">Criterio</th>
                                                                    <th>Valor</th>
                                                                    <th class="text-right">Aprobación</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="no-border-x">
                                                                <tr>
                                                                    <td>Edad</td>
                                                                    <td>35</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasMop99</td>
                                                                    <td>Si</td>
                                                                    <td class="text-right"><i class="fa fa-times"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasCV</td>
                                                                    <td>No</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading success">
                                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#p-4" class="collapsed"><i class="fa fa-angle-right"></i> Si cuento - consolida plus<i class=" fa fa-check-circle " style="float:right "></i></a></h4>
                                                </div>
                                                <div id="p-4" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <table class="no-border">
                                                            <thead class="no-border">
                                                                <tr>
                                                                    <th style="width:50%;">Criterio</th>
                                                                    <th>Valor</th>
                                                                    <th class="text-right">Aprobación</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="no-border-x">
                                                                <tr>
                                                                    <td>Edad</td>
                                                                    <td>35</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasMop99</td>
                                                                    <td>Si</td>
                                                                    <td class="text-right"><i class="fa fa-times"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasCV</td>
                                                                    <td>No</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading danger">
                                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#p-5" class="collapsed"><i class="fa fa-angle-right"></i> Si cuento - consolida<i class="fa fa-times-circle " style="float:right "></i></a></h4>
                                                </div>
                                                <div id="p-5" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <table class="no-border">
                                                            <thead class="no-border">
                                                                <tr>
                                                                    <th style="width:50%;">Criterio</th>
                                                                    <th>Valor</th>
                                                                    <th class="text-right">Aprobación</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="no-border-x">
                                                                <tr>
                                                                    <td>Edad</td>
                                                                    <td>35</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasMop99</td>
                                                                    <td>Si</td>
                                                                    <td class="text-right"><i class="fa fa-times"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasCV</td>
                                                                    <td>No</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading success">
                                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#p-6" class="collapsed"><i class="fa fa-angle-right"></i> Si cuento - crecimiento<i class=" fa fa-check-circle " style="float:right "></i></a></h4>
                                                </div>
                                                <div id="p-6" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <table class="no-border">
                                                            <thead class="no-border">
                                                                <tr>
                                                                    <th style="width:50%;">Criterio</th>
                                                                    <th>Valor</th>
                                                                    <th class="text-right">Aprobación</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="no-border-x">
                                                                <tr>
                                                                    <td>Edad</td>
                                                                    <td>35</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasMop99</td>
                                                                    <td>Si</td>
                                                                    <td class="text-right"><i class="fa fa-times"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>hasCV</td>
                                                                    <td>No</td>
                                                                    <td class="text-right"><i class="fa fa-check"></i></td>
                                                                </tr>
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
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<div class="md-overlay"></div>
