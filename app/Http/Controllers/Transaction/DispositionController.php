<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Disposition;
use App\Models\Division;
use App\Models\Instruction;
use App\Models\Memo;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class DispositionController extends Controller
{
    use BreadcrumbsTrait;

    public function index()
    {
        $dispositions = Disposition::paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('disposition', 'index');

        return view('transaction.disposition.index', ['breadcrumbs' => $breadcrumbs, 'dispositions' => $dispositions ]);
    }

    public function show()
    {
        //
    }

    public function create()
    {
        $memos = Memo::all();
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

    public function store(Request $request)
    {
        // $this->validate($request, [

        // ]);
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
