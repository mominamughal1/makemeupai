<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beauticians', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('bio');
            $table->string('city');
            $table->json('specializations');
            $table->decimal('hourly_rate', 8, 2);
            $table->enum('skill_badge', ['beginner', 'intermediate', 'expert']);
            $table->string('profile_photo')->nullable();
            $table->boolean('is_available')->default(true);
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->timestamps();

            $table->index(['city', 'is_available']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beauticians');
    }
};
