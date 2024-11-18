<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactIconTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_icons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url',50);
            $table->unsignedBigInteger('user_id');
            $table->integer('stt')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('animation')->default(0)->comment('1: Có, 0: Không');
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
        Schema::dropIfExists('contact_icon');
    }
}
