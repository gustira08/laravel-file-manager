<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Koderak\FileManager\Enums\FileCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('path', 150)->nullable();
            $table->string('category', 20)->default(FileCategory::IMAGE)
                ->comment('must be on of \Koderak\FileManager\Enums\FileCategory type');
            $table->string('disk', 20)->default('public');
            $table->string('extension', 10)->nullable();
            $table->string('size', 100)->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->string('sha1sum', 40)->nullable();
            $table->text('meta');
            $table->unsignedBigInteger('fileable_id');
            $table->string('fileable_type');
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
