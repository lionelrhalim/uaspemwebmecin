<?php ## BEGIN PAGE CONTENT ?>
<div class="container-fluid">

    <?php ## FLASH MESSAGE ## ?>
    <div class="row mt-5 justify-content-center">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php
            $now = now('Asia/Jakarta');
            $gmt = local_to_gmt(time());
            $timeNow = date('d F Y, H:i:s', gmt_to_local($now, FALSE));
            $nextDay = date('d F Y, H:i:s', strtotime($timeNow . '+1 day'));

            //echo $timeNow;
            //echo '<br>';
            //echo $nextDay;
        ?>

    <?php ## MAIN CARD ?>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card o-hidden shadow-sm my-5">

                <div class="card-header px-5 py-3" id="proposed_project">
                    <h2 class="font-heading-primary mb-0"><i class="fas fa-shopping-cart"></i> Cart</h2>
                </div>

                <div class="card-body">
                    <div class="container">

                        Please complete these proposal

                        <div class="row justify-content-end pr-4">
                            <div class="dropdown mb-3">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="?sort=0">Older First</a>
                                    <a class="dropdown-item" href="?sort=1">Newer First</a>
                                    <a class="dropdown-item" href="?sort=2">By Title</a>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center border p-3">

                            <?php foreach ($cart as $key=>$row): ?>
                            <?php if($row['employer_id'] == $user['id']): ?>
                            <?php $countCart++ ?>
                            <div class="col-6 card-deck mx-auto">
                                <div class="card shadow-sm mb-3">
                                    <div class="row no-gutters">

                                        <div class="col-md-12">
                                            <div class="card-body">

                                                <h5 class="card-text mb-3">
                                                    <?= $row['project_name']; ?>
                                                </h5>

                                                <hr>

                                                <p class="card-text font-primary mb-1">
                                                    Proposed To
                                                </p>

                                                <div class="row mb-2">
                                                    <div class="col text-center text-md-left">
                                                        <h5 class="card-text">
                                                            <?= $row['agent_name']; ?></h5>
                                                        <h6 class="text-card">
                                                            <i class="fas fa-clock font-primary"></i>
                                                            &nbsp;
                                                            <?php $dateFormat = strtotime($row['deadline']); ?>
                                                            <?= date('d F Y', $dateFormat) ?>
                                                        </h6>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-center">
                                                    <a href="<?= base_url('project/cart?id=').$row['cart_id']; ?>"
                                                        class="btn btn-info mx-1 text-uppercase font-weight-bold"
                                                        role="button" style="width:9rem; margin-top:1rem;">Continue</a>
                                                    <a href="<?= base_url('project/cancel_cart?id=').$row['cart_id']; ?>"
                                                        class="btn btn-danger mx-1" role="button"
                                                        style="width:7rem; margin-top:1rem;">Cancel</a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php endif ?>
                            <?php endforeach ?>

                            <?php if ($countCart <= 0): ?>
                            <h2><i class="fas fa-clipboard-list"></i> No incomplete proposal.</h2>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php ## END OF MAIN CARD ## ?>

</div>
<?php ## END OF PAGE CONTENT ?>

</div>
<?php ## END MAIN CONTENT ## ?>