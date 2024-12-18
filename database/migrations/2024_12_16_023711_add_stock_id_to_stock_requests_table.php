<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        //$table->unsignedBigInteger('stock_id')->nullable(); // Add the column
        $table->foreign('stock_id')->references('stock_id')->on('stocks')->onDelete('cascade'); // Add a foreign key constraint
    });
}

public function down()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->dropForeign(['stock_id']);
        $table->dropColumn('stock_id');
    });
}
};
