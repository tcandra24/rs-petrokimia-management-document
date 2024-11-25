<?php

namespace App\Http\Controllers\Transaction\Download\Memo;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

// Models
use App\Models\Memo;

class AttachmentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $memo = Memo::findOrFail($id);

        $filePath = 'files/memos/'. $memo->file;

        if (!Storage::exists($filePath)) {
            return abort(404);
        }

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return Storage::download($filePath, 'lampiran-' . Str::slug($memo->regarding) . '.pdf', $headers);
    }
}
