<?php

namespace Jiny\Theme\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        //dd("upload");
        // 요청에서 파일 가져오기
        $file = $request->file('file');

        // 파일이 유효한지 확인
        if ($file->isValid()) {
            // 파일을 저장
            // 파일을 업로드한 후에 저장된 경로를 얻어옴
            $path = $file->store('theme/img');
            $sourceFilePath = Storage::path($path);

            // 저장된 파일을 원하는 위치로 이동시킴
            $destinationFilePath = base_path('theme/img')."/";
            $destinationFilePath .= $file->getClientOriginalName();
            rename($sourceFilePath, $destinationFilePath);

            // 성공 응답 반환
            return response()->json([
                'success' => true,
                'path' => $path
                //,
                //'absolutePath' => $absolutePath,
                //'newPath '=>$newPath
            ]);
        } else {
            // 실패 응답 반환
            return response()->json(['success' => false]);
        }

    }
}
