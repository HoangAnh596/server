<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 15);
            $table->string('gmail')->nullable();
            $table->string('product');
            $table->integer('quantity')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('purpose')->default(0)->comment('0: công ty, 1: dự án');
            $table->tinyInteger('status')->default(0)->comment('0: chưa, 1: đã báo giá');
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
        Schema::dropIfExists('quotes');
    }
}
