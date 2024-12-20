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
    Schema::table('daily_reports', function (Blueprint $table) {
        $table->Integer('report_id'); // Add the foreign key column
        
        // Optionally, add the foreign key constraint (if you want to enforce this relationship)
        $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('daily_reports', function (Blueprint $table) {
        $table->dropForeign(['report_id']);
        $table->dropColumn('report_id');
    });
}

};
