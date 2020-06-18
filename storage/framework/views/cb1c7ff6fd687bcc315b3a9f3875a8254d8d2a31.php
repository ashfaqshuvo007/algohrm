<div id="mainMenu">
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="<?php echo e(url('/dashboard')); ?>"><i class="fa fa-dashboard text-purple"></i> <span><?php echo e(__('Dashboard')); ?></span></a></li>
        
        <?php if (\Entrust::can('people')) : ?>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-users text-purple"></i> <span><?php echo e(__('Employee Management')); ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                
               

                <?php if (\Entrust::can('manage-employee')) : ?>
                <li><a href="<?php echo e(url('/people/employees/create')); ?>"><i class="fa fa-circle-o"></i><?php echo e(__(' New Employee')); ?></a></li>
                <li><a href="<?php echo e(url('/people/employees')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(__('Manage Employee')); ?></a></li>
                <?php endif; // Entrust::can ?>
                <?php if (\Entrust::can('manage-clients')) : ?>
                 <li><a href="<?php echo e(url('people/clients/create')); ?>"><i class="fa fa-circle-o"></i><?php echo e(__(' New Customer')); ?></a></li>
                <li><a href="<?php echo e(url('/people/clients')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(__('Manage Clients')); ?></a></li>
                <?php endif; // Entrust::can ?>
                <?php if (\Entrust::can('manage-references')) : ?>
                
                <li><a href="<?php echo e(url('people/references/create')); ?>"><i class="fa fa-circle-o"></i><?php echo e(__(' New Reference')); ?></a></li>
                <li><a href="<?php echo e(url('/people/references')); ?>"><i class="fa fa-circle-o"></i><?php echo e(__(' Manage References')); ?></a></li>
                <?php endif; // Entrust::can ?>
            </ul>
        </li>
        <?php endif; // Entrust::can ?>
    </ul>

</div><?php /**PATH /Users/ashfaqhahmed/Sites/laraProjects/hrm-demo/resources/views/administrator/layouts/menu.blade.php ENDPATH**/ ?>