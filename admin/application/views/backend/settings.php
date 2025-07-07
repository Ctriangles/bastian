<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Last Edit</th>
                            <?php if(array_search('website_settings_edit',$this->role_list) !== false || array_search('website_settings_delete',$this->role_list) !== false) { ?>
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
                            <td>
                                <?=($AllData->setting_name=='site_logo')?'Logo':''?>
                                <?=($AllData->setting_name=='site_whitelogo')?'White Logo':''?>
                                <?=($AllData->setting_name=='site_otherlogo')?'Other Logo':''?>
                                <?=($AllData->setting_name=='site_favicon')?'Favicon Icon':''?>
                                <?=($AllData->setting_name=='site_phone')?'Phone':''?>
                                <?=($AllData->setting_name=='site_landline')?'Landline Number':''?>
                                <?=($AllData->setting_name=='site_email')?'Email':''?>
                                <?=($AllData->setting_name=='site_emailfrom')?'Email From':''?>
                                <?=($AllData->setting_name=='site_emailto')?'Email To':''?>
                                <?=($AllData->setting_name=='site_address')?'Address':''?>
                                <?=($AllData->setting_name=='copyright')?'Copyrights':''?>
                                <?=($AllData->setting_name=='site_title')?'Website Title':''?>
                                <?=($AllData->setting_name=='site_facebook')?'Facebook':''?>
                                <?=($AllData->setting_name=='site_linkedin')?'Linkedin':''?>
                                <?=($AllData->setting_name=='site_twitter')?'Twitter':''?>
                                <?=($AllData->setting_name=='site_youtube')?'YouTube':''?>
                                <?=($AllData->setting_name=='site_whatsapp')?'WhatsApp':''?>
                                <?=($AllData->setting_name=='site_instagram')?'Instagram':''?>
                                <?=($AllData->setting_name=='site_skype')?'Skype':''?>
                                <?=($AllData->setting_name=='site_insta_access')?'Instagram Access Token':''?>
                                <?=($AllData->setting_name=='site_insta_followers')?'Instagram Followers':''?>
                                <?=($AllData->setting_name=='site_insta_following')?'Instagram Following':''?>
                            </td>
                            <td><?php if($AllData->setting_name == 'site_logo' || $AllData->setting_name == 'site_otherlogo' || $AllData->setting_name == 'site_favicon') { ?>
                                    <img src="<?=site_url($AllData->setting_value)?>" style="width:30% !important"> 
                                <?php } else { ?> 
                                    <?php echo $shortctn = strip_tags(substr($AllData->setting_value, 0, 70)); ?>
                                <?php } ?></td>
                            <td><?=date('d M, Y (h:i A) ', strtotime($AllData->edit_date));?></td>
                            <?php if(array_search('website_settings_edit',$this->role_list) !== false || array_search('website_settings_delete',$this->role_list) !== false) { ?>
                            <td>
                                <?php if(array_search('website_settings_edit',$this->role_list) !== false) { ?>
                                    <a class="btn btn-outline-success waves-effect waves-light" href="<?=site_url('backend/EditSettings/'.$AllData->id.'/')?>"><i class="uil-edit"></i></a>
                                <?php } if(array_search('website_settings_delete',$this->role_list) !== false) { ?>
                                <button type="button" class="btn btn-outline-danger waves-effect waves-light" onClick="delFunction(<?=$AllData->id;?>);"><i class="uil-trash-alt"></i></button>
                                <?php } ?>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; } } else if($current_url == $trashurl) { 
                        foreach($TrashDatas as $AllData) { ?>
                        <tr>
                            <td><?=$i?></td>
                            <td>
                                <?=($AllData->setting_name=='site_logo')?'Logo':''?>
                                <?=($AllData->setting_name=='site_whitelogo')?'White Logo':''?>
                                <?=($AllData->setting_name=='site_otherlogo')?'Other Logo':''?>
                                <?=($AllData->setting_name=='site_favicon')?'Favicon Icon':''?>
                                <?=($AllData->setting_name=='site_phone')?'Phone':''?>
                                <?=($AllData->setting_name=='site_landline')?'Landline Number':''?>
                                <?=($AllData->setting_name=='site_email')?'Email':''?>
                                <?=($AllData->setting_name=='site_emailfrom')?'Email From':''?>
                                <?=($AllData->setting_name=='site_emailto')?'Email To':''?>
                                <?=($AllData->setting_name=='site_address')?'Address':''?>
                                <?=($AllData->setting_name=='copyright')?'Copyrights':''?>
                                <?=($AllData->setting_name=='site_title')?'Website Title':''?>
                                <?=($AllData->setting_name=='site_facebook')?'Facebook':''?>
                                <?=($AllData->setting_name=='site_linkedin')?'Linkedin':''?>
                                <?=($AllData->setting_name=='site_twitter')?'Twitter':''?>
                                <?=($AllData->setting_name=='site_youtube')?'YouTube':''?>
                                <?=($AllData->setting_name=='site_whatsapp')?'WhatsApp':''?>
                                <?=($AllData->setting_name=='site_instagram')?'Instagram':''?>
                                <?=($AllData->setting_name=='site_skype')?'Skype':''?>
                            </td>
                            <td><?php if($AllData->setting_name == 'site_logo' || $AllData->setting_name == 'site_whitelogo' || $AllData->setting_name == 'site_otherlogo' || $AllData->setting_name == 'site_favicon'){echo '<img src="'.site_url($AllData->setting_value).'" width="200px">';} else {echo $AllData->setting_value;}?></td>
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
                            <th>Name</th>
                            <th>Value</th>
                            <th>Last Edit</th>
                            <?php if(array_search('website_settings_edit',$this->role_list) !== false || array_search('website_settings_delete',$this->role_list) !== false) { ?>
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
            url: '<?=site_url('setting_controller/SettingTrash')?>',
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
            url: '<?=site_url('setting_controller/SettingTrashReverse')?>',
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
            url: '<?=site_url('setting_controller/SettingTrashPerma')?>',
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
