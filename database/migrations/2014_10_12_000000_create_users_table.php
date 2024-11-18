<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('email')->unique();
            $table->string('password', 100);
            $table->string('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('content')->nullable();
            $table->string('title_img')->nullable();
            $table->string('alt_img')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('skype')->nullable();
            $table->string('linkedin')->nullable();
            $table->integer('stt')->nullable();
            $table->rememberToken();
            $table->softdeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
