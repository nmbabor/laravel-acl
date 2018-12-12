<? $info = MyHelper::company(); ?>
<nav class="navbar header-navbar pcoded-header bg-white">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                <div style="padding-top: 3px">
                    <i class="feather icon-toggle-right" style="font-size:25px;color:blue;"></i>
                </div>
            </a>
            <div class="col-xs-4">
                <a href="<?php echo e(URL::to('/')); ?>">
                    <img class="img-fluid ml-4" src="<?php echo e(asset('images/logo.png')); ?>" alt="<?php echo e(MyHelper::info()->company_name); ?>" title="<?php echo e(MyHelper::info()->company_name); ?>" style="height:32px"/>
                </a>
            </div>


            <a class="mobile-options waves-effect waves-light">
                <i class="feather icon-more-horizontal text-custom"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <img class="img-fluid ml-4" src="<?php echo e(asset($info->logo)); ?>" alt="<?php echo e($info->company_name); ?>" title="<?php echo e($info->company_name); ?>" style="height:32px"/>
                    <b> <?php echo e($info->company_name); ?>  </b>
                </li>
                <li class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                                        <span class="input-group-prepend search-close">
										<i class="feather icon-x input-group-text" style="color:#777777"></i>
									</span>
                            <input type="text" class="form-control" placeholder="Enter Keyword">
                            <span class="input-group-append search-btn">
										<i class="feather icon-search input-group-text" style="color:black;"></i>
									</span>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                        <i class="full-screen feather icon-maximize text-custom"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="header-notification" style="display:none;">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-bell text-custom"></i>
                            <span class="badge bg-c-red">5</span>
                        </div>
                        <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                                <h6>Notifications</h6>
                                <label class="label label-danger">New</label>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="img-radius" src="<?php echo e(asset('images/avatar-4.jpg')); ?>" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <h5 class="notification-user">John Doe</h5>
                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                        <span class="notification-time">30 minutes ago</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="img-radius" src="<?php echo e(asset('images/avatar-3.jpg')); ?>" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <h5 class="notification-user">Joseph William</h5>
                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                        <span class="notification-time">30 minutes ago</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="img-radius" src="<?php echo e(asset('images/avatar-4.jpg')); ?>" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <h5 class="notification-user">Sara Soudein</h5>
                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                        <span class="notification-time">30 minutes ago</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                           

                            <span class="text-custom"> <i class="fa fa-user-circle-o"></i></span>
                            <i class="feather icon-chevron-down text-custom"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                                <a>
                                    <i class="fa fa-user"></i> <?php echo e(Auth::user()->name); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(URL::to('profile')); ?>">
                                    <i class="feather icon-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(URl::to('profile/password')); ?>">
                                    <i class="icofont icofont-ui-password"></i> Change password
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo e(route('logout')); ?>"
                                   onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo e(csrf_field()); ?>

                                </form>

                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ Header ] end -->

<!-- [ chat user list ] start -->
<div id="sidebar" class="users p-chat-user showChat">
    <div class="had-container">
        <div class="p-fixed users-main">
            <div class="user-box">
                <div class="chat-search-box">
                    <a class="back_friendlist">
                        <i class="feather icon-x"></i>
                    </a>
                    <div class="right-icon-control">
                        <form class="form-material">
                            <div class="form-group form-primary">
                                <input type="text" name="footer-email" class="form-control" id="search-friends" required="">
                                <span class="form-bar"></span>
                                <label class="float-label">
                                    <i class="feather icon-search m-r-10"></i>Search Friend
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="main-friend-list">
                    <div class="media userlist-box waves-effect waves-light" data-id="1" data-status="online" data-username="Josephin Doe">
                        <a class="media-left" href="#!">
                            <img class="media-object img-radius img-radius" src="<?php echo e(asset('images/avatar-3.jpg')); ?>" alt="Generic placeholder image ">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="chat-header">Josephin Doe</div>
                        </div>
                    </div>
                    <div class="media userlist-box waves-effect waves-light" data-id="2" data-status="online" data-username="Lary Doe">
                        <a class="media-left" href="#!">
                            <img class="media-object img-radius" src="<?php echo e(asset('images/avatar-2.jpg')); ?>" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="f-13 chat-header">Lary Doe</div>
                        </div>
                    </div>
                    <div class="media userlist-box waves-effect waves-light" data-id="3" data-status="online" data-username="Alice">
                        <a class="media-left" href="#!">
                            <img class="media-object img-radius" src="<?php echo e(asset('images/avatar-4.jpg')); ?>" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="f-13 chat-header">Alice</div>
                        </div>
                    </div>
                    <div class="media userlist-box waves-effect waves-light" data-id="4" data-status="offline" data-username="Alia">
                        <a class="media-left" href="#!">
                            <img class="media-object img-radius" src="<?php echo e(asset('images/avatar-3.jpg')); ?>" alt="Generic placeholder image">
                            <div class="live-status bg-default"></div>
                        </a>
                        <div class="media-body">
                            <div class="f-13 chat-header">Alia<small class="d-block text-muted">10 min ago</small></div>
                        </div>
                    </div>
                    <div class="media userlist-box waves-effect waves-light" data-id="5" data-status="offline" data-username="Suzen">
                        <a class="media-left" href="#!">
                            <img class="media-object img-radius" src="<?php echo e(asset('images/avatar-2.jpg')); ?>" alt="Generic placeholder image">
                            <div class="live-status bg-default"></div>
                        </a>
                        <div class="media-body">
                            <div class="f-13 chat-header">Suzen<small class="d-block text-muted">15 min ago</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ chat user list ] end -->

