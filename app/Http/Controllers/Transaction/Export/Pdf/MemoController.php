<?php

namespace App\Http\Controllers\Transaction\Export\Pdf;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

// Models
use App\Models\Memo;

class MemoController extends Controller
{
    public function download(Request $request)
    {
        $memo = Memo::with(['from_user', 'to_user', 'from_user.division', 'to_user.division'])->where('id', $request->id)->first();

        $qrcode_image = public_path('storage/memo/qr-codes-signature/' . $memo->qr_code_file);

        $file = Pdf::loadView('transaction.memo.exports.pdf.export', ['memo' => $memo, 'qrcode_image' => $qrcode_image ]);
        $filename = str_replace('/', '-', $memo->number_transaction) . '-' . $memo->regarding . '.pdf';
        return $file->download($filename);
    }
}
