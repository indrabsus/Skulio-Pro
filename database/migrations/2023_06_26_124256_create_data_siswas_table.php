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
        Schema::create('data_siswas', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->bigInteger('id_user');
            $table->bigInteger('nis');
            $table->bigInteger('nik');
            $table->enum('jenkel', ['l','p']);
            $table->string('nohp');
            $table->string('alamat');
            $table->string('ayah');
            $table->string('ibu');
            $table->string('agama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_siswas');
    }
};
