<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_adjustments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('timesheet_id');
            $table->date('date');
            $table->time('time_out')->nullable();
            $table->time('time_in')->nullable();
            $table->string('adjustment_status')->default('pending');
            $table->timestamps();

            $table->foreign('timesheet_id')->references('id')->on('time_sheets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_adjustments');
    }
}
