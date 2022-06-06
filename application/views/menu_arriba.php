<div id="head-nav" class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="fa fa-gear"></span> </button>
			<!-- <a class="navbar-brand" href="#">&nbsp;&nbsp;</a> -->
			<!-- <h3 style="color: #fff; margin: 15px">ProListas</h3> -->
			<a href="#">
				<img width="120" src="<?= base_url('assets/img/logo.png')?>">
				<?= $usuario=$this->session->userdata('empresa'); ?>
			</a>

				<?= $usuario=$this->session->userdata('empresa'); ?>

		</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right user-nav">

					<li class="dropdown profile_menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $usuario=$this->session->userdata('name'); ?>  <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href='<?=base_url('usuarios/verPerfil');?>'>Perfil</a></li>
							<li><a href='<?=base_url('fuentes/terminos');?>'>Terminos y condiciones</a></li>
								
							<?php $roll=$this->session->userdata('roll');
											$entidad=$this->session->userdata('entidad');
								if($roll=='2' && $entidad=='1500' ){
									?>
									<li><a href="<?=base_url('usuarios/mostrar_usuarios');?>">Usuarios</a></li>
							<?php }?>
							<li><a href="<?=base_url('login/cerrarlogin');?>">Salir</a></li>
						</ul>
					</li>
				</ul>
		</div>
		<!--/.nav-collapse -->
	</div>
</div>
</div>
