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
        Schema::create('user', function (Blueprint $table) {
            $table->string('login')->primary()->unique(true);
            $table->string('password_hash');
            $table->string('email'); // ->unique()
            $table->string('name');
            $table->string('last_name');
            $table->string('address');
            $table->string('role');
            $table->dateTime('date_of_registration')->useCurrent();
            $table->boolean('isActive')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
