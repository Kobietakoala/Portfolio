<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create profiles table
 *
 * Creates a table for storing user profile information:
 * - Supports multilingual content via JSON fields
 * - Stores personal and professional information
 * - Links to avatar files
 * - Includes contact information and social media links
 *
 * Relations:
 * - avatar -> files.id (FK to files table)
 */
return new class extends Migration
{
    protected string $description = 'Creates profiles table for managing user profile data with multilingual support';

    public function up(): void
    {
        Schema::create('profiles', static function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->string('firstname', 128)->nullable();
            $table->string('lastname', 128)->nullable();
            $table->json('position')->nullable();
            $table->json('about')->nullable();
            $table->json('contact_description')->nullable();

            $table->string('mail', 255)->unique();
            $table->char('avatar', 36)->nullable(); // FK -> files.id
            $table->string('github', 255)->nullable();

            $table->dateTimeTz('created_at', 3)->useCurrent();
            $table->dateTimeTz('updated_at', 3)->useCurrentOnUpdate()->useCurrent();

            $table->index('mail');
        });

        Schema::table('profiles', static function (Blueprint $table) {
            $table->foreign('avatar')->references('id')->on('files')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('profiles', static function (Blueprint $table) {
            $table->dropForeign(['avatar']);
        });
        Schema::dropIfExists('profiles');
    }
};
