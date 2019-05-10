<?php ## Propose Form ## ?>
<div class="col-6 mx-auto my-5">

    <?php ## Propose a New Project ?>
    <div class="card shadow-sm mb-3 col-12 ml-2">
        <div class="row no-gutters">

            <div class="col-md-12">
                <div class="card-body">
                    <h3 class="card-title">Propose a New Projects</h3>
                    <hr>

                    <form action="<?= base_url('project/propose?id='.$user['contact_id']); ?>" method="post">

                        <?php 
                            $this->session->set_userdata(['agent_id' => $user['contact_id']]);
                        ?>

                        <div class="form-group">
                            <label for="agent"><strong>Propose to</strong></label>
                            <input type="text" class="form-control" id="agent"
                                placeholder="<?= $user['contact_name']['profile']['name']; ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="projectname"><strong>Enter your project name</strong></label>
                            <input type="text" class="form-control" id="projectname" name="projectname"
                                placeholder="e.g Build me a news blog" value="<?= set_value('projectname'); ?>">
                            <?= form_error('projectname', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="desc"><strong>Tell us more</strong></label>
                            <textarea class="form-control" id="desc" name="desc" style="resize:none;" rows="5"
                                placeholder="Describe your project..."><?php echo set_value('desc'); ?></textarea>
                            <?= form_error('desc', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="field_category"><strong>Select best match category</strong></label>
                            <select class="form-control" id="field_category" name="field_category">
                                <option value="">Select Field Category</option>
                                <?php foreach($field as $f) : ?>
                                <option value="<?= $f['id']; ?>"><?= $f['field_category']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('field_category', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <select class="form-control" id="job_category" name="job_category">
                                <option value="">Select Job Category</option>
                                <?php foreach($job as $j) : ?>
                                <option value="<?= $j['id']; ?>"><?= $j['job_category']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('job_category', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="times"><strong>When should it finished?</strong></label>
                            <input type="date" class="form-control" id="times" name="times"
                                placeholder="Enter the deadline" value="<?= set_value('times'); ?>">
                            <?= form_error('times', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="price"><strong>Bid your starting price</strong></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp</div>
                                </div>
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="e.g 200000" value="<?= set_value('price'); ?>">
                            </div>
                            <?= form_error('price', '<small class="text-danger pl-3">* ', '</small>'); ?>
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