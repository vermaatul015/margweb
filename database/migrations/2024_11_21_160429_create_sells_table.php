<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('supplier_id')->nullable();
            $table->string('supplier_name')->nullable();
            $table->integer('stock_id')->nullable();
            $table->string('name')->nullable();
            $table->string('selling_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('total_selling_price')->nullable();
            $table->string('amount_received')->nullable();
            $table->string('due')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sells');
    }
}
