<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('business_id');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->float('price');
            $table->integer('type'); //寄送方式
            $table->string('tracking')->nullable(); //如果是快递的话
            $table->integer('status')->default(0); //订单状态
            $table->string('remark')->nulladble(); //备注
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
        Schema::dropIfExists('orders');
    }
}
