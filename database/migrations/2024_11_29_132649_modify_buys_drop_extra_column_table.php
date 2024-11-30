<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBuysDropExtraColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->string('total_paid_amount')->after('total_cost_price')->nullable();
            $table->dropColumn('product_id');
            $table->dropColumn('name');
            $table->dropColumn('cost_price');
            $table->dropColumn('quantity');
            $table->dropColumn('paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->dropColumn('total_paid_amount')->nullable();
            $table->integer('product_id')->after('supplier_name')->nullable();
            $table->string('name')->after('product_id')->nullable();
            $table->string('cost_price')->after('name')->nullable();
            $table->integer('quantity')->after('cost_price')->nullable();
            $table->string('paid')->after('total_cost_price')->nullable();
        });
    }
}
