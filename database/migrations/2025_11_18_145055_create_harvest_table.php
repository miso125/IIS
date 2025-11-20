<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('harvest', function (Blueprint $table) {
            $table->id('id_harvest');
            $table->foreignId('wine_row')->constrained('wineyardrow', 'id_row')->onDelete('restrict');
            $table->string('user');
            $table->foreign('user')->references('login')->on('user')->onDelete('restrict');
            $table->integer('weight_grapes');
            $table->string('variety');
            $table->integer('sugariness');
            $table->dateTime('date_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvest');
    }
};
