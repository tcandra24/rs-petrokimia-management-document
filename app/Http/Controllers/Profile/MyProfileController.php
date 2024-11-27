<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

// Traits
use App\Traits\General\BreadcrumbsTrait;


class MyProfileController extends Controller
{
    use BreadcrumbsTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $breadcrumbs = $this->setBreadcrumbs('profile', 'index', Auth::user());

        return view('profile.index', ['breadcrumbs' => $breadcrumbs]);
    }
}
