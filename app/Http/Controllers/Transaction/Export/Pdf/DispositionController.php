<?php

namespace App\Http\Controllers\Transaction\Export\Pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Disposition;

// Traits
use App\Traits\General\PdfHandlerTrait;

class DispositionController extends Controller
{
    use PdfHandlerTrait;

    public function download(Request $request)
    {
        $disposition = Disposition::with(['memo', 'sub_divisions', 'sub_divisions.division', 'instructions'])->where('id', $request->id)->first();
        $filenameDisposition = str_replace('/', '-', $disposition->number_transaction) . '.pdf';

        $qrcode_image = $disposition->qr_code_file ? public_path('storage/disposition/qr-codes-signature/' . $disposition->qr_code_file) : null;
        $logo = public_path('assets/img/logo-black-white.png');

        $dataDisposition = [
            'disposition' => $disposition,
            'qrcode_image' => $qrcode_image,
            'logo' => $logo
        ];
        $pathDisposition = 'files/dispositions/';

        $this->generatePdf($dataDisposition, 'transaction.disposition.exports.pdf.export', $filenameDisposition, $pathDisposition, 'local');

        // Start Merging
        $mergerInstance = $this->initMergePdf();
        $this->addFilePdf($mergerInstance, $filenameDisposition, $pathDisposition, 'local');

        if($disposition->memo){
            $filenameMemo = str_replace('/', '-', $disposition->memo->number_transaction) . '-' . $disposition->memo->regarding . '.pdf';

            $dataMemo = [
                'memo' => $disposition->memo,
                'qrcode_image' => $qrcode_image,
                'logo' => $logo
            ];
            $pathMemo = 'files/memos/';

            $this->generatePdf($dataMemo, 'transaction.memo.exports.pdf.export', $filenameMemo, $pathMemo, 'local');

            $this->addFilePdf($mergerInstance, $filenameMemo, $pathMemo, 'local');

            if($disposition->file){
                $this->addAttachmentFile($mergerInstance, $disposition->file, $pathDisposition, 'local');
            }

            if($disposition->memo->file){
                $this->addAttachmentFile($mergerInstance, $disposition->memo->file, $pathMemo, 'local');
            }

            $this->doMerger($mergerInstance, $filenameDisposition);

            $this->deletePdf('local', $pathMemo, $filenameMemo);
            $this->deletePdf('local', $pathDisposition, $filenameDisposition);
        } else {
            if($disposition->file){
                $this->addAttachmentFile($mergerInstance, $disposition->file, $pathDisposition, 'local');
            }

            $this->doMerger($mergerInstance, $filenameDisposition);
            $this->deletePdf('local', $pathDisposition, $filenameDisposition);
            $this->deletePdf('local', $pathDisposition, $filenameDisposition);
        }

        return $mergerInstance->download();
    }
}
