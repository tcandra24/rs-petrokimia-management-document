<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;

// Mail
use App\Jobs\SendMailJob;
use App\Mail\VerifyUserMail;

// Models
use App\Models\User;

class ResendEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($email)
    {
        try {
            $user = User::where('email', $email)->first();

            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . $user->name), $user->email . $user->name);

            $user->update([
                'token' => $token
            ]);

            $data = [
                'email' => $user->email,
                'name' => $user->name,
                'template' => (new VerifyUserMail('Silahkan Verifikasi Email', $user->name, $token, [$user->email])),
                'cc' => null
            ];

            dispatch(new SendMailJob($data));

            toastr()->success('Email Verifikasi Berhasil dikirim');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
