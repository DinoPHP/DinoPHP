<?php
?>
<html>
<head>
    <title>That page doesn't exist!</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .error {
            text-align: center;
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: center;
        }
        .error h1 {
            font-size: 90px;
            letter-spacing: 10px;
            color: #353535;
            margin-bottom: 0;
            margin-top: 0;
        }
        .error p {
            font-size: 25px;
            font-weight: 200;
            text-transform: uppercase;
            color: #353535;
        }
        .image img {
            max-width: 115px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .docs {
            padding: 10px;
            width: 180px;
            background: transparent;
            border: 1px solid #353535;
            color: #353535;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .docs:hover {
            background: #353535;
            color: white;
            -webkit-transition: 0.6s;
            transition: 0.6s;
        }
    </style>
</head>
<body>
<div class="error">
    <div class="image">
        <img src="<?php echo e(asset ('pics/dino-black.png')); ?>">
    </div>
    <h1>404</h1>
    <p>not found</p>
    <div class="buttons">
        <a href="https://DinoPHP.com/docs"><button class="docs">Documentation</button></a>
    </div>
</div>
</body>
</html><?php /**PATH C:\xampp\htdocs\DinoPHP\views/errors/404.php ENDPATH**/ ?>