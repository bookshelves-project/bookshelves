<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cms_navigations', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->string('route')->nullable();
            $table->string('category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cms_navigations');
    }
};
