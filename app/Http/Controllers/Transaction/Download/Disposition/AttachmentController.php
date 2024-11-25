<?php

namespace App\Http\Controllers\Transaction\Download\Disposition;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

// Models
use App\Models\Disposition;

class AttachmentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $disposition = Disposition::findOrFail($id);

        $filePath = 'files/dispositions/'. $disposition->file;

        if (!Storage::exists($filePath)) {
            return abort(404);
        }

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return Storage::download($filePath, 'lampiran-' . str_replace('/', '-', $disposition->number_transaction) . '.pdf', $headers);
    }
}
