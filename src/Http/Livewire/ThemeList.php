<?php
namespace Jiny\Theme\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Jiny\Theme\Http\Livewire\WireTableJson;
class ThemeList extends WireTableJson
{
    public function mount()
    {
        $this->actions['filename'] = "theme.json";

        $this->actions['view']['table'] = 'jinytheme::livewire.theme.tile';
        $this->actions['view']['list'] = 'jinytheme::livewire.theme.cell';
        $this->actions['view']['form'] = 'jinytheme::livewire.theme.form';


        // 초기화, json 데이터 읽기
        parent::mount();
    }

    public function render()
    {
        $path = base_path("theme");
        // check .git folder
        foreach($this->rows as &$item) {
            if(is_dir($path."/".$item['code']."/.git")) {
                $item['git'] = true;
            } else {
                $item['git'] = false;
            }
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

    public function delete($id=null)
    {
        $path = storage_path('app');
        $filename = $path."/".$this->forms['snapshot'];
        //dd($filename);

        if(file_exists($filename)) {
            unlink($filename);
        }



        parent::delete($id);
    }

}
