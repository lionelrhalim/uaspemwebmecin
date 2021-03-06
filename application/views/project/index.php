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

                <div class="card-header card-header-primary px-5">
                    <div class="mb-2"><strong class="font-light text-uppercase">Viewing as :</strong></div>
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" role="tab" href="#employer">Employer</a>
                        </li>
                        <?php if($user['profile']['is_dev'] == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" role="tab" href="#agent">Agent</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <?php ## TAB START ## ?>
                <div class="card-body px-5">
                    <div class="tab-content">

                        <?php ## EMPLOYER TAB ## ?>
                        <div class="tab-pane active" id="employer">
                            <div class="accordion" id="accordionExample">

                                <?php ## PROJECT LIST ## ?>
                                <div class="card">
                                    <div class="card-header" id="proposed_project">
                                        <button class="btn btn-link btn-link-accordion" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <h4 class="font-heading-primary mb-0">Project List</h4>
                                        </button>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="proposed_project"
                                        data-parent="#accordionExample">
                                        <div class="card-body">

                                            <div class="container">

                                                <div class="row justify-content-end pr-4">
                                                    <div class="dropdown mb-3">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Sort
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="?sort=0">Older First</a>
                                                            <a class="dropdown-item" href="?sort=1">Newer First</a>
                                                            <a class="dropdown-item" href="?sort=2">By Title</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-center">

                                                    <?php foreach ($project as $key=>$row): ?>
                                                    <?php if($row['employer_id'] == $user['id'] && ($row['status'] == '0' OR $row['status'] == '2' OR $row['status'] == '-4')): ?>
                                                    <?php $countProposedEmployer++; ?>
                                                    <div class="col-6 card-deck mx-auto">
                                                        <div class="card shadow-sm mb-3">
                                                            <div class="row no-gutters">

                                                                <div class="col-md-12">
                                                                    <div class="card-body">

                                                                        <h6 class="card-text badge 
                                                                    badge-pill badge-primary p-2">
                                                                            <?= $row['job_category']; ?>
                                                                        </h6>

                                                                        <h5 class="card-text">
                                                                            <?= $row['project_name']; ?>
                                                                        </h5>

                                                                        <p class="card-text font-primary mb-1">
                                                                            Proposed To
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

                                                                                <p
                                                                                    class="badge badge-<?= $row['color'] ?>">
                                                                                    <?= $row['status_desc'] ?>
                                                                                </p>

                                                                            </div>
                                                                        </div>

                                                                        <?php if($row['status'] == 0): ?>
                                                                        <div class="row justify-content-center">
                                                                            <a href="<?= base_url('project/cancel?id=').$row['project_id']; ?>"
                                                                                class="btn btn-danger mx-1"
                                                                                role="button"
                                                                                style="width:7rem; margin-top:1rem;">Cancel</a>
                                                                        </div>
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
                                                                    <h6 class="card-text text-center">You don't have
                                                                        active
                                                                        project
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
                                <?php ## END OF PROJECT LIST ## ?>


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
                                                    <?php if($row['employer_id'] == $user['id']  && ($row['status'] == '1' OR $row['status'] == '5')): ?>
                                                    <?php $countNeedPaidEmployer++; ?>
                                                    <div class="col-6 card-deck mx-auto">
                                                        <div class="card shadow-sm mb-3">
                                                            <div class="row no-gutters">

                                                                <div class="col-md-12">
                                                                    <div class="card-body">

                                                                        <h6 class="card-text badge 
                                                                    badge-pill badge-primary p-2">
                                                                            <?= $row['job_category']; ?>
                                                                        </h6>

                                                                        <h5 class="card-text">
                                                                            <?= $row['project_name']; ?>
                                                                        </h5>

                                                                        <p class="card-text font-primary mb-3">
                                                                            Proposed To
                                                                        </p>
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

                                                                                <p
                                                                                    class="badge badge-<?= $row['color'] ?>">
                                                                                    <?= $row['status_desc'] ?>
                                                                                </p>

                                                                                <?php if($row['status'] == 1): ?>
                                                                                <a href="<?= base_url('payment/pay?id=' . $row['project_id']) ?>"
                                                                                    class="btn btn-primary"
                                                                                    role="button"
                                                                                    style="width:10rem; margin-top:1rem;">Pay</a>
                                                                                <?php endif ?>
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
                                                                    <h6 class="card-text text-center">
                                                                        No Project Waiting for Payment
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


                                <?php ## REVIEW PROJECTS ## ?>
                                <div class="card">

                                    <div class="card-header" id="headingThree">
                                        <button class="btn btn-link btn-link-accordion collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            <h4 class="font-heading-primary mb-0">Review Your Project</h4>
                                        </button>
                                    </div>

                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                        data-parent="#accordionExample">
                                        <div class="card-body">

                                            <div class="container">
                                                <div class="row">

                                                    <?php foreach ($project as $key=>$row): ?>
                                                    <?php if($row['employer_id'] == $user['id']  && ($row['status'] == '3')): ?>
                                                    <?php $countNeedReviewEmployer++; ?>

                                                    <div class="col-6 card-deck mx-auto">
                                                        <div class="card shadow-sm mb-3">
                                                            <div class="row no-gutters">

                                                                <div class="col-md-12">
                                                                    <div class="card-body">

                                                                        <h6 class="card-text badge 
                                                                    badge-pill badge-primary p-2">
                                                                            <?= $row['job_category']; ?>
                                                                        </h6>

                                                                        <h5 class="card-text">
                                                                            <?= $row['project_name']; ?>
                                                                        </h5>

                                                                        <p class="card-text font-primary mb-3">
                                                                            Proposed To
                                                                        </p>
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

                                                                                <p
                                                                                    class="badge badge-<?= $row['color'] ?>">
                                                                                    <?= $row['status_desc'] ?>
                                                                                </p>

                                                                                <?php if($row['status'] == 3): ?>
                                                                                <a href="<?= base_url('user/updateProjectStatus/4/' . $row['project_id'] . '/') ?>"
                                                                                    class="btn btn-success mx-1"
                                                                                    role="button"
                                                                                    style="width:7rem; margin-top:1rem;">Satisfied</a>

                                                                                <div>
                                                                                    <p
                                                                                        class="card-text text-center mt-3">
                                                                                        Contact your agent if
                                                                                        there's a problem:</p>

                                                                                    <?php if($developer[$key]['line']!=null){?>
                                                                                    <h6><i class="fab fa-line"></i>
                                                                                        <?php echo ' : '. $developer[$key]['line']; ?>
                                                                                    </h6>
                                                                                    <?php } ?>
                                                                                    <h6><i
                                                                                            class="fas fa-phone"></i><?php echo ' : '. $developer[$key]['phone']; ?>
                                                                                    </h6>
                                                                                    <h6 style="font-size:0.80rem;"><i
                                                                                            class="fas fa-at"></i><?php echo ' : '. $developer[$key]['email']; ?>
                                                                                    </h6>
                                                                                </div>

                                                                                <?php endif ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>
                                                    <?php endforeach ?>

                                                    <?php if($countNeedReviewEmployer <= 0): ?>
                                                    <div class="card shadow-sm mb-3 ml-3 col-lg-12 mx-auto">
                                                        <div class="row no-gutters">

                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <h6 class="card-text text-center">
                                                                        No Project Waiting for Review
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
                                <?php ## END OF REVIEW PROJECT ## ?>


                                <?php ## HISTORY ## ?>
                                <div class="card">

                                    <div class="card-header" id="headingFour">
                                        <button class="btn btn-link btn-link-accordion collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                            <h4 class="font-heading-primary mb-0">History</h4>
                                        </button>
                                    </div>

                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                        data-parent="#accordionExample">
                                        <div class="card-body">

                                            <div class="container-fluid">
                                                <div class="row">

                                                    <?php ## Datatables ## ?>
                                                    <div class="card col-12 shadow mb-4">
                                                        <div class="card-body">
                                                            <div class="table-responsive p-1">
                                                                <table class="table table-bordered" id="dataTable"
                                                                    width="100%" cellspacing="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Project Name</th>
                                                                            <th>Agent Name</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>Project Name</th>
                                                                            <th>Agent Name</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                    <tbody>
                                                                        <?php foreach($project as $key=>$row) : ?>
                                                                        <?php if($row['employer_id'] == $user['id']  && ($row['status'] == '4' OR $row['status'] == '-1' OR $row['status'] == '-99')): ?>
                                                                        <tr>
                                                                            <td><?= $row['project_name']; ?></td>
                                                                            <td><?= $developer[$key]['name']; ?></td>
                                                                            <td
                                                                                class="text-<?= $row['color'] ?> font-weight-600">
                                                                                <?= $row['status_desc']; ?></td>
                                                                        </tr>
                                                                        <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php ## END OF HISTORY ## ?>

                            </div>
                        </div>
                        <?php ## END OF EMPLOYER TAB ## ?>



                        <?php ## AGENT TAB ## ?>
                        <div class="tab-pane" id="agent">
                            <div class="accordion" id="accordionExample2">

                                <?php ## PROJECT REQUEST ## ?>
                                <div class="card">
                                    <div class="card-header" id="requested_project">
                                        <button class="btn btn-link btn-link-accordion" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <h4 class="font-heading-primary mb-0">Project Request</h4>
                                        </button>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="requested_project"
                                        data-parent="#accordionExample2">
                                        <div class="card-body">

                                            <div class="container">
                                                <div class="row">

                                                    <?php foreach ($project as $key=>$row): ?>
                                                    <?php if($row['agent_id'] == $user['id'] && ($row['status'] != 2 && $row['status'] != 4 && $row['status'] != -4 && $row['status'] != -1 && $row['status'] != -99)): ?>
                                                    <?php $countRequestedAgent++; ?>
                                                    <div class="col-6 card-deck mx-auto">
                                                        <div class="card shadow-sm mb-3">
                                                            <div class="row no-gutters">

                                                                <div class="col-md-12">
                                                                    <div class="card-body">
                                                                        <h6
                                                                            class="card-text badge badge-pill badge-primary p-2">
                                                                            <?= $row['job_category']; ?></h6>
                                                                        <h5 class="card-text">
                                                                            <?= $row['project_name']; ?>
                                                                        </h5>
                                                                        <p><?= $row['description']; ?></p>
                                                                        <br>

                                                                        <p class="card-text font-primary mb-1">Project
                                                                            From
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

                                                                                <h6>Bid:
                                                                                    <?php
                                                                                setlocale(LC_MONETARY, 'en_US');
                                                                                echo "IDR " . number_format($row['bid'], 0, '', '.');
                                                                            ?>
                                                                                </h6>

                                                                                <p
                                                                                    class="badge badge-<?= $row['color'] ?>">
                                                                                    <?= $row['status_desc_agent'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>

                                                                        <?php if($row['status'] == 0) : ?>
                                                                        <div class="row justify-content-center">
                                                                            <a href="<?= base_url('user/updateProjectStatus/1/' . $row['project_id'] . '/') ?>"
                                                                                class="btn btn-primary mx-1"
                                                                                role="button"
                                                                                style="width:7rem; margin-top:1rem;">Accept</a>

                                                                            <a href="<?= base_url('user/updateProjectStatus/-1/' . $row['project_id'] . '/') ?>"
                                                                                class="btn btn-danger mx-1"
                                                                                role="button"
                                                                                style="width:7rem; margin-top:1rem;">Refuse</a>
                                                                        </div>
                                                                        <?php endif; ?>

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
                                                                    <h6 class="card-text text-center">No Project Request
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
                                <?php ## END OF PROJECT REQUEST ## ?>


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
                                        data-parent="#accordionExample2">
                                        <div class="card-body">

                                            <div class="container">
                                                <div class="row">

                                                    <?php foreach ($project as $key=>$row): ?>
                                                    <?php if($row['agent_id'] == $user['id'] && $row['status'] == 2): ?>
                                                    <?php $countOngoingAgent++; ?>
                                                    <div class="col-6 card-deck mx-auto">
                                                        <div class="card shadow-sm mb-3">
                                                            <div class="row no-gutters">

                                                                <div class="col-md-12">
                                                                    <div class="card-body">
                                                                        <h6
                                                                            class="card-text badge badge-pill badge-primary p-2">
                                                                            <?= $row['job_category']; ?></h6>
                                                                        <h5 class="card-text">
                                                                            <?= $row['project_name']; ?>
                                                                        </h5>
                                                                        <br>

                                                                        <p class="card-text font-primary mb-1">Project
                                                                            From
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
                                                                                <p
                                                                                    class="badge badge-<?= $row['color'] ?>">
                                                                                    <?= $row['status_desc_agent'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row justify-content-center">
                                                                            <a class="btn btn-primary"
                                                                                href="<?= base_url('user/updateProjectStatus/3/' . $row['project_id'] . '/') ?>">Finish</a>
                                                                        </div>

                                                                        <div>
                                                                            <p class="card-text text-center mt-3">
                                                                                Contact your agent if
                                                                                there's a problem:</p>

                                                                            <?php if($employer[$key]['line']!=null){?>
                                                                            <h6><i class="fab fa-line"></i>
                                                                                <?php echo ' : '. $employer[$key]['line']; ?>
                                                                            </h6>
                                                                            <?php } ?>
                                                                            <h6><i
                                                                                    class="fas fa-phone"></i><?php echo ' : '. $employer[$key]['phone']; ?>
                                                                            </h6>
                                                                            <h6 style="font-size:0.80rem;"><i
                                                                                    class="fas fa-at"></i><?php echo ' : '. $employer[$key]['email']; ?>
                                                                            </h6>
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
                                <?php ## END OF ON GOING PROJECTS ## ?>


                                <?php ## FINISHED PROJECT ## ?>
                                <div class="card">
                                    <div class="card-header" id="finished_project">
                                        <button class="btn btn-link btn-link-accordion" type="button"
                                            data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
                                            aria-controls="collapseFour">
                                            <h4 class="font-heading-primary mb-0">Finished Project</h4>
                                        </button>
                                    </div>

                                    <div id="collapseFour" class="collapse" aria-labelledby="finished_project"
                                        data-parent="#accordionExample2">
                                        <div class="card-body">

                                            <div class="container">
                                                <div class="row">

                                                    <?php foreach ($project as $key=>$row): ?>
                                                    <?php if($row['agent_id'] == $user['id'] && ($row['status'] == 4 OR $row['status'] == -1 OR $row['status'] == -99)): ?>
                                                    <?php $countFinishedAgent++; ?>
                                                    <div class="col-6 card-deck mx-auto">
                                                        <div class="card shadow-sm mb-3">
                                                            <div class="row no-gutters">

                                                                <div class="col-md-12">
                                                                    <div class="card-body">
                                                                        <h6
                                                                            class="card-text badge badge-pill badge-primary p-2">
                                                                            <?= $row['job_category']; ?></h6>
                                                                        <h5 class="card-text">
                                                                            <?= $row['project_name']; ?>
                                                                        </h5>
                                                                        <p><?= $row['description']; ?></p>
                                                                        <br>

                                                                        <p class="card-text font-primary mb-1">Project
                                                                            From
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

                                                                                <h6>Bid:
                                                                                    <?php
                                                                                setlocale(LC_MONETARY, 'en_US');
                                                                                echo "IDR " . number_format($row['bid'], 0, '', '.');
                                                                            ?>
                                                                                </h6>

                                                                                <p
                                                                                    class="badge badge-<?= $row['color'] ?>">
                                                                                    <?= $row['status_desc_agent'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>
                                                    <?php endforeach ?>

                                                    <?php if($countFinishedAgent<= 0): ?>
                                                    <div class="card shadow-sm mb-3 ml-3 col-lg-12 mx-auto">
                                                        <div class="row no-gutters">

                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <h6 class="card-text text-center">No Finished
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
                                <?php ## END OF FINISHED PROJECT ## ?>

                            </div>
                        </div>
                        <?php ## END OF AGENT TAB ## ?>

                    </div>
                </div>
                <?php ## END OF TAB ## ?>

            </div>
        </div>
    </div>
    <?php ## END OF MAIN CARD ## ?>

</div>
<?php ## END OF PAGE CONTENT ?>

</div>
<?php ## END MAIN CONTENT ## ?>