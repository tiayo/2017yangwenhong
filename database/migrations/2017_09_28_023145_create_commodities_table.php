<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('user_id');
            $table->string('name'); //商品名称
            $table->float('price'); //商品价格
            $table->integer('stock'); //商品库存
            $table->string('unit'); //商品计数单位（个、斤等）
            $table->longText('description'); //商品描述
            $table->integer('type')->default(0); //商品分组（默认无分组0）
            $table->integer('status')->default(0); //商品状态（默认下架）
            $table->string('image')->nullable(); //封面图片
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
        Schema::dropIfExists('commodities');
    }
}
