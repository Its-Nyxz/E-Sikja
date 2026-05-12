<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequestLetter;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Serve a document securely (view-only, no download).
     * Documents are served with headers that prevent downloading.
     */
    public function showDocument($id)
    {
        $document = DocumentRequestLetter::findOrFail($id);

        // Determine the file path
        $filePath = $this->resolveFilePath($document->url);

        if (!$filePath || !file_exists($filePath)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        $mimeType = mime_content_type($filePath);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline', // Forces browser to display, not download
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Serve a complaint image securely (view-only, no download).
     */
    public function showComplaintImage($id)
    {
        $complaint = Complaint::findOrFail($id);

        if (!$complaint->image) {
            abort(404, 'Gambar tidak ditemukan.');
        }

        $filePath = $this->resolveFilePath($complaint->image);

        if (!$filePath || !file_exists($filePath)) {
            abort(404, 'Gambar tidak ditemukan.');
        }

        $mimeType = mime_content_type($filePath);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Resolve the file path from either storage or public directory.
     * Supports both old files (in public/) and new files (in storage/).
     */
    private function resolveFilePath(string $url): ?string
    {
        // Check in storage/app/private first (new location)
        $storagePath = storage_path('app/private/' . $url);
        if (file_exists($storagePath)) {
            return $storagePath;
        }

        // Fall back to public directory (legacy files)
        $publicPath = public_path($url);
        if (file_exists($publicPath)) {
            return $publicPath;
        }

        return null;
    }
}
