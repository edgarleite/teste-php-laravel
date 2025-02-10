<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessDocumentImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $document;

    public function __construct(array $document)
    {
        $this->document = $document;
    }

    public function handle()
    {
        $category = Category::firstOrCreate(['name' => $this->document['categoria']]);
        
        Document::create([
            'category_id' => $category->id,
            'title' => $this->document['titulo'],
            'contents' => $this->document['conteúdo'],
        ]);
    }
}
