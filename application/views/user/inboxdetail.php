<?php ## BEGIN PAGE CONTENT ?>
<div class="container-fluid">

    <?php ## FLASH MESSAGE ## ?>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php //var_dump($to); ?>

    <h1 class="mb-4 font-heading-primary mt-5">Inbox Detail</h1>
    <?php ## Inbox Detail Info Card ?>
    <div class="row">
        <div class="card shadow-sm mb-3 ml-3 col-lg-11 mx-auto">
            <div class="row no-gutters">

                <div class="col-md-12">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="card-text badge badge-pill badge-primary p-2"><?= $inbox_detail[0]['field_category']; ?></h6>
                            <h6 class="card-text badge badge-pill badge-primary p-2"><?= $inbox_detail[0]['job_category']; ?></h6>
                            <h1 class="card-text"><?= $inbox_detail[0]['inbox_title']; ?></h1>
                            <p class="card-text text-dark"><?= $inbox_detail[0]['inbox_date']; ?></p>
                        </div>
                        <br>
                        <div class="col text-center text-md-left">
                            <p class="card-text">From: <?= $from['name'] ?> ( <?= $from['email'] ?> )</p>
                            <p class="card-text">To: <?= $to['name'] ?> ( <?= $to['email'] ?> )</p>
                        </div>
                        <hr>
                        <h6 class="card-text"><?= $inbox_detail[0]['inbox_description']; ?></h6>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>
<?php ## END OF PAGE CONTENT ?>

</div>
<?php ## END MAIN CONTENT ## ?>
