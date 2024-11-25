<?php

namespace App\Traits\General;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use phpseclib3\Crypt\RSA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait DigitalSignatureTrait
{
    public function createSignature($payload)
    {
        $privateKey = RSA::load(Auth::user()->private_key);
        return $privateKey->sign(json_encode($payload));
    }

    public function generateQrCode($pathQrCode, $signature, $numberTransaction)
    {
        $qrcode_name = 'qr-code-signature-' . str_replace('/', '-', $numberTransaction) . '.png';
        $qrcode = QrCode::format('png')
            ->size(300)
            ->style('round')
            ->eye('circle')
            ->generate(base64_encode($signature));
        Storage::disk('public')->put($pathQrCode . $qrcode_name, $qrcode);

        return $qrcode_name;
    }

    public function verification($signature, $payload, $publicKey)
    {
        $signature = base64_decode($signature);

        $publicKey = RSA::load($publicKey);

        return $publicKey->verify(json_encode($payload), $signature);
    }
}
