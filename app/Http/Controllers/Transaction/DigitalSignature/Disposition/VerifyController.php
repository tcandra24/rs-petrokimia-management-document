<?php

namespace App\Http\Controllers\Transaction\DigitalSignature\Disposition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Model
use App\Models\Disposition;
use App\Models\User;

// Traits
use App\Traits\General\BreadcrumbsTrait;
use App\Traits\General\DigitalSignatureTrait;

class VerifyController extends Controller
{
    use BreadcrumbsTrait, DigitalSignatureTrait;

    public function index()
    {
        $dispositions = Disposition::all();
        $breadcrumbs = $this->setBreadcrumbs('dispositionSignature', 'index');

        return view('transaction.disposition.digital-signature.index', [
            'breadcrumbs' => $breadcrumbs,
            'dispositions' => $dispositions
        ]);
    }

    public function check(Request $request)
    {
        $request->validate([
            'number_transaction' => 'required',
            'signature' => 'required',
        ]);

        try {
            $breadcrumbs = $this->setBreadcrumbs('dispositionSignature', 'index');

            $disposition = Disposition::where('number_transaction', $request->number_transaction)->first();

            $user = User::where('type', 'director')->first();
            $publicKey = $user->public_key;

            $payload = [
                'number_transaction' => $disposition->number_transaction
            ];

            $verification = $this->verification($request->signature, $payload, $publicKey);

            return view('transaction.disposition.digital-signature.show', [
                'breadcrumbs' => $breadcrumbs,
                'status' => $verification,
                'disposition' =>$disposition
            ]);
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
