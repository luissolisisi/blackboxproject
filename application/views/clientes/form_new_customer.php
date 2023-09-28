<div id="cl-wrapper">
    <div class="cl-sidebar">
        <!-- Sidebar Menu -->
        <?php $this->load->view('menu_left'); ?>
    </div>

    <div class="container-fluid" id="pcont">
        <div class="cl-mcont">
            <div class="block-flat">
                <div class="header">
                    <h2>Alta de clientes</h2>
                </div>
            </div>
            
            <div class="row wizard-row">
                <form id="insertCustomer" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="" class="form-horizontal group-border-dashed">
                <div class="col-md-12 fuelux">
                    <div class="block-wizard">
                        <div id="wizard1" class="wizard wizard-ux">
                            <ul class="steps">
                                <li data-step="1" class="active">Paso 1<span class="chevron"></span></li>
                                <li data-step="2">Paso 2<span class="chevron"></span></li>
                                <li data-step="3">Paso 3<span class="chevron"></span></li>
                            </ul>
                            <div class="actions">
                                <button type="button" class="btn btn-xs btn-prev btn-default"><i class="fa fa-chevron-left"></i>Atras</button>
                                <button type="button" data-last="Finish" class="btn btn-xs btn-next btn-default">Sig<i class="fa fa-chevron-right"></i></button>
                            </div>
                            <div class="step-content">
                                <div data-step="1" class="step-pane active">
                                    
                                        <div class="form-group no-padding">
                                            <div class="col-sm-7">
                                                <h3 class="hthin">Información personal</h3>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nombre <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Apellido paterno <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="apaterno" id="apaterno" placeholder="Apellido paterno" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Apellido materno <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="amaterno" id="amaterno" placeholder="Apellido materno" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tipo persona <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <select class="form-control" id="tipo_persona" name="tipo_persona">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php foreach ($cat_personas as $cat_p): ?>
                                                    <option value="<?php echo $cat_p->id ?>"><?php echo $cat_p->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">RFC <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="rfc" id="rfc" placeholder="RFC" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">CURP <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="curp" id="curp" placeholder="CURP" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Edad <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" name="age" id="age" placeholder="Edad" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Municipio <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="municipio" id="municipio" placeholder="CURP" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Estado <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="estado" id="estado" placeholder="CURP" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Fuente de ingresos <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="fuente_ingresos" id="fuente_ingresos" placeholder="CURP" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button class="btn btn-default">Cancel</button>
                                                <button data-wizard="#wizard1" class="btn btn-primary wizard-next">Siguiente <i class="fa fa-caret-right"></i></button>
                                            </div>
                                        </div>
                                    
                                </div>
                                <div data-step="2" class="step-pane">
                                    
                                        <div class="form-group no-padding">
                                            <div class="col-sm-7">
                                                <h3 class="hthin">Reglas KO</h3>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">BCScore <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" name="bcs_score" id="bcs_score" placeholder="BCScore" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">FICO Score <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" name="fico_score" id="fico_score" placeholder="FICO Score" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Consultas de últimos 12 meses <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" name="ultimas_consultas" id="ultimas_consultas" placeholder="Consultas de los últimos 12 meses" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">%MOP4 Saldo y totales <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" name="mop4_saldos_totales" id="mop4_saldos_totales" placeholder="%MOP4 Saldo y totales" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">MOP9 Financieras <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" name="mop9_financieras" id="mop9_financieras" placeholder="MOP9 Financieras" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Demandas <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input checked="" data-size="small" name="demandas" id="demandas" type="checkbox" class="switch">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">PLD (100% coincidencia) <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input checked="" data-size="small" name="pld" id="pld" type="checkbox" class="switch">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button data-wizard="#wizard1" class="btn btn-default wizard-previous"><i class="fa fa-caret-left"></i> Previous</button>
                                                <button data-wizard="#wizard1" class="btn btn-primary wizard-next">Siguiente <i class="fa fa-caret-right"></i></button>
                                            </div>
                                        </div>
                                    
                                </div>
                                <div data-step="3" class="step-pane">
                                    
                                        <div class="form-group no-padding">
                                            <div class="col-sm-7">
                                                <h3 class="hthin">Matriz de perfilamiento</h3>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Producto <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <select class="form-control" id="clave_producto" name="clave_producto">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php foreach ($cat_productos as $cat_pro): ?>
                                                    <option value="<?php echo $cat_pro->clave ?>"><?php echo $cat_pro->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Monto solicitado <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="monto_solicitado" id="monto_solicitado" placeholder="Monto solicitado" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Plazos a meses <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" name="plazos" id="plazos" placeholder="Plazo a meses" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Plazos promedio a meses <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" name="plazo_promedio" id="plazo_promedio" placeholder="Plazos promedio a meses" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Monto promedio <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="monto_promedio" id="monto_promedio" placeholder="Monto promedio" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Creditos promedio por mes <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" name="credito_promedio" id="credito_promedio" placeholder="Creditos promedio por mes" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Destino del crédito <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="destino_credito" id="destino_credito" placeholder="Destino del credito" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button data-wizard="#wizard1" class="btn btn-default wizard-previous"><i class="fa fa-caret-left"></i> Previous</button>
                                                <button type="submit" class="btn btn-success "><i class="fa fa-check"></i> Complete</button>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
      $(document).ready(function(){
      	//initialize the javascript
      	
      	App.wizard();
        
        $('#monto_solicitado,#monto_promedio').number(true, 2);
        
        $("#insertCustomer").submit(function (event) {
        event.preventDefault();
        
        //var str = window.location.href;

        var formulario = $("#insertCustomer").serialize();
        $.ajax({
            type: "post",
            url: "<?php  echo base_url('clientes/insert_customer') ?>",
            data: formulario,
            success: function (data)
            {
                
                switch (data.status) {
                        case 200:
                            
                            alert('Registro guardado correctamente');
                            window.location.href = "<?php echo base_url('customers/get_customers_all') ?>";

                        case 500:
                            alert('No se pudo guardar el registro');
                            location.reload();
                            break;
                        
                        default:
                            break;
                    }
                
                
                
            }
        });
    });
      });
      
    
    
    




    </script>
