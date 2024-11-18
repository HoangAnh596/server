<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexToExistingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unique('slug');
            $table->index('parent_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unique('name');
            $table->unique('slug');
            $table->unique('code');
            $table->index('is_outstand');
            $table->index('created_at');
        });

        Schema::table('category_news', function (Blueprint $table) {
            $table->unique('slug');
            $table->index('parent_id');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->unique('slug');
            $table->index('cate_id');
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->index(['category_id', 'product_id']);
        });
        Schema::table('filters_products', function (Blueprint $table) {
            $table->index(['filter_id', 'product_id']);
        });
        Schema::table('group_products', function (Blueprint $table) {
            $table->index(['group_id', 'product_id']);
        });
        Schema::table('compare_products', function (Blueprint $table) {
            $table->index(['compare_id', 'product_id']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->index(['product_id', 'parent_id']);
            $table->index('created_at');
        });
        Schema::table('cmt_news', function (Blueprint $table) {
            $table->index(['new_id', 'parent_id']);
            $table->index('created_at');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->index(['is_public', 'stt']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['parent_id']);
        });
    
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['slug']);
            $table->dropIndex(['code']);
        });
    
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['category_id']);
        });
    }
}
