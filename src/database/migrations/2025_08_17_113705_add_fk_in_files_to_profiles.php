<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Add foreign key constraints to files table
 *
 * Adds foreign key relationships for files table:
 * - Links created_by and updated_by with users table
 */
return new class extends Migration
{
    protected string $description = 'Adds foreign key constraints to files table for user relationships';

    public function up(): void
    {
        Schema::table('files', static function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
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
