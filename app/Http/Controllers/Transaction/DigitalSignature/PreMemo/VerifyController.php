<?php

namespace App\Http\Controllers\Transaction\DigitalSignature\PreMemo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Model
use App\Models\PreMemo;

// Requests
use App\Http\Requests\Transaction\DigitalSignature\VerifyRequest;

// Traits
use App\Traits\General\BreadcrumbsTrait;
use App\Traits\General\DigitalSignatureTrait;

class VerifyController extends Controller
{
    use BreadcrumbsTrait, DigitalSignatureTrait;

    public function index()
    {
        $memos = PreMemo::where('status', 'approve')->get();
        $breadcrumbs = $this->setBreadcrumbs('memoKainstSignature', 'index');

        return view('transaction.pre-memo.digital-signature.index', [
            'memos' => $memos,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function check(VerifyRequest $request)
    {
        try {
            $breadcrumbs = $this->setBreadcrumbs('memoKainstSignature', 'index');

            $memo = PreMemo::with(['from_user', 'to_user'])->where('number_transaction', $request->number_transaction)->first();
            $publicKey = $memo->to_user->public_key;

            $payload = [
                'number_transaction' => $memo->number_transaction,
            ];

            $verification = $this->verification($request->signature, $payload, $publicKey);

            return view('transaction.pre-memo.digital-signature.show', [
                'breadcrumbs' => $breadcrumbs,
                'status' => $verification,
                'memo' =>$memo
            ]);
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

    }
}
