<?php

namespace App\Http\Controllers\Transaction\Approval\Disposition;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Notification
use App\Notifications\GeneralNotification;

// Mail
use App\Mail\SendDispositionMail;

// Requests
use App\Http\Requests\Transaction\Disposition\ChangeStatusRequest;

// Models
use App\Models\Disposition;
use App\Models\User;
use App\Models\Instruction;
use App\Models\Division;
use App\Models\SubDivision;

// Traits
use App\Traits\Disposition\TransactionNumberTrait;
use App\Traits\General\DigitalSignatureTrait;
use App\Traits\General\SendNotificationsTrait;

class ChangeStatusController extends Controller
{
    use TransactionNumberTrait, DigitalSignatureTrait, SendNotificationsTrait;
    /**
     * Handle the incoming request.
     */
    public function __invoke(ChangeStatusRequest $request, $id)
    {
        try {
            $disposition = Disposition::with(['memo', 'memo.from_user'])->where('id', $id)->first();
            $numberTransaction = $disposition->number_transaction;

            $purpose =  $request->purpose_id ?? null;


            DB::transaction(function() use ($request, $disposition, $purpose, $numberTransaction){
                $data = [
                    'status' => $request->status,
                    'note' => $request->note,
                    'purpose_id' => $purpose,
                    'is_urgent' => $request->is_urgent,
                ];

                if($request->status === 'approve') {
                    $data['approve_datetime'] = Carbon::now();
                    $data['approve_by'] = Auth::user()->name;

                    if($disposition->memo){
                        $numberTransaction = $this->generateNumber($disposition->counter);
                        $data['number_transaction'] = $numberTransaction;
                    }

                    $payload = [
                        'number_transaction' => $numberTransaction,
                    ];

                    $signature = $this->createSignature($payload);
                    $qrcode_name = $this->generateQrCode('disposition/qr-codes-signature/', $signature, $numberTransaction);

                    $data['qr_code_file'] = $qrcode_name;

                    if($request->divisions){
                        $division = Division::select('id')->whereIn('id', $request->divisions)->get();
                        $disposition->divisions()->attach($division);
                    }

                    if($request->sub_divisions){
                        $subDivision = SubDivision::select('id')->whereIn('id', $request->sub_divisions)->get();
                        $disposition->sub_divisions()->attach($subDivision);
                    }

                    $instructions = Instruction::select('id')->whereIn('id', $request->instructions)->get();
                    $disposition->instructions()->attach($instructions);

                }

                $disposition->update($data);
            });


            $to = User::where('type', 'assistant')->first();

            $dataEmail = [
                'detail' => [
                    'email' => $to->email,
                    'name' => $to->name,
                    'cc' => $disposition->memo ? $disposition->memo->from_user->email : null,
                ],
                'content' => [
                    'title' => 'Disposisi ' . $numberTransaction,
                    'disposition' => $numberTransaction,
                    'memo' => $disposition->memo ?? null,
                    'view' => $request->status === 'approve' ? 'emails.dispositions.approve' : 'emails.dispositions.reject',
                    'note' => $request->note,
                    'files' => [],
                    'link' => route('dispositions.show', $disposition->id),
                ],
            ];

            $this->sendEmail($dataEmail, SendDispositionMail::class);

            $type = $request->status === 'approve' ? 'success' : 'danger';
            $title = $request->status === 'approve' ? 'Disposisi Telah  disetujui' : 'Disposisi Telah  ditolak';
            $message = $request->status === 'approve' ? 'Disposisi dengan nomor ' . $numberTransaction . ' telah disetujui' : 'Disposisi dengan nomor ' . $numberTransaction . ' telah ditolak';
            $link = route('dispositions.show', $disposition->id);
            $icon = $request->status === 'approve' ? 'bi-check-circle' : 'bi-x-circle';

            $to->notify(new GeneralNotification($type, $title, $message, $link, $icon));

            toastr()->success('Disposisi Berhasil Diubah Statusnya');
            return redirect()->route('dispositions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
