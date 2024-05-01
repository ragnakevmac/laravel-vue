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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->text('comment');

            // Create foreign ID columns and ensure naming is consistent
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dj_id')->constrained('djs')->onDelete('cascade');
            $table->foreignId('artist_song_id')->constrained('artist_songs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
