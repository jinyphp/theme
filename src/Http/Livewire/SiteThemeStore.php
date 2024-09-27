<?php
namespace Jiny\Theme\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Jiny\WireTable\Http\Livewire\PopupCreateUpdateDelete;
class SiteThemeStore extends PopupCreateUpdateDelete
{
    public $actions = [];
    public $slug;

    public $rows = [];
    use WithPagination;

    public $viewFile;


    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jinytheme::site.store.table";
        }
        parent::mount();
    }

    public function render()
    {
        if($this->slug) {
            return $this->detail("jinytheme::site.store.view");
        }

        return $this->list($this->viewFile);
    }

    private function detail($viewFile)
    {
        $row = DB::table('site_theme_store')->where('code', $this->slug)->first();

        return view($viewFile,[
            'row' => $row
        ]);
    }

    private function list($viewFile)
    {
        $rows = DB::table('site_theme_store')->get();
        $this->rows = [];
        foreach($rows as $item) {
            $temp = [];
            foreach($item as $k => $v) {
                $temp[$k] = $v;
            }
            $this->rows []= $temp;
        }

        return view($viewFile);

    }






}
