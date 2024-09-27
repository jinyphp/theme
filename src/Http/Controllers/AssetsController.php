<?php
namespace Jiny\Theme\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AssetsController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $uri = request()->path();

        //dd("assets");
        // 우선순위1
        if($res = $this->getResponseWWW($uri)) {
            return $res;
        }

        // 우선순위2
        if($res = $this->getResponseThemeByPath($uri)) {
            return $res;
        }

        // 우선순위3
        // if($res = $this->getResponseThemeByName($uri)) {
        //     return $res;
        // }

        // 파일이 없습니다.
    }

    private function getResponseWWW($uri)
    {
        // www 폴더에서 검색
        // 파일 경로 생성 (리소스 폴더의 www 하위에 파일이 있는 것으로 가정)
        $path = resource_path('www');
        $file = $path.DIRECTORY_SEPARATOR.$uri;
        if (file_exists($file)) {
            return $this->response($file);

        } else {
            // 우선순위 1-2
            // 슬롯이 적용되어 있는 경우
            $slot = www_slot();
            //dd($path.DIRECTORY_SEPARATOR.$slot.DIRECTORY_SEPARATOR.$uri);
            if($slot) {
                $file = $path.DIRECTORY_SEPARATOR.$slot.DIRECTORY_SEPARATOR.$uri;
                if (file_exists($file)) {
                    return $this->response($file);
                }
            }
        }
    }

    private function getResponseThemeByPath($uri)
    {
        // 리소스에 테마 경로까지 모두 지정한 경우
        // theme 폴더에서 검색
        $path = base_path('theme');

        $theme = theme()->getName();
        $theme = str_replace(".",DIRECTORY_SEPARATOR,$theme);
        //dump($theme);

        $filename = $path.DIRECTORY_SEPARATOR.$theme;
        $filename .= DIRECTORY_SEPARATOR.str_replace("/", DIRECTORY_SEPARATOR, $uri);

        // if (session()->has('theme')) {
        //     $theme = session('theme');
        // } else {
        //     $theme = "---";
        // }
        // dump($theme);
        // dd($filename);

        // $arr = explode('/',ltrim($uri, '/assets'));
        // $themePath = implode('/',
        // array_slice($arr, 0, 2))."/assets".'/'.implode('/',array_slice($arr, 2));
        // $file = $path.DIRECTORY_SEPARATOR.$themePath;
        // dd($file);
        if (file_exists($filename)) {
            return $this->response($filename);
        }
    }

    private function getResponseThemeByName($uri)
    {
        // 테마가 선택되어 있는 상태에서
        // assets 이 지정되는 경우, 테마를 지정하여 theme 폴더에서
        // $path = base_path('theme');
        // $theme = file_get_contents($path.DIRECTORY_SEPARATOR."default.txt");

        // if($theme) {
        //     // 디렉터리 기호 변경
        //     $theme = str_replace(".", DIRECTORY_SEPARATOR, $theme);

        //     $themePath = $theme.DIRECTORY_SEPARATOR.request()->path();
        //     $file = $path.DIRECTORY_SEPARATOR.$themePath;
        //     if (file_exists($file)) {
        //         return $this->response($file);
        //     }
        // }
    }

    private function getTheme($uri)
    {
        if($name = getThemeName()) {
            return $name;
        }

        $uri = ltrim($uri, '/assets');
        $arr = explode('/',ltrim($uri, '/assets'));
        return array_slice($arr, 0, 2);
    }

    private function contentType($file)
    {
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

            case "json":
                $mime="application/json";
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

        return $mime;
    }

    private function response($file)
    {
        // 파일 이름에서 확장자 추출
        $mime = $this->contentType($file);

        // BinaryFileResponse 인스턴스 생성
        $response = new BinaryFileResponse($file);

        // Content-Type 헤더 설정
        $response->headers->set('Content-Type', $mime);
        return $response;
    }
}
