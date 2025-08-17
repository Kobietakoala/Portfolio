<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create experience skills pivot table
 *
 * Creates a many-to-many relationship table between experience and skills:
 * - Links specific skills used in each work experience
 * - Tracks focus percentage (how much the skill was used)
 * - Optional notes for additional context
 * - Prevents duplicate skill assignments per experience
 *
 * Relations:
 * - experience_id -> experience.id (FK with cascade delete)
 * - skill_id -> skills.id (FK with cascade delete)
 */
return new class extends Migration
{
    protected string $description = 'Creates pivot table linking experience records with skills used';

    public function up(): void
    {
        Schema::create('experience_skills', static function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('experience_id', 36);
            $table->char('skill_id', 36);
            $table->unsignedTinyInteger('focus_percent')->nullable()->comment('Usage intensity percentage (0-100)');
            $table->string('notes', 255)->nullable();

            $table->dateTimeTz('created_at', 3)->useCurrent();
            $table->dateTimeTz('updated_at', 3)->useCurrentOnUpdate()->useCurrent();

            $table->unique(['experience_id', 'skill_id']);
            $table->index('experience_id');
            $table->index('skill_id');

            $table->foreign('experience_id')->references('id')->on('experience')->cascadeOnDelete();
            $table->foreign('skill_id')->references('id')->on('skills')->cascadeOnDelete();
        });

    }

    public function down(): void
    {
        // Najpierw wyłącz sprawdzanie kluczy obcych
        Schema::disableForeignKeyConstraints();

        Schema::table('experience_skills', static function (Blueprint $table) {
            $table->dropForeign(['experience_id']);
            $table->dropForeign(['skill_id']);
        });

        Schema::dropIfExists('experience_skills');

        // Włącz z powrotem sprawdzanie kluczy obcych
        Schema::enableForeignKeyConstraints();
    }
};
