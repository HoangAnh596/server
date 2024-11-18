<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInforsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 15);
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('desc_role')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('role')->default('0');
            $table->string('skype')->nullable();
            $table->string('zalo')->nullable();
            $table->string('gmail')->nullable();
            $table->integer('stt')->nullable();
            $table->tinyInteger('send_price')->default(0)->comment('0: không nhận mail, 1: nhận mail');
            $table->tinyInteger('is_public')->default(0)->comment('1: hiển thị, 0: không hiển thị');
            $table->tinyInteger('is_contact')->default(0)->comment('1: hiển thị, 0: không hiển thị');
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
        Schema::dropIfExists('infors');
    }
}
