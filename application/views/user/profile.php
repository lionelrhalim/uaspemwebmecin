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
        <div class="row mb-4">
            <?php ## Profile Info Card ## ?>
            <div class="card shadow-sm mb-3 col-lg-3 mx-auto">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="card-body">

                            <h3 class="card-title">Profile Info</h3>
                            <hr>
                            <div class="text-center">
                                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>"
                                    class="card-img w-50 p-3">
                            </div>
                            <h5 class="card-title"><?= $user['name']; ?></h5>
                            <p class="card-text"><?= $user['email']; ?></p>
                            <p class="card-text"><?= $user['description']; ?></p>
                            <p class="card-text"><small class="text-muted">Member since
                                    <?= date('d F Y', $user['date_created']); ?></small></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php ## END OF PAGE CONTENT ?>

    </div>
    <?php ## END MAIN CONTENT ## ?>