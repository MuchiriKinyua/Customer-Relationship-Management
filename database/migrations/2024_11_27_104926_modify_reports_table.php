<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Remove old columns (adjust as necessary)
            $table->dropColumn([
                'lead_id',
                'client_id',
                'lead_date',
                'client_date',
                'product_id',
                'quantity_ordered',
            ]);

            // Add new columns
            $table->Integer('employee_id'); // Foreign key to employees table
            $table->text('monday')->nullable();
            $table->text('tuesday')->nullable();
            $table->text('wednesday')->nullable();
            $table->text('thursday')->nullable();
            $table->text('friday')->nullable();
            $table->text('summary')->nullable();

            // Add foreign key constraint for employee_id
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Remove new columns
            $table->dropForeign(['employee_id']);
            $table->dropColumn([
                'employee_id',
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'summary',
            ]);

            // Re-add old columns (adjust as necessary)
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->date('lead_date')->nullable();
            $table->date('client_date')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('quantity_ordered')->nullable();
        });
    }
}
