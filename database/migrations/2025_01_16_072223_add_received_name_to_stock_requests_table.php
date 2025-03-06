<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->string('received_name')->nullable()->after('date_approved');
        });
    }
    
    public function down()
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->dropColumn('received_name');
        });
    }
    
};
