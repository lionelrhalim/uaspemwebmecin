<div class="container" style="margin-top:100px;">

	<div class="card o-hidden border-0 shadow-lg my-5 col-12 col-md-6 mx-auto">
		<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
			<div class="row">
				<div class="col">
					<div class="py-5 px-4">

						<div class="text-center">
							<h1 class="h4 text-gray-900 mb-4">Developer Profile</h1>
							<h3 class="h5 text-gray-900 mb-4">Show us what you've got.</h3>
						</div>

						<form method="post" action="<?= base_url('user/edit_developer_profile'); ?>">

							<div class="form-group">
							<input type="text" class="form-control form-control-user" id="tagline" name="tagline" placeholder="Write your headline" value="<?= $tagline; ?>">
								<?php //Shows error message if any ?>
								<?= form_error('tagline', '<small class="text-danger pl-3">* ', '</small>'); ?>
							</div>

							<div class="form-group">
								<label for="field">What field(s) are you good at : </label><br>
									<?php echo $view_fields; ?>
								</select><br>
							</div>

							<div class="form-group">
								<label for="job">What job category are you interested in : </label><br>
									<?php echo $view_jobs; ?>
								</select><br>
							</div>

							<div class="form-group">
								<label for="skill">What skill(s) do you have : </label><br>
									<?php echo $view_skill; ?>
								<br>
							</div>

							<div class="form-group">
							<input type="number" class="form-control form-control-user" id="fee" name="fee" placeholder="Enter your starting bid" value="<?= $fee; ?>">
								<?php //Shows error message if any ?>
								<?= form_error('fee', '<small class="text-danger pl-3">* ', '</small>'); ?>
							</div>

							<button type="submit" class="btn btn-primary btn-user btn-block">
								Done
							</button>
							<a class="btn btn-outline-danger btn-user btn-block" name="btnCancel" href="<?php echo base_url('user/profile?id='.$user['id']) ?>" role="button">Cancel</a> 
						</form>
						<hr>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>