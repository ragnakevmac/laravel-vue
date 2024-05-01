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
        Schema::create('artist_songs', function (Blueprint $table) {
            $table->id();

            // Create foreign ID columns properly and define foreign key constraints
            $table->foreignId('song_id')->constrained('songs')->onDelete('cascade');
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_songs');
    }
};
