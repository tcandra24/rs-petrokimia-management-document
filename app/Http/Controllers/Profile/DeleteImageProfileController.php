<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Model
use App\Models\User;

// Traits
use App\Traits\General\UploadImageTrait;

class DeleteImageProfileController extends Controller
{
    use UploadImageTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $user = Auth::user();

            $this->deleteImage('public', 'users/avatar', $user->image);

            User::where('id', $user->id)->update([
                'image' => ''
            ]);

            toastr()->success('Gambar Profile Berhasil Dihapus');
            return redirect()->route('profile.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
