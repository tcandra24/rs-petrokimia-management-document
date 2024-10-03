<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

// Request
use App\Http\Requests\Setting\RoleRequest;

// Models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class RoleController extends Controller
{
    use BreadcrumbsTrait;

    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        $breadcrumbs = $this->setBreadcrumbs('role', 'index');

        return view('setting.role.index', ['breadcrumbs' => $breadcrumbs, 'roles' => $roles ]);
    }

    public function create()
    {
        $permissions = Permission::all();
        $breadcrumbs = $this->setBreadcrumbs('role', 'create');

        return view('setting.role.create', ['breadcrumbs' => $breadcrumbs, 'permissions' => $permissions]);
    }

    public function store(RoleRequest $request)
    {
        try {
            DB::transaction(function () use ($request){
                $role = Role::create(['name' => $request->name]);
                $role->givePermissionTo($request->permissions);
            });

            toastr()->success('Peran berhasil Disimpan');
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

    }

    public function edit($id)
    {
        try {
            $role = Role::with('permissions')->findOrFail($id);
            $breadcrumbs = $this->setBreadcrumbs('role', 'edit', $role);

            $permissions = Permission::all();
            return view('setting.role.edit', [
                'breadcrumbs' => $breadcrumbs,
                'role' => $role,
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function update(RoleRequest $request, Role $role)
    {
        try {
            DB::transaction(function () use ($request, $role){
                $role->update(['name' => $request->name]);
                $role->syncPermissions($request->permissions);
            });

            toastr()->success('Peran berhasil Diupdate');
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            toastr()->success('Peran Berhasil Dihapus');
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
