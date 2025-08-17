<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Add foreign keys in files to profiles
 *
 * Adds audit foreign key constraints to files table:
 * - Links created_by and updated_by to profiles
 * - Enables audit trail functionality
 * - Uses nullOnDelete to preserve file records when profile is deleted
 *
 * Relations:
 * - files.created_by -> profiles.id
 * - files.updated_by -> profiles.id
 */
return new class extends Migration
{
    protected string $description = 'Adds audit foreign key constraints from files to profiles table';

    public function up(): void
    {
        Schema::table('files', static function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('profiles')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('profiles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('files', static function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
    }

};
