<div class="row">
   <?php if(in_array('pages',$this->role_list) !== false) { ?>
   <div class="col-md-6 col-xl-3">
      <div class="card">
         <div class="card-body">
            <div class="float-end mt-2">
               <div id=""><i class="uil-file-check-alt"></i></div>
            </div>
            <div>
               <a href="<?=site_url('backend/pages')?>">
                  <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?=count($totalpages)?></span></h4>
                  <p class="text-muted mb-0">Total Pages</p>
               </a>
            </div>
         </div>
      </div>
   </div>
   <?php } 
   if(in_array('blog',$this->role_list) !== false) { ?>
   <div class="col-md-6 col-xl-3">
      <div class="card">
         <div class="card-body">
            <div class="float-end mt-2">
               <div id=""><i class="uil-book-open"></i></div>
            </div>
            <div>
               <a href="<?=site_url('backend/blog')?>">
                  <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?=count($totalblog)?></span></h4>
                  <p class="text-muted mb-0">Total Blog</p>
               </a>
            </div>
         </div>
      </div>
   </div>
   <?php } 
   if(in_array('users',$this->role_list) !== false) { ?>
   <div class="col-md-6 col-xl-3">
      <div class="card">
         <div class="card-body">
            <div class="float-end mt-2">
               <div id=""><i class="uil-users-alt"></i></div>
            </div>
            <div>
               <a href="<?=site_url('backend/users')?>">
                  <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?=count($totalusers)?></span></h4>
                  <p class="text-muted mb-0">Total Users</p>
               </a>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>
</div>