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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Esse método já cria o campo e a chave FK de relacionamento.
            $table->string('title', 150)->index(); // Prefiro definir um tamanho maior, afim de evitar truncar no insert. Indexar para melhoria de performance em busca.
            $table->text('contents');
            $table->timestamps(); // Prefiro deixar os timestamp no fim da tabela.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Se houver outras tabelas referenciando documents, apenas dropIfExists() pode causar erro de integridade referencial.
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('documents');
    }
};
