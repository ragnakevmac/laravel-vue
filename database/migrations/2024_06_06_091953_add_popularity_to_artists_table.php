<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPopularityToArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->integer('popularity')->after('name')->default(0); // Adjust default value as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('popularity');
        });
    }
}