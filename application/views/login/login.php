<body class="texture">
	<div id="cl-wrapper" class="login-container">
		<div class="aviso">


	</div>
	<div class="middle-login">

		<div class="block-flat">
			<div class="header">
				<h3 class="text-center"> 
					<img  src="<?= base_url('assets/img/logo.png')?>" width="120"  alt="logo" class="logo-img" align="center" >
				</h3>

			</div>
			<div>
				<form id="formulario_login" method="post" action="<?= base_url('login/get_login') ?>" >

					<div class="content" style="margin-bottom: 0px !important;">
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input id="user_name" name='user_name' type="email" placeholder="Usuario" class="form-control" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
							<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input id="password" name="password" type="password" placeholder="Password" class="form-control" required>
									<span class="input-group-addon"><i class="fa fa-eye" aria-hidden="true" id="show-pass"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="foot">
						<button data-dismiss="modal" type="submit" class="btn btn-primary">Iniciar sesión</button>
					</div>
				</form>
				<div style="color:#FF0000; text-align: center; font-weight: bold;"><?php echo $this->session->flashdata('message');?></div>
			</div>
			<br>
		</div>
		<div class="text-center out-links"><a href="http://www.ubcubo.com/" target="_blank">© <?= date("Y") ?> &nbsp; <img src="<?=base_url('assets/img/logo_ubcubo.png')?>" alt="logo-ubcubo"> UBCubo</a></div>
	</div>
</div>
</body>
