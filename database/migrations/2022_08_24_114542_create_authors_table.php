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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique()->index()->nullable();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('name')->nullable();
            $table->string('role')->nullable();
            $table->json('description')->nullable();
            $table->string('link')->nullable();
            $table->json('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
};
