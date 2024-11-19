<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Master\PurposeRequest;

// Models
use App\Models\Purpose;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class PurposeController extends Controller
{
    use BreadcrumbsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purposes = Purpose::paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('purpose', 'index');

        return view('master.purpose.index', [
            'purposes' => $purposes,
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
        $breadcrumbs = $this->setBreadcrumbs('purpose', 'create');

        return view('master.purpose.create', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurposeRequest $request)
    {
        try {
            Purpose::create([
                'name' => $request->name
            ]);

            toastr()->success('Tujuan Berhasil Disimpan');
            return redirect()->route('purposes.index');
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
    public function edit(Purpose $purpose)
    {
        $breadcrumbs = $this->setBreadcrumbs('purpose', 'edit', $purpose);

        return view('master.purpose.edit', [
            'purpose' => $purpose,
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
    public function update(PurposeRequest $request, Purpose $purpose)
    {
        try {
            $isActive = $request->is_active ? true : false;

            $purpose->update([
                'name' => $request->name,
                'is_active' => $isActive
            ]);

            toastr()->success('Tujuan Berhasil Diupdate');
            return redirect()->route('purposes.index');
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
            $purpose = Purpose::findOrFail($id);
            $purpose->delete();

            toastr()->success('Tujuan Berhasil Dihapus');
            return redirect()->route('purposes.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());

            return back();
        }
    }
}
