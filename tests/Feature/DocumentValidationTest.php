<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Document;
use App\Models\Category;

class DocumentValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se o tamanho máximo do campo conteúdo é respeitado.
     */
    public function test_content_field_max_length()
    {
        $category = Category::create(['name' => 'Remessa']);

        $document = Document::create([
            'category_id' => $category->id,
            'title' => 'Teste de Conteúdo',
            'contents' => str_repeat('A', 65536) // Excede 64KB
        ]);

        $this->assertDatabaseMissing('documents', ['id' => $document->id], 'O documento não deve ser inserido se o conteúdo for muito grande.');
    }

    /**
     * Testa a validação do título para a categoria "Remessa".
     */
    public function test_remessa_title_validation()
    {
        $category = Category::create(['name' => 'Remessa']);

        // Teste com título válido
        $validDocument = Document::create([
            'category_id' => $category->id,
            'title' => 'Documento do primeiro semestre',
            'contents' => 'Teste de conteúdo'
        ]);

        $this->assertDatabaseHas('documents', ['id' => $validDocument->id]);

        // Teste com título inválido
        $this->expectException(\Exception::class);
        Document::create([
            'category_id' => $category->id,
            'title' => 'Título inválido',
            'contents' => 'Teste de conteúdo'
        ]);
    }

    /**
     * Testa a validação do título para a categoria "Remessa Parcial".
     */
    public function test_remessa_parcial_title_validation()
    {
        $category = Category::create(['name' => 'Remessa Parcial']);

        // Teste com título válido
        $validDocument = Document::create([
            'category_id' => $category->id,
            'title' => 'Relatório de Janeiro',
            'contents' => 'Teste de conteúdo'
        ]);

        $this->assertDatabaseHas('documents', ['id' => $validDocument->id]);

        // Teste com título inválido
        $this->expectException(\Exception::class);
        Document::create([
            'category_id' => $category->id,
            'title' => 'Título sem mês',
            'contents' => 'Teste de conteúdo'
        ]);
    }
}
