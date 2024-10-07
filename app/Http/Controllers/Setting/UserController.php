<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

// Request
use App\Http\Requests\Setting\User\StoreRequest;
use App\Http\Requests\Setting\User\EditRequest;

// Models
use App\Models\User;
use App\Models\Division;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class UserController extends Controller
{
    use BreadcrumbsTrait;

    public function index()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        $breadcrumbs = $this->setBreadcrumbs('user', 'index');

        return view('setting.user.index', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        $divisions = Division::all();
        $breadcrumbs = $this->setBreadcrumbs('user', 'create');

        return view('setting.user.create', ['roles' => $roles, 'breadcrumbs' => $breadcrumbs, 'divisions' => $divisions]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $isDirector = $request->is_director ? true : false;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'division_id' => $request->division_id ?? null,
                'is_director' => $isDirector,
            ]);

            $roles = Role::whereIn('id', $request->roles)->first();
            $user->assignRole($roles);

            toastr()->success('Pengguna Berhasil Disimpan');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            // Log::error('Error occurred: '.$e->getMessage(), [
            //     'exception' => $e,
            //     'request' => $request->all(),
            // ]);
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $divisions = Division::all();
        $breadcrumbs = $this->setBreadcrumbs('user', 'edit', $user);

        return view('setting.user.edit', [
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'roles' => $roles,
            'divisions' => $divisions
        ]);
    }

    public function update(EditRequest $request, User $user)
    {
        try {
            $isDirector = $request->is_director ? true : false;

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'division_id' => $request->division_id ?? null,
                'is_director' => $isDirector,
            ];

            if($request->filled('password')){
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            $roles = Role::whereIn('id', $request->roles)->first();
            $user->syncRoles($roles);

            toastr()->success('Divisi Berhasil Diupdate');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            toastr()->success('Divisi Berhasil Dihapus');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
