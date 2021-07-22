<html>
<head>
    <title>Welcome Page | DinoPHP Framework</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            background: #092531;
            font-family: 'Tajawal', sans-serif;
        }
        .container {
            max-width: 1050px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 8%;
        }
        .code {
            padding: 7px;
            border-radius: 5px;
            margin-top: 3%;
        }
        .ide {
            background: #eceae8;
            padding: 15px;
            border-radius: 5px;
            box-shadow: rgb(0 0 0 / 55%) 0px 20px 68px
        }
        .close-btn {
            background: #ff5f56;
            border-radius: 50%;
            height: 14px;
            width: 14px;
            border: none;
        }
        .down-btn {
            background: #ffbd2e;
            border-radius: 50%;
            height: 14px;
            width: 14px;
            border: none;
        }
        .min-btn {
            background: #27c93f;
            border-radius: 50%;
            height: 14px;
            width: 14px;
            border: none;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }
        .buttons button {
            cursor: pointer;
        }
        .cont-code {
            margin-top: 2%;
            color:white;
            font-size: 17px;
            letter-spacing: 1px;
            font-family: inherit;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="<?php echo e(('pics/DinoPHP-word.png')); ?>" style="max-width: 200px;">
    <div class="code">
        <div class="ide">
            <div class="buttons">
                <button class="close-btn" title="Close"></button>
                <button class="down-btn" title="Resize window"></button>
                <button class="min-btn" title="Minimize"></button>
            </div>
            <div class="cont-code">
                <?php
                highlight_string('<?php
function welcome(){
	$intro =[
		"welcome" => "Welcome !",
		"congrat" => "Congratulation! You have successfully installed a new DinoPHP application"
	];
	return $intro;
}

echo "<pre>";
print_r (welcome());
echo "</pre>";
?>') ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\DinoPHP\views/home.blade.php ENDPATH**/ ?>