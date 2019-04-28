    <?php ## BEGIN PAGE CONTENT ?>
    <div class="container-fluid">

        <?php ## FLASH MESSAGE ## ?>
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
            </div>
        </div>

        <?php //var_dump($project) ?>
        <?php
            $now = time();
            $timezone = 'UP7';
            $gmt = local_to_gmt(time());
            $timeNow = date('d F Y, H:i:s', gmt_to_local($now, $timezone, FALSE));
            $nextDay = date('d F Y, H:i:s', strtotime($timeNow . '+1 day'));

            echo $timeNow;
            echo '<br>';
            echo $nextDay;
        ?>

        <h1 class="mb-4 font-heading-primary mt-5">Section - Inbox Employer</h1>
        <?php ## Employer Proposed Projects Info Card ?>
        <h3 class="card-title">Proposed Projects</h3>

        <div class="row">
            <?php foreach ($project as $key=>$row): ?>
            <?php if($row['employer_id'] == $user['id']): ?>
            <?php $countProposedEmployer++; ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-4">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text badge badge-pill badge-primary p-2"><?= $row['job_category']; ?></h6>
                            <h5 class="card-text"><?= $row['project_name']; ?></h5>
                            <br>

                            <p class="card-text font-primary mb-1">Proposed To</p>
                            <div class="row mb-2">
                                <div class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                    <img src="<?= base_url('assets/img/profile/') . $developer[$key]['image']; ?>"
                                        class="card-img">
                                </div>
                                <div class="col text-center text-md-left">
                                    <h5 class="card-text"><?= $developer[$key]['name'] ?></h5>
                                    <h6 class="text-card">
                                        <i class="fas fa-clock font-primary"></i> &nbsp;
                                        <?php $dateFormat = strtotime($row['deadline']); ?>
                                        <?= date('d F Y', $dateFormat) ?>
                                    </h6>

                                    <?php if($row['status'] == -4): ?>
                                    <p class="badge badge-warning">Project is Complained</p>
                                    <?php elseif($row['status'] == -1): ?>
                                    <p class="badge badge-danger">Project is Refused</p>
                                    <?php elseif($row['status'] == 0): ?>
                                    <p class="badge badge-dark">Waiting for response</p>
                                    <?php elseif($row['status'] == 1): ?>
                                    <p class="badge badge-success">Project is Accepted</p>
                                    <?php elseif($row['status'] == 2): ?>
                                    <p class="badge badge-info">Project is on progress</p>
                                    <?php elseif($row['status'] == 3): ?>
                                    <p class="badge badge-primary">Project is Finished</p>
                                    <?php elseif($row['status'] == 4): ?>
                                    <p class="badge badge-success">Request is finished</p>
                                    <?php endif ?>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <?php if($row['status'] == 3): ?>
                                <a href="<?= base_url('user/updateProjectStatus/4/' . $row['project_id'] . '/') ?>" class="btn btn-success mx-1" role="button"
                                    style="width:7rem; margin-top:1rem;">Satisfied</a>
                                <a href="<?= base_url('user/updateProjectStatus/-4/' . $row['project_id'] . '/') ?>" class="btn btn-danger mx-1" role="button"
                                    style="width:7rem; margin-top:1rem;">Complain</a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
            <?php endforeach ?>

            <?php if($countProposedEmployer <= 0): ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-12 mx-auto">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text text-center">No Proposed Project</h6>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
        </div>



        <?php ## Employer - Waiting for Projects payment Info Card ?>
        <h3 class="card-title">Waiting for payment</h3>

        <div class="row">
            <?php foreach ($project as $key=>$row): ?>
            <?php if($row['employer_id'] == $user['id'] && $row['status'] == '1'): ?>
            <?php $countNeedPaidEmployer++; ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-4">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text badge badge-pill badge-primary p-2"><?= $row['job_category']; ?></h6>
                            <h5 class="card-text"><?= $row['project_name']; ?></h5>
                            <br>

                            <p class="card-text font-primary mb-1">Project to be Paid</p>
                            <div class="row mb-2">
                                <div class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                    <img src="<?= base_url('assets/img/profile/') . $developer[$key]['image']; ?>"
                                        class="card-img">
                                </div>
                                <div class="col text-center text-md-left">
                                    <h5 class="card-text"><?= $developer[$key]['name'] ?></h5>
                                    <h6 class="text-card">
                                        <i class="fas fa-clock font-primary"></i> &nbsp;
                                        <?php $dateFormat = strtotime($row['deadline']); ?>
                                        <?= date('d F Y', $dateFormat) ?>
                                    </h6>
                                    <a href="<?= base_url('user/updateProjectStatus/2/' . $row['project_id'] . '/') ?>" class="btn btn-primary" role="button"
                                        style="width:10rem; margin-top:1rem;">Pay</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
            <?php endforeach ?>

            <?php if($countNeedPaidEmployer <= 0): ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-12 mx-auto">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text text-center">No Waiting for Payment Project</h6>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
        </div>


        <h1 class="mb-4 font-heading-primary mt-5">Section - Inbox Agent</h1>
        <?php ## Agent Requested Projects Info Card ?>
        <h3 class="card-title">Requested Projects</h3>

        <div class="row">
            <?php foreach ($project as $key=>$row): ?>
            <?php if($row['agent_id'] == $user['id'] && $row['status'] == 0): ?>
            <?php $countRequestedAgent++; ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-4">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text badge badge-pill badge-primary p-2"><?= $row['job_category']; ?></h6>
                            <h5 class="card-text"><?= $row['project_name']; ?></h5>
                            <p><?= $row['description']; ?></p>
                            <br>

                            <p class="card-text font-primary mb-1">Request From</p>
                            <div class="row mb-2">
                                <div class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                    <img src="<?= base_url('assets/img/profile/') . $employer[$key]['image']; ?>"
                                        class="card-img">
                                </div>
                                <div class="col text-center text-md-left">
                                    <h5 class="card-text"><?= $employer[$key]['name'] ?></h5>
                                    <h6 class="text-card">
                                        <i class="fas fa-clock font-primary"></i> &nbsp;
                                        <?php $dateFormat = strtotime($row['deadline']); ?>
                                        <?= date('d F Y', $dateFormat) ?>
                                    </h6>
                                    <br>
                                    <h6>Bid:
                                        <?php
                                            setlocale(LC_MONETARY, 'en_US');
                                            echo "IDR " . number_format($row['bid'], 0, '', '.');
                                        ?>
                                    </h6>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <a href="<?= base_url('user/updateProjectStatus/1/' . $row['project_id'] . '/') ?>" class="btn btn-primary mx-1" role="button"
                                    style="width:7rem; margin-top:1rem;">Accept</a>

                                <a href="<?= base_url('user/updateProjectStatus/-1/' . $row['project_id'] . '/') ?>" class="btn btn-danger mx-1" role="button"
                                    style="width:7rem; margin-top:1rem;">Refuse</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
            <?php endforeach ?>

            <?php if($countRequestedAgent<= 0): ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-12 mx-auto">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text text-center">No Requested Project</h6>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
        </div>



        <?php ## Agent On Going Projects Card ?>
        <h3 class="card-title">On Going Projects</h3>

        <div class="row">
            <?php foreach ($project as $key=>$row): ?>
            <?php if($row['agent_id'] == $user['id'] && $row['status'] == 2): ?>
            <?php $countOngoingAgent++; ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-4">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text badge badge-pill badge-primary p-2"><?= $row['job_category']; ?></h6>
                            <h5 class="card-text"><?= $row['project_name']; ?></h5>
                            <br>

                            <p class="card-text font-primary mb-1">Request From</p>
                            <div class="row mb-2">
                                <div class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                    <img src="<?= base_url('assets/img/profile/') . $employer[$key]['image']; ?>"
                                        class="card-img">
                                </div>
                                <div class="col text-center text-md-left">
                                    <h5 class="card-text"><?= $employer[$key]['name'] ?></h5>
                                    <h6 class="text-card">
                                        <i class="fas fa-clock font-primary"></i> &nbsp;
                                        <?php $dateFormat = strtotime($row['deadline']); ?>
                                        <?= date('d F Y', $dateFormat) ?>
                                    </h6>
                                    <br>
                                    <h6>Bid:
                                        <?php
                                            setlocale(LC_MONETARY, 'en_US');
                                            echo "IDR " . number_format($row['bid'], 0, '', '.');
                                        ?>
                                    </h6>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <a href="<?= base_url('user/updateProjectStatus/3/' . $row['project_id'] . '/') ?>" class="btn btn-primary" role="button"
                                    style="width:10rem; margin-top:1rem;">Finish Project</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
            <?php endforeach ?>

            <?php if($countOngoingAgent<= 0): ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-12 mx-auto">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text text-center">No On Going Project</h6>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
        </div>



        <?php ## Agent Complained Projects Card ?>
        <h3 class="card-title">Complained Projects</h3>

        <div class="row">
            <?php foreach ($project as $key=>$row): ?>
            <?php if($row['agent_id'] == $user['id'] && $row['status'] == -4): ?>
            <?php $countOngoingAgent++; ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-4">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text badge badge-pill badge-primary p-2"><?= $row['job_category']; ?></h6>
                            <h5 class="card-text"><?= $row['project_name']; ?></h5>
                            <br>

                            <p class="card-text font-primary mb-1">Request From</p>
                            <div class="row mb-2">
                                <div class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                    <img src="<?= base_url('assets/img/profile/') . $employer[$key]['image']; ?>"
                                        class="card-img">
                                </div>
                                <div class="col text-center text-md-left">
                                    <h5 class="card-text"><?= $employer[$key]['name'] ?></h5>
                                    <h6 class="text-card">
                                        <i class="fas fa-clock font-primary"></i> &nbsp;
                                        <?php $dateFormat = strtotime($row['deadline']); ?>
                                        <?= date('d F Y', $dateFormat) ?>
                                    </h6>
                                    <br>
                                    <h6>Bid:
                                        <?php
                                            setlocale(LC_MONETARY, 'en_US');
                                            echo "IDR " . number_format($row['bid'], 0, '', '.');
                                        ?>
                                    </h6>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <a href="<?= base_url('user/updateProjectStatus/3/' . $row['project_id'] . '/') ?>" class="btn btn-primary" role="button"
                                    style="width:10rem; margin-top:1rem;">Finish Revision</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
            <?php endforeach ?>

            <?php if($countOngoingAgent<= 0): ?>
            <div class="card shadow-sm mb-3 ml-3 col-lg-12 mx-auto">
                <div class="row no-gutters">

                    <div class="col-md-12">
                        <div class="card-body">
                            <h6 class="card-text text-center">No On Going Project</h6>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif ?>
        </div>

    </div>
    <?php ## END OF PAGE CONTENT ?>

    </div>
    <?php ## END MAIN CONTENT ## ?>
