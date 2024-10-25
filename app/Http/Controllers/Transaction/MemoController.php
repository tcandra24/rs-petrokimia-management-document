<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use phpseclib3\Crypt\RSA;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Storage;
// use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

// Requests
use App\Http\Requests\Transaction\MemoRequest;

// Models
use App\Models\Memo;
use App\Models\User;

// Traits
use App\Traits\General\BreadcrumbsTrait;
use App\Traits\General\UploadImageTrait;

class MemoController extends Controller
{
    use BreadcrumbsTrait, UploadImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memos = Memo::with(['to_user', 'from_user'])->paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('memo', 'index');

        return view('transaction.memo.index', ['breadcrumbs' => $breadcrumbs, 'memos' => $memos ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $breadcrumbs = $this->setBreadcrumbs('memo', 'create');

        return view('transaction.memo.create', ['users' => $users, 'breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemoRequest $request)
    {
        try {
            $now = Carbon::now();
            $maxCounter = Memo::max('counter') + 1;
            $numberTransaction = $maxCounter . '/' . str_pad($now->month, 2, '0', STR_PAD_LEFT) . '/MEMO/' . strtoupper(Auth::user()->division->acronym) . '/RSPGD/' . $now->year;

            $privateKey = RSA::load(Auth::user()->private_key);
            $payload = [
                'number_transaction' => $numberTransaction,
                'content' => $request->content
            ];

            $signature = $privateKey->sign(json_encode($payload));
            $qrcode_name = 'qr-code-signature-' . str_replace('/', '-', $numberTransaction) . '.png';
            $qrcode = QrCode::format('png')->size(300)->style('round')->eye('circle')->generate(base64_encode($signature));

            Storage::disk('public')->put('memo/qr-codes-signature/' . $qrcode_name, $qrcode);

            Memo::create([
                'counter' => $maxCounter,
                'number_transaction' => $numberTransaction,
                'regarding' => $request->regarding,
                'from_user_id' => Auth::user()->id,
                'to_user_id' => $request->to_user_id,
                'content' => $request->content,
                'file' => $this->doUpload('local', $request, 'public/files/memos'),
                'qr_code_file' => $qrcode_name,
                'approve_datetime' => Carbon::now(),
            ]);

            // $file = Pdf::loadView('transaction.disposition.exports.pdf.export', ['memo' => $memo ]);
            // $content = $file->output();
            // $filename = str_replace('/', '-', $memo->number_transaction) . '-' . $memo->regarding;
            // Storage::put('public/files/memos/export/pdf/' . $filename, $content);

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

        return view('transaction.memo.show', ['breadcrumbs' => $breadcrumbs, 'memo' => $memo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Memo $memo)
    {
        $users = User::all();
        $breadcrumbs = $this->setBreadcrumbs('memo', 'edit', $memo);

        return view('transaction.memo.edit', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users,
            'memo' => $memo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemoRequest $request, Memo $memo)
    {
        try {
            try {
                $memo->update([
                    'regarding' => $request->regarding,
                    'to_user_id' => $request->to_user_id,
                    'content' => $request->content,
                    'file' => $this->doUpload('local', $request, 'public/files/memos', $memo->file),
                ]);

                toastr()->success('Memo Berhasil Diupdate');
                return redirect()->route('memos.index');
            } catch (\Exception $e) {
                toastr()->error($e->getMessage());
                return back();
            }
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

            $this->deleteImage('local', 'public/files/memos', $memo->file);
            $this->deleteImage('public', 'public/memo/qr-codes-signature', $memo->qr_code_file);

            toastr()->success('Memo Berhasil Dihapus');
            return redirect()->route('memos.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
