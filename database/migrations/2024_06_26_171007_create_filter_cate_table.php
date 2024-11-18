<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterCateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_cate', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->bigInteger('cate_id');
            $table->integer('stt_filter')->nullable();
            $table->tinyInteger('special')->default(0)->comment('0: bình thường, 1: đặc biệt');
            $table->tinyInteger('top_filter')->default(0)->comment('0: phía sau, 1: đứng đầu');
            // $table->tinyInteger('is_select')->default(0)->comment('1: chọn nhiều, 0: chọn một');
            $table->tinyInteger('is_public')->default(0)->comment('1: hiển thị, 0: không hiển thị');
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
        Schema::dropIfExists('filter_cate');
    }
}
