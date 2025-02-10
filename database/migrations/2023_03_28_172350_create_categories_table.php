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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique()->index(); // Prefiro definir um tamanho maior, afim de evitar truncar no insert. Também deixar como único para evitar duplicidades. Indexar para melhoria de performance em busca.
            $table->timestamps(); // Prefiro deixar os timestamp no fim da tabela.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
