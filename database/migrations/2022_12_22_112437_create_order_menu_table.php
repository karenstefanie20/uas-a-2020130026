<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_menu', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->references('id')->on('orders')->constrained()->onDelete('cascade');
            $table->char('menu_id',6)->references('id')->on('menus')->constrained()->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->constrained()->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menus')->constrained()->onDelete('cascade');
            $table->integer('quantity')->nullable();
        });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_menu');
    }
}
