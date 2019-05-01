    <?php ## BEGIN PAGE CONTENT ?>
    <div class="container-fluid">

        <?php ## FLASH MESSAGE ## ?>
        <div class="row">
            <div class="col-lg-12">
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
        <div class="card o-hidden shadow-sm my-5">

            <div class="card-header card-header-primary px-5">
                <div class="mb-2"><strong class="font-light text-uppercase">Viewing as :</strong></div>
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" role="tab" href="#employer">Employer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" role="tab" href="#agent">Agent</a>
                    </li>
                </ul>
            </div>

            <?php ## TAB START ## ?>
            <div class="card-body px-5">
                <div class="tab-content">

                    <?php ## EMPLOYER TAB ## ?>
                    <div class="tab-pane active" id="employer">
                        <div class="accordion" id="accordionExample">

                            <?php ## PROPOSED PROJECTS ## ?>
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <button class="btn btn-link btn-link-accordion" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <h4 class="font-heading-primary mb-0">Proposed Projects</h4>
                                    </button>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">

                                        <div class="container">
                                            <div class="row">

                                                <?php foreach ($project as $key=>$row): ?>
                                                <?php if($row['employer_id'] == $user['id']): ?>
                                                <?php $countProposedEmployer++; ?>
                                                <div class="col-6 card-deck">
                                                    <div class="card shadow-sm mb-3">
                                                        <div class="row no-gutters">

                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <h6
                                                                        class="card-text badge badge-pill badge-primary p-2">
                                                                        <?= $row['job_category']; ?></h6>
                                                                    <h5 class="card-text"><?= $row['project_name']; ?>
                                                                    </h5>
                                                                    <br>

                                                                    <p class="card-text font-primary mb-1">Proposed To
                                                                    </p>
                                                                    <div class="row mb-2">
                                                                        <div
                                                                            class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                                                            <img src="<?= base_url('assets/img/profile/') . $developer[$key]['image']; ?>"
                                                                                class="card-img">
                                                                        </div>
                                                                        <div class="col text-center text-md-left">
                                                                            <h5 class="card-text">
                                                                                <?= $developer[$key]['name'] ?></h5>
                                                                            <h6 class="text-card">
                                                                                <i
                                                                                    class="fas fa-clock font-primary"></i>
                                                                                &nbsp;
                                                                                <?php $dateFormat = strtotime($row['deadline']); ?>
                                                                                <?= date('d F Y', $dateFormat) ?>
                                                                            </h6>

                                                                            <?php if($row['status'] == -4): ?>
                                                                            <p class="badge badge-warning">Project is
                                                                                Complained
                                                                            </p>
                                                                            <?php elseif($row['status'] == -1): ?>
                                                                            <p class="badge badge-danger">Project is
                                                                                Refused
                                                                            </p>
                                                                            <?php elseif($row['status'] == 0): ?>
                                                                            <p class="badge badge-dark">Waiting for
                                                                                response
                                                                            </p>
                                                                            <?php elseif($row['status'] == 1): ?>
                                                                            <p class="badge badge-success">Project is
                                                                                Accepted
                                                                            </p>
                                                                            <?php elseif($row['status'] == 2): ?>
                                                                            <p class="badge badge-info">Project is on
                                                                                progress
                                                                            </p>
                                                                            <?php elseif($row['status'] == 3): ?>
                                                                            <p class="badge badge-primary">Project is
                                                                                Finished
                                                                            </p>
                                                                            <?php elseif($row['status'] == 4): ?>
                                                                            <p class="badge badge-success">Request is
                                                                                finished
                                                                            </p>
                                                                            <?php endif ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row justify-content-center">
                                                                        <?php if($row['status'] == 3): ?>
                                                                        <a href="<?= base_url('user/updateProjectStatus/4/' . $row['project_id'] . '/') ?>"
                                                                            class="btn btn-success mx-1" role="button"
                                                                            style="width:7rem; margin-top:1rem;">Satisfied</a>
                                                                        <a href="<?= base_url('user/updateProjectStatus/-4/' . $row['project_id'] . '/') ?>"
                                                                            class="btn btn-danger mx-1" role="button"
                                                                            style="width:7rem; margin-top:1rem;">Complain</a>
                                                                        <?php endif ?>
                                                                    </div>
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
                                                                <h6 class="card-text text-center">No Proposed Project
                                                                </h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <?php endif ?>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php ## END OF PROPOSED PROJECTS ## ?>


                            <?php ## WAITING FOR PAYMENT PROJECTS ## ?>
                            <div class="card">

                                <div class="card-header" id="headingTwo">
                                    <button class="btn btn-link btn-link-accordion collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <h4 class="font-heading-primary mb-0">Waiting for Payment</h4>
                                    </button>
                                </div>

                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">

                                        <div class="container">
                                            <div class="row">

                                                <?php foreach ($project as $key=>$row): ?>
                                                <?php if($row['employer_id'] == $user['id'] && $row['status'] == '1'): ?>
                                                <?php $countNeedPaidEmployer++; ?>
                                                <div class="col-6 card-deck">
                                                    <div class="card shadow-sm mb-3">
                                                        <div class="row no-gutters">

                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <h6
                                                                        class="card-text badge badge-pill badge-primary p-2">
                                                                        <?= $row['job_category']; ?></h6>
                                                                    <h5 class="card-text"><?= $row['project_name']; ?>
                                                                    </h5>
                                                                    <br>

                                                                    <p class="card-text font-primary mb-1">Project to be
                                                                        Paid</p>
                                                                    <div class="row mb-2">
                                                                        <div
                                                                            class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                                                            <img src="<?= base_url('assets/img/profile/') . $developer[$key]['image']; ?>"
                                                                                class="card-img">
                                                                        </div>
                                                                        <div class="col text-center text-md-left">
                                                                            <h5 class="card-text">
                                                                                <?= $developer[$key]['name'] ?>
                                                                            </h5>
                                                                            <h6 class="text-card">
                                                                                <i
                                                                                    class="fas fa-clock font-primary"></i>
                                                                                &nbsp;
                                                                                <?php $dateFormat = strtotime($row['deadline']); ?>
                                                                                <?= date('d F Y', $dateFormat) ?>
                                                                            </h6>
                                                                            <a href="<?= base_url('user/updateProjectStatus/2/' . $row['project_id'] . '/') ?>"
                                                                                class="btn btn-primary" role="button"
                                                                                style="width:10rem; margin-top:1rem;">Pay</a>
                                                                        </div>
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
                                                                <h6 class="card-text text-center">No Waiting for
                                                                    Payment
                                                                    Project
                                                                </h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <?php endif ?>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php ## END OF WAITING FOR PAYMENT PROJECTS ## ?>

                            <div class="card">
                                <div class="card-header" id="headingThree">

                                    <button class="btn btn-link btn-link-accordion collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <h4 class="font-heading-primary mb-0">What again Projects</h4>
                                    </button>

                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                        terry
                                        richardson ad
                                        squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                                        Food
                                        truck
                                        quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua
                                        put a
                                        bird
                                        on it
                                        squid single-origin coffee nulla assumenda shoreditch et. Nihil anim
                                        keffiyeh
                                        helvetica,
                                        craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad
                                        vegan
                                        excepteur
                                        butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim
                                        aesthetic
                                        synth
                                        nesciunt you probably haven't heard of them accusamus labore sustainable
                                        VHS.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php ## END OF EMPLOYER TAB ## ?>



                    <?php ## AGENT TAB ## ?>
                    <div class="tab-pane" id="agent">
                        <div class="accordion" id="accordionExample">

                            <?php ## REQUESTED PROJECTS ## ?>
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <button class="btn btn-link btn-link-accordion" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <h4 class="font-heading-primary mb-0">Requested Projects</h4>
                                    </button>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">

                                        <div class="container">
                                            <div class="row">

                                                <?php foreach ($project as $key=>$row): ?>
                                                <?php if($row['agent_id'] == $user['id'] && $row['status'] == 0): ?>
                                                <?php $countRequestedAgent++; ?>
                                                <div class="col-6 card-deck">
                                                    <div class="card shadow-sm mb-3 ml-3 col-lg-4">
                                                        <div class="row no-gutters">

                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <h6
                                                                        class="card-text badge badge-pill badge-primary p-2">
                                                                        <?= $row['job_category']; ?></h6>
                                                                    <h5 class="card-text"><?= $row['project_name']; ?>
                                                                    </h5>
                                                                    <p><?= $row['description']; ?></p>
                                                                    <br>

                                                                    <p class="card-text font-primary mb-1">Request From
                                                                    </p>
                                                                    <div class="row mb-2">
                                                                        <div
                                                                            class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                                                            <img src="<?= base_url('assets/img/profile/') . $employer[$key]['image']; ?>"
                                                                                class="card-img">
                                                                        </div>
                                                                        <div class="col text-center text-md-left">
                                                                            <h5 class="card-text">
                                                                                <?= $employer[$key]['name'] ?></h5>
                                                                            <h6 class="text-card">
                                                                                <i
                                                                                    class="fas fa-clock font-primary"></i>
                                                                                &nbsp;
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
                                                                        <a href="<?= base_url('user/updateProjectStatus/1/' . $row['project_id'] . '/') ?>"
                                                                            class="btn btn-primary mx-1" role="button"
                                                                            style="width:7rem; margin-top:1rem;">Accept</a>

                                                                        <a href="<?= base_url('user/updateProjectStatus/-1/' . $row['project_id'] . '/') ?>"
                                                                            class="btn btn-danger mx-1" role="button"
                                                                            style="width:7rem; margin-top:1rem;">Refuse</a>
                                                                    </div>
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
                                                                <h6 class="card-text text-center">No Requested Project
                                                                </h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <?php endif ?>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php ## END OF PROPOSED PROJECTS ## ?>


                            <?php ## ON GOING PROJECTS ## ?>
                            <div class="card">

                                <div class="card-header" id="headingTwo">
                                    <button class="btn btn-link btn-link-accordion collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <h4 class="font-heading-primary mb-0">On Going Project</h4>
                                    </button>
                                </div>

                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">

                                        <div class="container">
                                            <div class="row">

                                                <?php foreach ($project as $key=>$row): ?>
                                                <?php if($row['agent_id'] == $user['id'] && $row['status'] == 2): ?>
                                                <?php $countOngoingAgent++; ?>
                                                <div class="col-6 card-deck">
                                                    <div class="card shadow-sm mb-3 ml-3 col-lg-4">
                                                        <div class="row no-gutters">

                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <h6
                                                                        class="card-text badge badge-pill badge-primary p-2">
                                                                        <?= $row['job_category']; ?></h6>
                                                                    <h5 class="card-text"><?= $row['project_name']; ?>
                                                                    </h5>
                                                                    <br>

                                                                    <p class="card-text font-primary mb-1">Request From
                                                                    </p>
                                                                    <div class="row mb-2">
                                                                        <div
                                                                            class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                                                            <img src="<?= base_url('assets/img/profile/') . $employer[$key]['image']; ?>"
                                                                                class="card-img">
                                                                        </div>
                                                                        <div class="col text-center text-md-left">
                                                                            <h5 class="card-text">
                                                                                <?= $employer[$key]['name'] ?></h5>
                                                                            <h6 class="text-card">
                                                                                <i
                                                                                    class="fas fa-clock font-primary"></i>
                                                                                &nbsp;
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
                                                                        <a href="<?= base_url('user/updateProjectStatus/3/' . $row['project_id'] . '/') ?>"
                                                                            class="btn btn-primary" role="button"
                                                                            style="width:10rem; margin-top:1rem;">Finish
                                                                            Project</a>
                                                                    </div>
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
                                                                <h6 class="card-text text-center">No On Going Project
                                                                </h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <?php endif ?>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php ## END OF WAITING FOR PAYMENT PROJECTS ## ?>


                            <?php ## COMPLAINED PROJECTS ## ?>
                            <div class="card">

                                <div class="card-header" id="headingThree">
                                    <button class="btn btn-link btn-link-accordion collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <h4 class="font-heading-primary mb-0">Complained Project</h4>
                                    </button>
                                </div>

                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">

                                        <div class="container">
                                            <div class="row">

                                                <?php foreach ($project as $key=>$row): ?>
                                                <?php if($row['agent_id'] == $user['id'] && $row['status'] == -4): ?>
                                                <?php $countOngoingAgent++; ?>
                                                <div class="col-6 card-deck">
                                                    <div class="card shadow-sm mb-3 ml-3 col-lg-4">
                                                        <div class="row no-gutters">

                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <h6
                                                                        class="card-text badge badge-pill badge-primary p-2">
                                                                        <?= $row['job_category']; ?></h6>
                                                                    <h5 class="card-text"><?= $row['project_name']; ?>
                                                                    </h5>
                                                                    <br>

                                                                    <p class="card-text font-primary mb-1">Request From
                                                                    </p>
                                                                    <div class="row mb-2">
                                                                        <div
                                                                            class="col-12 col-md-3 col-lg-5 mb-2 mb-md-0">
                                                                            <img src="<?= base_url('assets/img/profile/') . $employer[$key]['image']; ?>"
                                                                                class="card-img">
                                                                        </div>
                                                                        <div class="col text-center text-md-left">
                                                                            <h5 class="card-text">
                                                                                <?= $employer[$key]['name'] ?></h5>
                                                                            <h6 class="text-card">
                                                                                <i
                                                                                    class="fas fa-clock font-primary"></i>
                                                                                &nbsp;
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
                                                                        <a href="<?= base_url('user/updateProjectStatus/3/' . $row['project_id'] . '/') ?>"
                                                                            class="btn btn-primary" role="button"
                                                                            style="width:10rem; margin-top:1rem;">Finish
                                                                            Revision</a>
                                                                    </div>
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
                                                                <h6 class="card-text text-center">No On Going
                                                                    Project</h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <?php endif ?>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php ## END OF COMPLAINED PROJECTS ## ?>

                        </div>
                    </div>
                    <?php ## END OF AGENT TAB ## ?>

                </div>
            </div>
            <?php ## END OF TAB ## ?>

        </div>
        <?php ## END OF MAIN CARD ## ?>


    </div>
    <?php ## END OF PAGE CONTENT ?>

    </div>
    <?php ## END MAIN CONTENT ## ?>