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
        Schema::create('poin_groups', function (Blueprint $table) {
            $table->id('id_pg');
            $table->bigInteger('id_user');
            $table->bigInteger('id_ks');
            $table->enum('sts',['plus','minus']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poin_groups');
    }
};
