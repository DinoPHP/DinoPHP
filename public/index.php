<?php
use DinoPHP\Bootstrap\App;

/**
 * DinoPHP is a PHP Framework
 * 
 * @author Ahmed Mohamed Ibrahim eng.ahmedmohamed.2002@gmail.com
 */

/*
|-------------------------------------------------------------------
| Autoloader
|-------------------------------------------------------------------
|
| Load the autoloader that will generated class that will be used
*/
require __DIR__.'/../vendor/autoload.php';
/*
|-------------------------------------------------------------------
| Bootstrap
|-------------------------------------------------------------------
|
| Bootstrap the app and do action from framework
*/
require __DIR__.'/../bootstrap/app.php';
/*
|-------------------------------------------------------------------
| Run the app
|-------------------------------------------------------------------
|
| Handle the requests
*/
Application::run();