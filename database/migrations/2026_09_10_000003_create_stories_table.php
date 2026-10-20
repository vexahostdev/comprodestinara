<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Etnobotani');
            $table->string('archive_no')->nullable();
            $table->string('read_time')->nullable()->default('5 Menit');
            $table->string('author_name')->nullable();
            $table->string('author_role')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->text('image_path')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
