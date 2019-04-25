    <?php ## GET QUERY NAVBAR LIST

        $role_id = $this->session->userdata('role_id');
        $queryMenu = "SELECT `user_navbar`.`id`, `title`, 'url'
                FROM `user_navbar` JOIN `user_access_navbar`
                  ON `user_navbar`.`id` = `user_access_navbar`.`navbar_id`
               WHERE `user_access_navbar`.`role_id` = $role_id
            ORDER BY `user_access_navbar`.`role_id` ASC
            ";

        $queryNavBar = "SELECT * FROM user_navbar";

        $navBar = $this->db->query($queryMenu)->result_array();
    ?>
    
    <?php ## NAVBAR ## ?>
    <nav class="navbar navbar-expand-md static-top navbar-light bg-white shadow d-none d-md-block"
        style="margin-top:80px;">
        <div class="container px-1">

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <?php foreach($navBar as $nb) : ?>

                    <?php if($title == $nb['title']) : ?>
                        <li class="nav-item active active-primary">

                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>

                            <a class="nav-link" href="<?= base_url($nb['url']); ?>">
                                <?= $nb['title']; ?>
                            </a>

                        </li>
                    <?php endforeach; ?>

                    <!--
                    <li class="nav-item active active-primary">
                        <a class="nav-link" href="<?= base_url('user') ?>">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                    -->
                    <!-- <li class="nav-item">
                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                            </li> -->
                </ul>
                <!-- <form class="form-inline mt-2 mt-md-0">
                            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                            <button class="btn btn-light my-2 my-sm-0 font-primary" type="submit">Search</button>
                        </form> -->
            </div>
        </div>
    </nav>
    <?php ## END OF NAVBAR ## ?>