<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComparesProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compare_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compare_id');
            $table->unsignedBigInteger('product_id');
            $table->string('display_compare')->nullable();
            $table->string('value_compare')->nullable();
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
        Schema::dropIfExists('compares_products');
    }
}
