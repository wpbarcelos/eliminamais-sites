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
            $table->foreignId('subdomain_id')->constrained('subdomains')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('image_icon')->nullable();
            $table->unique(['slug', 'subdomain_id']);
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
