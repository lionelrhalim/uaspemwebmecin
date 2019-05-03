<div class="container">

	<div class="card o-hidden border-0 shadow-lg my-5 col-12 col-md-6 mx-auto">
		<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
			<div class="row">
				<div class="col">
					<div class="py-5 px-4">

						<div class="text-center">
							<h1 class="h4 text-gray-900 mb-4">Activate Developer Mode</h1>
							<h3 class="h3 text-gray-900 mb-4">Show us what you've got.</h3>
						</div>

						<form class="user" method="post" action="<?= base_url('user/form_completion_action'); ?>">

							<div class="form-group">
								<label for="field">What field(s) are you good at : </label><br>
								<select class="form-control" name="field" required>
									<?php echo $view_fields; ?>
								</select><br>
							</div>

							<div class="form-group">
								<label for="job">What job category are you interested in : </label><br>
								<select class="form-control" name="job" required>
									<?php echo $view_jobs; ?>
								</select><br>
							</div>

							<div class="form-group">
								<label for="skill">What skill(s) do you have : </label><br>
								<select class="form-control" name="skill" required>
									<?php echo $view_skill; ?>
								</select><br>
							</div>

							<button type="submit" class="btn btn-primary btn-user btn-block">
								Done
							</button>
						</form>
						<hr>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>