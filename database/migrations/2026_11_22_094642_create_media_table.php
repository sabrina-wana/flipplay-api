<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('type');                  // anime, drama, manga, light_novel
            $table->string('title')->unique();
            $table->json('genres');
            $table->unsignedSmallInteger('year');
            $table->decimal('score', 3, 1);
            $table->unsignedInteger('unit_count');   // episodes / chapters / volumes
            $table->string('country')->nullable();   // khusus Drama
            $table->string('author')->nullable();    // khusus Manga & Light Novel
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
