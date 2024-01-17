<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('authorables', function (Blueprint $table) {
            $table->foreignUlid('author_id');
            $table->ulidMorphs('authorable');
            // $table->bigInteger('authorable_id')->nullable();
            // $table->string('authorable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('authorables');
    }
};
