<?php
namespace Jiny\Theme\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Jiny\Theme\Http\Livewire\WireTableJson;
class ThemeListJson extends WireTableJson
{


    public function mount()
    {
        $this->actions['filename'] = "theme/theme.json";

        $this->actions['view']['table'] = 'jinytheme::admin.list.tile';
        $this->actions['view']['list'] = 'jinytheme::admin.list.cell';
        $this->actions['view']['form'] = 'jinytheme::admin.list.form';


        // 초기화, json 데이터 읽기
        parent::mount();
    }

    public function render()
    {

        $path = base_path("theme");
        // check .git folder
        foreach($this->rows as &$item) {
            /*
            if(is_dir($path."/".$item['code']."/.git")) {
                $item['git'] = true;
            } else {
                $item['git'] = false;
            }
            */
        }



        return parent::render();
    }

    // 오버로드
    public function store()
    {
        if(isset($this->forms['code'])) {
            $code = $this->forms['code'];
            $path = base_path('theme/'.$code);
            if(!is_dir($path)) mkdir($path,0777,true);
        }

        parent::store();
    }

    public function update()
    {
        // 파일 업로드 체크 Trait
        $this->fileUpload();

        // 변경된 데이터, 목록 반영
        $id = $this->edit_id;
        $this->rows[$id] = $this->forms;
        //dd($this->rows[$id]);

        // 변경된 데이터 저장
        $this->saveRowsToJson();

        $this->popupForm = false;
        $this->edit_id = null;
    }

    public function delete($id=null)
    {
        /*
        $path = storage_path('app');
        $filename = $path."/".$this->forms['snapshot'];
        //dd($filename);

        if(file_exists($filename)) {
            unlink($filename);
        }




        */

        parent::delete($id);

    }

}
