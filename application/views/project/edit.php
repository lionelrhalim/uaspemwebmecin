<?php ## Propose Form ## ?>
<div class="col-6 mx-auto my-5">

    <?php ## Propose a New Project ?>
    <div class="card shadow-sm mb-3 col-12 ml-2">
        <div class="row no-gutters">

            <div class="col-md-12">
                <div class="card-body">
                    <h3 class="card-title">Edit Projects</h3>
                    <hr>

                    <form action="<?= base_url('project/edit?id='.$project['cart_id']); ?>" method="post">

                        <div class="form-group">
                            <label for="agent"><strong>Propose to</strong></label>
                            <input type="text" class="form-control" id="agent"
                                placeholder="<?= $project['agent_name']; ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="projectname"><strong>Enter your project name</strong></label>
                            <input type="text" class="form-control" id="projectname" name="projectname"
                                placeholder="e.g Build me a news blog" value="<?= $project['project_name']; ?>">
                            <?= form_error('projectname', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="desc"><strong>Tell us more</strong></label>
                            <textarea class="form-control" id="desc" name="desc" style="resize:none;" rows="5"
                                placeholder="Describe your project..."><?= $project['description']; ?></textarea>
                            <?= form_error('desc', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="field_category"><strong>Select best match category</strong></label>
                            <select class="form-control" id="field_category" name="field_category">
                                <option value="">Select Field Category</option>
                                <?php foreach($field as $f) : ?>
                                <?php if($f['id'] == $project['field_category']) : ?>
                                <option selected value="<?= $f['id']; ?>"><?= $f['field_category']; ?>
                                </option>
                                <?php else: ?>
                                <option value="<?= $f['id']; ?>"><?= $f['field_category']; ?>
                                </option>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('field_category', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <select class="form-control" id="job_category" name="job_category">
                                <option value="">Select Job Category</option>
                                <?php foreach($job as $j) : ?>
                                <?php if($j['id'] == $project['job_category']) : ?>
                                <option selected value="<?= $j['id']; ?>"><?= $project['job']; ?>
                                </option>
                                <?php else: ?>
                                <option value="<?= $j['id']; ?>"><?= $j['job_category']; ?>
                                </option>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('job_category', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="times"><strong>When should it finished?</strong></label>
                            <input type="date" class="form-control" id="times" name="times"
                                placeholder="Enter the deadline" value="<?= $project['deadline']; ?>">
                            <?= form_error('times', '<small class="text-danger pl-3">* ', '</small>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="price"><strong>Bid your starting price</strong></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp</div>
                                </div>
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="e.g 200000" value="<?= $project['bid']; ?>">
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