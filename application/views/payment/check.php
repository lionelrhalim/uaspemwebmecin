<!-- Begin Page Content -->
<div class="container-fluid" style="margin-top:80px; padding-top:20px;">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Check Payment</h1>
    <p class="mb-4">
        Incoming payment to check.<br>
        Press <i class="fas fa-check"></i> if done checking.<br>
        Press <i class="fas fa-times"></i> if there is a mistake.
    </p>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">MECIN.AN - Incoming Transfer</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive p-1">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <?php foreach($payment[0] as $key=>$value) : ?>
                            <th><?= $key ?></th>
                            <?php endforeach; ?>
                            <th>Check</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <?php foreach($payment[0] as $key=>$value) : ?>
                            <th><?= $key ?></th>
                            <?php endforeach; ?>
                            <th>Check</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($payment as $key=>$value) : ?>
                        <tr>
                            <td><?= $value['ID']; ?></td>
                            <td><?= $value['Project ID']; ?></td>
                            <td>Rp <?= number_format(intval($value['Ammount'])); ?></td>
                            <td><?= $value['Bank ID']; ?></td>
                            <td><?= $value['Emp ID']; ?></td>
                            <td><?= $value['Agt ID']; ?></td>
                            <td><?= $value['Status']; ?></td>
                            <?php if($value['Status'] == 0) : ?>
                            <td>
                                <a href="process_check?pck_id=<?= $value['ID']; ?>&set=1"
                                    class="btn btn-success" role="button"><i class="fas fa-check"></i></a>
                                <a href="process_check?pck_id=<?= $value['ID']; ?>&set=2"
                                    class="btn btn-danger" role="button"><i class="fas fa-times"></i></a>
                            </td>
                            <?php else: ?>
                            <td>DONE</td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->