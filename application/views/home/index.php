<!-- Begin page content -->
<main role="main" class="flex-shrink-0">

    <div class="container-fluid bg-gradient-primary border-rounded-bottom">
        <div class="container">
            <div class="row py-5">

                <div class="col align-self-center">
                    <div class="row">
                        <h1 class="font-light">Get work done,<br>or get hired!</h1>
                    </div>
                    <div class="row">
                        <p class="col-10 p-0 font-light">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                            Consectetur
                            molestiae laborum atque
                            voluptatem, eveniet necessitatibus distinctio adipisci corrupti vero odio quibusdam corporis
                            placeat minus.</p>
                    </div>
                    <div class="row">
                        <button class="btn btn-light w-25">Start</button>
                    </div>
                </div>

                <div class="col">
                    <img src="<?= base_url('assets/img/illustration/'); ?>process.svg" alt="process" class="img-fluid"
                        width="85%">
                </div>

            </div>
        </div>
    </div>

    <div class="container my-4">

        <div class="row">
            <div class="col">
                <h1>Best Agents</h1>
                <p>Take a look at our top picked agent.</p>
            </div>
        </div>

        <hr class="pb-3">

        <div class="row">
            <?php
        for($i=0;$i<3;$i++){
            echo '
            <div class="card mx-auto" style="width: 18rem;">
                <h5 class="card-header font-primary">Pablo Suherman</h5>
                <div class="text-center">
                    <img src="'. base_url('assets/img/profile/') .'default.svg" class="card-img-top rounded-circle w-50"
                        alt="profile_pict">
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <h6>My Skills</h6>

                        Website
                        <div class="progress mb-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 85%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        Android Development
                        <div class="progress mb-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        iOS Development
                        <div class="progress mb-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </p>
                    <div class="text-center"><a href="#" class="btn btn-gradient-primary">Contact</a></div>
                </div>
                <div class="card-footer">
                    Last online : 2 days ago
                </div>
            </div>';
        }
        ?>
        </div>


    </div>

</main>