<?php ## BEGIN PAGE CONTENT ?>
<div class="container-fluid">

    <?php ## FLASH MESSAGE ## ?>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php //var_dump($countInbox); ?>

    <h1 class="mb-4 font-heading-primary mt-5">Inbox</h1>
    <?php ## Inbox Info Card ?>
    <div class="row">
        <div class="card shadow-sm mb-3 ml-3 col-lg-11 mx-auto">
            <div class="row no-gutters">

                <div class="col-md-12">
                    <?php foreach($inbox as $key=>$value): ?>
                    <?php $countInbox++; ?>
                    <a href="<?= base_url('user/inbox_detail?inbox_id=' . $value['inbox_id'] . '&project_id=' . $value['project_id']); ?>" class="row no-gutters card-body">
                        <?php if(!$value['inbox_status']): ?>
                        <h6 class="col-md-2 card-text badge badge-pill badge-primary p-2">Icon</h6>
                        <h5 class="col-md-6 card-text text-primary"> <?= $value['inbox_title']; ?> </h5>
                        <?php else: ?>
                        <h6 class="col-md-2 card-text badge badge-pill badge-light p-2">Icon</h6>
                        <h5 class="col-md-6 card-text text-dark"> <?= $value['inbox_title']; ?> </h5>
                        <?php endif ?>
                        <p class="col-md-4 card-text"> <?= date('d F Y H:i:s', strtotime($value['inbox_date'])); ?> </p>
                    </a>

                    <?php if($key != count($inbox)-1): ?>
                    <hr class="mb-1 mt-1">
                    <?php endif ?>
                    <?php endforeach ?>
                </div>

            </div>

            <?php if($countInbox <= 0): ?>
            <div class="col-md-12">
                <div class="card-body">
                    <h6 class="card-text text-center">Inbox is Empty</h6>
                </div>
            </div>
            <?php endif ?>
        </div>
    </div>

</div>
<?php ## END OF PAGE CONTENT ?>

</div>
<?php ## END MAIN CONTENT ## ?>
