<div class="container">

	<div class="card o-hidden border-0 shadow-lg my-5 col-12 col-md-6 mx-auto">
		<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
			<div class="row">
				<div class="col">
					<div class="py-5 px-4">

						<div class="text-center">
							<h1 class="h4 text-gray-900 mb-4">Activate Developer Mode</h1>
							<h3 class="h5 text-gray-900 mb-4">Show us what you've got.</h3>
						</div>

						<form class="user" method="post" action="<?= base_url('user/activate_developer_action'); ?>">

							<div class="form-group">
							<input type="text" class="form-control form-control-user" id="tagline" name="tagline" placeholder="Write your Tagline" value="<?= set_value('tagline'); ?>">
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
							<input type="number" class="form-control form-control-user" id="fee" name="fee" placeholder="How much you want to be paid" value="<?= set_value('fee'); ?>">
								<?php //Shows error message if any ?>
								<?= form_error('fee', '<small class="text-danger pl-3">* ', '</small>'); ?>
							</div>

							<button type="submit" class="btn btn-primary btn-user btn-block">
								Done
							</button>
							<!-- disini harusnya kalo cancel balik ke profile lagi -->
							<a class="btn btn-outline-light btn-user btn-block" type="button" name="btnCancel" href="<?php echo base_url('user') ?>">Cancel</a> 
						</form>
						<hr>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>