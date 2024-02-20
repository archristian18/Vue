<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->float('total_price', 8, 2);

            // Define customer_id and menu_id columns
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('menu_id')->nullable();

            // Define foreign key constraints
            $table->foreign('customer_id')
                ->references('id')
                ->on('customer_orders')
                ->onDelete('cascade');
            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lists');
    }
};
