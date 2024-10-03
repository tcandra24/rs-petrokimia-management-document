<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\General\BreadcrumbsTrait;

class DashboardController extends Controller
{
    use BreadcrumbsTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $breadcrumbs = $this->setBreadcrumbs('dashboard', 'index');

        return view('dashboard.index', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
