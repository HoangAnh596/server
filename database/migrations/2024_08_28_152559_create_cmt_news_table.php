<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmtNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmt_news', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->bigInteger('parent_id');
            $table->unsignedBigInteger('new_id');
            $table->bigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('slugNew');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->tinyInteger('star')->nullable();
            $table->tinyInteger('is_public')->default(0)->comment('0: không hiển thị, 1: hiển thị');
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
        Schema::dropIfExists('cmt_post');
    }
}
