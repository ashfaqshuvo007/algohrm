<?php $__env->startSection('content'); ?>
<div class="col-md-offset-4 col-md-6 py-5 full_container" style="background:rgba(28, 45, 42,0.7);border-radius:10px; color: #fff; margin:0 auto; margin-top: 100px;">
    <div class="row">
        <div class="col-md-6 panel_container" style="border-right: 2px solid grey;" >
            <div class="panel panel-default">
                

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-6 control-label"><?php echo e(__('E-Mail Address')); ?></label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required autofocus>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="password" class="col-md-6 control-label"><?php echo e(__('Password')); ?></label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> <?php echo e(__('Remember Me')); ?>

                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <?php echo e(__('Login')); ?>

                                </button>
                                
                                <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                                   <?php echo e(__('Forgot Your Password?')); ?> 
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text_container text-white text-center">
                <img src="" alt="LOGO" width="200" class="logo"> 
                
                <h1 class="title">HRMS</h1>
                <p class="text_block">A total Human Resource Management Solution</p>
            </div>
        </div>
    </div>
    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ashfaqhahmed/Sites/laraProjects/hrm-demo/resources/views/auth/login.blade.php ENDPATH**/ ?>