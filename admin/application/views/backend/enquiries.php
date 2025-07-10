<div class="row align-items-center mb-3">
    <div class="col">
        <form method="get" action="<?= site_url('backend/enquiries') ?>" class="d-flex align-items-center">
            <div class="me-2">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="<?= set_value('start_date', $_GET['start_date'] ?? '') ?>">
            </div>
            <div class="me-2">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="<?= set_value('end_date', $_GET['end_date'] ?? '') ?>">
            </div>
            <div class="me-2">
                <button type="submit" class="btn btn-success mt-4">Filter</button>
            </div>
            <div>
                <a href="<?= site_url('backend/enquiries') ?>" class="btn btn-secondary mt-4">Clear Filter</a>
            </div>
        </form>
    </div>

    <div class="col-auto mt-4">
        <a href="<?= site_url('post_controller/EnquiriesExport') ?>?start_date=<?= $_GET['start_date'] ?? '' ?>&end_date=<?= $_GET['end_date'] ?? '' ?>"
            class="btn btn-primary waves-effect waves-light">
            Export In CSV
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Restaurant</th>
                            <th>Booking Date & Time</th>
                            <th>Added Date</th>
                            <?php if (array_search('enquiry_delete', $this->role_list) !== false) { ?>
                                <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        if ($current_url == $viewurl) {
                            foreach ($AllDatas as $AllData) { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $AllData->full_name ?></td>
                                    <td><?= $AllData->contact_number ?></td>
                                   <!-- <td><?= ($AllData->restaurant_id == '43383004') ? 'Bastian At The Top' : '' ?>
                                        <?= ($AllData->restaurant_id == '98725763') ? 'Bastian Bandra' : '' ?>
                                        <?= ($AllData->restaurant_id == '51191537') ? 'Inka By Bastian' : '' ?>
                                        <?= ($AllData->restaurant_id == '10598428') ? 'Bastian Empire (Pune)' : '' ?>
                                        <?= ($AllData->restaurant_id == '92788130') ? 'Bastian Garden City (Bengaluru)' : '' ?>
                                    </td>-->
                                    <td><?= !empty($AllData->restaurant_name) ? $AllData->restaurant_name : 'Unknown Restaurant' ?></td>
                                    <td><?= date('d M, Y', strtotime($AllData->booking_date)) . ' ' . date('(h:i A)', strtotime($AllData->booking_time)) ?></td>
                                    <td><?= date('d M, Y (h:i A) ', strtotime($AllData->edit_date)); ?></td>
                                    <?php if (array_search('enquiry_delete', $this->role_list) !== false) { ?>
                                        <td>
                                            <?php if (array_search('enquiry_delete', $this->role_list) !== false) { ?>
                                                <button type="button" class="btn btn-outline-danger waves-effect waves-light" onClick="delFunction(<?= $AllData->id; ?>);"><i class="uil-trash-alt"></i></button>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php $i++;
                            }
                        } else if ($current_url == $trashurl) {
                            foreach ($TrashDatas as $AllData) { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $AllData->full_name ?></td>
                                    <td><?= $AllData->contact_number ?></td>
                                    <td><?= ($AllData->restaurant_id == '43383004') ? 'Bastian At The Top' : '' ?>
                                        <?= ($AllData->restaurant_id == '98725763') ? 'Bastian Bandra' : '' ?>
                                        <?= ($AllData->restaurant_id == '51191537') ? 'Inka By Bastian' : '' ?>
                                        <?= ($AllData->restaurant_id == '10598428') ? 'Bastian Empire (Pune)' : '' ?>
                                        <?= ($AllData->restaurant_id == '92788130') ? 'Bastian Garden City (Bengaluru)' : '' ?>
                                    </td>
                                    <td><?= date('d M, Y', strtotime($AllData->booking_date)) . ' ' . date('(h:i A)', strtotime($AllData->booking_time)) ?></td>
                                    <td><?= date('d M, Y (h:i A) ', strtotime($AllData->edit_date)); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success waves-effect waves-light" onClick="revFunction(<?= $AllData->id; ?>);"><i class="uil-corner-up-left"></i></button>
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light" onClick="delpFunction(<?= $AllData->id; ?>);"><i class="uil-trash-alt"></i></button>
                                    </td>
                                </tr>
                        <?php $i++;
                            }
                        } ?>
                    </tbody>
                    <tfooter>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Restaurant</th>
                            <th>Booking Date & Time</th>
                            <th>Added Date</th>
                            <?php if (array_search('enquiry_delete', $this->role_list) !== false) { ?>
                                <th>Action</th>
                            <?php } ?>
                        </tr>
                    </tfooter>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function delFunction(pageid) {
        $.ajax({
            type: "POST",
            url: '<?= site_url('post_controller/FormTrash') ?>',
            data: {
                "id": pageid
            },
            beforeSend: function() {
                $(".card").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
            },
            success: function(response) {
                if (response == 'true') {
                    location.reload();
                } else {
                    $(".card .preloaderremove").remove();
                }
            }
        });
    }

    function revFunction(pageid) {
        $.ajax({
            type: "POST",
            url: '<?= site_url('post_controller/FormTrashReverse') ?>',
            data: {
                "id": pageid
            },
            beforeSend: function() {
                $(".card").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
            },
            success: function(response) {
                if (response == 'true') {
                    location.reload();
                } else {
                    $(".card .preloaderremove").remove();
                }
            }
        });
    }

    function delpFunction(pageid) {
        $.ajax({
            type: "POST",
            url: '<?= site_url('post_controller/FormTrashPerma') ?>',
            data: {
                "id": pageid
            },
            beforeSend: function() {
                $(".card").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
            },
            success: function(response) {
                if (response == 'true') {
                    location.reload();
                } else {
                    $(".card .preloaderremove").remove();
                }
            }
        });
    }
</script>