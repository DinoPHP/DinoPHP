<?php
use DinoPHP\Csrf\Csrf;
?>
<html>
<body>
<form>
    <input type="hidden" name="token" value="<?php echo e(generate_token()); ?>">
</form>
</body>
</html><?php /**PATH C:\xampp\htdocs\DinoPHP\views/form.blade.php ENDPATH**/ ?>