<?php

namespace App\Http\Controllers\Transaction\Export\Pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\PreMemo;

// Traits
use App\Traits\General\PdfHandlerTrait;

class PreMemoController extends Controller
{
    use PdfHandlerTrait;

    public function download(Request $request)
    {
        $memo = PreMemo::with(['from_user', 'to_user', 'from_user.division', 'to_user.division'])->where('id', $request->id)->first();
        $filename = str_replace('/', '-', $memo->number_transaction) . '-' . $memo->regarding . '.pdf';

        $qrcode_image = public_path('storage/pre-memo/qr-codes-signature/' . $memo->qr_code_file);
        $logo = public_path('assets/img/logo-black-white.png');

        $data = [
            'memo' => $memo,
            'qrcode_image' => $qrcode_image,
            'logo' => $logo
        ];
        $path = 'files/pre-memos/';

        $this->generatePdf($data, 'transaction.pre-memo.exports.pdf.export', $filename, $path, 'local');

        $mergerInstance = $this->initMergePdf();
        $this->addFilePdf($mergerInstance, $filename, $path, 'local');

        if($memo->file){
            $this->addAttachmentFile($mergerInstance, $memo->file, $path, 'local');
        }

        $this->doMerger($mergerInstance, $filename);

        $this->deletePdf('local', $path, $filename);
        return $mergerInstance->download();
    }
}