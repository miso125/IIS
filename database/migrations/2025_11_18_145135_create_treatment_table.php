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
        Schema::create('treatment', function (Blueprint $table) {
            $table->id('id_treatment');
            $table->foreignId('wine_row')->constrained('wineyardrow', 'id_row')->onDelete('restrict');
            $table->string('user');
            $table->foreign('user')->references('login')->on('user')->onDelete('restrict');
            $table->dateTime('date_time');
            $table->string('type');
            $table->string('treatment_product')->nullable();
            $table->float('concentration')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment');
    }
};
