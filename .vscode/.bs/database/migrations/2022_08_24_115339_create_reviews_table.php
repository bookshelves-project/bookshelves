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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->integer('rating')->nullable();
            $table->foreignId('user_id')->index()->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
            ;
            $table->foreignId('reviewable_id')->nullable();
            $table->string('reviewable_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
