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
        Schema::create('berandas', function (Blueprint $table) {
            $table->id();
            $table->string('hero');
            $table->unsignedBigInteger('wahana_id');
            $table->unsignedBigInteger('fasilitas_id');
            $table->timestamps();
            $table->foreign('wahana_id')->references('id')->on('wahanas')->onDelete('cascade');
            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berandas');
    }
};
