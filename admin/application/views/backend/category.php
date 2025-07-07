<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Last Edit</th>
                            <?php if(array_search('category_edit',$this->role_list) !== false || array_search($delrole,$this->role_list) !== false) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; 
                        if($current_url == $viewurl) { 
                        foreach($AllDatas as $AllData) { ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$AllData->cat_title?></td>
                            <td><?=$AllData->cat_slug?></td>
                            <td><?=date('d M, Y (h:i A) ', strtotime($AllData->edit_date));?></td>
                            <?php if(array_search('category_edit',$this->role_list) !== false || array_search($delrole,$this->role_list) !== false) { ?>
                            <td>
                                <a class="btn btn-outline-info waves-effect waves-light" href="#" target="_blank"><i class="uil-eye"></i></a>
                                <?php if(array_search('category_edit',$this->role_list) !== false) { ?>
                                <a class="btn btn-outline-success waves-effect waves-light" href="<?=site_url('backend/EditCategory/'.$AllData->id.'/')?>"><i class="uil-edit"></i></a>
                                <?php } if(array_search($delrole,$this->role_list) !== false) { ?>
                                <button type="button" class="btn btn-outline-danger waves-effect waves-light" onClick="delFunction(<?=$AllData->id;?>);"><i class="uil-trash-alt"></i></button>
                                <?php } ?>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; } } else if($current_url == $trashurl) {
                        foreach($TrashDatas as $AllData) { ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$AllData->cat_title?></td>
                            <td><?=$AllData->cat_slug?></td>
                            <td><?=date('d M, Y (h:i A) ', strtotime($AllData->edit_date));?></td>
                            <td>
                                <button type="button" class="btn btn-outline-success waves-effect waves-light" onClick="revFunction(<?=$AllData->id;?>);"><i class="uil-corner-up-left"></i></button>
                                <button type="button" class="btn btn-outline-danger waves-effect waves-light" onClick="delpFunction(<?=$AllData->id;?>);"><i class="uil-trash-alt"></i></button>
                            </td>
                        </tr>
                        <?php $i++; } } ?>
                    </tbody>
                    <tfooter>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Last Edit</th>
                            <?php if(array_search('category_edit',$this->role_list) !== false || array_search($delrole,$this->role_list) !== false) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </tfooter>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<script>
    function delFunction(pageid) {
        $.ajax({
            type: "POST",
            url: '<?=site_url('category_controller/CategoryTrash')?>',
            data : {"id" : pageid},
            beforeSend: function(){
                $(".card").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
            },
            success: function(response) {
                if(response == 'true') {
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
            url: '<?=site_url('category_controller/CategoryTrashReverse')?>',
            data : {"id" : pageid},
            beforeSend: function(){
                $(".card").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
            },
            success: function(response) {
                if(response == 'true') {
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
            url: '<?=site_url('category_controller/CategoryTrashPerma')?>',
            data : {"id" : pageid},
            beforeSend: function(){
                $(".card").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
            },
            success: function(response) {
                if(response == 'true') {
                    location.reload();
                } else {
                    $(".card .preloaderremove").remove();
                }
            }
        });
    }
</script>
