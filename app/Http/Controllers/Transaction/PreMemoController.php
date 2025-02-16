<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

// Mail
use App\Mail\SendPreMemoMail;

// Requests
use App\Http\Requests\Transaction\PreMemoRequest;

// Models
use App\Models\PreMemo;
use App\Models\User;

// Traits
use App\Traits\General\BreadcrumbsTrait;
use App\Traits\General\UploadImageTrait;
use App\Traits\General\GeneratesTransactionNumberTrait;
use App\Traits\General\DigitalSignatureTrait;
use App\Traits\General\SendNotificationsTrait;

class PreMemoController extends Controller
{
    use BreadcrumbsTrait, UploadImageTrait, GeneratesTransactionNumberTrait, DigitalSignatureTrait, SendNotificationsTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memos = PreMemo::when(Auth::user()->division_id, function($query){
            $query->where(function($query){
                $query->whereHas('from_user', function($query){
                    $query->where('division_id', Auth::user()->division_id);
                })->orWhereHas('to_user', function($query){
                    $query->where('division_id', Auth::user()->division_id);
                });
            });
        })->with(['to_user', 'from_user'])->orderBy('created_at', 'desc')->paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('preMemo', 'index');

        return view('transaction.pre-memo.index', ['breadcrumbs' => $breadcrumbs, 'memos' => $memos ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = $this->setBreadcrumbs('preMemo', 'create');
        $users = User::where('type', 'general')->get();

        return view('transaction.pre-memo.create', ['breadcrumbs' => $breadcrumbs, 'users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PreMemoRequest $request)
    {
        try {
            $maxCounter = PreMemo::max('counter') + 1;
            $numberTransaction = $this->generatesTransactionNumber('MEMO-KAINST', $maxCounter, false);

            $file = $this->doUpload('local', $request, 'files/pre-memos');

            $memo = PreMemo::create([
                'counter' => $maxCounter,
                'number_transaction' => $numberTransaction,
                'regarding' => $request->regarding,
                'from_user_id' => $request->from_user_id,
                'to_user_id' => $request->to_user_id,
                'content' => $request->content,
                'status' => '',
                'file' => $file,
            ]);

            $to = User::where('id', $request->to_user_id)->first();

            $files = [];
            if($file){
                array_push($files, 'files/pre-memos/' . $file);
            }

            $dataEmail = [
                'detail' => [
                    'email' => $to->email,
                    'name' => $to->name,
                    'cc' => null,
                ],
                'content' => [
                    'title' => 'Memo ' . $numberTransaction,
                    'number_transaction' => $numberTransaction,
                    'files' => $files,
                    'link' => route('pre-memos.show', $memo->id),
                    'view' => 'emails.pre-memo.create',
                    'note' => '',
                ],
            ];

            $this->sendEmail($dataEmail, SendPreMemoMail::class);

            $dataNotification = [
                'type' => 'primary',
                'title' => 'Memo Telah Dibuat',
                'message' => 'Memo dengan nomor ' . $numberTransaction . ' telah dibuat',
                'link' => route('pre-memos.show', $memo->id),
                'icon' => 'bi-info-circle'
            ];
            $this->sendNotification($to, $dataNotification);

            toastr()->success('Memo Berhasil Disimpan');
            return redirect()->route('pre-memos.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PreMemo $preMemo)
    {
        $breadcrumbs = $this->setBreadcrumbs('preMemo', 'show', $preMemo);

        return view('transaction.pre-memo.show', ['breadcrumbs' => $breadcrumbs, 'memo' => $preMemo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PreMemo $preMemo)
    {
        $breadcrumbs = $this->setBreadcrumbs('preMemo', 'edit', $preMemo);
        $users = User::where('type', 'general')->get();

        return view('transaction.pre-memo.edit', [
            'breadcrumbs' => $breadcrumbs,
            'memo' => $preMemo,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PreMemoRequest $request, PreMemo $preMemo)
    {
        try {
            $data  = [
                'from_user_id' => $request->from_user_id,
                'to_user_id' => $request->to_user_id,
                'regarding' => $request->regarding,
                'content' => $request->content,
                'status' => '',
            ];

            $file = $this->doUpload('local', $request, 'files/pre-memos', $preMemo->file);
            if($file){
                $data['file'] = $file;
            }

            $preMemo->update($data);

            $to = User::where('id', $request->to_user_id)->first();

            $files = [];
            if($preMemo->file){
                array_push($files, 'files/pre-memos/' . $preMemo->file);
            } else {
                if($file){
                    array_push($files, 'files/pre-memos/' . $file);
                }
            }

            $dataEmail = [
                'detail' => [
                    'email' => $to->email,
                    'name' => $to->name,
                    'cc' => null,
                ],
                'content' => [
                    'title' => '[Update] Memo ' . $preMemo->number_transaction,
                    'number_transaction' => $preMemo->number_transaction,
                    'files' => $files,
                    'link' => route('pre-memos.show', $preMemo->id),
                    'view' => 'emails.pre-memo.create',
                    'note' => '',
                ],
            ];

            $this->sendEmail($dataEmail, SendPreMemoMail::class);

            $dataNotification = [
                'type' => 'primary',
                'title' => 'Memo Telah Dibuat',
                'message' => 'Memo dengan nomor ' . $preMemo->number_transaction . ' telah dibuat',
                'link' => route('pre-memos.show', $preMemo->id),
                'icon' => 'bi-info-circle'
            ];
            $this->sendNotification($to, $dataNotification);

            toastr()->success('Memo Berhasil Diupdate');
            return redirect()->route('pre-memos.index');
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
            $memo = PreMemo::findOrFail($id);
            $memo->delete();

            $this->deleteImage('local', 'files/pre-memos', $memo->file);
            $this->deleteImage('public', 'public/pre-memo/qr-codes-signature', $memo->qr_code_file);

            toastr()->success('Memo Berhasil Dihapus');
            return redirect()->route('pre-memos.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
