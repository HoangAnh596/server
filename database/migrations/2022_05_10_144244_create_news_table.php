<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('slugParent');
            $table->unsignedBigInteger('cate_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('is_outstand')->default(0)->comment('1: nổi bật, 0: không nổi bật');
            $table->string('view_count')->nullable();
            $table->text('desc')->nullable();
            $table->string('image')->nullable();
            $table->text('content')->nullable();
            $table->string('title_img')->nullable();
            $table->string('alt_img')->nullable();
            $table->string('title_seo')->nullable();
            $table->string('keyword_seo')->nullable();
            $table->string('des_seo')->nullable();
            $table->timestamps();
            // $table->foreign('cate_id')->references('id')->on('category_news');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
