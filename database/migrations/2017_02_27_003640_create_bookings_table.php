<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('locations_id')->unsigned();
            $table->foreign('locations_id')->references('id')->on('locations');
            $table->string('doc_numb', 250)->nullable();
            $table->string('name_booked', 100)->nullable();
            $table->date('delivery_date')->nullable();  
            $table->boolean('accepted')->nullable(); 
            $table->boolean('approved')->nullable(); 
            $table->string('approved_by', 100)->nullable(); 
            $table->string('reason_refusal', 250)->nullable();  
            $table->string('description', 250)->nullable();    
            $table->timestamps();
            $table->softDeletes();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
