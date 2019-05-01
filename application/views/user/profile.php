<?php ## BEGIN PAGE CONTENT ?>
<div class="container-fluid">

    <?php ## FLASH MESSAGE ## ?>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>



    <?php ## FIRST ROW ## ?>
    <!-- <div class="row mb-4">
            <div class="col-12">
                <?php ## Page Heading ## ?>
                <h1 class="mb-4 font-heading-primary">Your Profile</h1>
            </div>
        </div> -->



    <?php ## SECOND ROW ## ?>
    <div class="row my-4">

        <?php ## Profile Info Card ## ?>
        <div class="card shadow-sm mb-3 col-lg-4 mx-auto">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <div class="card-body text-center">

                        <h3 class="card-title"><?= $card_title ?></h3>
                        <hr>
                        <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img w-50 p-3">
                        <h2 class="card-title font-weight-bold"><?= $user['name']; ?></h2>

                        <?php if ($user['is_dev'] === 0) : ?>
                        <p class="card-text"><?= $user['email']; ?></p>

                        <?php elseif ($user['is_dev'] === 1) : ?>
                        <h5 class="card-text text-gray-500"><?= $user['headline']; ?></h5>
                        <p class="card-text">Rating : <?= $user['rating']; ?></p>

                        <br>
                        <br>
                        <p class="card-text font-weight-bold">Field : </p>
                        <?php foreach ($field as $row) : ?>
                        <p class="card-text">• <?= $row['field_category']; ?></p>
                        <?php endforeach; ?>

                        <br>
                        <br>
                        <p class="card-text font-weight-bold">Job Category : </p>
                        <?php foreach ($job as $row) : ?>
                        <p class="card-text">• <?= $row['job_category']; ?></p>
                        <?php endforeach; ?>

                        <br>
                        <br>
                        <p class="card-text font-weight-bold">Skill : </p>
                        <?php foreach ($skill as $row) : ?>
                        <p class="card-text">• <?= $row['skill']; ?></p>
                        <?php endforeach; ?>

                        <br>
                        <br>
                        <p class="card-text">Job complete : <?= $user['job_complete']; ?></p>
                        <p class="card-text">Job ongoing : <?= $user['job_ongoing']; ?></p>
                        <p class="card-text">Starting bid : <?= $user['starting_bid']; ?></p>
                        <?php endif; ?>

                        <p class="card-text">
                            <small class="text-muted">
                                Member since <?= date('d F Y', $user['date_created']); ?>
                            </small>
                        </p>

                        <hr>

                        <?php if($user['hide_wallet'] === 0): ?>
                        <p class="card-text text-left">
                            Your <span class="font-weight-bold">MecinPowder<sup>&reg;</sup></span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-light"
                                        style="background-color:#FF8965;">Rp</span>
                                </div>
                                <input type="text" class="form-control" style="background-color:white;"
                                    value="<?= number_format(intval($user['wallet'])); ?>" disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button"
                                        id="button-addon1">Refill</button>
                                </div>
                            </div>
                        </p>
                        <?php endif; ?>

                        <?php if ($user['is_dev'] === 1) : ?>
                        <a href="<?= base_url('project/propose?id='.$user['user_id']); ?>" class="btn btn-primary"
                            role="button" style="width:7rem; margin-top:1rem;">Contact</a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>




    </div>

</div>
<?php ## END OF PAGE CONTENT ?>

</div>
<?php ## END MAIN CONTENT ## ?>