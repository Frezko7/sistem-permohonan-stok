<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->date('date_approved')->nullable()->after('approved_quantity'); // Adjust the position as needed
    });
}

public function down()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->dropColumn('date_approved');
    });
}
};
