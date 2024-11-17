<?php

namespace App\Traits\General;

use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

trait PdfHandlerTrait
{
    public function generatePdf($data, $view, $filename, $path, $disk)
    {
        $file = Pdf::loadView($view, $data);

        $file->save($path . 'tmp/' . $filename, $disk);
    }

    public function initMergePdf()
    {
        return PDFMerger::init();
    }

    public function doMerger($instanceMerger, $filename)
    {
        $instanceMerger->merge();
        $instanceMerger->setFileName($filename);
    }

    public function addFilePdf($instanceMerger, $filename, $path, $disk)
    {
        $instanceMerger->addPDF(Storage::disk($disk)->path($path . 'tmp/' . $filename), 'all');
    }

    public function addAttachmentFile($instanceMerger, $attachment, $path, $disk)
    {
        $instanceMerger->addPDF(Storage::disk($disk)->path($path . $attachment), 'all');
    }

    public function deletePdf($disk, $path, $filename)
    {
        Storage::disk($disk)->delete($path . 'tmp/' . $filename);
    }
}
