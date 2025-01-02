<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subCate')->nullable();
            $table->string('slug');
            $table->unsignedBigInteger('user_id');
            $table->string('related_pro')->nullable();
            $table->string('tag_ids')->nullable();
            $table->string('code', 50);
            $table->tinyInteger('status')->default(1)->comment('1: còn hàng, 0: hết hàng');
            $table->tinyInteger('is_outstand')->default(0)->comment('1: nổi bật, 0: không nổi bật');
            $table->string('price')->nullable();
            $table->float('quantity', 8, 2)->nullable();
            $table->unsignedTinyInteger('discount')->nullable();
            $table->string('image_ids')->nullable();
            $table->string('group_ids')->nullable();
            $table->string('config_pr')->nullable();
            $table->string('cpu_pr')->nullable();
            $table->string('ram_pr')->nullable();
            $table->string('hdd_pr')->nullable();
            $table->text('des')->nullable();
            $table->text('content')->nullable();
            $table->text('title_seo')->nullable();
            $table->text('keyword_seo')->nullable();
            $table->text('des_seo')->nullable();
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
        Schema::dropIfExists('products');
    }
}
