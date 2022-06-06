<div id="cl-wrapper">
	<div class="cl-sidebar">
		<!-- Sidebar Menu -->
		<?php $this->load->view('menu_left');?>
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
							<h2>Bitacora de Movimientos de: <?= $usuario=$this->session->userdata('empresa'); ?></h2>
						</div>
						<div class="content">
              <div class="table-responsive">
								<table  data-order='[[ 2, "asc" ]]'  class="no-border blue" id="list_blocked">
									<thead>
										<tr>
											<th>#</th>
                      <th>Nombre de Usuario</th>
                      <th>Ip</th>
                      <th>Fecha</th>
                      <th>Seccion</th>
                      <th>Accion</th>
                      <th>Detalles</th>
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

$(document).ready(function(){

	var langTabl = '//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json';
 var buttons = {"buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5']};

	 $('#list_blocked').dataTable({
			 "language": { "url": langTabl },
	 "lengthMenu": [[25,50, 100, ''], [25,50, 100, "Todos"]],
	 "dom": '<"top"B><"clear">lf<"bottom"Trtip>', buttons,
					"processing": true,
					"serverSide": true,
					"ajax":{
					 "url": "<?php echo base_url('bitacora/get_bitacora') ?>",
			 "dataType": "json",
			 "type": "POST",
			 "data":{ '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
		 },
		 "columns": [
			 		{ "data": "id" },
					{ "data": "usuario" },
					{ "data": "ip" },
					{ "data": "date" },
					{ "data": "seccion" },
					{ "data": "accion" },
					{ "data": "detalles" },

				 ]
	 });
	});
</script>
