<?php

use App\Enums\GenderEnum;
use App\Enums\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_blocked')->default(0);
            $table->rememberToken();
            $table->text('about')->nullable();
            $table->string('gender')->default(GenderEnum::unknown->value);
            $table->string('role')->default(UserRole::user->value);
            $table->string('pronouns')->nullable();
            $table->boolean('use_gravatar')->default(0);
            $table->boolean('display_favorites')->default(0);
            $table->boolean('display_reviews')->default(0);
            $table->boolean('display_gender')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
