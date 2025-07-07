<form id="add_settings">
   <div class="row">
      <div class="col-9">
         <div class="card">
            <div class="card-body">
                <p class="text-center" id="errormessages"></p>
               <div class="mb-3 row">
                  <label class="col-md-2 col-form-label">Setting Name</label>
                  <div class="col-md-12">
                     <input type="hidden" name="id" value="<?php if(isset($editdata)){echo $editdata->id ? $editdata->id : '' ;}else {echo '' ;}?>" >
                     <select class="form-select select2" id="sitesetting" name="setting_name">
                        <option value="">Select Name</option>
                        <option value="site_logo" <?php if(isset($editdata)){ if($editdata->setting_name =="site_logo"){echo "selected" ;}}?>>Logo</option>
                        <option value="site_whitelogo" <?php if(isset($editdata)){ if($editdata->setting_name =="site_whitelogo"){echo "selected" ;}}?>>White Logo</option>
                        <option value="site_otherlogo" <?php if(isset($editdata)){ if($editdata->setting_name =="site_otherlogo"){echo "selected" ;}}?>>Other Logo</option>
                        <option value="site_favicon" <?php if(isset($editdata)){ if($editdata->setting_name =="site_favicon"){echo "selected" ;}}?>>Favicon Icon</option>
                        <option value="site_phone" <?php if(isset($editdata)){ if($editdata->setting_name =="site_phone"){echo "selected" ;}}?> >Phone</option>
                        <option value="site_email" <?php if(isset($editdata)){ if($editdata->setting_name =="site_email"){echo "selected" ;}}?> >Email</option>
                        <option value="site_emailfrom" <?php if(isset($editdata)){ if($editdata->setting_name =="site_emailfrom"){echo "selected" ;}}?> >Email From</option>
                        <option value="site_emailto" <?php if(isset($editdata)){ if($editdata->setting_name =="site_emailto"){echo "selected" ;}}?> >Email To</option>
                        <option value="site_address" <?php if(isset($editdata)){ if($editdata->setting_name =="site_address"){echo "selected" ;}}?> >Address</option>
                        <option value="copyright" <?php if(isset($editdata)){ if($editdata->setting_name =="copyright"){echo "selected" ;}}?> >Copyright</option>
                        <option value="site_title" <?php if(isset($editdata)){ if($editdata->setting_name =="site_title"){echo "selected" ;}}?> >Title</option>
                        <option value="site_facebook" <?php if(isset($editdata)){ if($editdata->setting_name =="site_facebook"){echo "selected" ;}}?> >Facebook</option>
                        <option value="site_linkedin" <?php if(isset($editdata)){ if($editdata->setting_name =="site_linkedin"){echo "selected" ;}}?>>Linkedin</option>
                        <option value="site_twitter" <?php if(isset($editdata)){ if($editdata->setting_name =="site_twitter"){echo "selected" ;}}?> >Twitter</option>
                        <option value="site_youtube" <?php if(isset($editdata)){ if($editdata->setting_name =="site_youtube"){echo "selected" ;}}?> >YouTube</option>
                        <option value="site_whatsapp" <?php if(isset($editdata)){ if($editdata->setting_name =="site_whatsapp"){echo "selected" ;}}?> >WhatsApp</option>
                        <option value="site_instagram" <?php if(isset($editdata)){ if($editdata->setting_name =="site_instagram"){echo "selected" ;}}?> >instagram</option>
                        <option value="site_insta_access" <?php if(isset($editdata)){ if($editdata->setting_name =="site_insta_access"){echo "selected" ;}}?> >Instagram Access Token</option>
                        <option value="site_insta_followers" <?php if(isset($editdata)){ if($editdata->setting_name =="site_insta_followers"){echo "selected" ;}}?> >Instagram Followers</option>
                        <option value="site_insta_following" <?php if(isset($editdata)){ if($editdata->setting_name =="site_insta_following"){echo "selected" ;}}?> >Instagram Following</option>
                     </select>
                  </div>
               </div>
               <div class="mb-3 row" id="setting_value">
                  <label for="example-text-input" class="col-md-2 col-form-label">Setting Value</label>
                  <div class="col-md-12">
                     <input class="form-control" name="setting_value" type="text" value="<?php if(isset($editdata)){echo $editdata->setting_value ? $editdata->setting_value : '';}?>" id="example-text-input">
                  </div>
               </div>
               <div class="mb-3 row" id="file_logo">
                  <label for="logo" class="col-md-2 col-form-label">Setting Value</label>
                  <div class="col-md-12">
                     <input type="file" name="filelogo" >
                     <?php if(isset($editdata->setting_value) && $editdata->setting_name == "site_logo") {?> <img src="<?=site_url($editdata->setting_value); ?>" style="width:20% !important"><?php }  ?>
                     <?php if(isset($editdata->setting_value) && $editdata->setting_name == "site_otherlogo") {?> <img src="<?=site_url($editdata->setting_value); ?>" style="width:20% !important"><?php }  ?>
                     <?php if(isset($editdata->setting_value) && $editdata->setting_name == "site_whitelogo") {?> <img src="<?=site_url($editdata->setting_value); ?>" style="width:20% !important"><?php }  ?>
                     <?php if(isset($editdata->setting_value) && $editdata->setting_name == "site_favicon") {?> <img src="<?=site_url($editdata->setting_value); ?>" style="width:20% !important"><?php }  ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end col -->
      <div class="col-3">
         <div class="card">
            <div class="card-body">
               <h4 class="card-title">Attributes</h4>
               <hr>
               <div class="mt-4">
                  <button type="submit" class="btn btn-primary w-md">Submit</button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end row -->
</form>