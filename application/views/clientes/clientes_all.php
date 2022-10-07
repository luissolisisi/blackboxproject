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
                            <h2>Concentrado de Clientes</h2>
                        </div>
                        <div class="content">
                            <div class="table-responsive">
                                <table  data-order='[[ 2, "asc" ]]'  class="no-border blue " id="customers_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>					
                                            <th>RFC</th>
                                            <th>Estado</th>
                                            <th>Estatus</th>
                                            <th>Estatus de reglas de KO</th>
                                            <th style="width: 80px;">Acciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#customers_table').DataTable({
            "language": {"url": langTabl},
            "lengthMenu": [[50, 100, ''], [50, 100, "Todos"]],
            "dom": '<"top"B><"clear">lf<"bottom"Trtip>',
            "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('clientes/clientes_all') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            "columns": [
                {"data": "orden"},
                {"data": "nombre"},
                {"data": "rfc"},
                {"data": "estado"},
                {"data": "estatus"},
                {"data": "reglas"},
                {"data": "id"},
                
            ]
        });
    });


</script>