<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function downloadManual()
    {
        $filePath = public_path('files\DOKUMEN MANUAL PENGGUNAAN  SISTEM PENGURUSAN PERMOHONAN STOK.pdf'); // Ensure the file exists here
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Response::download($filePath, 'DOKUMEN MANUAL PENGGUNAAN  SISTEM PENGURUSAN PERMOHONAN STOK.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
