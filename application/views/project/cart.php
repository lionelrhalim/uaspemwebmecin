<?php ## Propose Form ## ?>
<div class="col-6 mx-auto my-5">

    <?php ## Propose a New Project ?>
    <div class="card shadow-sm mb-3 col-12 ml-2">
        <div class="row no-gutters">

            <div class="col-md-12">
                <div class="card-body">
                    <h3 class="card-title">Project Cart</h3>
                    <h5 class="card-title">Review your order</h5>
                    <p>Edit if there is a change</p>
                    <hr>

                    <form action="<?= base_url('project/cart'); ?>" method="post">

                        <div class="form-group">
                            <label for="agent"><strong>Propose to</strong></label>
                            <input type="text" class="form-control" id="agent"
                                value="<?= $user['contact_name']['profile']['name']; ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="projectname"><strong>Your project name</strong></label>
                            <input type="text" class="form-control" id="projectname" name="projectname"
                                value="<?= $project_name; ?>">
                            <?= form_error('projectname', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="desc"><strong>Details</strong></label>
                            <textarea class="form-control" id="desc" name="desc" style="resize:none;" rows="5">
                            <?= $description; ?>
                            </textarea>
                            <?= form_error('desc', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id="projectname" name="projectname"
                                value="<?= $job_category; ?>">
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id="projectname" name="projectname"
                                value="<?= $field_category; ?>">
                        </div>

                        <div class="form-group">
                            <label for="times"><strong>Deadline</strong></label>
                            <input type="date" class="form-control" id="times" name="times"
                                value="<?= $deadline; ?>">
                            <?= form_error('times', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="price"><strong>Starting price</strong></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp</div>
                                </div>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="<?= $bid; ?>">
                            </div>
                            <?= form_error('price', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="confirm"><strong>Type Confirm Here</strong></label>
                            <input type="text" class="form-control" id="confirm" name="confirm" required>
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