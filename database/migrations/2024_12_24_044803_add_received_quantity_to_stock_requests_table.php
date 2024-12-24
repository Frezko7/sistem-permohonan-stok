<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // In the migration file
public function up()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->integer('received_quantity')->nullable()->after('date_approved'); // Add the received_quantity field
    });
}

public function down()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->dropColumn('received_quantity');
    });
}

};
