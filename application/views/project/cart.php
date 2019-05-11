<?php ## Propose Form ## ?>
<div class="col-6 mx-auto my-5">

    <?php ## Propose a New Project ?>
    <div class="card shadow-sm mb-3 col-12 ml-2">
        <div class="row no-gutters">

            <div class="col-md-12">
                <div class="card-body">
                    <h2 class="card-title"><i class="fas fa-shopping-cart"></i> | Your Project Cart</h2>
                    <p class="card-text">Make sure eveything is correct!</p>

                    <hr>

                    <form action="<?= base_url('project/post'); ?>" method="post">

                        <?php ## Agent's Details Section ## ?>
                        <div class="form-group">
                            <strong>Agent's Details</strong>
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <img src="<?= base_url('assets/img/profile/').$project['agent_photo']; ?>"
                                        class="img-fluid mt-2">
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="agent_name" class="mt-2"><strong>Name</strong></label>
                                            <input type="text" class="form-control-plaintext border px-2"
                                                id="agent_name" value="<?= $project['agent_name']; ?>" disabled>
                                        </div>
                                        <div class="col-12">
                                            <label for="agent_headline" class="mt-2"><strong>Headline</strong></label>
                                            <input type="text" class="form-control-plaintext border px-2"
                                                id="agent_headline" value="<?= $project['agent_headline']; ?>" disabled>
                                        </div>
                                        <div class="col-12">
                                            <label for="agent_rating" class="mt-2"><strong>Rating</strong></label>
                                            <input type="text" class="form-control-plaintext border px-2"
                                                id="agent_rating" value="<?= $project['agent_rating']; ?>" disabled>
                                            <input type="hidden" name="agent_id" value="<?= $project['agent_id']; ?>">
                                        </div>
                                    </div>
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
                                <div class="col-6">
                                    <label for="job_category" class="mt-2"><strong>Category</strong></label>
                                    <input type="hidden" name="job_category" value="<?= $project['job_category']; ?>">
                                    <input type="text" class="form-control-plaintext border px-2" id="job_category"
                                        value="<?= $project['job']; ?>" disabled>
                                </div>
                                <div class="col-6">
                                    <label for="field_category" class="mt-2"><strong>Field</strong></label>
                                    <input type="hidden" name="field_category"
                                        value="<?= $project['field_category']; ?>">
                                    <input type="text" class="form-control-plaintext border px-2" id="field_category"
                                        value="<?= $project['field']; ?>" disabled>
                                </div>
                                <div class="col-6">
                                    <label for="times" class="mt-2"><strong>Deadline</strong></label>
                                    <input type="date" class="form-control-plaintext border px-2" id="times"
                                        value="<?= $project['deadline']; ?>" disabled>
                                    <input type="hidden" name="times" value="<?= $project['deadline']; ?>">
                                </div>
                                <div class="col-6">
                                    <label for="price" class="mt-2"><strong>Starting price</strong></label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control-plaintext border px-2" id="price"
                                            value="<?= $project['bid']; ?>" disabled>
                                        <input type="hidden" name="price" value="<?= $project['bid']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php ## END OF Project's Details Section ## ?>


                        <div class="float-right mb-4">
                            <button type="submit" class="btn btn-primary text-uppercase">
                                <strong>Confirm</strong>
                            </button>
                            <a href="project/edit" role="button" class="btn btn-danger">Edit</a>
                        </div>

                    </form>


                </div>
            </div>

        </div>
    </div>
</div>