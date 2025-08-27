<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create files table
 *
 * Creates a table for storing file metadata:
 * - Handles different file types
 * - Stores checksum for integrity
 * - Includes audit system
 * - Supports metadata in JSON format
 *
 * Relations:
 * - created_by/updated_by -> profiles.id (FK added in later migration)
 */
return new class extends Migration
{
    protected string $description = 'Creates files table for managing user files';

    public function up(): void
    {
        Schema::create('files', static function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('filename', 255);
            $table->string('mime_type', 255);
            $table->unsignedBigInteger('size');
            $table->string('checksum', 64);
            $table->string('storage_key', 512)->unique();
            $table->string('content_disposition', 255)->nullable();
            $table->string('source', 50)->nullable();
            $table->unsignedTinyInteger('status')->default(\App\Enums\FileStatusEnum::ACTIVE)->comment('\App\Enums\FileStatusEnum::class values: 0,1,9');
            $table->json('metadata')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTimeTz('created_at', 3)->useCurrent();
            $table->dateTimeTz('updated_at', 3)->useCurrentOnUpdate()->useCurrent();

            $table->index('mime_type');
            $table->index('status');
            $table->index('created_at');
            $table->index('created_by');
            $table->index('updated_by');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
