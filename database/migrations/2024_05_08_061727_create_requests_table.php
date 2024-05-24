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
            $table->string('status')->default('pending');
            $table->text('comment')->nullable();

            // Create foreign ID columns and ensure naming is consistent
            $table->foreignId('user_id')->default(1)->constrained('users')->onDelete('cascade');
            $table->foreignId('dj_id')->nullable()->constrained('djs')->onDelete('cascade');
            $table->foreignId('artist_song_id')->nullable()->constrained('artist_song')->onDelete('cascade');

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
