<?php
use DinoPHP\Bootstrap\App;
use DinoPHP\Http\Request;

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
| .env configuration
|-------------------------------------------------------------------
|
| Load .environment file
*/
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbUsername = getenv("SECRET_KEY");
echo $dbUsername;

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