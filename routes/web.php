<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Jiny\Theme\Http\Controllers\AdminTheme;
use Jiny\Theme\Http\Controllers\AdminThemeCopy;

// 관리자 URL
Route::middleware(['web','auth:sanctum', 'verified'])
->name('admin.theme.')
->prefix('/admin/themes')->group(function () {
    Route::resource('/', \Jiny\Theme\Http\Controllers\Admin\ThemeListController::class);
});

Route::middleware(['web','auth:sanctum', 'verified'])
->name('admin.theme.')
->prefix('/admin/theme')->group(function () {

    Route::resource('/store', \Jiny\Theme\Http\Controllers\Admin\ThemeStoreController::class);
    Route::resource('/copy', AdminThemeCopy::class);
});



// 테마 리소스의 aseet 파일을 반환하는 response
Route::middleware(['web'])
->prefix('/assets')->group(function () {
    $uri = ltrim(request()->path(), '/assets');
    //$uri = ltrim($_SERVER['REQUEST_URI'], '/assets');
    $arr = explode('/',ltrim($uri, '/assets'));
    $themePath = implode('/',array_slice($arr, 0, 2))."/assets".'/'.implode('/',array_slice($arr, 2));
    $path = base_path('theme');

    $file = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $path.DIRECTORY_SEPARATOR.$themePath);
    if(file_exists($file)) {
        Route::get($uri, function () use ($file) {
            return response()->file($file);
        });
    }

});


