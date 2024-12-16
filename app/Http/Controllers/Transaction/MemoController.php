<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Mail
use App\Mail\SendMemoMail;

// Requests
use App\Http\Requests\Transaction\MemoRequest;

// Models
use App\Models\PreMemo;
use App\Models\Memo;
use App\Models\User;

// Traits
use App\Traits\General\BreadcrumbsTrait;
use App\Traits\General\UploadImageTrait;
use App\Traits\General\GeneratesTransactionNumberTrait;
use App\Traits\General\DigitalSignatureTrait;
use App\Traits\General\SendNotificationsTrait;

// Events
// use App\Events\SendNotificationEvent;

class MemoController extends Controller
{
    use BreadcrumbsTrait, UploadImageTrait, GeneratesTransactionNumberTrait, DigitalSignatureTrait, SendNotificationsTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memos = Memo::when(Auth::user()->division_id, function($query){
            $query->whereHas('from_user', function($query){
                $query->where('division_id', Auth::user()->division_id);
            });
        })->with(['to_user', 'from_user'])->paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('memo', 'index');

        // event(new SendNotificationEvent('Hi', Auth::user()->id));

        return view('transaction.memo.index', ['breadcrumbs' => $breadcrumbs, 'memos' => $memos ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $preMemos = PreMemo::doesntHave('memo')->where('status', 'approve')->get();
        $breadcrumbs = $this->setBreadcrumbs('memo', 'create');

        return view('transaction.memo.create', [
            'breadcrumbs' => $breadcrumbs,
            'preMemos' => $preMemos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemoRequest $request)
    {
        try {
            $preMemo =  $request->pre_memo_id ?? null;

            $maxCounter = Memo::max('counter') + 1;
            $numberTransaction = $this->generatesTransactionNumber('MEMO', $maxCounter);

            $payload = [
                'number_transaction' => $numberTransaction,
                'content' => $request->content
            ];
            $signature = $this->createSignature($payload);
            $qrcode_name = $this->generateQrCode('memo/qr-codes-signature/', $signature, $numberTransaction);

            $file = $this->doUpload('local', $request, 'files/memos');

            $assistant = User::where('type', 'assistant')->first();

            $memo = Memo::create([
                'counter' => $maxCounter,
                'number_transaction' => $numberTransaction,
                'regarding' => $request->regarding,
                'from_user_id' => Auth::user()->id,
                'to_user_id' => $assistant->id,
                'content' => $request->content,
                'file' => $file,
                'pre_memo_id' => $preMemo,
                'qr_code_file' => $qrcode_name,
                'approve_datetime' => Carbon::now(),
            ]);

            $to = User::where('type', 'assistant')->first();
            $cc = User::where('type', 'director')->get();

            $files = [];
            if($file){
                array_push($files, 'files/memos/' . $file);
            }

            $preMemoRef = null;
            if($preMemo){
                $preMemoRef = PreMemo::where('id', $preMemo)->first();
            }

            $dataEmail = [
                'detail' => [
                    'email' => $to->email,
                    'name' => $to->name,
                    'cc' => $cc,
                ],
                'content' => [
                    'title' => 'Memo ' . $numberTransaction,
                    'number_transaction' => $numberTransaction,
                    'preMemo' => $preMemoRef,
                    'files' => $files,
                    'link' => route('memos.show', $memo->id),
                ],
            ];

            $this->sendEmail($dataEmail, SendMemoMail::class);

            $dataNotification = [
                'type' => 'primary',
                'title' => 'Memo Telah Dibuat',
                'message' => 'Memo dengan nomor ' . $numberTransaction . ' telah dibuat',
                'link' => route('memos.show', $memo->id),
                'icon' => 'bi-info-circle'
            ];
            $this->sendNotification($to, $dataNotification);

            toastr()->success('Memo Berhasil Disimpan');
            return redirect()->route('memos.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Memo $memo)
    {
        $breadcrumbs = $this->setBreadcrumbs('memo', 'show', $memo);

        return view('transaction.memo.show', [
            'breadcrumbs' => $breadcrumbs,
            'memo' => $memo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Memo $memo)
    {
        $preMemos = PreMemo::doesntHave('memo')->where('status', 'approve')->get()->sortBy('id');
        if ($memo->pre_memo){
            $preMemos->push($memo->pre_memo);
            $preMemos = $preMemos->sortBy('id');
        }

        $breadcrumbs = $this->setBreadcrumbs('memo', 'edit', $memo);

        return view('transaction.memo.edit', [
            'breadcrumbs' => $breadcrumbs,
            'preMemos' => $preMemos,
            'memo' => $memo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemoRequest $request, Memo $memo)
    {
        try {
            $preMemo =  $request->pre_memo_id ?? null;

            $data  = [
                'regarding' => $request->regarding,
                'content' => $request->content,
                'pre_memo_id' => $preMemo,
            ];

            $file = $this->doUpload('local', $request, 'files/memos', $memo->file);
            if($file){
                $data['file'] = $file;
            }

            $memo->update($data);

            $to = User::where('type', 'assistant')->first();
            $cc = User::where('type', 'director')->get();

            $files = [];
            if($memo->file){
                array_push($files, 'files/memos/' . $memo->file);
            } else {
                if($file){
                    array_push($files, 'files/memos/' . $file);
                }
            }

            $preMemoRef = null;
            if($preMemo){
                $preMemoRef = PreMemo::where('id', $preMemo)->first();
            }

            $dataEmail = [
                'detail' => [
                    'email' => $to->email,
                    'name' => $to->name,
                    'cc' => $cc,
                ],
                'content' => [
                    'title' => '[Update] Memo ' . $memo->number_transaction,
                    'number_transaction' => $memo->number_transaction,
                    'preMemo' => $preMemoRef,
                    'files' => $files,
                    'link' => route('memos.show', $memo->id),
                ],
            ];

            $this->sendEmail($dataEmail, SendMemoMail::class);

            $dataNotification = [
                'type' => 'primary',
                'title' => 'Memo Telah Dibuat',
                'message' => 'Memo dengan nomor ' . $memo->number_transaction . ' telah dibuat',
                'link' => route('memos.show', $memo->id),
                'icon' => 'bi-info-circle'
            ];
            $this->sendNotification($to, $dataNotification);

            toastr()->success('Memo Berhasil Diupdate');
            return redirect()->route('memos.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $memo = Memo::findOrFail($id);
            $memo->delete();

            $this->deleteImage('local', 'files/memos', $memo->file);
            $this->deleteImage('public', 'public/memo/qr-codes-signature', $memo->qr_code_file);

            toastr()->success('Memo Berhasil Dihapus');
            return redirect()->route('memos.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
