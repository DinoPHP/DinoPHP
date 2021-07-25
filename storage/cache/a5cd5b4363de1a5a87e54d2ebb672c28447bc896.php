<?php
    use DinoPHP\Csrf\Csrf
?>
<html>
<head>
    <title>test</title>
</head>
<body>
<form method="POST" action="submit">
    <input type="hidden" name="token" value="<?php echo e(generate_token()); ?>" />
    <input type="text">
    <input type="submit">
</form>
</body>
</html><?php /**PATH C:\xampp\htdocs\DinoPHP\views/test.blade.php ENDPATH**/ ?>