<!-- [ chat message ] start -->
<div class="showChat_inner">
    <div class="media chat-inner-header">
        <a class="back_chatBox">
            <i class="feather icon-x"></i>
        </a>
    </div>
    <div class="main-friend-chat">
        <div class="media chat-messages">
            <a class="media-left photo-table" href="#!">
                <img class="media-object img-radius img-radius m-t-5" src="<?php echo e(asset('images/avatar-2.jpg')); ?>" alt="Generic placeholder image">
            </a>
            <div class="media-body chat-menu-content">
                <div class="">
                    <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                </div>
                <p class="chat-time">8:20 a.m.</p>
            </div>
        </div>
        <div class="media chat-messages">
            <div class="media-body chat-menu-reply">
                <div class="">
                    <p class="chat-cont">Ohh! very nice</p>
                </div>
                <p class="chat-time">8:22 a.m.</p>
            </div>
        </div>
        <div class="media chat-messages">
            <a class="media-left photo-table" href="#!">
                <img class="media-object img-radius img-radius m-t-5" src="<?php echo e(asset('images/avatar-2.jpg')); ?>" alt="Generic placeholder image">
            </a>
            <div class="media-body chat-menu-content">
                <div class="">
                    <p class="chat-cont">can you come with me?</p>
                </div>
                <p class="chat-time">8:20 a.m.</p>
            </div>
        </div>
    </div>
    <div class="chat-reply-box">
        <div class="right-icon-control">
            <form class="form-material">
                <div class="form-group form-primary">
                    <input type="text" name="footer-email" class="form-control" required="">
                    <span class="form-bar"></span>
                    <label class="float-label">
                        <i class="feather icon-search m-r-10"></i>Share Your Thoughts
                    </label>
                </div>
            </form>
            <div class="form-icon ">
                <button class="btn btn-success btn-icon  waves-effect waves-light">
                    <i class="feather icon-message-circle"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- [ chat message ] end -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper ">
        <!-- [ navigation menu ] start -->
        <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar main-menu">
                <div class="" style="display: none">
                    <div class="main-menu-header">
                        <img class="img-menu-user" style="height: 80px; width: 80px; border-radius: 50%; "  src="<?php echo e(asset('images/avatar-4.jpg')); ?>" alt="User-Profile-Image">
                        <div class="user-details">
                            <p id="more-details"><i class="feather icon-chevron-down m-l-10"></i></p>
                        </div>
                    </div>
                    <div class="main-menu-content">
                        <ul>
                            <li class="more-details">
                                <a href="user-profile.html">
                                    <i class="feather icon-user"></i>View Profile
                                </a>
                                <a href="#!">
                                    <i class="feather icon-settings"></i>Settings
                                </a>
                                <a href="">
                                    <i class="feather icon-log-out"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <ul class="pcoded-item pcoded-left-item">
                    <li>
                        <a href="<?php echo e(URL::to('')); ?>" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-aperture text-white"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
                    <?php if(Auth::user()->isRole('super-admin')): ?>
                        <?php $__currentLoopData = $allCompany; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href='<?php echo e(URL::to("company-dashboard/$company->id")); ?>' class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="fa fa-building-o text-white"></i></span>
                                <span class="pcoded-mtext"> <?php echo e($company->company_name); ?> </span>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php else: ?>
                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (app('laravel-acl.directives.canAtLeast')->handle(json_decode($menu->slug,true))): ?>
                            <?php
                            $subMenus=[];
                                if(isset($menu->subMenu)){
                                    $subMenus = $menu->subMenu->where('status',1);
                                }
                            if(count($subMenus)>0){
                                $menuUrl = 'javascript:void(0)';
                            }else{
                                $menuUrl = URL::to("$menu->url");
                            }
                            ?>
                            <li>
                                <a data-href="<?php echo e(URL::to('')); ?>" onclick="loadSubMenu('<?php echo e($menu->id); ?>' , '<?php echo e($menu->url); ?>')" class="waves-effect waves-dark" title="<?php echo e($menu->name); ?>">
                                        <span class="pcoded-micon">
                                            <i class="<?php echo e(($menu->icon_class!=null)?$menu->icon_class:'fa fa-folder-o'); ?> text-white"></i>
                                        </span>
                                    <span class="pcoded-mtext"><?php echo e($menu->name); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <div class="pcoded-navigation-label" menu-title-theme="theme1">Navigation</div>
                    <?php $__currentLoopData = $menu2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (app('laravel-acl.directives.canAtLeast')->handle(json_decode($menu->slug,true))): ?>
                        <?php
                        $subMenus=[];
                        if(isset($menu->subMenu)){
                            $subMenus = $menu->subMenu->where('status',1);
                        }
                        if(count($subMenus)>0){
                            $menuUrl = 'javascript:void(0)';
                        }else{
                            $menuUrl = URL::to("$menu->url");
                        }
                        ?>
                        <li>
                            <a data-href="<?php echo e(URL::to('')); ?>" onclick="loadSubMenu('<?php echo e($menu->id); ?>' , '<?php echo e($menu->url); ?>')" class="waves-effect waves-dark" title="<?php echo e($menu->name); ?>">
                                        <span class="pcoded-micon">
                                            <i class="<?php echo e(($menu->icon_class!=null)?$menu->icon_class:'fa fa-folder-o'); ?> text-white"></i>
                                        </span>
                                <span class="pcoded-mtext"><?php echo e($menu->name); ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                </ul>


            </div>
        </nav>
