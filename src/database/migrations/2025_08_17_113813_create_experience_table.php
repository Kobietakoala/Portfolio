<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create experience table
 *
 * Creates a table for storing work experience records:
 * - Links profiles with companies for employment history
 * - Supports multilingual position titles and descriptions
 * - Tracks employment periods with start/end dates
 * - Used with experience_skills for skill-experience relationships
 *
 * Relations:
 * - profile_id -> profiles.id (FK with cascade delete)
 * - company_id -> companies.id (FK with restrict delete)
 * - Referenced by experience_skills pivot table
 */
return new class extends Migration
{
    protected string $description = 'Creates experience table for storing work history and employment records';

    public function up(): void
    {
        Schema::create('experience', static function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->char('profile_id', 36);
            $table->char('company_id', 36);

            $table->json('position')->nullable();
            $table->json('description')->nullable();

            $table->dateTimeTz('since', 3);
            $table->dateTimeTz('until', 3)->nullable();

            $table->dateTimeTz('created_at', 3)->useCurrent();
            $table->dateTimeTz('updated_at', 3)->useCurrentOnUpdate()->useCurrent();

            $table->index('profile_id');
            $table->index('company_id');
            $table->index('since');

            $table->foreign('profile_id')->references('id')->on('profiles')->cascadeOnDelete();
            $table->foreign('company_id')->references('id')->on('companies')->restrictOnDelete();
        });

    }

    public function down(): void
    {
        // Najpierw wyłącz sprawdzanie kluczy obcych
        Schema::disableForeignKeyConstraints();

        Schema::table('experience', static function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropForeign(['company_id']);
        });

        Schema::dropIfExists('experience');

        // Włącz z powrotem sprawdzanie kluczy obcych
        Schema::enableForeignKeyConstraints();

    }
};
