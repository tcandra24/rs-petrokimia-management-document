<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

// Requests
use App\Http\Requests\Transaction\DispositionRequest;

// Models
use App\Models\Disposition;
use App\Models\Division;
use App\Models\Instruction;
use App\Models\Memo;

// Traits
use App\Traits\General\BreadcrumbsTrait;
use App\Traits\Disposition\TransactionNumberTrait;
use App\Traits\General\UploadImageTrait;

class DispositionController extends Controller
{
    use BreadcrumbsTrait, TransactionNumberTrait, UploadImageTrait;

    public function index()
    {
        $dispositions = Disposition::with(['divisions', 'instructions'])->paginate(10);
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
        $divisions = Division::all();
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
        try {
            DB::transaction(function () use ($request){
                $memo =  $request->memo_id ?? null;
                $maxCounter = Disposition::max('counter') + 1;
                $numberTransaction = $this->generateNumber($maxCounter, $memo);

                $disposition = Disposition::create([
                    'counter' => $maxCounter,
                    'number_transaction' => $numberTransaction,
                    'committee' => $request->committee,
                    'is_urgent' => $request->is_urgent,
                    'memo_id' => $memo,
                    'status' => '',
                    'file' => $this->doUpload('local', $request, 'public/files/dispositions'),
                ]);

                $divisions = Division::select('id')->whereIn('id', $request->divisions)->get();
                $disposition->divisions()->attach($divisions);

                $instructions = Instruction::select('id')->whereIn('id', $request->instructions)->get();
                $disposition->instructions()->attach($instructions);
            });

            toastr()->success('Disposisi Berhasil Disimpan');
            return redirect()->route('dispositions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function edit(Disposition $disposition)
    {
        $memos = Memo::doesntHave('dispositions')->get()->sortBy('id');
        if ($disposition->memo){
            $memos->push($disposition->memo);
            $memos = $memos->sortBy('id');
        }

        $instructions = Instruction::all();
        $divisions = Division::all();
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

                $disposition->update([
                    'committee' => $request->committee,
                    'is_urgent' => $request->is_urgent,
                    'memo_id' => $memo,
                    'status' => '',
                    'file' => $this->doUpload('local', $request, 'public/files/dispositions', $disposition->file),
                ]);

                $divisions = Division::select('id')->whereIn('id', $request->divisions)->get();
                $disposition->divisions()->sync($divisions);

                $instructions = Instruction::select('id')->whereIn('id', $request->instructions)->get();
                $disposition->instructions()->sync($instructions);
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
                $disposition->divisions()->detach();
                $disposition->instructions()->detach();
                $disposition->delete();

                $this->deleteImage('local', 'public/files/dispositions', $disposition->file);
            });

            toastr()->success('Disposisi Berhasil Dihapus');
            return redirect()->route('dispositions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
