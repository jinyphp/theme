<?php

namespace Jiny\Theme\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Jiny\Action\Http\Livewire\LiveData;
use Jiny\Action\Http\Livewire\LiveTable;

class LiveTreeJson extends Component
{

    public function mount()
    {

    }
    
    public function render()
    {
        $themeList = theme()->getThemeList();
        return view("jinytheme::livewire.tree",['tree'=>$themeList]);
    }


}
