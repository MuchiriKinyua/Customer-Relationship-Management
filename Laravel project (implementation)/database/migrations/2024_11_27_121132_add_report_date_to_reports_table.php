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
        Schema::table('reports', function (Blueprint $table) {
            $table->date('report_date')->after('employee_id'); // Adjust the position if needed
        });
    }
    
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('report_date');
        });
    }
    
};
