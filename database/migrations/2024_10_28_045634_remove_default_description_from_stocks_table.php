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
    Schema::table('stocks', function (Blueprint $table) {
        $table->string('description')->default(null)->change();
    });
}

public function down()
{
    Schema::table('stocks', function (Blueprint $table) {
        $table->string('description')->default('No Description')->change();
    });
}

};
