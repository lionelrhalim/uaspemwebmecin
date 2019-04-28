<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="container">

		<div class="row">

        <!-- query my project -->
        <?php
            $email = $user['email'];
            $queryPast = "SELECT * FROM `createproject`
                                WHERE `status` = '1'
                              ";

            $past = $this->db->query($queryPast)->result_array();
        ?>

            <!--looping past project -->
            <?php foreach($past as $p) : ?>
            <div class="card o-hidden shadow-sm mx-auto my-3 profile-card" style="width: 18rem;">
                <div class="card-header"></div>
                <div class="card-body">
                    <p class="card-text">
                        <h5 class="text-center font-weight-600 mb-4"><strong><?=$p['username']?></strong></h5>
                        <h6 class="text-center font-weight-600 mb-4"><strong><?=$p['email']?></strong></h6>
                        <div>
                            <?=$p['project_name']?>
                        </div>

                        <div>
                            <?=$p['description']?>
                        </div>
                        
                        <div>
                            <?=$p['field_category']?>
                        </div>

                        <div>
                            <?=$p['job_category']?>
                        </div>

                        <div>
                            <?=$p['times']?> Times
                        </div>

                        <div>
                            <?=$p['price']?> 
                        </div>
                    </p>
                    <div class="text-center mt-4">
                        <form method="POST" action="<?= base_url('user/ongoing'); ?>">
                            <button type="submit" name="submitContact" class="btn btn-primary-custom px-4">Contact</button>
                        <form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
		</div>


	</div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

