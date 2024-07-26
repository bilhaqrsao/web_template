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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['url', 'page'])->default('url');
            $table->foreignId('page_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('parent_id')->nullable();
            $table->integer('sort')->nullable();
            $table->string('url')->nullable();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->enum('status', ['Draft', 'Publish'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
