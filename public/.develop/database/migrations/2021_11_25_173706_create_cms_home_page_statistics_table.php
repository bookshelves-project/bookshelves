<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsHomePageStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cms_home_page_statistics', function (Blueprint $table) {
            $table->id();
            $table->json('label')->nullable();
            $table->string('link')->nullable();
            $table->string('model')->nullable();
            $table->json('modelWhere')->nullable();
            $table->foreignId('home_page_id')->index()->nullable();
            $table->foreign('home_page_id')
                ->references('id')
                ->on('cms_home_pages')
                ->nullOnDelete()
            ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cms_home_page_statistics');
    }
}
