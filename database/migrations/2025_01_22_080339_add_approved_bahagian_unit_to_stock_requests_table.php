<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->string('approved_bahagian_unit')->nullable()->after('approved_name');
        });
    }
    
    public function down()
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->dropColumn('approved_bahagian_unit');
        });
    }
    
};
