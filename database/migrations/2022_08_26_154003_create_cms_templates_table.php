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
        Schema::create('cms_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->index()->unique();
            $table->string('language');
            $table->string('type');
            $table->json('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cms_templates');
    }
};
