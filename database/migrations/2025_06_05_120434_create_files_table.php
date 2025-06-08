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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // Caminho/URL do arquivo
            $table->string('name'); // Nome do arquivo no sistema
            $table->string('original_name'); // Nome original do arquivo
            $table->string('mime_type'); // Tipo MIME do arquivo
            $table->unsignedBigInteger('file_size'); // Tamanho em bytes
            $table->text('description')->nullable(); // Descrição opcional
            $table->json('metadata')->nullable(); // Dados específicos do tipo de arquivo
            $table->timestamps();

            // Índices para performance
            $table->index('mime_type');
            $table->index(['mime_type', 'created_at']);
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