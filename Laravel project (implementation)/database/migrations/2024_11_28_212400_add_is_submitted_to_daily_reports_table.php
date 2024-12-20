<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSubmittedToDailyReportsTable extends Migration
{
    public function up()
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            $table->boolean('is_submitted')->default(0);  // Only add the 'is_submitted' column
        });
    }

    public function down()
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            $table->dropColumn('is_submitted');  // Drop the 'is_submitted' column
        });
    }
}
