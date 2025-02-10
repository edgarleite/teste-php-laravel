<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessDocumentImport;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Facades\Artisan;

class DocumentImportController extends Controller
{
    /**
     * Exibe a tela de upload
     */
    public function showForm()
    {
        return view('import');
    }

    /**
     * Dispara o job para processar o arquivo JSON.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json|max:2048',
        ]);
        
        $file = $request->file('file');
        $filePath = $file->storeAs('data', $file->getClientOriginalName());
        
        $jsonContent = Storage::get($filePath);
        $data = json_decode($jsonContent, true);
        
        if (!isset($data['documentos']) || !is_array($data['documentos'])) {
            return back()->with('error', 'Formato de arquivo inválido.');
        }
        
        // Adiciona cada documento à fila de processamento
        foreach ($data['documentos'] as $document) {
            ProcessDocumentImport::dispatch($document);
        }

        return back()->with('success', 'Importação iniciada com sucesso!');
    }

    /**
     * Dispara o processamento da fila manualmente
     */
    public function processQueue()
    {
        Artisan::call('queue:work --stop-when-empty');
        return back()->with('success', 'Fila de processamento iniciada.');
    }
}