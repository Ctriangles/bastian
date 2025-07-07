<form id="add_User">
    <div class="row">
        <div class="col-9">
            <div class="card mb-0">
                <p class="text-center" id="errormessages"></p>
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#about" role="tab">
                            <i class="uil uil-user-circle font-size-20"></i>
                            <span class="d-none d-sm-block">About</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#addresss" role="tab">
                            <i class="uil uil-building font-size-20"></i>
                            <span class="d-none d-sm-block">Address</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                            <i class="uil uil-lock-access font-size-20"></i>
                            <span class="d-none d-sm-block">Password</span>   
                        </a>
                    </li>
                    <?php if(isset($editdata)){ ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#login" role="tab">
                            <i class="uil uil-lock-open-alt font-size-20"></i>
                            <span class="d-none d-sm-block">Login Histroy</span>   
                        </a>
                    </li>
                    <?php } ?>
                </ul>
                <!-- Tab content -->
                <div class="tab-content p-4">
                    <div class="tab-pane active" id="about" role="tabpanel">
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="first_name" class="col-form-label">First Name</label>
                                <input type="hidden" name="id" value="<?php if(isset($editdata)){echo $editdata->id ? $editdata->id : '' ;}?>" >
                                <input type="text" name="first_name" id="first_name" value="<?php if(isset($editdata)){echo $editdata->first_name?$editdata->first_name:'';}?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="col-form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" value="<?php if(isset($editdata)){echo $editdata->last_name?$editdata->last_name:'';}?>" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-3">
                                <label for="username" class="col-form-label">Username</label>
                                <input type="text" name="username" id="username" value="<?php if(isset($editdata)){echo $editdata->username?$editdata->username:'';}?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="user_email" class="col-form-label">Email</label>
                                <input type="email" name="user_email" id="user_email" value="<?php if(isset($editdata)){echo $editdata->user_email?$editdata->user_email:'';}?>" class="form-control">
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="country_code" class="col-form-label">Code</label>
                                        <select class="form-select select2" id="country_code" name="country_code">
                                            <option value="">Select Code</option>
                                            <?php 
                                            $json = file_get_contents(site_url('assets/countries.json')); 
                                            $result['json_decoded'] = json_decode($json); 
                                            foreach($result['json_decoded'] as $json_decoded) { ?>
                                                <option value="<?=$json_decoded->phone?>" <?php if(isset($editdata)){if($editdata->country_code == $json_decoded->phone){echo 'selected';}}?>><?=$json_decoded->phone?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="phone" class="col-form-label">Phone</label>
                                        <input type="text" name="phone" id="phone" value="<?php if(isset($editdata)){echo $editdata->phone?$editdata->phone:'';}?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label for="biography" class="col-form-label">Biography</label>
                                <textarea cols="40" id="biography" name="biography" rows="12" style="width:100px;"><?php if(isset($editdata)){echo $editdata->biography ? $editdata->biography : '';}?></textarea>
                                <script type="text/javascript">
                                    CKEDITOR.replace( 'biography',
                                    {
                                        uiColor: '#f4f6f9',
                                        forcePasteAsPlainText:	true,
                                        filebrowserBrowseUrl : '<?=site_url('public/ckfinder/ckfinder.html')?>',
                                        filebrowserImageBrowseUrl : '<?=site_url('public/ckfinder/ckfinder.html?Type=Images')?>',
                                        filebrowserFlashBrowseUrl : '<?=site_url('public/ckfinder/ckfinder.html?Type=Flash')?>',
                                        filebrowserUploadUrl : '<?=site_url('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files')?>',
                                        filebrowserImageUploadUrl : '<?=site_url('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images')?>',
                                        filebrowserFlashUploadUrl : '<?=site_url('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash')?>',
                                        skin : 'kama'
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="addresss" role="tabpanel">
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label for="address" class="col-form-label">Address</label>
                                <input type="text" name="address" id="address" value="<?php if(isset($editdata)){echo $editdata->address?$editdata->address:'';}?>" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="city" class="col-form-label">City</label>
                                <input type="text" name="city" id="city" value="<?php if(isset($editdata)){echo $editdata->city?$editdata->city:'';}?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="state" class="col-form-label">State</label>
                                <input type="text" name="state" id="state" value="<?php if(isset($editdata)){echo $editdata->state?$editdata->state:'';}?>" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="poster_code" class="col-form-label">Postal Code</label>
                                <input type="text" name="poster_code" id="poster_code" value="<?php if(isset($editdata)){echo $editdata->poster_code?$editdata->poster_code:'';}?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="col-form-label">Country</label>
                                <input type="text" name="country" id="country" value="<?php if(isset($editdata)){echo $editdata->country?$editdata->country:'';}?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="messages" role="tabpanel">
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="password" class="col-form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                                <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                            </div>
                            <div class="col-md-6">
                                <label for="cpassword" class="col-form-label">Confirm Password</label>
                                <input type="password" name="cpassword" id="cpassword" class="form-control">
                                <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($editdata)){ ?>
                    <div class="tab-pane" id="login" role="tabpanel">
                        <h5 class="font-size-16 mb-4">Login History</h5>
                        <div class="table-responsive">
                            <table class="table table-nowrap table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">IP</th>
                                        <th scope="col">Borwser</th>
                                        <th scope="col">OS</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i=1;
                                    foreach($loginhistory as $login) { ?>
                                    <tr>
                                        <th scope="row"><?=$i?></th>
                                        <td><?=$login->login_ip?></td>
                                        <td><?=$login->login_browser?></td>
                                        <td><?=$login->login_os?></td>
                                        <td><?=date('d M, Y (h:i A) ', strtotime($login->login_date));?></td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-3">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title">Attributes</h4>
                <hr>
               <div class="mb-3 row">
                  <label for="user_for" class="col-md-12 col-form-label">User For</label>
                  <div class="col-md-12">
                     <select class="form-select select2" id="user_for" name="user_for">
                        <option value="">Select User for</option>
                        <option value="front" <?php if(isset($editdata)){if($editdata->user_for == 'front'){echo 'selected';}}?>>Front</option>
                        <option value="backend" <?php if(isset($editdata)){if($editdata->user_for == 'backend'){echo 'selected';}}?>>Backend</option>
                     </select>
                  </div>
               </div>
               <div class="mb-3 row" id="user_types">
                  <label for="user_type" class="col-md-12 col-form-label">User Type</label>
                  <div class="col-md-12">
                     <select class="form-select select2" id="user_type" name="user_type">
                        <option value="">Select User Type</option>
                        <?php foreach($userroles as $role) { ?>
                            <option value="<?=$role->id?>" <?php if(isset($editdata)){if($editdata->user_type == $role->id){echo 'selected';}}?>><?=$role->role_name?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="for-status" class="col-md-12 col-form-label">Profile Image</label>
                  <div class="col-md-12">
                     <input id="imgpath" type="hidden" name="user_img" value="<?php if(isset($data['details'])){echo $data['details']->user_img ? $data['details']->user_img : '';}?>" style="width:60%"/>
                     <button id="imgbutton" type="button" class="form-control">Browse Image</button>
                     <span id="imgsrc" > <?php if(isset($data['details']->user_img) && $data['details']->user_img != "") {?> <img src="<?php echo site_url(); ?><?=$data['details']->user_img?>" style="width:100% !important"><?php }  ?> </span>
                  </div>
               </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                </div>
            </div>
            </div>
        </div>
    </div>
   <!-- end row -->
</form>