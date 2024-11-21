<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('supplier_id')->nullable();
            $table->string('supplier_name')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('name')->nullable();
            $table->string('cost_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('paid')->nullable();
            $table->string('due')->nullable();
            $table->string('selling_price')->nullable();
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
        Schema::dropIfExists('buys');
    }
}
