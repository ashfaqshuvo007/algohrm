<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', __('Laravel'))); ?></title>

    <!-- Styles -->
    <link href="<?php echo e(asset('/public/css/app.css')); ?>" rel="stylesheet">
</head>
<body>
    <div id="app" style="background-image: url('/public/uploaded_files/hrms_back.jpg');height:100vh; padding-top: 50px">
        

        <?php echo $__env->yieldContent('content'); ?>
        
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('/public/js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH /Users/ashfaqhahmed/Sites/laraProjects/hrm-demo/resources/views/layouts/app.blade.php ENDPATH**/ ?>