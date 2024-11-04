<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    DB::table('stocks')->whereNull('description')->update(['description' => 'No Description']);
    Schema::table('stocks', function (Blueprint $table) {
        $table->string('description')->default('No Description')->change();
    });
}

public function down()
{
    Schema::table('stocks', function (Blueprint $table) {
        $table->string('description')->nullable()->change();
    });
}

};
