<?php

use Brick\Math\BigInteger;
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
        Schema::create('hitung_absens', function (Blueprint $table) {
            $table->id('id_hitung');
            $table->BigInteger('id_user');
            $table->string('bulan');
            $table->bigInteger('hadir');
            $table->bigInteger('kegiatan');
            $table->bigInteger('sakit');
            $table->bigInteger('izin');
            $table->bigInteger('nojadwal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitung_absens');
    }
};
