<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->enum('gender', ['Male', 'Female']);
            $table->date('date_of_birth');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('title');
            $table->string('department');
            $table->string('shift_start', 5);
            $table->string('shift_end', 5);
            $table->string('contact_number');
            $table->string('emergency_contact_number');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informations');
    }
}
