<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create skills table
 *
 * Creates a table for storing individual skills:
 * - Supports multilingual skill names via JSON
 * - URL-friendly slug for web routing
 * - Optional logo/icon and proficiency level
 * - Categorized skills with mandatory category assignment
 * - Used in experience-skill relationships
 *
 * Relations:
 * - logo -> files.id (FK to files table)
 * - category -> skill_categories.id (FK to skill categories)
 * - Referenced by experience_skills pivot table
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', static function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->json('name');
            $table->string('slug', 160)->unique()->comment('URL-friendly skill name: ex "php", "laravel", "javascript"');
            $table->char('logo', 36)->nullable(); // FK -> files.id
            $table->unsignedTinyInteger('level')->nullable()->comment('\App\Enums\SkillLevelEnum::class values: 0-3');
            $table->char('category', 36); // FK -> skill_categories.id

            $table->dateTimeTz('created_at', 3)->useCurrent();
            $table->dateTimeTz('updated_at', 3)->useCurrentOnUpdate()->useCurrent();

            $table->index('category');
        });

        Schema::table('skills', static function (Blueprint $table) {
            $table->foreign('logo')->references('id')->on('files')->nullOnDelete();
            $table->foreign('category')->references('id')->on('skill_categories')->restrictOnDelete();
        });

    }

    public function down(): void
    {
        Schema::table('skills', static function (Blueprint $table) {
            $table->dropForeign(['logo']);
            $table->dropForeign(['category']);
        });
        Schema::dropIfExists('skills');
    }
};
