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
            $queryOngoing = "SELECT * FROM `createproject`
                                WHERE `status` = '0'
                              ";

            $ongoing = $this->db->query($queryOngoing)->result_array();
        ?>

            <!--looping ongoing project -->
            <?php foreach($ongoing as $op) : ?>
            <div class="card o-hidden shadow-sm mx-auto my-3 profile-card" style="width: 18rem;">
                <div class="card-header"></div>
                <div class="card-body">
                    <p class="card-text">
                        <h5 class="text-center font-weight-600 mb-4"><strong><?=$op['username']?></strong></h5>
                        <h6 class="text-center font-weight-600 mb-4"><strong><?=$op['email']?></strong></h6>
                        <div>
                            <?=$op['project_name']?>
                        </div>

                        <div>
                            <?=$op['description']?>
                        </div>
                        
                        <div>
                            <?=$op['field_category']?>
                        </div>

                        <div>
                            <?=$op['job_category']?>
                        </div>

                        <div>
                            <?=$op['times']?> Times
                        </div>

                        <div>
                            <?=$op['price']?> 
                        </div>

                    </p>
                    <div class="text-center mt-4">
                        <a href="<?= base_url('user/visitProfile/') . $op['user_id']; ?> " class="btn btn-primary-custom px-4">Contact</a>
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

