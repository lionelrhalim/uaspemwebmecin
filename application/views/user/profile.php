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
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>"
                                class="card-img w-50 p-3">
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

                        </div>
                    </div>
                </div>
            </div>

            <?php if ($user['is_dev'] === 1) : ?>
            <?php ## Propose Form ## ?>
            <div class="col-6 mx-auto">

                <?php ## Propose a New Project ?>
                <div class="card shadow-sm mb-3 col-12 ml-2">
                    <div class="row no-gutters">

                        <div class="col-md-12">
                            <div class="card-body">
                                <h3 class="card-title">Propose a New Projects</h3>
                                <hr>

                                <form action="<?= base_url('user/index?id=').$user['user_id']; ?>" method="post">
                                    <div class="form-group">
                                        <label for="projectname"><strong>Enter your project name</strong></label>
                                        <input type="text" class="form-control" id="projectname" name="projectname"
                                            placeholder="e.g Build me a news blog">
                                    </div>

                                    <div class="form-group">
                                        <label for="desc"><strong>Tell us more</strong></label>
                                        <textarea class="form-control" id="desc" name="desc"
                                            style="resize:none;" rows="5" placeholder="Describe your project..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="desc"><strong>Select best match category</strong></label>
                                        <select class="form-control" id="field_category" name="field_category">
                                            <option value="">Select Field Category</option>
                                            <?php foreach($field as $f) : ?>
                                            <option value="<?= $f['field_category_id']; ?>"><?= $f['field_category']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" id="job_category" name="job_category">
                                            <option value="">Select Job Category</option>
                                            <?php foreach($job as $j) : ?>
                                            <option value="<?= $j['job_category_id']; ?>"><?= $j['job_category']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="desc"><strong>When should it finished?</strong></label>
                                        <input type="date" class="form-control" id="times" name="times"
                                            placeholder="Enter the deadline">
                                    </div>

                                    <div class="form-group">
                                        <label for="desc"><strong>Bid your starting price</strong></label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp</div>
                                            </div>
                                            <input type="number" class="form-control" id="price" name="price"
                                                placeholder="e.g 200000">
                                        </div>
                                    </div>

                                    <div class="float-right mb-4">
                                        <button type="submit" class="btn btn-primary text-uppercase">
                                            <strong>Propose Now</strong>
                                        </button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php endif; ?>


        </div>

    </div>
    <?php ## END OF PAGE CONTENT ?>

    </div>
    <?php ## END MAIN CONTENT ## ?>