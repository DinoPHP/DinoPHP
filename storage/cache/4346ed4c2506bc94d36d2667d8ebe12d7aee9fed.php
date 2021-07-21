<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<?php $__currentLoopData = $users['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div><?php echo e($user->id); ?></div>
    <div><?php echo e($user->name); ?></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php echo links($users['current_page'], $users['pages']); ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\DinoPHP\views/admin/dashboard.blade.php ENDPATH**/ ?>