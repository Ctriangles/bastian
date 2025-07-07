$( document ).ready(function() {
	if(current_url == 'add_settings' || current_url == 'EditSettings') {
		$('#add_settings').validate({
			rules: {
				setting_name: {
				required: true,
				}
			},
			submitHandler: function(form) {
				$.ajax({
					url: site_url+"setting_controller/addSettings",
					type: 'POST',
					data: new FormData(form),
					mimeType: "multipart/form-data",
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function () {
						$("#add_settings .preloaderremove").remove();
						$("#add_settings").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
					},
					success: function(data) {
						data = JSON.parse(data); 
						console.log(data);
						if(data.status == 'false') {
							$('#errormessages').html('<span style="color: red;">Something wrong.</span>');
						} else if(data.status == 'already') {
							$('#errormessages').html('<span style="color: red;">This setting already exist.</span>');
						} else if(data.status == 'true') {
							window.location.href = site_url+'backend/EditSettings/'+data.values+'/';
						}
						$("#add_settings .preloaderremove").remove();
					}
				});
			}
		});
	}



	if(current_url == 'add_roles' || current_url == 'EditRoles') {
		$('#addRoles').validate({
			rules: {
				role_name: {
					required: true,
				}
			},
			submitHandler: function(form) {
				$.ajax({
					url: site_url+"user_controller/AddRoles",
					type: 'POST',
					data: new FormData(form),
					mimeType: "multipart/form-data",
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function () {
						$("#addRoles .preloaderremove").remove();
						$("#addRoles").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
					},
					success: function(data) {
						data = JSON.parse(data); 
						if(data.status == 'false') {
							$('#errormessages').html('<span style="color: red;">Something wrong.</span>');
						} else if(data.status == 'already') {
							$('#errormessages').html('<span style="color: red;">This roles already exist.</span>');
						} else if(data.status == 'true') {
							window.location.href = site_url+'backend/EditRoles/'+data.values+'/';
						}
						$("#addRoles .preloaderremove").remove();
					}
				});
			}
		});
	}


	if(current_url == 'smtp') {
		$('#smtpupdate').validate({
			rules: {
				smtp_service: {
					required: true,
				},
				smtp_crypto: {
					required: true,
				},
				mail_type: {
					required: true,
				},
				mail_port: {
					required: true,
				},
				mail_username: {
					required: true,
				},
				mail_password: {
					required: true,
				}
			},
			submitHandler: function(form) {
				$.ajax({
					url: site_url+"setting_controller/UpdateSMTP",
					type: 'POST',
					data: new FormData(form),
					mimeType: "multipart/form-data",
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function () {
						$("#smtpupdate .preloaderremove").remove();
						$("#smtpupdate").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
					},
					success: function(data) {
						if(data == 'false') {
							$('#errormessages').html('<span style="color: red;">Something wrong.</span>');
						} else if(data == 'already') {
							$('#errormessages').html('<span style="color: red;">This SMTP already exist.</span>');
						} else if(data == 'true') {
							window.location.href = site_url+'backend/smtp';
						}
						$("#smtpupdate .preloaderremove").remove();
					}
				});
			}
		});
	}

	if(current_url == 'add_template' || current_url == 'EditTemplate') {
		$('#add_Template').validate({
			rules: {
				template_name: {
					required: true,
				},
				template_url: {
					required: true,
				}
			},
			submitHandler: function(form) {
				$.ajax({
					url: site_url+"post_controller/AddTemplate",
					type: 'POST',
					data: new FormData(form),
					mimeType: "multipart/form-data",
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function () {
						$("#add_Template .preloaderremove").remove();
						$("#add_Template").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
					},
					success: function(data) {
						data = JSON.parse(data); 
						if(data.status == 'false') {
							$('#errormessages').html('<span style="color: red;">Something wrong.</span>');
						} else if(data.status == 'already') {
							$('#errormessages').html('<span style="color: red;">This template already exist.</span>');
						} else if(data.status == 'true') {
							window.location.href = site_url+'backend/EditTemplate/'+data.values+'/';
						}
						$("#add_Template .preloaderremove").remove();
					}
				});
			}
		});
	}

	if(current_url == 'add_pages' || current_url == 'EditPage') {
		$('#add_page').validate({
			rules: {
				post_title: {
					required: true,
				},
				post_slug: {
					required: true,
				}
			},
			submitHandler: function(form) {
				var ckEditorContent = CKEDITOR.instances.post_content.getData();
				var formData = $(form).serializeArray();
				formData.push({ name: 'post_content', value: ckEditorContent });
				$.ajax({
					url: site_url+"post_controller/AddPages",
					type: 'POST',
					data: formData,
					beforeSend: function () {
						$("#add_page .preloaderremove").remove();
						$("#add_page").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
					},
					success: function(data) {
						console.log(data);
						data = JSON.parse(data); 
						if(data.status == 'false') {
							$('#errormessages').html('<span style="color: red;">Something wrong.</span>');
						} else if(data.status == 'already') {
							$('#errormessages').html('<span style="color: red;">This page already exist.</span>');
						} else if(data.status == 'true') {
							window.location.href = site_url+'backend/EditPage/'+data.values+'/';
						}
						$("#add_page .preloaderremove").remove();
					}
				});
			}
		});
	}

	if(current_url == 'add_users' || current_url == 'EditUsers') {
		$('#add_User').validate({
			rules: {
				first_name: {
					required: true,
				},
				last_name: {
					required: true,
				},
				username: {
					required: true,
				},
				user_email: {
					required: true,
				},
				user_email: {
					required: true,
				},
				cpassword: {
					equalTo: '#password[name="password"]'
				}
			},
			submitHandler: function(form) {
				var ckEditorContent = CKEDITOR.instances.biography.getData();
				var formData = $(form).serializeArray();
				formData.push({ name: 'biography', value: ckEditorContent });
				$.ajax({
					url: site_url+"user_controller/AddUsers",
					type: 'POST',
					data: formData,
					beforeSend: function () {
						$("#add_User .preloaderremove").remove();
						$("#add_User").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
					},
					success: function(data) {
						console.log(data);
						data = JSON.parse(data); 
						if(data.status == 'false') {
							$('#errormessages').html('<span style="color: red;">Something wrong.</span>');
						} else if(data.status == 'already') {
							$('#errormessages').html('<span style="color: red;">This user already exist.</span>');
						} else if(data.status == 'true') {
							if(current_url == 'profile') {
							window.location.href = site_url+'backend/profile/';
							} else {
							window.location.href = site_url+'backend/EditUsers/'+data.values+'/';
							}
						}
						$("#add_User .preloaderremove").remove();
					}
				});
			}
		});
	}

	if(current_url == 'add_category' || current_url == 'EditCategory') {
		$('#add_category').validate({
			rules: {
				cat_title: {
					required: true,
				},
				cat_slug: {
					required: true,
				}
			},
			submitHandler: function(form) {
				var ckEditorContent = CKEDITOR.instances.cat_disc.getData();
				var formData = $(form).serializeArray();
				formData.push({ name: 'cat_disc', value: ckEditorContent });
				$.ajax({
					url: site_url+"category_controller/AddCategory",
					type: 'POST',
					data: formData,
					beforeSend: function () {
						$("#add_category .preloaderremove").remove();
						$("#add_category").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
					},
					success: function(data) {
						console.log(data);
						data = JSON.parse(data); 
						if(data.status == 'false') {
							$('#errormessages').html('<span style="color: red;">Something wrong.</span>');
						} else if(data.status == 'already') {
							$('#errormessages').html('<span style="color: red;">This category already exist.</span>');
						} else if(data.status == 'true') {
							window.location.href = site_url+'backend/EditCategory/'+data.values+'/';
						}
						$("#add_category .preloaderremove").remove();
					}
				});
			}
		});
	}
	
	if(current_url == 'add_blog' || current_url == 'EditBlog') {
		$('#add_blog').validate({
			rules: {
				post_title: {
					required: true,
				},
				post_slug: {
					required: true,
				}
			},
			submitHandler: function(form) {
				var ckEditorContent = CKEDITOR.instances.post_content.getData();
				var formData = $(form).serializeArray();
				formData.push({ name: 'post_content', value: ckEditorContent });
				$.ajax({
					url: site_url+"post_controller/AddBlog",
					type: 'POST',
					data: formData,
					beforeSend: function () {
						$("#add_blog .preloaderremove").remove();
						$("#add_blog").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
					},
					success: function(data) {
						console.log(data);
						data = JSON.parse(data); 
						if(data.status == 'false') {
							$('#errormessages').html('<span style="color: red;">Something wrong.</span>');
						} else if(data.status == 'already') {
							$('#errormessages').html('<span style="color: red;">This page already exist.</span>');
						} else if(data.status == 'true') {
							window.location.href = site_url+'backend/EditBlog/'+data.values+'/';
						}
						$("#add_blog .preloaderremove").remove();
					}
				});
			}
		});
	}
});
