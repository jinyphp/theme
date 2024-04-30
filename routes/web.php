<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Jiny\Theme\Http\Controllers\AdminTheme;
use Jiny\Theme\Http\Controllers\AdminThemeCopy;

// 지니어드민 패키지가 설치가 되어 있는 경우에만 실행
if(function_exists("isAdminPackage")) {

    // admin prefix 모듈 검사
    if(function_exists('admin_prefix')) {
        $prefix = admin_prefix();
    } else {
        $prefix = "admin";
    }

    Route::middleware(['web', 'auth'])
    ->name('admin.')
    ->prefix($prefix."/theme")->group(function () {
        Route::get('setting', [\Jiny\Theme\Http\Controllers\SettingController::class,"index"]);

        Route::resource('/store', \Jiny\Theme\Http\Controllers\Admin\ThemeStoreController::class);
        Route::resource('/copy', AdminThemeCopy::class);

        Route::resource('/list', \Jiny\Theme\Http\Controllers\Admin\ThemeListController::class);

        // 사이트 데쉬보드
        Route::get('/', [
            \Jiny\Theme\Http\Controllers\Admin\AdminThemeDashboard::class,
            "index"]);
    });


}



/**
 * Theme Assets
 * 테마 리소스의 aseet 파일을 반환하는 response
 */
Route::middleware(['web'])
->name('assets.')
->prefix('/assets')->group(function () {
    Route::get('{any}', [
        \Jiny\Theme\Http\Controllers\AssetsController::class,
        'index'])->where('any', '.*');
});

/*
use Symfony\Component\HttpFoundation\BinaryFileResponse;
Route::middleware(['web'])
->prefix('/assets')->group(function () {
    $uri = ltrim(request()->path(), '/assets');
    $arr = explode('/',ltrim($uri, '/assets'));

    $themePath = implode('/',array_slice($arr, 0, 2))."/assets".'/'.implode('/',array_slice($arr, 2));
    $path = base_path('theme');

    $file = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $path.DIRECTORY_SEPARATOR.$themePath);
    if(file_exists($file)) {
        Route::get($uri, function () use ($file) {

            // 파일 이름에서 확장자 추출
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            switch( $extension ) {
                case "css":
                    // CSS 파일인 경우
                    $mime="text/css";
                    break;
                case "js":
                    // 예를 들어, JavaScript 파일인 경우
                    $mime="application/javascript";
                    break;

                case "gif":
                    $mime="image/gif";
                    break;
                case "png":
                    $mime="image/png";
                    break;
                case "jpeg":
                case "jpg":
                    $mime="image/jpeg";
                    break;
                case "svg":
                    $mime="image/svg+xml";
                    break;
                default:
                    // 기본적으로 알려진 MIME 유형이 없는 경우
                    $mime="application/octet-stream";
            }

            // BinaryFileResponse 인스턴스 생성
            $response = new BinaryFileResponse($file);

            // Content-Type 헤더 설정
            $response->headers->set('Content-Type', $mime);
            //dd($mime);
            return $response;



        });
    }

});
*/


/**
 * 파일 업로드
 */
Route::post('/admin/theme/upload',[
    \Jiny\Theme\Http\Controllers\Admin\UploadController::class,
    'upload'
]);// ->middleware(['web', 'auth'])->name('theme.upload');
