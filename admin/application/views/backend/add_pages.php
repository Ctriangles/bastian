    <form id="add_page">
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <p class="text-center" id="errormessages"></p>
                <div class="mb-3 row">
                    <label for="post_title" class="col-md-12 col-form-label">Page Title</label>
                    <div class="col-md-12">
                        <input type="hidden" name="id" value="<?php if(isset($editdata)){echo $editdata->id ? $editdata->id : '' ;}?>" >
                        <input type="text" name="post_title" id="post_title" value="<?php if(isset($editdata)){echo $editdata->post_title?$editdata->post_title:'';}?>" class="form-control" onblur="myFunction()">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="post_slug" class="col-md-12 col-form-label">Page URL</label>
                    <div class="col-md-12">
                        <input type="text" name="post_slug" id="post_slug" value="<?php if(isset($editdata)){echo $editdata->post_slug?$editdata->post_slug:'';}?>" class="form-control">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="post_content" class="col-md-12 col-form-label">Page Content</label>
                    <div class="col-md-12">
                        <textarea cols="40" id="post_content" name="post_content" rows="12" style="width:100px;"><?php if(isset($editdata)){echo $editdata->post_content ? $editdata->post_content : '';}?></textarea>
                        <script type="text/javascript">
                            CKEDITOR.replace( 'post_content',
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
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><b>SEO Data</b></button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="mb-3 row">
                                                <label for="meta_title" class="col-md-12 col-form-label">Meta Title</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="meta_title" id="meta_title" value="<?php if(isset($editdata)){echo $editdata->meta_title?$editdata->meta_title:'';}?>" class="form-control" oninput="metaTitle()">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="meta_keywords" class="col-md-12 col-form-label">Meta Keyword</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="meta_keywords" id="meta_keywords" value="<?php if(isset($editdata)){echo $editdata->meta_keywords?$editdata->meta_keywords:'';}?>" class="form-control" data-role="tagsinput">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="meta_description" class="col-md-12 col-form-label">Meta Description</label>
                                                <div class="col-md-12">
                                                    <textarea rows="4" name="meta_description" id="meta_description" class="form-control" oninput="metaDescription()"><?php if(isset($editdata)){echo $editdata->meta_description?$editdata->meta_description:'';}?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body metadisplays">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <img src="<?=(!empty(@$this->site_favicon))?site_url(@$this->site_favicon):''?>" alt="<?=@$this->site_title?>">
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p><b><?=@$this->site_title?></b></p>
                                                            <small><?=str_replace(['https://', 'http://'], '', site_url());?> > <span id="pageslug"><?php if(isset($editdata)){echo $editdata->post_slug?$editdata->post_slug:'';}?></span></small>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="metatitlearea mt-2">
                                                                <p id="metatitle"><?php if(isset($editdata)){echo $editdata->meta_title?$editdata->meta_title:'';}?></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="metadisarea mt-2">
                                                                <p id="metadiscriptions"><?php if(isset($editdata)){echo $editdata->meta_description?$editdata->meta_description:'';}?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                <div class="mb-3 row">
                    <label for="parent_post" class="col-md-12 col-form-label">Parent Page</label>
                    <div class="col-md-12">
                        <select class="form-select select2" id="parent_post" name="parent_post">
                            <option value="">Select Page</option>
                            <?php $result['pages'] = $this->post_model->viewpages();
                            foreach($result['pages'] as $postpages) { ?>
                            <option value="<?=$postpages->id?>"<?php if(isset($editdata)){ if($postpages->id ==$editdata->parent_post){echo "selected" ;}}?>><?=$postpages->post_title?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="for-status" class="col-md-12 col-form-label">Featured Image</label>
                    <div class="col-md-12">
                        <input id="imgpath" type="hidden" name="featured_img" value="<?php if(isset($editdata)){echo $editdata->featured_img ? $editdata->featured_img : '';}?>" style="width:60%"/>
                        <button id="imgbutton" type="button" class="form-control">Browse Image</button>
                        <span id="imgsrc" > <?php if(isset($editdata->featured_img) && $editdata->featured_img != "") {?> <img src="<?php echo site_url(); ?><?=$editdata->featured_img?>" style="width:100% !important"><?php }  ?> </span>
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
    <script>
    function myFunction() {
        var x = document.getElementById("post_title"); 
        var y = document.getElementById("post_slug"); 
        var z = document.getElementById("pageslug"); 
        var myval = x.value.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-');
        y.value = myval;
        z.textContent = myval;
        }
    </script>
    <script>
    function metaTitle() {
        var x = document.getElementById("meta_title"); 
        var y = document.getElementById("metatitle");  
        var myval = x.value;
        y.textContent = myval;
        }
    function metaDescription() {
        var x = document.getElementById("meta_description"); 
        var y = document.getElementById("metadiscriptions");  
        var myval = x.value;
        y.textContent = myval;
        }
    </script>
