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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('kk', 20);
            $table->string('nik', 16);
            $table->string('name', 100);
            $table->string('pob', 100);
            $table->date('dob');
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->default('Laki-laki');
            $table->text('address');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('sub_village', 100)->nullable()->comment('Dusun/Kampung');
            $table->string('village', 100)->comment('Kelurahan/Desa');
            $table->string('district', 100)->comment('Kecamatan');
            $table->string('religion', 20);
            $table->enum('marital_status', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->string('occupation', 100);
            $table->string('nationality', 50)->default('WNI');
            $table->string('education', 50);
            $table->string('father_name', 100)->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
