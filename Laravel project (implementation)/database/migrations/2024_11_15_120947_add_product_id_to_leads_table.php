<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->Integer('product_id')->nullable()->after('description'); 
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null'); // Add a foreign key linking to the `products` table.
        });
    }

    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};
