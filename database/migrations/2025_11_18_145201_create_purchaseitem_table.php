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
        Schema::create('purchaseitem', function (Blueprint $table) {
            $table->id('id_item');
            $table->foreignId('purchase')->constrained('purchase', 'id_purchase')->onDelete('cascade');
            $table->foreignId('wine_batch')->constrained('winebatch','batch_number')->onDelete('cascade');
            $table->integer('number_of_bottles');
            $table->boolean('stock')->default(true);
            $table->float('item_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaseitem');
    }
};
