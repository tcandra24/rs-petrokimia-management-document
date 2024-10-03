<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Master\InstructionRequest;

// Models
use App\Models\Instruction;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class InstructionController extends Controller
{
    use BreadcrumbsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instructions = Instruction::paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('instruction', 'index');

        return view('master.instruction.index', [
            'instructions' => $instructions,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = $this->setBreadcrumbs('instruction', 'create');

        return view('master.instruction.create', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstructionRequest $request)
    {
        try {
            Instruction::create([
                'name' => $request->name
            ]);

            toastr()->success('Instruksi Berhasil Disimpan');
            return redirect()->route('instructions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Instruction $instruction)
    {
        $breadcrumbs = $this->setBreadcrumbs('instruction', 'edit', $instruction);

        return view('master.instruction.edit', [
            'instruction' => $instruction,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstructionRequest $request, Instruction $instruction)
    {
        try {
            $isActive = $request->is_active ? true : false;

            $instruction->update([
                'name' => $request->name,
                'is_active' => $isActive
            ]);

            toastr()->success('Instruksi Berhasil Diupdate');
            return redirect()->route('instructions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $instruction = Instruction::findOrFail($id);
            $instruction->delete();

            toastr()->success('Instruksi Berhasil Dihapus');
            return redirect()->route('instructions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());

            return back();
        }
    }
}
