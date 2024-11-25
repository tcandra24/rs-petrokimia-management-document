<?php

namespace App\Http\Controllers\Transaction\DigitalSignature\Memo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Model
use App\Models\Memo;

// Traits
use App\Traits\General\BreadcrumbsTrait;
use App\Traits\General\DigitalSignatureTrait;

class VerifyController extends Controller
{
    use BreadcrumbsTrait, DigitalSignatureTrait;

    public function index()
    {
        $memos = Memo::all();
        $breadcrumbs = $this->setBreadcrumbs('memoSignature', 'index');

        return view('transaction.memo.digital-signature.index', [
            'memos' => $memos,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function check(Request $request)
    {
        $request->validate([
            'number_transaction' => 'required',
            'signature' => 'required',
        ]);

        try {
            $breadcrumbs = $this->setBreadcrumbs('memoSignature', 'index');

            $memo = Memo::with(['from_user'])->where('number_transaction', $request->number_transaction)->first();
            $publicKey = $memo->from_user->public_key;

            $payload = [
                'number_transaction' => $memo->number_transaction,
                'content' => $memo->content
            ];

            $verification = $this->verification($request->signature, $payload, $publicKey);

            return view('transaction.memo.digital-signature.show', [
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
