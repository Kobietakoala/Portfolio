<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create companies table
 *
 * Creates a table for storing company information:
 * - Stores basic company data (name, website)
 * - Used in experience/employment records
 * - Simple structure with unique company names
 * - Optional website URL for company reference
 *
 * Relations:
 * - Referenced by experience table
 */
return new class extends Migration
{
    protected string $description = 'Creates companies table for storing employer information';

    public function up(): void
    {
        Schema::create('companies', static function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->string('name', 128)->unique();
            $table->string('url', 255)->nullable();

            $table->dateTimeTz('created_at', 3)->useCurrent();
            $table->dateTimeTz('updated_at', 3)->useCurrentOnUpdate()->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
