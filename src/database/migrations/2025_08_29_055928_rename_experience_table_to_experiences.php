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
        Schema::disableForeignKeyConstraints();

        Schema::table('experience_skills', function (Blueprint $table) {
            $table->dropForeign(['experience_id']);
        });

        Schema::rename('experience', 'experiences');

        Schema::table('experience_skills', function (Blueprint $table) {
            $table->foreign('experience_id')->references('id')->on('experiences')->cascadeOnDelete();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('experience_skills', function (Blueprint $table) {
            $table->dropForeign(['experience_id']);
        });

        Schema::rename('experiences', 'experience');

        Schema::table('experience_skills', function (Blueprint $table) {
            $table->foreign('experience_id')->references('id')->on('experience')->cascadeOnDelete();
        });

        Schema::enableForeignKeyConstraints();
    }
};
