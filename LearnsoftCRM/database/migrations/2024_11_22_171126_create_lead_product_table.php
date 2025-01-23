<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadProductTable extends Migration
{
    public function up()
    {
        Schema::create('lead_product', function (Blueprint $table) {
            $table->id();  
            $table->Integer('lead_id');  
            $table->Integer('product_id');  
            $table->integer('quantity')->unsigned();  
            $table->timestamps();  

            // Adding foreign key constraints
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lead_product');
    }
}
