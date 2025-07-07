<?php if(isset($editdata)){$rolelist = explode(",",@$editdata->roles);}?>
<form id="addRoles">
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <p class="text-center" id="errormessages"></p>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label" for="role_name">Role Name</label>
                        <div class="col-md-12">
                        <input type="hidden" name="id" value="<?php if(isset($editdata)){echo $editdata->id ? $editdata->id : '' ;}else {echo '' ;}?>" >
                        <input class="form-control" name="role_name" type="text" value="<?php if(isset($editdata)){echo $editdata->role_name ? $editdata->role_name : '';}?>" id="role_name" required>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="website_settings" name="roles[]" value="website_settings" <?php if(isset($editdata)){if(array_search('website_settings',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> class="form-check-input parentcheck">
                                <label class="form-check-label" for="website_settings">Global Settings</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="website_settings_add" name="roles[]" <?php if(isset($editdata)){if(array_search('website_settings_add',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="website_settings_add" class="form-check-input childcheck">
                                <label class="form-check-label" for="website_settings_add">Add</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="website_settings_edit" name="roles[]" <?php if(isset($editdata)){if(array_search('website_settings_edit',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="website_settings_edit" class="form-check-input childcheck">
                                <label class="form-check-label" for="website_settings_edit">Edit</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="website_settings_delete" <?php if(isset($editdata)){if(array_search('website_settings_delete',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> name="roles[]" value="website_settings_delete" class="form-check-input childcheck">
                                <label class="form-check-label" for="website_settings_delete">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="smtp" name="roles[]" <?php if(isset($editdata)){if(array_search('smtp',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="smtp" class="form-check-input parentcheck">
                                <label class="form-check-label" for="smtp">SMTP</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="smtp_edit" <?php if(isset($editdata)){if(array_search('smtp_edit',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="smtp_edit" name="roles[]" class="form-check-input childcheck">
                                <label class="form-check-label" for="smtp_edit">Edit</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="smtp_delete" <?php if(isset($editdata)){if(array_search('smtp_delete',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="smtp_delete" name="roles[]" class="form-check-input childcheck">
                                <label class="form-check-label" for="smtp_delete">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="pages" name="roles[]" value="pages" <?php if(isset($editdata)){if(array_search('pages',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> class="form-check-input parentcheck">
                                <label class="form-check-label" for="pages">Pages</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="pages_add" name="roles[]" <?php if(isset($editdata)){if(array_search('pages_add',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="pages_add" class="form-check-input childcheck">
                                <label class="form-check-label" for="pages_add">Add</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="pages_edit" name="roles[]" <?php if(isset($editdata)){if(array_search('pages_edit',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="pages_edit" class="form-check-input childcheck">
                                <label class="form-check-label" for="pages_edit">Edit</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="pages_delete" <?php if(isset($editdata)){if(array_search('pages_delete',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> name="roles[]" value="pages_delete" class="form-check-input childcheck">
                                <label class="form-check-label" for="pages_delete">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="blog" name="roles[]" value="blog" <?php if(isset($editdata)){if(array_search('blog',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> class="form-check-input parentcheck">
                                <label class="form-check-label" for="blog">Blogs</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="blog_add" name="roles[]" <?php if(isset($editdata)){if(array_search('blog_add',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="blog_add" class="form-check-input childcheck">
                                <label class="form-check-label" for="blog_add">Add</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="blog_edit" name="roles[]" <?php if(isset($editdata)){if(array_search('blog_edit',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="blog_edit" class="form-check-input childcheck">
                                <label class="form-check-label" for="blog_edit">Edit</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="blog_delete" <?php if(isset($editdata)){if(array_search('blog_delete',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> name="roles[]" value="blog_delete" class="form-check-input childcheck">
                                <label class="form-check-label" for="blog_delete">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="category" name="roles[]" value="category" <?php if(isset($editdata)){if(array_search('category',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> class="form-check-input parentcheck">
                                <label class="form-check-label" for="category">Blogs Category</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="category_add" name="roles[]" <?php if(isset($editdata)){if(array_search('category_add',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="category_add" class="form-check-input childcheck">
                                <label class="form-check-label" for="category_add">Add</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="category_edit" name="roles[]" <?php if(isset($editdata)){if(array_search('category_edit',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="category_edit" class="form-check-input childcheck">
                                <label class="form-check-label" for="category_edit">Edit</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="category_delete" <?php if(isset($editdata)){if(array_search('category_delete',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> name="roles[]" value="category_delete" class="form-check-input childcheck">
                                <label class="form-check-label" for="category_delete">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="enquiry" name="roles[]" value="enquiry" <?php if(isset($editdata)){if(array_search('enquiry',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> class="form-check-input parentcheck">
                                <label class="form-check-label" for="enquiry">Enquiries</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="enquiry_delete" <?php if(isset($editdata)){if(array_search('enquiry_delete',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> name="roles[]" value="enquiry_delete" class="form-check-input childcheck">
                                <label class="form-check-label" for="enquiry_delete">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="career" name="roles[]" value="career" <?php if(isset($editdata)){if(array_search('career',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> class="form-check-input parentcheck">
                                <label class="form-check-label" for="career">Career</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="career_delete" <?php if(isset($editdata)){if(array_search('career_delete',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> name="roles[]" value="career_delete" class="form-check-input childcheck">
                                <label class="form-check-label" for="career_delete">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="users" name="roles[]" value="users" <?php if(isset($editdata)){if(array_search('users',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> class="form-check-input parentcheck">
                                <label class="form-check-label" for="users">Users</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="users_add" name="roles[]" <?php if(isset($editdata)){if(array_search('users_add',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="users_add" class="form-check-input childcheck">
                                <label class="form-check-label" for="users_add">Add</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="users_edit" name="roles[]" <?php if(isset($editdata)){if(array_search('users_edit',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="users_edit" class="form-check-input childcheck">
                                <label class="form-check-label" for="users_edit">Edit</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="users_delete" <?php if(isset($editdata)){if(array_search('users_delete',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> name="roles[]" value="users_delete" class="form-check-input childcheck">
                                <label class="form-check-label" for="users_delete">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="profile" <?php if(isset($editdata)){if(array_search('profile',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> name="roles[]" value="profile" class="form-check-input parentcheck">
                                <label class="form-check-label" for="profile">Profile</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="profile_edit" <?php if(isset($editdata)){if(array_search('profile_edit',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="profile_edit" name="roles[]" class="form-check-input childcheck">
                                <label class="form-check-label" for="profile_edit">Edit</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row rolesbox">
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="manage_roles" <?php if(isset($editdata)){if(array_search('manage_roles',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> name="roles[]" value="manage_roles" class="form-check-input parentcheck">
                                <label class="form-check-label" for="manage_roles">Manage Role</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="manage_roles_add" <?php if(isset($editdata)){if(array_search('manage_roles_add',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="manage_roles_add" name="roles[]" class="form-check-input childcheck">
                                <label class="form-check-label" for="manage_roles_add">Add</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="manage_roles_edit" <?php if(isset($editdata)){if(array_search('manage_roles_edit',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="manage_roles_edit" name="roles[]" class="form-check-input childcheck">
                                <label class="form-check-label" for="manage_roles_edit">Edit</label>
                            </div>
                            <div class="custom-radio form-check form-check-inline">
                                <input type="checkbox" id="manage_roles_delete" <?php if(isset($editdata)){if(array_search('manage_roles_delete',$rolelist) !== false){echo 'checked';}}else{echo 'checked';}?> value="manage_roles_delete" name="roles[]" class="form-check-input childcheck">
                                <label class="form-check-label" for="manage_roles_delete">Delete</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</form>