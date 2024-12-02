<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Model
use App\Models\User;

// Traits
use App\Traits\General\UploadImageTrait;

class ChangeProfileController extends Controller
{
    use UploadImageTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'nullable',
                'file' => 'nullable|mimes:png|dimensions:min_width=200'
            ], [
                'file.mimes' => 'File harus mempunyai format png',
                'file.dimensions' => 'Minimal lebar file adalah 200px',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->with('active_tab', 'profile-edit')->withInput();
            }

            $user = Auth::user();

            $data = [];

            $image = $this->doUpload('public', $request, 'users/avatar');

            if($image){
                $data['image'] = $image;
            }

            if($request->name){
                $data['name'] = $request->name;
            }

            User::where('id', $user->id)->update($data);

            toastr()->success('Profile Berhasil Diubah');
            return redirect()->route('profile.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
