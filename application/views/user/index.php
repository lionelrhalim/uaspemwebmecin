    <?php ## BEGIN PAGE CONTENT ## ?>
    <div class="container-fluid mt-5 pt-5 mt-md-3 pt-md-3">

        <?php ## FLASH MESSAGE ## ?>
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
            </div>
        </div>


        <?php ## FIRST ROW ## ?>
        <div class="row mb-4">

            <div class="col-12">
                <?php ## Section Heading ## ?>
                <h1 class="mb-4 font-heading-primary">Overview</h1>
            </div>

            <?php ## Active Projects Card ?>
            <div class="card shadow-sm mb-3 col-lg-8 mx-auto">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h3 class="card-title">Active Projects</h3>
                            <hr>

                            <h6 class="card-text font-primary">Category</h6>
                            <h5 class="card-text">Project name</h5>
                            <br>

                            <p class="card-text font-primary mb-1">Worked by</p>
                            <div class="row mb-2">
                                <div class="col-12 col-md-2 mb-2 mb-md-0">
                                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>"
                                        class="card-img">
                                </div>
                                <div class="col text-center text-md-left">
                                    <h5 class="card-text">Mecin.an Agent</h5>
                                    <h6 class="text-card"><i class="fas fa-clock font-primary"></i> &nbsp; 19 August
                                        2019
                                    </h6>
                                    <a href="" class="btn btn-primary" role="button"
                                        style="width:7rem; margin-top:1rem;">Contact</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

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
        <?php ## END OF FIRST ROW ## ?>




        <?php ## CAROUSEL ROW ## ?>
        <div class="row">

            <?php ## Section Heading ## ?>
            <div class="col-12">
                <h1 class="mb-4 font-heading-primary">Feeds</h1>
            </div>


            <?php ## Carousel ## ?>
            <div class="col-12 mx-auto mb-5">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/1920x300?text=Promo 1" class="d-block w-100"
                                alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/1920x300?text=Promo 2" class="d-block w-100"
                                alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/1920x300?text=Promo 3" class="d-block w-100"
                                alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

        </div>
        <?php ## END OF CAROUSEL ROW ## ?>



        <hr>



        <?php ## TOP AGENTS ROW ## ?>
        <div class="row text-center mb-4">

            <div class="col-12">
                <h2 class="mb-4 text-gray-600">Top Agents</h2>
            </div>

            <div class="card-deck mx-auto">
                <?php
                for($i=0;$i<3;$i++){
                    echo '
                    <div class="card o-hidden shadow-sm  my-3 profile-card" style="width: 18rem;">
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


            <!-- query my project -->
            <!-- <?php
                    $email = $user['email'];
                    $queryMyProject = "SELECT * FROM `createproject`
                                        WHERE `email` = '$email'
                                    ";
    
                    $myproject = $this->db->query($queryMyProject)->result_array();
                ?> -->

            <!--looping my project -->
            <!-- <?php foreach($myproject as $mp) : ?>
            <div class="card o-hidden shadow-sm mx-auto my-3 profile-card" style="width: 18rem;">
                <div class="card-header"></div>
                <div class="card-body">
                    <p class="card-text">
                        <h5 class="text-center font-weight-600 mb-4"><strong><?=$mp['project_name']?></strong></h5>
                        <h6 class="text-center font-weight-600 mb-4"><strong><?=$mp['description']?></strong></h6>
                        <div>
                            <?=$mp['field_category']?>
                        </div>

                        <div>
                            <?=$mp['job_category']?>
                        </div>

                        <div>
                            <?=$mp['times']?> Times
                        </div>

                        <div>
                            <?=$mp['price']?>
                        </div>

                    </p>

                    <div class="text-center mt-4">
                        <form method="POST" action="<?= base_url('user/updateStatus'); ?>">
                            <input type="hidden" id="projectname" name="projectname" value="<?= $mp['project_name'] ?>">
                            <button type="submit" name="submitDone" class="btn btn-primary-custom px-4">Done</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?> -->

        </div>
        <?php ## END OF TOP AGENTS ROW ## ?>



        <hr>



        <?php ## THIRD ROW ## ?>
        <div class="row">

            <?php ## Propose Form ## ?>
            <div class="col-6">
                <?php ## Card Heading ## ?>
                <div class="col-12">
                    <h2 class="mb-4 text-gray-600">Need profesional work?</h2>
                </div>

                <?php ## Propose a New Projects Card ?>
                <div class="card shadow-sm mb-3 col-12 ml-2">
                    <div class="row no-gutters">

                        <div class="col-md-12">
                            <div class="card-body">
                                <h3 class="card-title">Propose a New Projects</h3>
                                <hr>

                                <form action="<?= base_url('user/'); ?>" method="post">
                                    <div class="form-group">
                                        <label for="projectname"><strong>Enter your project name</strong></label>
                                        <input type="text" class="form-control" id="projectname" name="projectname"
                                            placeholder="e.g Build me a news blog">
                                    </div>

                                    <div class="form-group">
                                        <label for="desc"><strong>Tell us more</strong></label>
                                        <textarea class="form-control" id="desc" name="desc"
                                            placeholder="Describe your project..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="desc"><strong>Select best match category</strong></label>
                                        <select class="form-control" id="field_category" name="field_category">
                                            <option value="">Select Field Category</option>
                                            <?php foreach($field as $f) : ?>
                                            <option value="<?= $f['field_category']; ?>"><?= $f['field_category']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" id="job_category" name="job_category">
                                            <option value="">Select Job Category</option>
                                            <?php foreach($job as $j) : ?>
                                            <option value="<?= $j['job_category']; ?>"><?= $j['job_category']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="desc"><strong>When should it finished?</strong></label>
                                        <input type="tezt" class="form-control" id="times" name="times"
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


            <?php ## Benefit Card ## ?>
            <div class="col-4 mx-auto text-center">
                <?php ## Card Heading ## ?>
                <div class="col-12">
                    <h2 class="mb-4 text-gray-600">Our Benefits</h2>
                </div>

                <?php ## Benefit Card ?>
                <div class="card o-hidden shadow-sm card-header-primary">

                    <div class="card-body">
                        <h5 class="card-title">What you can get from<br>our professional work</h5>
                        <hr>
                        <img src="<?= base_url('assets/img/illustration/orange/'); ?>benefitOrange.svg"
                            class="card-img w-75 p-5">
                        <p class="card-text"><i class="fas fa-check font-primary"></i> &nbsp; Benefit</p>
                        <p class="card-text"><i class="fas fa-check font-primary"></i> &nbsp; Awesome Benefit</p>
                        <p class="card-text"><i class="fas fa-check font-primary"></i> &nbsp; Another Benefit</p>
                    </div>

                    <div class="card-footer">
                        <h4 class="font-light mt-3">Still have questions?</h4>
                        <a href="" role="button" class="btn btn-outline-light mb-3">See Feature</a>
                    </div>

                </div>
            </div>

        </div>
        <?php ## END OF THIRD ROW ## ?>


    </div>
    <?php ## END PAGE CONTENT ## ?>

    </div>
    <?php ## END MAIN CONTENT ## ?>