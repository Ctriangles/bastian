<?php if(in_array('smtp_edit',$this->role_list) !== false) { ?>
<form id="smtpupdate">
<?php } ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="col-form-label" for="smtp_service">Protocol</label>
                                <input type="hidden" name="id" value="<?php if(isset($editdata)){echo $editdata->id ? $editdata->id : '' ;}else {echo '' ;}?>" >
                                <select class="form-select" name="smtp_service" id="smtp_service">
                                    <option value="">Select Protocol</option>
                                    <option value="mail" <?php if(isset($editdata)){if($editdata->smtp_service == 'mail'){echo 'selected';}}?>>Mail</option>
                                    <option value="smtp" <?php if(isset($editdata)){if($editdata->smtp_service == 'smtp'){echo 'selected';}}?>>SMTP</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="col-form-label" for="smtp_crypto">Crypto</label>
                                <select class="form-select" name="smtp_crypto" id="smtp_crypto">
                                    <option value="">Select Crypto</option>
                                    <option value="ttl" <?php if(isset($editdata)){if($editdata->smtp_crypto == 'ttl'){echo 'selected';}}?>>TTL</option>
                                    <option value="ssl" <?php if(isset($editdata)){if($editdata->smtp_crypto == 'ssl'){echo 'selected';}}?>>SSL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="col-form-label" for="mail_type">Mail Type</label>
                                <select class="form-select" name="mail_type" id="mail_type">
                                    <option value="">Select Mail Type</option>
                                    <option value="text" <?php if(isset($editdata)){if($editdata->mail_type == 'text'){echo 'selected';}}?>>Text</option>
                                    <option value="html" <?php if(isset($editdata)){if($editdata->mail_type == 'html'){echo 'selected';}}?>>HTML</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="col-form-label" for="mail_port">Mail Port</label>
                                <input class="form-control" name="mail_port" type="text" value="<?php if(isset($editdata)){echo $editdata->mail_port ? $editdata->mail_port : '' ;}?>" id="mail_port">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label" for="mail_host">Mail Host</label>
                                <input class="form-control" name="mail_host" type="text" value="<?php if(isset($editdata)){echo $editdata->mail_host ? $editdata->mail_host : '' ;}?>" id="mail_host" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label" for="mail_username">Mail Username</label>
                                <input class="form-control" name="mail_username" type="text" value="<?php if(isset($editdata)){echo $editdata->mail_username ? $editdata->mail_username : '' ;}?>" id="mail_username" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="col-form-label" for="mail_password">Mail Password</label>
                                <input class="form-control" name="mail_password" type="password" value="<?php if(isset($editdata)){echo $editdata->mail_password ? $editdata->mail_password : '' ;}?>" id="mail_password" required>
                                <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                            </div>
                        </div>
                    </div>
                    <?php if(in_array('smtp_edit',$this->role_list) !== false) { ?>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-md">Update</button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row --> 
<?php if(in_array('smtp_edit',$this->role_list) !== false) { ?>
</form>
<?php } ?>