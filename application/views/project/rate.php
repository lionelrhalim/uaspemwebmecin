<?php ## Propose Form ## ?>
<div class="col-6 mx-auto my-5">

    <?php ## Propose a New Project ?>
    <div class="card shadow-sm mb-3 col-12 ml-2">
        <div class="row no-gutters">

            <div class="col-md-12">
                <div class="card-body">
                    <h2 class="card-title">Rate Your Agent!</h2>

                    <hr>

                    <form action="<?= base_url('user/rate?id=').$project['project_id']; ?>" method="post">

                        <?php ## Agent's Details Section ## ?>
                        <div class="form-group">
                            <strong><?= $agent['profile']['name']; ?></strong>
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <img src="<?= base_url('assets/img/profile/').$agent['profile']['image']; ?>"
                                        class="img-fluid mt-2">
                                </div>
                                <div class="col">
                                    <strong>Rate</strong>

                                    <div class="form-check">
                                        <input type="radio" name="rate" id="very-bad" value="1">
                                        <label class="form-check-label" for="very-bad">
                                            <span class="icon">★</span>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input type="radio" name="rate" id="bad" value="2">
                                        <label class="form-check-label" for="bad">
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input type="radio" name="rate" id="standard" value="3">
                                        <label class="form-check-label" for="standard">
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input type="radio" name="rate" id="good" value="4">
                                        <label class="form-check-label" for="good">
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input type="radio" name="rate" id="very-good" value="5">
                                        <label class="form-check-label" for="very-good">
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                            <span class="icon">★</span>
                                        </label>
                                    </div>

                                    <?= form_error('rate', '<small class="text-danger pl-3">* ', '</small>'); ?>

                                </div>
                            </div>
                        </div>
                        <?php ## END OF Agent's Details Section ## ?>


                        <hr class="my-4">


                        <?php ## Project's Details Section ## ?>
                        <div class="form-group">

                            <strong>Project's Details</strong>
                            <div class="row align-items-center">

                                <div class="col-4">
                                    <img src="<?= base_url('assets/img/illustration/orange/projectOrange.svg') ?>"
                                        class="img-fluid mt-2 border">
                                </div>

                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="projectname" class="mt-2"><strong>Project name</strong></label>
                                            <input type="hidden" name="projectname"
                                                value="<?= $project['project_name']; ?>">
                                            <input type="text" class="form-control-plaintext border px-2"
                                                id="projectname" value="<?= $project['project_name']; ?>" disabled>
                                        </div>

                                        <div class="col-12">
                                            <label for="desc" class="mt-2"><strong>Desctiption</strong></label>
                                            <textarea class="form-control-plaintext border px-2" id="desc"
                                                style="resize:none;" rows="5"
                                                disabled><?= $project['description']; ?></textarea>
                                            <input type="hidden" name="desc" value="<?= $project['description']; ?>">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <?php ## END OF Project's Details Section ## ?>


                        <div class="float-right mb-4">
                            <button type="submit" class="btn btn-primary text-uppercase">
                                <strong>Confirm</strong>
                            </button>
                        </div>

                    </form>


                </div>
            </div>

        </div>
    </div>
</div>