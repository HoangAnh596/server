<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCateFooterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cate_footer', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('title');
            $table->bigInteger('parent_menu');
            $table->unsignedBigInteger('user_id');
            $table->text('content')->nullable();
            $table->integer('stt_menu')->nullable();
            $table->tinyInteger('is_role')->default(0)->comment('0: mặc định, 1: chính sách, 2: thông tin khác');
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
        Schema::dropIfExists('cate_footer');
    }
}
