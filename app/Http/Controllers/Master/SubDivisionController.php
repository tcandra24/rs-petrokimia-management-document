<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Master\SubDivisionRequest;

// Models
use App\Models\Division;
use App\Models\SubDivision;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class SubDivisionController extends Controller
{
    use BreadcrumbsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subDivisions = SubDivision::paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('sub_division', 'index');

        return view('master.sub-division.index', [
            'subDivisions' => $subDivisions,
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
        $breadcrumbs = $this->setBreadcrumbs('sub_division', 'create');
        $divisions = Division::all();

        return view('master.sub-division.create', [
            'breadcrumbs' => $breadcrumbs,
            'divisions' => $divisions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubDivisionRequest $request)
    {
        try {
            SubDivision::create([
                'name' => $request->name,
                'division_id' => $request ->division_id,
            ]);

            toastr()->success('Sub Divisi Berhasil Disimpan');
            return redirect()->route('sub-divisions.index');
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
    public function edit(SubDivision $subDivision)
    {
        $breadcrumbs = $this->setBreadcrumbs('sub_division', 'edit', $subDivision);
        $divisions = Division::all();

        return view('master.sub-division.edit', [
            'subDivision' => $subDivision,
            'divisions' => $divisions,
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
    public function update(SubDivisionRequest $request, SubDivision $subDivision)
    {
        try {
            $isActive = $request->is_active ? true : false;

            $subDivision->update([
                'name' => $request->name,
                'division_id' => $request ->division_id,
                'is_active' => $isActive,
            ]);

            toastr()->success('Sub Divisi Berhasil Diupdate');
            return redirect()->route('sub-divisions.index');
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
    public function destroy(string $id)
    {
        try {
            $subDivision = SubDivision::findOrFail($id);
            $subDivision->delete();

            toastr()->success('Sub Divisi Berhasil Dihapus');
            return redirect()->route('divisions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
