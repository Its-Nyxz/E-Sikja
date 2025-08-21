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
        Schema::create('history_request_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_letter_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['Diajukan','Diproses', 'Selesai', 'Ditolak'])->default('Diajukan');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_request_letters');
    }
};
