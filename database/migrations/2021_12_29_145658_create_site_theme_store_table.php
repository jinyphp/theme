<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteThemeStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_theme_store', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('enable')->default(1);

            // 테마정보
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('author')->nullable();
            $table->string('email')->nullable();

            $table->string('code');
            $table->string('vendor')->nullable();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->string('version')->nullable();
            $table->string('css')->nullable();

            $table->string('category')->nullable();
            $table->string('price')->nullable();
            // prices : standard, multisite, extended
            $table->string('vote')->nullable();

            $table->text('content')->nullable();

            $table->unsignedBigInteger('reviews')->default(0);
            $table->unsignedBigInteger('cnt')->default(0);  // 다운로드 횟수

            $table->string('description')->nullable();
            // 작업자ID
            $table->unsignedBigInteger('user_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_theme_store');
    }
}
