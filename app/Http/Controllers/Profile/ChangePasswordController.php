<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Request
use App\Http\Requests\Profile\ChangePasswordRequest;

// Model
use App\Models\User;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ChangePasswordRequest $request)
    {
        try {
            $user = Auth::user();
            if(!Hash::check($request->old_password, $user->password)){
                toastr()->error('Password lama salah');
                return back();
            }

            User::where('id', $user->id)->update([
                'password' => bcrypt($request->new_password),
            ]);

            toastr()->success('Password Berhasil Diubah');
            return redirect()->route('profile.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
