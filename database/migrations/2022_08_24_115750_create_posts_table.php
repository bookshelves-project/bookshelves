<?php

use App\Enums\PublishStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('status')->default(PublishStatusEnum::published->value);
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->boolean('pin')->default(0);
            $table->string('slug');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->foreignId('user_id')->index()->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('posts');
    }
};
