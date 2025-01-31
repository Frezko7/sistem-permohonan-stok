<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->date('date')->nullable()->after('status'); // Adds a nullable date column
    });
}

public function down()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->dropColumn('date');
    });
}

};
