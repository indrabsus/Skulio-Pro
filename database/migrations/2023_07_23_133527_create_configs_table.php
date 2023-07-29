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
        Schema::create('configs', function (Blueprint $table) {
            $table->id('id_config');
            $table->string('instansi');
            $table->float('long');
            $table->float('lat');
            $table->string('token_telegram');
            $table->string('chat_id_telegram');
            $table->bigInteger('x_spp');
            $table->bigInteger('xi_spp');
            $table->bigInteger('xii_spp');
            $table->bigInteger('daftar');
            $table->bigInteger('ppdb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
