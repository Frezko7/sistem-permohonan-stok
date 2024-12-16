<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupIdToStockRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->string('group_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });
    }
}

