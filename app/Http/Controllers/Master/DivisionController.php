<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Master\DivisionRequest;

// Models
use App\Models\Division;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class DivisionController extends Controller
{
    use BreadcrumbsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('division', 'index');

        return view('master.division.index', [
            'divisions' => $divisions,
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
        $breadcrumbs = $this->setBreadcrumbs('division', 'create');

        return view('master.division.create', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DivisionRequest $request)
    {
        try {
            Division::create([
                'name' => $request->name
            ]);

            toastr()->success('Divisi Berhasil Disimpan');
            return redirect()->route('divisions.index');
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
    public function edit(Division $division)
    {
        $breadcrumbs = $this->setBreadcrumbs('division', 'edit', $division);

        return view('master.division.edit', [
            'division' => $division,
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
    public function update(DivisionRequest $request, Division $division)
    {
        try {
            $isActive = $request->is_active ? true : false;

            $division->update([
                'name' => $request->name,
                'is_active' => $isActive
            ]);

            toastr()->success('Divisi Berhasil Diupdate');
            return redirect()->route('divisions.index');
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
            $division = Division::findOrFail($id);
            $division->delete();

            toastr()->success('Divisi Berhasil Dihapus');
            return redirect()->route('divisions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
