<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class VerifyEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $token = $request->token;
        $user = User::where('token', $token)->first();
        if(!$user){
            abort(404);
        }

        if($user->hasVerifiedEmail()){
            abort(404);
        }

        $user->markEmailAsVerified();

        toastr()->success('Email Berhasil Diverifikasi');
        return redirect()->route('login');
    }
}
