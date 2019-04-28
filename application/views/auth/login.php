<div class="container">

	<!-- Outer Row -->
	<div class="row justify-content-center">

		<div class="col-12 col-md-6">

			<div class="text-center my-4">
				<a href="<?= base_url(); ?>">
					<img src="<?= base_url('assets/img/logo/'); ?>logo-wide.svg" width="50%"
						class="d-inline-block align-middle" alt="">
				</a>
			</div>

			<div class="card o-hidden border-0 shadow-lg my-5 font-light">
				<div class="card-header bg-gradient-primary"></div>
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">

						<div class="col">
							<div class="py-5 px-4">

								<div class="text-center">
									<h1 class="mb-4">Welcome Back!</h1>
								</div>

								<?= $this->session->flashdata('message'); ?>

								<form class="user" method="post" action="<?= base_url('auth'); ?>">
									<div class="form-group">
										<input name="email" type="text" class="form-control form-control-user"
											id="email" placeholder="Email Address"
											value="<?= set_value('email'); //Set value if exist ?>">
										<?php //Shows error message if any ?>
										<?= form_error('email', '<small class="text-danger font-weight-600 pl-3">* ', '</small>'); ?>
									</div>
									<div class="form-group">
										<input name="password" type="password" class="form-control form-control-user"
											id="password" placeholder="Password">
										<?php //Shows error message if any ?>
										<?= form_error('password', '<small class="text-danger font-weight-600 pl-3">* ', '</small>'); ?>
									</div>

									<?php
										// <div class="form-group">
										// 	<div class="custom-control custom-checkbox small">
										// 		<input type="checkbox" class="custom-control-input" id="customCheck">
										// 		<label class="custom-control-label" for="customCheck">Remember
										// 			Me</label>
										// 	</div>
										// </div>
									?>

									<div class="col">
										<button type="submit" class="btn btn-primary btn-user btn-block w-25 mx-auto">
											Login
										</button>
									</div>

									<?php
										// <hr>
										// <a href="index.html" class="btn btn-google btn-user btn-block">
										// 	<i class="fab fa-google fa-fw"></i> Login with Google
										// </a>
										// <a href="index.html" class="btn btn-facebook btn-user btn-block">
										// 	<i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
										// </a>
									?>

								</form>
								<hr class="bg-gray-400">
								<div class="text-center">
									<a class="small font-weight-600" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
								</div>
								<div class="text-center">
									<a class="small font-weight-600" href="<?= base_url('auth/registration'); ?>">Create an Account!</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer bg-gradient-primary"></div>
			</div>

		</div>

	</div>

</div>