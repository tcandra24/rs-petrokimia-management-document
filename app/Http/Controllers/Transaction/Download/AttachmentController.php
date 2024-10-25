<?php

namespace App\Http\Controllers\Transaction\Download;

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
        return Storage::download('public/files/memos/'. basename($memo->file), 'lampiran-' . Str::slug($memo->regarding));
    }
}
