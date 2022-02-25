<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsHomePagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cms_home_pages', function (Blueprint $table) {
            $table->id();
            $table->json('hero_title')->nullable();
            $table->json('hero_text')->nullable();
            $table->json('statistics_eyebrow')->nullable();
            $table->json('statistics_title')->nullable();
            $table->json('statistics_text')->nullable();
            $table->json('logos_title')->nullable();
            $table->json('features_title')->nullable();
            $table->json('features_text')->nullable();
            $table->boolean('display_statistics')->nullable();
            $table->boolean('display_logos')->nullable();
            $table->boolean('display_features')->nullable();
            $table->boolean('display_latest')->nullable();
            $table->boolean('display_selection')->nullable();
            $table->boolean('display_highlights')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cms_home_page');
    }
}
