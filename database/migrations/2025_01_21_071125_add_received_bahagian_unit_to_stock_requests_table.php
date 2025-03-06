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
        $table->string('received_bahagian_unit')->nullable()->after('received_name');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->dropColumn('received_bahagian_unit');
        });
    }
    
};
