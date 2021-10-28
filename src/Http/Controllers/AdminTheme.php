<?php

namespace Jiny\Theme\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;

use Jiny\Members\Http\Controllers\CrudController;

class AdminTheme extends CrudController
{
    public function __construct()
    {
        //$this->initRules($this::class);
        //app()->instance("LiveDataController", $this);

        // 테이블 확인
        //Schema::dropIfExists("theme");
        /*
        if (!$this->isTable("theme")) {
            Schema::create("theme", function (Blueprint $table) {
                $table->id();
                $table->string('enable')->nullable();
                $table->integer('ref')->default(0);
                $table->integer('level')->default(1);
                $table->integer('pos')->default(0);
                $table->timestamps();

                $table->string('regdate')->nullable();
                $table->string('title')->nullable();
                $table->string('image')->nullable();
                $table->string('description')->nullable();
            });
        }
        */

    }

    public function index()
    {
        

        //dd($themeList);
        return view("jinytheme::admin.themelist");
    }



}
