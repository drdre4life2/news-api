<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('source')->index();
            $table->text('content');
            $table->string('category');
            $table->string('image_url')->nullable();
            $table->string('author')->nullable()->nullable();
            $table->string('url');
            $table->date('published_at')->index();
            $table->timestamps();
            $table->fullText('category');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
