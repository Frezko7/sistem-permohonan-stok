<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->string('approved_name')->nullable()->after('date_approved'); // Adjust 'status' to the appropriate column.
    });
}

public function down()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->dropColumn('approved_name');
    });
}

};
