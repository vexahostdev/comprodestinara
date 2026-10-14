<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->default('budaya'); // budaya, ekologi, pangan, bahari
            $table->string('badge')->nullable(); // Konservasi Karst, Etnomatematika Kriya, etc.
            $table->string('location');
            $table->text('lead')->nullable();
            $table->longText('description')->nullable();
            $table->text('research_focus')->nullable();
            $table->string('module_name')->nullable();
            $table->string('capacity')->nullable();
            $table->text('image_path')->nullable();
            $table->json('gallery_paths')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
