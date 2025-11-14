<?php

use App\Modules\Post\Http\Controllers\Web\PostController;
use App\Modules\Tag\Http\Controllers\Web\TagController;
use Illuminate\Support\Facades\Route;

$modulesPath = base_path('app/Modules');
$modules = array_filter(glob($modulesPath . '/*'), 'is_dir');
foreach ($modules as $modulePath) {
    $moduleName = basename($modulePath);
    $routesFile = $modulePath . '/Routes/web.php';
    if (file_exists($routesFile)) {
        require $routesFile;
    }
}

