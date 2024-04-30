<?php

use App\Models\Djs;
use App\Models\User as ModelsUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
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
            // $table->foreignIdFor(User);
            // $table->foreignIdFor(Djs);
            // $table->integer('artist_song_id');
            // $table->integer('user_id');
            // $table->integer('dj_id');
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