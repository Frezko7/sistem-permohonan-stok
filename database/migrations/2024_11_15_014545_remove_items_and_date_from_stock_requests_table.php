<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->dropColumn(['items', 'date']);
    });
}

public function down()
{
    Schema::table('stock_requests', function (Blueprint $table) {
        $table->string('items')->nullable();
        $table->date('date')->nullable();
    });
}

};
