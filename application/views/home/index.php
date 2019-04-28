<!-- Begin page content -->
<main role="main" class="flex-shrink-0">

	<div class="container-fluid">

		<div class="container">
			<div class="row align-items-center text-center text-md-left" style="height:100vh;">

				<div class="col-12 col-md-10">
					<div class="row d-md-none justify-content-center" style="margin-top:65%;">
						<h1>Get work <span class="font-weight-800 font-primary">done</span>,<br>or get
							<span class="font-weight-800 font-primary">hired</span>!</h1>
					</div>
					<div class="row d-none d-md-block">
						<h1>Get work <span class="font-weight-800 font-primary">done</span>,<br>or get
							<span class="font-weight-800 font-primary">hired</span>!</h1>
					</div>
					<div class="row">
						<p class="col-12 col-md-10 p-0">
							Need job done? Whatever your needs, there will be an agent ready to get it done for you,
							starting from web design, mobile app development, and whole lot more. Simply find someone
							that you think fit for the jobs and hire them to work it out.
						</p>
					</div>
					<div class="row justify-content-md-start justify-content-center">
						<a href="<?= base_url('auth/') ?>" class="btn btn-primary-custom" role="button"
							style="width:8rem;">Start</a>
					</div>
				</div>

				<div class="col text-right pr-0 pb-0 d-none d-md-block"
					style="position:absolute; bottom:0; right:0; width:30%; height: 100%; z-index:-99;">
					<img src="<?= base_url('assets/img/background/'); ?>bg-01.svg" alt="process" class="img-fluid"
						style="height: 100%;">
				</div>

			</div>
		</div>

	</div>

	<div class="container section-container">
		<div class="row text-center mb-4 pt-5 pt-md-0">
			<div class="col pt-5 pt-md-0">
				<h1>How We Works</h1>
				<hr class="bg-gray-400">
				<div class="row">
					<div class="col-12 col-md-3 m-auto">
						<img src="<?= base_url('assets/img/illustration/'); ?>orange/hireOrange.svg" alt="hire"
							class="img-fluid" style="height:13rem;">
						<h5>Hire</h5>
						<p>Browse our collection of agents and hire to do your work.</p>
					</div>
					<div class="col-12 col-md-3 m-auto">
						<img src="<?= base_url('assets/img/illustration/'); ?>orange/meetOrange.svg" alt="hire"
							class="img-fluid" style="height:13rem;">
						<h5>Meet</h5>
						<p>Meet and give them a brief about the project you want to work on.</p>
					</div>
					<div class="col-12 col-md-3 m-auto">
						<img src="<?= base_url('assets/img/illustration/'); ?>orange/doneOrange.svg" alt="hire"
							class="img-fluid" style="height:13rem;">
						<h5>Done</h5>
						<p>Sit back and relax. Your job being worked by your picked agent.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">

		<div class="row text-center mb-4">
			<div class="col">
				<h1>Best Agents</h1>
				<hr class="bg-gray-400">
				<p>Take a look at our top picked agent.</p>
			</div>
		</div>

		<div class="row">
			<?php
        for($i=0;$i<3;$i++){
            echo '
            <div class="card o-hidden shadow-sm mx-auto my-3 profile-card" style="width: 18rem;">
                <div class="card-header"></div>
                <div class="text-center">
                    <img src="'. base_url('assets/img/profile/') .'default.svg" class="card-img-top rounded-circle w-50"
                        alt="profile_pict">
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <h5 class="text-center font-weight-600 mb-4">Pablo <strong>Suherman</strong></h5>
                        <div>
                            Website
                            <div class="progress mb-2">
                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 85%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div>
                            Android
                            <div class="progress mb-2">
                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 65%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div>
                            iOS
                            <div class="progress mb-2">
                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 45%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                    </p>
                    <div class="text-center mt-4"><a href="#" class="btn btn-primary-custom px-4">Contact</a></div>
                </div>
            </div>';
        }
        ?>
		</div>


	</div>

</main>
