<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('url_text');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('description');
            $table->string('image')->nullable();
            $table->tinyInteger('is_color')->default(0)->comment('1: Màu trắng, 0: Màu đen');
            $table->tinyInteger('is_public')->default(0)->comment('1: Hiển thị, 0: Ẩn');
            $table->integer('stt_slider')->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
