<?php
namespace Jiny\Theme\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class WireTableJson extends Component
{
    use WithFileUploads;
    use \Jiny\WireTable\Http\Trait\Upload;

    public $actions=[];

    public $filename;
    public $user_id;
    public $row_id;

    public $rows = [];
    public $edit_id;
    public $forms = [];
    public $selected;

    public $popupForm = false;
    public $viewFile;

    public function mount()
    {
        $this->filename = $this->actions['filename'];
        $this->viewFile = $this->actions['view']['table'];

        $this->jsonLoad();
        $this->setActive();
    }

    public function jsonLoad()
    {
        $filePath = base_path($this->filename);
        if(file_exists($filePath)) {
            $json = file_get_contents($filePath);
            $this->rows = json_decode($json, true);
        }

        return $this;
    }

    public function setActive($active=null)
    {
        if($active) {
            $this->selected = $active;
        } else {
            foreach($this->rows as $key => $item) {
                if(isset($item['active']) && $item['active']) {
                    $this->selected = $key;
                }
            }
        }
    }

    public function render()
    {
        return view($this->viewFile);
    }

    public function create()
    {
        $this->popupForm = true;
        $this->forms = [];
    }

    public function close()
    {
        $this->popupForm = false;
        $this->forms = [];
    }

    public function store()
    {
        // 파일 업로드 체크 Trait
        $this->fileUpload();

        // 신규 데이터 저장
        $this->rows []= $this->forms;
        $this->saveRowsToJson();

        $this->close();
    }

    public function edit($id)
    {
        $this->popupForm = true;
        $this->edit_id = $id;

        $this->forms = $this->rows[$id];
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

    public function cancel()
    {
        $this->close();
    }

    public function delete($id=null)
    {
        $this->popupForm = false;

        $id = $this->edit_id;
        unset($this->rows[$id]);

        // 수정한 데이터 저장
        $this->saveRowsToJson();

        $this->forms = [];
    }


    public function active($id)
    {
        foreach($this->rows as $i => &$item) {
            // 하나만 선택됨
            if($i == $id) {
                $item['active'] = true;
            } else {
                $item['active'] = false;
            }
        }

        // 수정한 데이터 저장
        $this->saveRowsToJson();
    }

    public function enable($id)
    {
        foreach($this->rows as $i => &$item) {
            if($i == $id) {
                // 토글
                if($item['enable'] == false) {
                    $item['enable'] = true;
                } else {
                    $item['enable'] = false;
                }
            }
        }

        // 수정한 데이터 저장
        $this->saveRowsToJson();
    }

    private function saveRowsToJson()
    {
        $filePath = base_path($this->filename);
        $json = json_encode($this->rows, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($filePath,$json);
    }

}
