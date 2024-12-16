<?php

namespace App\Http\Controllers\Transaction\Approval\PreMemo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Notification
use App\Notifications\GeneralNotification;

// Mail
use App\Mail\SendPreMemoMail;

// Requests
use App\Http\Requests\Transaction\PreMemo\ChangeStatusRequest;
use App\Mail\SendMemoMail;
// Models
use App\Models\PreMemo;
use App\Models\User;

// Traits
use App\Traits\General\GeneratesTransactionNumberTrait;
use App\Traits\General\DigitalSignatureTrait;
use App\Traits\General\SendNotificationsTrait;

class ChangeStatusController extends Controller
{
    use GeneratesTransactionNumberTrait, DigitalSignatureTrait, SendNotificationsTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(ChangeStatusRequest $request, $id)
    {
        try {
            $preMemo = PreMemo::where('id', $id)->first();
            $numberTransaction = $preMemo->number_transaction;

            $data = [
                'status' => $request->status,
                'note' => $request->note,
            ];

            if($request->status === 'approve') {
                $data['approve_datetime'] = Carbon::now();
                $data['approve_by'] = Auth::user()->name;

                $payload = [
                    'number_transaction' => $numberTransaction,
                ];

                $signature = $this->createSignature($payload);
                $qrcode_name = $this->generateQrCode('pre-memo/qr-codes-signature/', $signature, $numberTransaction);

                $data['qr_code_file'] = $qrcode_name;
            }

            $preMemo->update($data);

            $to = User::where('id', $preMemo->from_user_id)->first();

            $dataEmail = [
                'detail' => [
                    'email' => $to->email,
                    'name' => $to->name,
                    'cc' => null,
                ],
                'content' => [
                    'title' => 'Memo Kainst ' . $preMemo->number_transaction,
                    'number_transaction' => $preMemo->number_transaction,
                    'files' => [],
                    'link' => route('pre-memos.show', $preMemo->id),
                    'view' => $request->status === 'approve' ? 'emails.pre-memo.approve' : 'emails.pre-memo.reject',
                    'note' => $request->note,
                ],
            ];

            $this->sendEmail($dataEmail, SendPreMemoMail::class);

            $type = $request->status === 'approve' ? 'success' : 'danger';
            $title = $request->status === 'approve' ? 'Memo Kainst Telah  disetujui' : 'Memo Kainst Telah  ditolak';
            $message = $request->status === 'approve' ? 'Memo Kainst dengan nomor ' . $numberTransaction . ' telah disetujui' : 'Memo Kainst dengan nomor ' . $numberTransaction . ' telah ditolak';
            $link = route('pre-memos.show', $preMemo->id);
            $icon = $request->status === 'approve' ? 'bi-check-circle' : 'bi-x-circle';

            $to->notify(new GeneralNotification($type, $title, $message, $link, $icon));

            toastr()->success('Memo Kainst Berhasil Diubah Statusnya');
            return redirect()->route('pre-memos.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
