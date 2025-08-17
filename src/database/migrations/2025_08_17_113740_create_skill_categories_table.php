<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create skill categories table
 *
 * Creates a table for organizing skills into categories:
 * - Supports multilingual category names via JSON
 * - Optional logo/icon for visual representation
 * - Used to group related skills together
 * - Categories like "Programming Languages", "Frameworks", etc.
 *
 * Relations:
 * - logo -> files.id (FK to files table)
 * - Referenced by skills table
 */
return new class extends Migration
{
    protected string $description = 'Creates skill categories table for organizing skills into groups';

    public function up(): void
    {
        Schema::create('skill_categories', static function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->json('name');
            $table->char('logo', 36)->nullable(); // FK -> files.id

            $table->dateTimeTz('created_at', 3)->useCurrent();
            $table->dateTimeTz('updated_at', 3)->useCurrentOnUpdate()->useCurrent();
        });

        Schema::table('skill_categories', static function (Blueprint $table) {
            $table->foreign('logo')->references('id')->on('files')->nullOnDelete();
        });

    }

    public function down(): void
    {
        Schema::table('skill_categories', static function (Blueprint $table) {
            $table->dropForeign(['logo']);
        });
        Schema::dropIfExists('skill_categories');
    }
};
