<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cate_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable();
            $table->bigInteger('parent_menu');
            $table->unsignedBigInteger('user_id');
            $table->integer('stt_menu')->nullable();
            // $table->string('image')->nullable();
            $table->tinyInteger('is_public')->default(0)->comment('1: hiển thị, 0: không hiển thị');
            $table->tinyInteger('is_tab')->default(0)->comment('1: mở tab mới, 0: không mở tab');
            $table->tinyInteger('is_click')->default(0)->comment('1: click, 0: không click');
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
        Schema::dropIfExists('cate_menu');
    }
}
