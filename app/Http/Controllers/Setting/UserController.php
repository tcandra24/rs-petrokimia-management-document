<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use phpseclib3\Crypt\RSA;
use Carbon\Carbon;

// Mail
use App\Jobs\SendMailJob;
use App\Mail\VerifyUserMail;

// Request
use App\Http\Requests\Setting\User\StoreRequest;
use App\Http\Requests\Setting\User\EditRequest;

// Models
use App\Models\User;
use App\Models\Division;
use App\Models\Position;

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
        $positions = Position::all();
        $breadcrumbs = $this->setBreadcrumbs('user', 'create');

        return view('setting.user.create', [
            'roles' => $roles,
            'breadcrumbs' => $breadcrumbs,
            'divisions' => $divisions,
            'positions' => $positions,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $privateKey = RSA::createKey(2048);
            $privateKeyString = $privateKey->toString('PKCS8');
            $publicKeyString = $privateKey->getPublicKey()->toString('PKCS8');

            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . $request->name), $request->email . $request->name);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'division_id' => $request->division_id ?? null,
                'position_id' => $request->position_id ?? null,
                'type' => $request->type,
                'public_key' => $publicKeyString,
                'private_key' => $privateKeyString,
                'token' => $token
            ]);

            $roles = Role::whereIn('id', $request->roles)->first();
            $user->assignRole($roles);

            $data = [
                'email' => $user->email,
                'name' => $user->name,
                'template' => (new VerifyUserMail('Silahkan Verifikasi Email', $user->name, $token, [$user->email])),
                'cc' => null
            ];
            dispatch(new SendMailJob($data));

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
        $positions = Position::all();
        $breadcrumbs = $this->setBreadcrumbs('user', 'edit', $user);

        return view('setting.user.edit', [
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'roles' => $roles,
            'divisions' => $divisions,
            'positions' => $positions,
        ]);
    }

    public function update(EditRequest $request, User $user)
    {
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'division_id' => $request->division_id ?? null,
                'position_id' => $request->position_id ?? null,
                'type' => $request->type,
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
