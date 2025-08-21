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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('title');
            $table->text('description');
            $table->dateTime('date');
            $table->text('location');
            $table->string('image')->nullable();
            $table->enum('status', ['Diajukan','Diproses', 'Selesai', 'Ditolak'])->default('Diajukan');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('histories')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
