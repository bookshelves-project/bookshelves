<?php

use App\Enums\BookTypeEnum;
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug_sort')->nullable();
            $table->string('slug')->unique()->index();
            $table->string('contributor')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('released_on')->nullable();
            $table->string('rights')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('page_count')->nullable();
            $table->boolean('is_maturity_rating')->default(0);
            $table->boolean('is_hidden')->default(0);
            $table->enum('type', BookTypeEnum::toList())->default(BookTypeEnum::novel->value);
            $table->string('isbn10')->nullable();
            $table->string('isbn13')->nullable();
            $table->json('identifiers')->nullable();
            $table->string('google_book_id')->nullable();
            $table->string('physical_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
