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
    Schema::table('departments', function (Blueprint $table) {
        $table->Integer('employee_id')->nullable()->after('description');
        $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('departments', function (Blueprint $table) {
        $table->dropForeign(['employee_id']);
        $table->dropColumn('employee_id');
    });
}

};
