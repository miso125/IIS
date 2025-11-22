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
        Schema::create('winebatch', function (Blueprint $table) {
            $table->id('batch_number');
            $table->foreignId('harvest')->constrained('harvest', 'id_harvest')->onDelete('restrict');
            $table->integer('vintage');
            $table->string('variety');
            $table->integer('sugariness');
            $table->float('alcohol_percentage');
            $table->integer('number_of_bottles');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->dateTime('date_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winebatch');
    }
};
