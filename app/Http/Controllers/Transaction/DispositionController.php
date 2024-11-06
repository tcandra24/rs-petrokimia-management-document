<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

// Mail
use App\Mail\SendDispositionMail;

// Notification
use App\Notifications\GeneralNotification;

// Requests
use App\Http\Requests\Transaction\DispositionRequest;

// Models
use App\Models\Disposition;
use App\Models\Division;
use App\Models\Instruction;
use App\Models\Memo;
use App\Models\SubDivision;
use App\Models\User;

// Traits
use App\Traits\General\BreadcrumbsTrait;
use App\Traits\Disposition\TransactionNumberTrait;
use App\Traits\General\UploadImageTrait;
use App\Traits\General\SendNotificationsTrait;

class DispositionController extends Controller
{
    use BreadcrumbsTrait, TransactionNumberTrait, UploadImageTrait, SendNotificationsTrait;

    public function index()
    {
        $dispositions = Disposition::with(['sub_divisions', 'sub_divisions.division', 'instructions'])->paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('disposition', 'index');

        return view('transaction.disposition.index', ['breadcrumbs' => $breadcrumbs, 'dispositions' => $dispositions ]);
    }

    public function show(Disposition $disposition)
    {
        $breadcrumbs = $this->setBreadcrumbs('disposition', 'show', $disposition);

        return view('transaction.disposition.show', ['breadcrumbs' => $breadcrumbs, 'disposition' => $disposition]);
    }

    public function create()
    {
        $memos = Memo::doesntHave('dispositions')->get();
        $instructions = Instruction::all();
        $divisions = Division::with(['sub_divisions'])->get();
        $breadcrumbs = $this->setBreadcrumbs('disposition', 'create');

        return view('transaction.disposition.create', [
            'breadcrumbs' => $breadcrumbs,
            'memos' => $memos,
            'instructions' => $instructions,
            'divisions' => $divisions,
        ]);
    }

    public function store(DispositionRequest $request)
    {
        // try {
            DB::transaction(function () use ($request){
                $memo =  $request->memo_id ?? null;
                $maxCounter = Disposition::max('counter') + 1;
                $numberTransaction = $this->generateNumber($maxCounter, $memo);

                $file = $this->doUpload('local', $request, 'files/dispositions');

                $disposition = Disposition::create([
                    'counter' => $maxCounter,
                    'number_transaction' => $numberTransaction,
                    'committee' => $request->committee,
                    'is_urgent' => $request->is_urgent,
                    'memo_id' => $memo,
                    'status' => '',
                    'file' => $file,
                ]);

                $subDivision = SubDivision::select('id')->whereIn('id', $request->sub_divisions)->get();
                $disposition->sub_divisions()->attach($subDivision);

                $instructions = Instruction::select('id')->whereIn('id', $request->instructions)->get();
                $disposition->instructions()->attach($instructions);

                $to = User::where('type', 'director')->first();
                $cc = User::where('type', 'assistant')->get();

                $files = [];
                if($file){
                    array_push($files, 'files/dispositions/' . $file);
                }

                $memoRef = null;
                if($memo){
                    $memoRef = Memo::where('id', $memo)->first();
                }

                $dataEmail = [
                    'detail' => [
                        'email' => $to->email,
                        'name' => $to->name,
                        'cc' => $cc,
                    ],
                    'content' => [
                        'title' => 'Disposisi ' . $numberTransaction,
                        'disposition' => $numberTransaction,
                        'memo' => $memoRef,
                        'view' => 'emails.dispositions.create',
                        'note' => '',
                        'files' => $files,
                    ],
                ];

                $this->sendEmail($dataEmail, SendDispositionMail::class);

                $type = 'primary';
                $title = 'Disposisi Telah Dibuat';
                $message = 'Disposisi dengan nomor ' . $numberTransaction . ' telah dibuat';
                $link = route('dispositions.show', $disposition->id);
                $icon = 'bi-info-circle';

                $to->notify(new GeneralNotification($type, $title, $message, $link, $icon));
            });

            toastr()->success('Disposisi Berhasil Disimpan');
            return redirect()->route('dispositions.index');
        // } catch (\Exception $e) {
        //     toastr()->error($e->getMessage());
        //     return back();
        // }
    }

    public function edit(Disposition $disposition)
    {
        $memos = Memo::doesntHave('dispositions')->get()->sortBy('id');
        if ($disposition->memo){
            $memos->push($disposition->memo);
            $memos = $memos->sortBy('id');
        }

        $instructions = Instruction::all();
        $divisions = Division::with(['sub_divisions'])->get();
        $breadcrumbs = $this->setBreadcrumbs('disposition', 'edit', $disposition);

        return view('transaction.disposition.edit', [
            'breadcrumbs' => $breadcrumbs,
            'memos' => $memos,
            'instructions' => $instructions,
            'divisions' => $divisions,
            'disposition' => $disposition
        ]);
    }

    public function update(DispositionRequest $request, Disposition $disposition)
    {
        try {
            DB::transaction(function () use ($request, $disposition){
                $memo = $request->memo_id ?? null;

                $data  = [
                    'committee' => $request->committee,
                    'is_urgent' => $request->is_urgent,
                    'memo_id' => $memo,
                    'status' => '',
                ];

                $file = $this->doUpload('local', $request, 'files/dispositions', $disposition->file);
                if($file){
                    $data['file'] = $file;
                }

                $disposition->update($data);

                $subDivisions = Division::select('id')->whereIn('id', $request->sub_divisions)->get();
                $disposition->sub_divisions()->sync($subDivisions);

                $instructions = Instruction::select('id')->whereIn('id', $request->instructions)->get();
                $disposition->instructions()->sync($instructions);

                $to = User::where('type', 'director')->first();
                $cc = User::where('type', 'assistant')->get();

                $files = [];
                if($disposition->file){
                    array_push($files, 'files/dispositions/' . $disposition->file);
                } else {
                    if($file){
                        array_push($files, 'files/dispositions/' . $file);
                    }
                }

                $memoRef = null;
                if($memo){
                    $memoRef = Memo::where('id', $memo)->first();
                }

                $dataEmail = [
                    'detail' => [
                        'email' => $to->email,
                        'name' => $to->name,
                        'cc' => $cc,
                    ],
                    'content' => [
                        'title' => '[Update] Disposisi ' . $disposition->number_transaction,
                        'disposition' => $disposition->number_transaction,
                        'memo' => $memoRef,
                        'view' => 'emails.dispositions.create',
                        'note' => '',
                        'files' => $files,
                    ],
                ];

                $this->sendEmail($dataEmail, SendDispositionMail::class);

                $type = 'primary';
                $title = 'Disposisi Telah Diupdate';
                $message = 'Disposisi dengan nomor ' . $disposition->number_transaction . ' telah diupdate';
                $link = route('dispositions.show', $disposition->id);
                $icon = 'bi-info-circle';

                $to->notify(new GeneralNotification($type, $title, $message, $link, $icon));
            });

            toastr()->success('Disposisi Berhasil Diupdate');
            return redirect()->route('dispositions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id){
                $disposition = Disposition::findOrFail($id);
                $disposition->sub_divisions()->detach();
                $disposition->instructions()->detach();
                $disposition->delete();

                $this->deleteImage('local', 'files/dispositions', $disposition->file);
            });

            toastr()->success('Disposisi Berhasil Dihapus');
            return redirect()->route('dispositions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
