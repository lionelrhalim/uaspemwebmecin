<?php ## Payment Form ## ?>
<div class="col-6 mx-auto my-5">


    <?php ## Select Method ?>
    <div class="card shadow-sm mb-3 col-12 ml-2">
        <div class="row no-gutters">

            <div class="col-md-12">
                <div class="card-body">
                    <h3 class="card-title text-center">Complete Your Payment</h3>
                    <hr>

                    <form action="<?= base_url('payment/processing_payment?id=' . $project['project_id']); ?>"
                        method="post">

                        <?php ## CHOOSE PAYMENT METHOD ## ?>
                        <h5 class="card-title">Choose Payment Method</h5>
                        <?= form_error('bank', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        <div class="card o-hidden shadow-sm my-3">

                            <?php ## ACCORDION START ## ?>
                            <div class="accordion" id="accordionExample">

                                <?php foreach($bank as $b) : ?>
                                <div class="card">
                                    <div class="card-header" id="heading<?= $b['id'] ?>">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="selectbank<?= $b['id'] ?>" name="bank"
                                                class="custom-control-input" value="<?= $b['id'] ?>">
                                            <label class="custom-control-label" for="selectbank<?= $b['id'] ?>"
                                                data-toggle="collapse" data-target="#bank<?= $b['id'] ?>"
                                                aria-expanded="true" aria-controls="bank<?= $b['id'] ?>">
                                                <?= $b['bank_method'] ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="bank<?= $b['id'] ?>" class="collapse"
                                        aria-labelledby="heading<?= $b['id'] ?>" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <?= $b['description'] ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                            </div>
                            <?php ## END OF ACCORDION ## ?>

                        </div>
                        <?php ## END OF CHOOSE PAYMENT METHOD ## ?>


                        <hr class="my-4">


                        <?php ## SUMMARY ## ?>
                        <h5 class="card-title">Review Your Order</h5>
                        <div class="card o-hidden shadow-sm my-3">
                            <div class="card-header card-header-primary px-5"></div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">

                                        <div class="col-4">
                                            <h6 class="card-text">Project Title</h6>
                                        </div>
                                        <div class="col-8">
                                            <p class="card-text"><?= $project['project_name']; ?></p>
                                        </div>

                                        <div class="col-4">
                                            <h6 class="card-text">Field Category</h6>
                                        </div>
                                        <div class="col-8">
                                            <p class="card-text"><?= $project['field_category']; ?></p>
                                        </div>

                                        <div class="col-4">
                                            <h6 class="card-text">Job Category</h6>
                                        </div>
                                        <div class="col-8">
                                            <p class="card-text"><?= $project['job_category']; ?></p>
                                        </div>

                                        <div class="col-4">
                                            <h6 class="card-text">Deadline</h6>
                                        </div>
                                        <div class="col-8">
                                            <p class="card-text">
                                                <?php $dateFormat = strtotime($project['deadline']); ?>
                                                <?= date('d F Y', $dateFormat) ?>
                                            </p>
                                        </div>

                                        <div class="col-4">
                                            <h6 class="card-text">Proposed To</h6>
                                        </div>
                                        <div class="col-8">
                                            <p class="card-text"><?= $project['agent']['profile']['name']; ?></p>
                                        </div>

                                        <div class="col-4">
                                            <h6 class="card-text">Agreed Price</h6>
                                        </div>
                                        <div class="col-8">
                                            <p class="card-text">Rp<?= number_format(intval($project['bid'])); ?></p>
                                        </div>

                                        <div class="col-4">
                                            <h6 class="card-text">Description</h6>
                                        </div>
                                        <div class="col-8">
                                            <p class="card-text"><?= $project['description']; ?></p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <?php ## END OF SUMMARY ## ?>

                <hr class="my-3">

                <div class="float-right mb-4 mr-4">
                    <button type="submit" class="btn btn-primary text-uppercase">
                        <strong>Pay Now</strong>
                    </button>
                </div>
                </form>

            </div>
        </div>

    </div>
</div>
</div>