<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nametag', 12);
            $table->string('name_contractor', 50);
            $table->string('country', 100);
            $table->string('city', 50);
            $table->string('street',50)->nullable();    
            $table->string('street_number',10)->nullable();    
            $table->string('postcode',10)->nullable();     
            $table->string('telephone', 50)->nullable();
            $table->string('email', 50)->nullable(); 
            $table->string('nip', 10)->nullable();
            $table->string('regon', 14)->nullable();
            $table->string('description', 250)->nullable();    
            $table->boolean('disable')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contractors');
    }
}
