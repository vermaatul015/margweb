<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySellTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sells', function (Blueprint $table) {
            $table->string('total_recieved_amount')->after('total_selling_price')->nullable();
            $table->dropColumn('stock_id');
            $table->dropColumn('name');
            $table->dropColumn('selling_price');
            $table->dropColumn('quantity');
            $table->dropColumn('amount_received');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sells', function (Blueprint $table) {
            $table->dropColumn('total_recieved_amount')->nullable();
            $table->integer('stock_id')->after('supplier_name')->nullable();
            $table->string('name')->after('stock_id')->nullable();
            $table->string('selling_price')->after('name')->nullable();
            $table->integer('quantity')->after('selling_price')->nullable();
            $table->string('amount_received')->after('total_selling_price')->nullable();
        });
    }
}
