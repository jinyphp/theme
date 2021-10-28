<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Jiny\Theme\Http\Controllers\AdminTheme;
use Jiny\Theme\Http\Controllers\AdminThemeCopy;
Route::middleware(['web'])
    ->prefix('/admin/theme')->name("admin-theme")->group(function () {
        Route::resource('/list', AdminTheme::class);
        Route::resource('/copy', AdminThemeCopy::class);

    });



