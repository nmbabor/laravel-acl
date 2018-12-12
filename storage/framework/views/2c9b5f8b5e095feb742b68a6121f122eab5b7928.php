<?php if(Session::has('menu')): ?>
    <ul class="navbar-nav">

    <?php $__currentLoopData = $subMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $subSubMenu = $sMenu->subSubMenu->where('status',1);
            if(count($subSubMenu)>0){
                $subMenuUrl = '#';
            }else{
                $subMenuUrl = URL::to("$sMenu->url");
            }
            ?>
        <?php if (app('laravel-acl.directives.canAtLeast')->handle(json_decode($sMenu->slug,true))): ?>
        <li class="nav-item  <?php if(count($subSubMenu)>0): ?> dropdown <?php endif; ?>" >
            <a href="<?php echo e($subMenuUrl); ?>" class="nav-link <?php if(count($subSubMenu)>0): ?> dropdown-toggle <?php endif; ?>" <?php if(count($subSubMenu)>0): ?> id="navbardrop" data-toggle="dropdown" <?php endif; ?>>
                <i class="fa fa-folder-o text-white"></i>
                <span><?php echo e($sMenu->name); ?></span>
            </a>
            <?php if(count($subSubMenu)>0): ?>
                <div class="dropdown-menu">
                <?php $__currentLoopData = $subSubMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ssMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (app('laravel-acl.directives.canAtLeast')->handle(json_decode($ssMenu->slug,true))): ?>
                    <a href='<?php echo e(URL::to("$ssMenu->url")); ?>' class="dropdown-item"><?php echo e($ssMenu->name); ?></a>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </li>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>