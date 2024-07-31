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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('meta_title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->longText('content')->nullable();
            $table->enum('status', ['Draft', 'Publish'])->default('Draft');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('view')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
