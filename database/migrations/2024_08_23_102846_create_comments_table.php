<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->bigInteger('parent_id');
            $table->unsignedBigInteger('product_id');
            $table->bigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('slugProduct');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->tinyInteger('star')->nullable();
            $table->tinyInteger('is_public')->default(0)->comment('0: không hiển thị, 1: hiển thị');
            $table->timestamps();
            // $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
