<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

// Model
use App\Models\User;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|required_with:new_password_confirmation|same:new_password_confirmation',
            ], [
                'old_password.required' => 'Password lama wajib diisi',
                'new_password.required' => 'Password baru wajib diisi',
                'new_password.required_with' => 'Password baru dan konfirmasi password harus sama',
                'new_password.same' => 'Password baru dan konfirmasi password harus sama',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->with('active_tab', 'profile-change-password')->withInput();
            }

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
