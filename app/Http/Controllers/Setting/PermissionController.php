<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Setting\PermissionRequest;

// Models
use Spatie\Permission\Models\Permission;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class PermissionController extends Controller
{
    use BreadcrumbsTrait;

    public function index()
    {
        $permissions = Permission::paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('permission', 'index');

        return view('setting.permission.index', ['breadcrumbs' => $breadcrumbs, 'permissions' => $permissions ]);
    }

    public function create()
    {
        $breadcrumbs = $this->setBreadcrumbs('permission', 'create');

        return view('setting.permission.create', [ 'breadcrumbs' => $breadcrumbs ]);
    }

    public function store(PermissionRequest $request)
    {
        try {
            Permission::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            toastr()->success('Hak Akses berhasil Disimpan');
            return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
