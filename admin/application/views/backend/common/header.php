<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$title?> | <?=@$this->site_title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?=site_url(@$this->site_favicon)?>">
        <link href="<?=site_url('assets/css/bootstrap.min.css')?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="<?=site_url('assets/css/icons.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=site_url('assets/css/app.min.css')?>" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?=site_url('assets/css/line.css')?>">
        <link href="<?=site_url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=site_url('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=site_url('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')?>" rel="stylesheet" type="text/css" />  
        <link href="<?=site_url('assets/libs/select2/css/select2.min.css')?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?=site_url('public/ckeditor/ckeditor.js'); ?>"></script>
        <script type="text/javascript" src="<?=site_url('public/ckfinder/ckfinder.js'); ?>"></script>
        <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    </head>
    <body>
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box">
                            <a href="<?=site_url('backend/')?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?=site_url(@$this->site_favicon)?>" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=site_url(@$this->site_logo)?>" alt="" height="20">
                                </span>
                            </a>
                            <a href="<?=site_url('backend/')?>" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?=site_url(@$this->site_favicon)?>" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=site_url(@$this->site_logo)?>" alt="" height="20">
                                </span>
                            </a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                    </div>
                    <div class="d-flex">
                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                <i class="uil-minus-path"></i>
                            </button>
                        </div>
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil-bell"></i>
                                <span class="badge bg-danger rounded-pill">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="m-0 font-size-16"> Notifications </h5>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small"> Mark all as read</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="javascript:void(0);" class="text-reset notification-item">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                        <i class="uil-shopping-basket"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="text-reset notification-item">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="<?=site_url('assets/images/users/avatar-3.jpg')?>" class="rounded-circle avatar-xs" alt="user-pic">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">James Lemire</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">It will seem like simplified English.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hour ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="text-reset notification-item">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                                        <i class="uil-truck"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your item is shipped</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="text-reset notification-item">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="<?=site_url('assets/images/users/avatar-4.jpg')?>" class="rounded-circle avatar-xs" alt="user-pic">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Salena Layfield</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top">
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                            <i class="uil-arrow-circle-right me-1"></i> View More..
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?=(!empty($this->getUserData->user_img))?site_url($this->getUserData->user_img):site_url('assets/img/avtar.webp')?>" alt="<?=$this->getUserData->first_name.' '.$this->getUserData->last_name?>">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15"><?=$this->getUserData->first_name.' '.$this->getUserData->last_name?></span>
                                <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="<?=site_url('backend/profile/')?>"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">View Profile</span></a>
                                <a class="dropdown-item" href="<?=site_url('user_controller/backend_logout')?>"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Sign out</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">
                <div class="navbar-brand-box">
                    <a href="<?=site_url('backend/')?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?=site_url(@$this->site_favicon)?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?=site_url(@$this->site_logo)?>" alt="" height="60">
                        </span>
                    </a>
                    <a href="<?=site_url('backend/')?>" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?=site_url(@$this->site_favicon)?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?=site_url(@$this->site_logo)?>" alt="" height="20">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <div data-simplebar class="sidebar-menu-scroll">
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li><a href="<?=site_url('backend/')?>"><i class="uil-home-alt"></i><span>Dashboard</span></a></li>
                            <?php if(array_search('website_settings',$this->role_list) !== false || array_search('smtp',$this->role_list) !== false) :?>
                            <li><a href="javascript: void(0);" class="has-arrow waves-effect"><i class="uil-window-section"></i><span>Settings</span></a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <?php if(array_search('website_settings',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/settings/')?>">Global Settings</a></li>
                                    <?php } if(array_search('smtp',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/smtp/')?>">SMTP</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php endif;
                            if(array_search('blog',$this->role_list) !== false || array_search('blog_add',$this->role_list) !== false || array_search('category',$this->role_list) !== false) :?>
                            <li><a href="javascript: void(0);" class="has-arrow waves-effect"><i class="uil-book-open"></i><span>Blogs</span></a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <?php if(array_search('blog',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/blog/')?>">Blog</a></li>
                                    <?php } if(array_search('blog_add',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/add_blog/')?>">Add Blog</a></li>
                                    <?php } if(array_search('category',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/category/')?>">Category</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php endif; 
                            if(array_search('clients_featured',$this->role_list) !== false || array_search('template',$this->role_list) !== false || array_search('pages_add',$this->role_list) !== false) :?>
                            <li><a href="javascript: void(0);" class="has-arrow waves-effect"><i class="uil-file-alt"></i><span>Pages</span></a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <?php if(array_search('pages',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/pages/')?>">Pages</a></li>
                                    <?php } if(array_search('pages_add',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/add_pages/')?>">Add Page</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php endif; 
                            if(array_search('client_featured',$this->role_list) !== false) : ?>
                            <li><a href="<?=site_url('backend/clients_featured/')?>"><i class="uil-bag"></i><span>Clients / Featured in</span></a></li>
                            <?php endif;  
                            if(array_search('enquiry',$this->role_list) !== false) : ?>
                                <li><a href="<?=site_url('backend/enquiries/')?>"><i class="uil-envelope-alt"></i><span>Enquiries</span></a></li>
                            <?php endif; 
                            if(array_search('career',$this->role_list) !== false) : ?>
                                <li><a href="<?=site_url('backend/career/')?>"><i class="uil-envelope-alt"></i><span>Career</span></a></li>
                            <?php endif; 
                            if(array_search('profile',$this->role_list) !== false || array_search('manage_roles',$this->role_list) !== false || array_search('users',$this->role_list) !== false || array_search('users_add',$this->role_list) !== false) :?>
                            <li><a href="javascript: void(0);" class="has-arrow waves-effect"><i class="uil-users-alt"></i><span>Users</span></a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <?php if(array_search('users',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/users/')?>">Users</a></li>
                                    <?php } if(array_search('users_add',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/add_users/')?>">Add User</a></li>
                                    <?php } if(array_search('profile',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/profile/')?>">Profile</a></li>
                                    <?php } if(array_search('manage_roles',$this->role_list) !== false) { ?>
                                    <li><a href="<?=site_url('backend/roles/')?>">Roles</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <li><a href="<?=site_url()?>" class="waves-effect" target="_blank"><i class="uil-globe"></i><span>Front View</span></a></li>
                            <li><a href="<?=site_url('user_controller/backend_logout')?>" class="waves-effect"><i class="uil-sign-out-alt"></i><span>Sign out</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0"><?=$title?></h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <?php if($this->uri->segment(1) == 'backend' && $this->uri->segment(2) != '') { ?>
                                            <li class="breadcrumb-item"><a href="<?=site_url('backend/')?>">Dashboard</a></li>
                                            <?php } ?>
                                            <li class="breadcrumb-item active"><?=$title?></li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($this->uri->segment(1) == 'backend' && $this->uri->segment(2) != '') { ?>
                        <div class="row">
                            <div class="col-6">
                                <?php if($current_url != $addurl && $this->uri->segment(3) == '' && $current_url != 'smtp' && $current_url != 'profile') { ?>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="<?=site_url('backend/'.$viewurl.'/')?>">All (<?=count($AllDatas)?>)</a></li>
                                        <?php if(array_search($delrole,$this->role_list) !== false) { ?>
                                        <li class="breadcrumb-item active"><a href="<?=site_url('backend/'.$trashurl.'/')?>">Trash (<?=count($TrashDatas)?>)</a></li>
                                        <?php } ?>
                                    </ol>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col-6 text-right">
                                <div class="pagebackbtnright">
                                    <ol class="breadcrumbbtn m-0">
                                        <li class="breadcrumb-item-btn"><button type="button" onclick="goBack()" class="btn btn-warning waves-effect waves-light">Back</button></li>
                                        <?php if($current_url == $viewurl && $current_url != $addurl && $this->uri->segment(3) == '') { 
                                            if(array_search($addrole,$this->role_list) !== false) { ?>
                                            <li class="breadcrumb-item-btn"><a href="<?=site_url('backend/'.$addurl.'/')?>" class="btn btn-primary waves-effect waves-light">Add <?=$mtitle?></a></li>
                                        <?php } } else { ?>
                                            <li class="breadcrumb-item-btn"><a href="<?=site_url('backend/'.$viewurl.'/')?>" class="btn btn-primary waves-effect waves-light">All <?=$mtitle?></a></li>
                                        <?php } ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
