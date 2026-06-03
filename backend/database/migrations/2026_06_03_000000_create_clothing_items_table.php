<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clothing_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('category', [
                'tops',
                'bottoms',
                'dresses',
                'shoes',
                'accessories',
                'outerwear',
            ]);
            $table->json('colors');
            $table->json('season');
            $table->json('occasion');
            $table->string('image_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clothing_items');
    }
};
