<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->date('request_date');
        });
    }

    public function down()
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->dropColumn('request_date');
        });
    }
};
