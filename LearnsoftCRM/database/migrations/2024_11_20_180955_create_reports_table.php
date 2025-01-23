<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');  // Foreign key to employees
            $table->string('employee_name');  // Name of the employee
            $table->string('lead_name')->nullable();  // Name of the lead
            $table->string('client_name')->nullable();  // Name of the client
            $table->date('lead_date')->nullable();  // Date the lead was created
            $table->date('client_date')->nullable();  // Date the client was created
            $table->unsignedBigInteger('product_id')->nullable();  // Foreign key to products
            $table->integer('quantity_ordered')->nullable();  // Quantity ordered
            $table->date('order_date')->nullable();  // Order date
            $table->string('order_status', 50)->nullable();  // Status of the order
            $table->string('interaction_type', 250);  // Type of interaction
            $table->date('start_date');  // Start date of the report
            $table->date('end_date');  // End date of the report
            $table->timestamps();  // Created at and updated at timestamps

            // Foreign key constraints
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
