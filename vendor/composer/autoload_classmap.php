<?php

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
 
    'AuthController' => $baseDir . '/app/controllers/AuthController.php',
    'BaseController' => $baseDir . '/app/controllers/BaseController.php',
    'Common_helper' => $baseDir . '/app/helpers/common_helper.php',
    'DatabaseSeeder' => $baseDir . '/app/database/seeds/DatabaseSeeder.php',
    //'FrontController' => $baseDir . '/app/controllers/frontend/FrontController.php',
    'IlluminateQueueClosure' => $vendorDir . '/laravel/framework/src/Illuminate/Queue/IlluminateQueueClosure.php',
    'SessionHandlerInterface' => $vendorDir . '/symfony/http-foundation/Symfony/Component/HttpFoundation/Resources/stubs/SessionHandlerInterface.php',
    'TestCase' => $baseDir . '/app/tests/TestCase.php',

    //'App\\Modules\\ServiceProvider' => $baseDir . '/app/modules/ServiceProvider.php',

    // 'App\\Modules\\Users\\ServiceProvider' => $baseDir . '/app/modules/users/ServiceProvider.php',
    // 'UserController' => $baseDir . '/app/modules/users/controllers/UserController.php',
    // 'Role' => $baseDir . '/app/modules/users/models/Role.php',
    // 'User' => $baseDir . '/app/modules/users/models/User.php',    

    // 'App\\Modules\\Menus\\ServiceProvider' => $baseDir . '/app/modules/menus/ServiceProvider.php',
    // 'MenuController' => $baseDir . '/app/modules/menus/controllers/MenuController.php',
    // 'Menu' => $baseDir . '/app/modules/menus/models/Menu.php',

    // 'App\\Modules\\Dashboard\\ServiceProvider' => $baseDir . '/app/modules/dashboard/ServiceProvider.php',
    // 'DashboardController' => $baseDir . '/app/modules/dashboard/controllers/DashboardController.php',
    // 'Dashboard' => $baseDir . '/app/modules/dashboard/models/Dashboard.php',

    // 'App\\Modules\\Folders\\ServiceProvider' => $baseDir . '/app/modules/folders/ServiceProvider.php',
    // 'FolderController' => $baseDir . '/app/modules/folders/controllers/FolderController.php',
    // 'Folder' => $baseDir . '/app/modules/folders/models/Folder.php',

    // 'App\\Modules\\Articles\\ServiceProvider' => $baseDir . '/app/modules/articles/ServiceProvider.php',
    // 'ArticleController' => $baseDir . '/app/modules/articles/controllers/ArticleController.php',
    // 'Article' => $baseDir . '/app/modules/articles/models/Article.php',
);