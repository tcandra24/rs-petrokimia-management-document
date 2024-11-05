<?php

namespace App\Traits\General;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

trait GeneratesTransactionNumberTrait
{
    public function generatesTransactionNumber($prefix, $counter): string
    {
        $now = Carbon::now();
        return $counter . '/' . str_pad($now->month, 2, '0', STR_PAD_LEFT) . '/' . $prefix . '/' . strtoupper(Auth::user()->division->acronym) . '/RSPGD/' . $now->year;
    }
}
