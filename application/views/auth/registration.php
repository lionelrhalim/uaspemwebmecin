<div class="container">

	<div class="card o-hidden border-0 shadow-lg my-5 col-12 col-md-6 mx-auto">
		<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
			<div class="row">
				<div class="col">
					<div class="py-5 px-4">

						<div class="text-center">
							<h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
						</div>

						<form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
							<div class="form-group">
								<input name="name" type="name" class="form-control form-control-user" id="name"
									placeholder="Fullname" value="<?= set_value('name') //Set value if exist ?>">
								<?php //Shows error message if any ?>
								<?= form_error('name', '<small class="text-danger pl-3">* ', '</small>'); ?>
							</div>

							<div class="form-group">
								<input name="email" type="name" class="form-control form-control-user" id="email"
									placeholder="Email Address" value="<?= set_value('email') //Set value if exist ?>">
								<?php //Shows error message if any ?>
								<?= form_error('email', '<small class="text-danger pl-3">* ', '</small>'); ?>
							</div>

							<div class="form-group">
								<input name="password1" type="password" class="form-control form-control-user"
									id="password1" placeholder="Password">
							</div>

							<div class="form-group">
								<input name="password2" type="password" class="form-control form-control-user"
									id="password2" placeholder="Repeat Password">
								<?php //Shows error message if any ?>
								<?= form_error('password1', '<small class="text-danger pl-3">* ', '</small>'); ?>
							</div>

							<button type="submit" class="btn btn-primary btn-user btn-block">
								Register Account
							</button>
							<?php
								// <hr>
								// <a href="index.html" class="btn btn-google btn-user btn-block">
								// 	<i class="fab fa-google fa-fw"></i> Register with Google
								// </a>
								// <a href="index.html" class="btn btn-facebook btn-user btn-block">
								// 	<i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
								// </a>
							?>
						</form>

						<hr>

						<div class="text-center">
							<a class="small" href="forgot-password.html">Forgot Password?</a>
						</div>
						<div class="text-center">
							<a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login!</a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>