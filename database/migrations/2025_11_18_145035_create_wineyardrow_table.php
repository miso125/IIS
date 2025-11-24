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
        Schema::create('wineyardrow', function (Blueprint $table) {
            $table->id('id_row');
            $table->string('user');
            $table->foreign('user')->references('login')->on('user')->onDelete('cascade');
            $table->string('variety');
            $table->integer('number_of_vines');
            $table->integer('planting_year');
            $table->string('colour');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wineyardrow');
    }
};
