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
        Schema::create('spp_reqs', function (Blueprint $table) {
            $table->id('id_req');
            $table->bigInteger('id_user');
            $table->bigInteger('bayar');
            $table->bigInteger('subsidi');
            $table->enum('sts',['n','y']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_reqs');
    }
};
