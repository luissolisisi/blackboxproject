<div id="cl-wrapper">

	<div class="cl-sidebar">
		<!-- Sidebar Menu -->
		<?php $this->load->view('menu_left');?>
	</div>
	<div id="pcont" class="container-fluid">
		<div class="page-head">
			<h2>Países</h2>
		</div>

		<div class="cl-mcont">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="row">
						<div class="col-md-12">
							<div class="block-flat">
								<div class="content">

									<table id="datatable-paises" class="table no-border blue">
										<thead>
											<tr>
												<th>País</th>
												<th>Paraíso fiscal</th>
												<th>Con deficiencias</th>
												<th>No cooperante</th>

											</tr>
										</thead>
										<tbody>
											<?php foreach ($paises as $pais):?>
												<tr class="odd gradeX">
													<td><?= $pais->pais ?></td>
													<td align="center">
														<input type="checkbox" id="<?= $pais->id ?>" data-type="paradise" <?php if(isset($pais->paraiso)){ echo ($pais->paraiso == "1") ? "checked":""; } ?> >
														<?php if($pais->paraiso=='1'){?>
															<p style="color:#FCFCFC";>X</p>
														<?php }?>
													</td>
													<td align="center">
														<input type="checkbox" id="<?= $pais->id ?>" data-type="shortcomings" <?php if(isset($pais->deficiencia)){ echo ($pais->deficiencia == "1") ? "checked":""; } ?> >
															<?php if($pais->deficiencia=='1'){?>
																<p style="color:#FCFCFC";>X</p>
															<?php }?>
													</td>
													<td align="center">
														<input type="checkbox" id="<?= $pais->id ?>" data-type="not_cooperative" <?php if(isset($pais->no_cooperante)){ echo ($pais->no_cooperante == "1") ? "checked":""; } ?> >
															<?php if($pais->no_cooperante=='1'){?>
																<p style="color:#FCFCFC";>X</p>
															<?php }?>
													</td>

												</tr>
											<?php endforeach;?>
										</tbody>
									</table>

								</div>
							</div>
						</div>
					</div>

					<!-- Nifty Modal Movimientos -->
					<div id="form-primary-movimiento" class="md-modal colored-header-encabezado custom-width-productos md-effect-9">
						<form id="form-movimientos">
							<div class="md-content">
								<div class="modal-header">
									<button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close">×</button>
								</div>
								<div class="modal-body form" id="mb-movimiento">

								</div>
								<div class="modal-footer">
									<button type="button" data-dismiss="modal" class="btn btn-default btn-flat md-close">Cancelar</button>
									<button type="submit" data-dismiss="modal" class="btn btn-primary btn-flat md-close">Guardar</button>
								</div>
							</div>
						</div>
						<div class="md-overlay"></div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function() {
		$('.riesgo').on('change', function(e) {
			e.preventDefault();
			var id = $(this).attr('id');
			var risk = $(this).val();
			$.ajax({
				url: 'risk_paises',
				type: 'POST',
				dataType: 'json',
				data: {id: id, risk: risk},
			})
			.done(function(response) {
				if (response) {
					console.log('Riesgo');
				}
			})
			.fail(function() {
				console.log("error");
			})
		});
		$('input[type="checkbox"]').click(function() {
			var id = this.id;
			var type = $(this).data("type");

			if (this.checked) {
				$.ajax({
					url: 'paises_considerados',
					type: 'POST',
					dataType: 'json',
					data: {id: id, type: type, check: 1},
				})
				.done(function(response) {
					console.log("success");
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});

			}
			else
			{
				$.ajax({
					url: 'paises_considerados',
					type: 'POST',
					dataType: 'json',
					data: {id: id, type: type, check: 0},
				})
				.done(function(response) {
					console.log("success");
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}
		});
	});
</script>
