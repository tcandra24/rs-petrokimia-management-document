<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Master\PositionRequest;

// Models
use App\Models\Position;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class PositionController extends Controller
{
    use BreadcrumbsTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('position', 'index');

        return view('master.position.index', [
            'positions' => $positions,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = $this->setBreadcrumbs('position', 'create');

        return view('master.position.create', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PositionRequest $request)
    {
        try {
            Position::create([
                'name' => $request->name
            ]);

            toastr()->success('Jabatan Berhasil Disimpan');
            return redirect()->route('positions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        $breadcrumbs = $this->setBreadcrumbs('position', 'edit', $position);

        return view('master.position.edit', [
            'position' => $position,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PositionRequest $request, Position $position)
    {
        try {
            $isActive = $request->is_active ? true : false;

            $position->update([
                'name' => $request->name,
                'is_active' => $isActive
            ]);

            toastr()->success('Jabatan Berhasil Diupdate');
            return redirect()->route('positions.index');
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
            $position = Position::findOrFail($id);
            $position->delete();

            toastr()->success('Jabatan Berhasil Dihapus');
            return redirect()->route('positions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
