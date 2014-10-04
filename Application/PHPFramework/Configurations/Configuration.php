<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-08
 * Time: 21:12
 * To change this template use File | Settings | File Templates.
 */

use Application\PHPFramework\AutoLoader;

require_once 'Application/PHPFramework/Configurations/PersonalConfiguration.php';


// Set default character encoding.
mb_internal_encoding('UTF-8');

// Set where the project folder is found on disk.
set_include_path(PROJECT_ROOT);

// Set the folder where the saved session files should go. Change the second argument if you want to change the folder.
ini_set('session.save_path', 'tmp');

// Set up the auto loader.
require_once 'Application/PHPFramework/AutoLoader.php';
$autoLoader = new AutoLoader();
$autoLoader->setUpAutoLoader();

// Setup error handlers so that errors such as no such method exists or variable is used but never defined throws an exception.
require_once 'Application/PHPFramework/ErrorHandling/ErrorHandler.php';