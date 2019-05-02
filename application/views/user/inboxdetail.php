<?php ## BEGIN PAGE CONTENT ?>
<div class="container-fluid">

    <?php ## FLASH MESSAGE ## ?>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <h1 class="mb-4 font-heading-primary mt-5">Inbox Detail</h1>
    <?php ## Inbox Detail Info Card ?>
    <div class="row">
        <div class="card shadow-sm mb-3 ml-3 col-lg-11 mx-auto">
            <div class="row no-gutters">

                <div class="col-md-12">
                    <div class="card-body">


                        <p class="card-text">
                            Time &nbsp;: &nbsp;<?= date('j F Y - g:ia', strtotime($inbox_detail[0]['inbox_date'])); ?>
                            <br>
                            From : &nbsp;<?= $from['email'] ?>
                            <br>
                            To &nbsp; &nbsp; &nbsp; : &nbsp;<?= $to['email'] ?>

                            <hr>

                            Dear, <strong><?= $to['name'] ?></strong>.
                            <br>
                            <?= $inbox_detail[0]['inbox_description']; ?>

                            <div class="p-5 pt-4">
                                <h3><?= $inbox_detail[0]['inbox_title']; ?></h3>
                                Field Category : <strong><?= $inbox_detail[0]['field_category']; ?></strong>
                                <br>
                                Job Category &nbsp; : <strong><?= $inbox_detail[0]['job_category']; ?></strong>
                                <br>
                                Deadline : <strong><?= $inbox_detail[0]['deadline']; ?></strong>
                                <br>
                                Bid : <strong>Rp <?= number_format(intval($inbox_detail[0]['bid'])); ?></strong>
                                <br>
                                Description :
                                <br>
                                <p class="px-3">
                                    <i><?= $inbox_detail[0]['description']; ?></i>
                                </p>
                            </div>

                            Check your <a href="<?= base_url('project') ?>">Project Page</a> now.
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>


</div>
<?php ## END OF PAGE CONTENT ?>

</div>
<?php ## END MAIN CONTENT ## ?>