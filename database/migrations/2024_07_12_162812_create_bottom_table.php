<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBottomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bottom', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url',50);
            $table->unsignedBigInteger('user_id');
            $table->integer('stt')->nullable();
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
        Schema::dropIfExists('bottom');
    }
}
