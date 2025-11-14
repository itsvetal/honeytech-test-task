<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

$modulesPath = base_path('app/Modules');
$modules = array_filter(glob($modulesPath . '/*'), 'is_dir');
foreach ($modules as $modulePath) {
    $moduleName = basename($modulePath);
    $routesFile = $modulePath . '/Routes/api.php';
    if (file_exists($routesFile)) {
        require $routesFile;
    }
}

Route::get('/user', function (Request $request) {
    return $request->user();
});
