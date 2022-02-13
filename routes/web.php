<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Jiny\Theme\Http\Controllers\AdminTheme;
use Jiny\Theme\Http\Controllers\AdminThemeCopy;

// 관리자 URL
Route::middleware(['web','auth:sanctum', 'verified'])
->name('admin.theme.')
->prefix('/admin/theme')->group(function () {

    Route::resource('list', \Jiny\Theme\Http\Controllers\Admin\ThemeListController::class);
    Route::resource('store', \Jiny\Theme\Http\Controllers\Admin\ThemeStoreController::class);

    //Route::resource('/list', AdminTheme::class);
    Route::resource('/copy', AdminThemeCopy::class);
});


// 테마내용보기
/*
Route::middleware(['web',])
->name('theme.')
->prefix('/theme')->group(function () {
    Route::get('/{vendor?}/{name?}', [\Jiny\Theme\Http\Controllers\ThemeExplore::class,'index']);

});
*/
