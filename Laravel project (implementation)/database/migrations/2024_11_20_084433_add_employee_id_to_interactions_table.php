<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeIdToInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interactions', function (Blueprint $table) {
            $table->Integer('employee_id')->nullable(); // Add employee_id column
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null'); // Create foreign key relationship (optional, if you have an 'employees' table)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interactions', function (Blueprint $table) {
            $table->dropForeign(['employee_id']); // Drop foreign key (if added)
            $table->dropColumn('employee_id'); // Drop the employee_id column
        });
    }
}
